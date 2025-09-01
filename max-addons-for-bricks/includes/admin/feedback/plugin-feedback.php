<?php
/**
 * Universal WordPress Plugin Feedback System
 *
 * A reusable feedback system for WordPress plugins that handles:
 * - Deactivation feedback
 * - Review notices
 * - User data collection
 * - Customizable configurations
 *
 * @package UniversalPluginFeedback
 * @version 1.0.0
 */

namespace MaxAddons\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mab_Plugin_Feedback {

	private $config;
	private $plugin_slug;
	private $plugin_name;
	private $plugin_url;
	private $plugin_version;
	private $assets_url;

	/**
	 * Initialize the feedback system.
	 *
	 * @param array $config Configuration array
	 */
	public function __construct( $config = [] ) {

		$this->config         = wp_parse_args( $config, $this->get_default_config() );

		$kebab_slug = $this->config['plugin_slug'];
		$snake_slug = str_replace( '-', '_', $kebab_slug );

		$this->plugin_slug    = $snake_slug; // $this->config['plugin_slug'];
		$this->plugin_name    = $this->config['plugin_name'];
		$this->plugin_url     = $this->config['plugin_url'];
		$this->plugin_version = $this->config['plugin_version'];
		$this->assets_url     = $this->config['assets_url'];

		$this->init_hooks();
	}

	/**
	 * Get default configuration
	 *
	 * @return array Default configuration
	 */
	private function get_default_config() {
		return [
			'plugin_slug'                 => '',
			'plugin_name'                 => '',
			'plugin_url'                  => '',
			'plugin_version'              => '1.0.0',
			'assets_url'                  => '',
			'feedback_api_url'            => 'https://feedback.bloompixel.com/wp-json/feedback/v1/feedback',
			'review_link'                 => '',
			'buy_link'                    => '',
			'plugin_logo'                 => 'assets/images/logo.png',
			'company_name'                => 'BloomPixel',
			'company_url'                 => 'https://www.bloompixel.com/',
			'review_notice_days'          => 3,
			'installation_date_option'    => '{plugin_slug}_install_date',
			'review_option'               => '{plugin_slug}_review_notice_dismissed',
			'show_review_notice'          => true,
			'show_deactivation_feedback'  => true,
			'collect_system_info'         => true,
			'custom_deactivation_reasons' => [],
			'custom_css'                  => '',
			'custom_js'                   => ''
		];
	}

	/**
	 * Initialize WordPress hooks
	 */
	private function init_hooks() {
		if (!$this->is_valid_config()) {
			return;
		}

		add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

		$this->plugin_slug = str_replace( "-", "_", $this->plugin_slug );

		if ($this->config['show_deactivation_feedback']) {
			add_action('admin_head', [$this, 'show_deactivation_feedback_popup']);
			add_action('wp_ajax_' . $this->plugin_slug . '_submit_deactivation_response', [$this, 'submit_deactivation_response']);
		}

		if ($this->config['show_review_notice']) {
			add_action('admin_notices', [$this, 'show_review_notice']);
			add_action('wp_ajax_' . $this->plugin_slug . '_dismiss_review_notice', [$this, 'dismiss_review_notice']);
		}
	}

	/**
	 * Validate configuration
	 *
	 * @return bool True if valid, false otherwise
	 */
	private function is_valid_config() {
		$required_fields = [ 'plugin_slug', 'plugin_name', 'plugin_url', 'assets_url' ];

		foreach ( $required_fields as $field ) {
			if ( empty( $this->config[ $field ] ) ) {
				error_log( "Universal_Plugin_Feedback: Missing required field: {$field}" );
				return false;
			}
		}

		return true;
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		$screen = get_current_screen();

		// Enqueue CSS.
		wp_enqueue_style(
			$this->plugin_slug . '-feedback-css',
			$this->assets_url . 'css/feedback.css',
			[],
			$this->plugin_version
		);

		if ( ! isset( $screen ) || $screen->id !== 'plugins' ) {
			return;
		}

		// Enqueue JavaScript.
		wp_enqueue_script(
			$this->plugin_slug . '-feedback-js',
			$this->assets_url . 'js/feedback.js',
			[ 'jquery' ],
			$this->plugin_version,
			true
		);

		// Localize script.
		wp_localize_script(
			$this->plugin_slug . '-feedback-js',
			$this->plugin_slug . '_feedback_vars',
			[
				'ajax_url'    => admin_url( 'admin-ajax.php' ),
				'plugin_slug' => $this->plugin_slug,
				'nonce'       => wp_create_nonce( $this->plugin_slug . '_feedback_nonce' ),
				'strings'     => [
					'submitting' => esc_html__( 'Submitting...', 'max-addons' ),
					'error'      => esc_html__( 'An error occurred. Please try again.', 'max-addons' ),
					'success'    => esc_html__( 'Thank you for your feedback!', 'max-addons' )
				]
			]
		);
	}

	/**
	 * Show review notice.
	 */
	public function show_review_notice() {
		if ( ! current_user_can( 'update_plugins' ) ) {
			return;
		}

		$installation_date_option = str_replace( '{plugin_slug}', $this->plugin_slug, $this->config['installation_date_option'] );
		$review_option            = str_replace( '{plugin_slug}', $this->plugin_slug, $this->config['review_option'] );

		$installation_date = get_option( $installation_date_option );
		$already_dismissed = get_option( $review_option, 'no' );

		$user_id                 = get_current_user_id();
		$already_dismissed_user  = $user_id ? get_user_meta( $user_id, $review_option, true ) : '';
		$already_dismissed_opt   = get_option( $review_option, '' );
		$already_dismissed_site  = is_multisite() ? get_site_option( $review_option, '' ) : '';

		if ( 'yes' === $already_dismissed_user || 'yes' === $already_dismissed_opt || 'yes' === $already_dismissed_site ) {
			return;
		}

		$install_date = new \DateTime( $installation_date );
		$current_date = new \DateTime();
		$difference   = $install_date->diff( $current_date );

		if ( $difference->days >= $this->config['review_notice_days'] ) {
			echo $this->get_review_notice_html();
		}
	}

	/**
	 * Get review notice HTML
	 *
	 * @return string HTML content
	 */
	private function get_review_notice_html() {
		$logo = $this->config['plugin_logo'];

		if ( filter_var( $logo, FILTER_VALIDATE_URL ) ) {
			$plugin_logo = $logo; // already a full URL
		} else {
			$plugin_logo = $this->plugin_url . ltrim( $logo, '/' ); // avoid double slashes
		}

		$review_link  = $this->config['review_link'];
		$buy_link     = $this->config['buy_link'];
		$company_name = $this->config['company_name'];
		$company_url  = $this->config['company_url'];

		$buy_button = '';
		if ( ! empty( $buy_link ) ) {
			$buy_button = '<li><a href="' . esc_url( $buy_link ) . '" target="_blank" class="button button-secondary buy-pro-btn">Buy Pro</a></li>';
		}

		ob_start();
		?>
		<div class="<?php echo esc_attr( $this->plugin_slug ); ?>-review-notice notice notice-info is-dismissible" data-plugin-slug="<?php echo esc_attr( $this->plugin_slug ); ?>">
			<p>
				<?php
				printf(
					/* translators: 1: Plugin name */
					esc_html__(
						'Thank you for using %1$s. If our plugin has made your workflow easier or brought value to your site, we\'d be truly grateful if you could leave us a ★★★★★ review on WordPress.org. Your support keeps us motivated!',
						'max-addons'
					),
					'<strong>' . esc_html( $this->plugin_name ) . '</strong>',
				);
				?>
			</p>
			<ul class="mab-notice-actions">
				<li>
					<a href="<?php echo esc_url( $review_link ); ?>" class="button button-primary rate-btn" target="_blank">
						<?php
							printf(
								/* translators: %s: Star rating */
								esc_html__( 'Rate Now! %s', 'max-addons' ),
								'★★★★★'
							);
						?>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="button button-secondary dismiss-notice" data-reason="already-rated">
						<?php echo esc_html__( '🙌 Already Rated', 'max-addons' ); ?>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="button button-secondary dismiss-notice" data-reason="not-interested">
						<?php echo esc_html__( 'No Thanks', 'max-addons' ); ?>
					</a>
				</li>
				<?php echo $buy_button; ?>
			</ul>
		</div>
		<script>
		jQuery(function($){
			// Persist dismissal for: Already Rated, No Thanks, Dismiss
			$(document).on('click', '.<?php echo esc_js( $this->plugin_slug ); ?>-review-notice .dismiss-notice', function(e){
				e.preventDefault();
				var $notice = $(this).closest('.<?php echo esc_js( $this->plugin_slug ); ?>-review-notice');

				$.post(ajaxurl, {
				action: '<?php echo esc_js( $this->plugin_slug ); ?>_dismiss_review_notice',
				nonce: '<?php echo esc_js( wp_create_nonce( $this->plugin_slug . "_feedback_nonce" ) ); ?>',
				reason: $(this).data('reason') || 'dismiss'
				}).always(function(){
				$notice.fadeOut(150, function(){ $(this).remove(); });
				});
			});

			// Persist dismissal when user clicks the core "×" on the notice
			$(document).on('click', '.<?php echo esc_js( $this->plugin_slug ); ?>-review-notice .notice-dismiss', function(){
				$.post(ajaxurl, {
				action: '<?php echo esc_js( $this->plugin_slug ); ?>_dismiss_review_notice',
				nonce: '<?php echo esc_js( wp_create_nonce( $this->plugin_slug . "_feedback_nonce" ) ); ?>',
				reason: 'x'
				});
			});
		});
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Dismiss review notice
	 */
	public function dismiss_review_notice() {
		check_ajax_referer( $this->plugin_slug . '_feedback_nonce', 'nonce' );

		$review_option = str_replace( '{plugin_slug}', $this->plugin_slug, $this->config['review_option'] );

		update_option( $review_option, 'yes' );

		if ( is_multisite() ) {
			update_site_option( $review_option, 'yes' );
		}

		if ( is_user_logged_in() ) {
			update_user_meta( get_current_user_id(), $review_option, 'yes' );
		}

		wp_send_json_success( [ 'message' => esc_html__( 'Notice dismissed successfully', 'max-addons' ) ] );
	}

	/**
	 * Show deactivation feedback popup
	 */
	public function show_deactivation_feedback_popup() {
		$screen = get_current_screen();
		if ( ! isset( $screen ) || $screen->id !== 'plugins' ) {
			return;
		}

		$reasons = $this->get_deactivation_reasons();
		?>
		<div id="<?php echo esc_attr( $this->plugin_slug ); ?>-feedback-popup" class="feedback-popup-overlay">
			<div class="feedback-popup-container">
				<div class="feedback-popup-header">
					<h3><?php esc_html_e( 'Quick Feedback', 'max-addons' ); ?></h3>
				</div>

				<div class="feedback-popup-content">
					<div class="feedback-loader">
						<div class="loader-spinner"></div>
					</div>

					<div class="feedback-form-container">
						<p class="feedback-form-title">
							<?php printf( esc_html__( 'If you have a moment, please let us know why you\'re deactivating %s:', 'max-addons' ), $this->plugin_name ); ?>
						</p>

						<form class="feedback-form" data-plugin-slug="<?php echo esc_attr( $this->plugin_slug ); ?>">
							<?php foreach ( $reasons as $key => $reason ): ?>
								<div class="feedback-reason-item">
									<label class="feedback-reason-label">
										<input type="radio" name="reason" value="<?php echo esc_attr( $key ); ?>" class="feedback-reason-input">
										<span class="feedback-reason-text"><?php echo esc_html( $reason['title'] ); ?></span>
									</label>
									<?php if ( ! empty( $reason['placeholder'] ) ): ?>
										<div class="feedback-reason-details">
											<textarea
												class="feedback-details-input"
												placeholder="<?php echo esc_attr( $reason['placeholder'] ); ?>"
												rows="2"
											></textarea>
										</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>

							<?php if ( $this->config['collect_system_info'] ): ?>
								<div class="feedback-consent">
									<label class="feedback-consent-label">
										<input type="checkbox" class="feedback-consent-checkbox" required>
										<span class="feedback-consent-text">
											<?php printf( esc_html__( 'I agree to share anonymous usage data and basic site details to help improve %s.', 'max-addons' ), $this->plugin_name ); ?>
										</span>
									</label>
								</div>
							<?php endif; ?>

							<div class="feedback-actions">
								<button type="submit" class="button button-primary feedback-submit-btn">
									<?php esc_html_e( 'Submit & Deactivate', 'max-addons' ); ?>
								</button>
								<button type="button" class="button button-secondary feedback-skip-btn">
									<?php esc_html_e( 'Skip & Deactivate', 'max-addons' ); ?>
								</button>
								<button type="button" class="button button-secondary feedback-cancel-btn">
									<?php esc_html_e( 'Cancel', 'max-addons' ); ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Get deactivation reasons
	 *
	 * @return array Deactivation reasons
	 */
	private function get_deactivation_reasons() {
		$default_reasons = [
			'not_working' => [
				'title' => esc_html__( 'The plugin is not working', 'max-addons' ),
				'placeholder' => esc_html__( 'Please describe the issue you encountered', 'max-addons' ),
			],
			'found_better' => [
				'title' => esc_html__( 'I found a better alternative', 'max-addons' ),
				'placeholder' => esc_html__( 'Please share which plugin you\'re switching to', 'max-addons' ),
			],
			'no_longer_required' => [
				'title' => esc_html__( 'I no longer need the plugin', 'max-addons' ),
				'placeholder' => ''
			],
			'temporary' => [
				'title' => esc_html__( 'It\'s a temporary deactivation', 'max-addons' ),
				'placeholder' => ''
			],
			'missing_feature' => [
				'title' => esc_html__( 'Missing a feature I need', 'max-addons' ),
				'placeholder' => esc_html__( 'What feature were you looking for?', 'max-addons' ),
			],
			'other' => [
				'title' => esc_html__( 'Other', 'max-addons' ),
				'placeholder' => esc_html__( 'Please share your reason', 'max-addons' ),
			]
		];

		// Merge with custom reasons if provided.
		if ( ! empty( $this->config['custom_deactivation_reasons'] ) ) {
			return array_merge( $default_reasons, $this->config['custom_deactivation_reasons'] );
		}

		return $default_reasons;
	}

	/**
	 * Submit deactivation response.
	 */
	public function submit_deactivation_response() {
		check_ajax_referer( $this->plugin_slug . '_feedback_nonce', 'nonce' );

		$reason  = sanitize_text_field( $_POST['reason'] ?? '' );
		$details = sanitize_textarea_field( $_POST['details'] ?? '' );
		$consent = isset( $_POST['consent'] ) ? true : false;

		$data = [
			'plugin_name'    => $this->plugin_name,
			'plugin_version' => $this->plugin_version,
			'plugin_slug'    => $this->plugin_slug,
			'reason'         => $reason,
			'details'        => $details,
			'site_url'       => site_url(),
			'timestamp'      => current_time( 'mysql' ),
		];

		// Add system info if consent is given.
		if ( $consent && $this->config['collect_system_info'] ) {
			$data['system_info'] = $this->get_system_info();
		}

		// Send to feedback API.
		$response = $this->send_feedback( $data );

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( [ 'message' => esc_html__( 'Failed to send feedback', 'max-addons' ) ] );
		}

		wp_send_json_success( [ 'message' => esc_html__( 'Feedback submitted successfully', 'max-addons' ) ] );
	}

	/**
	 * Get system information
	 *
	 * @return array System information
	 */
	private function get_system_info() {
		global $wpdb;

		return [
			'wp_version'      => get_bloginfo( 'version' ),
			'php_version'     => phpversion(),
			'mysql_version'   => $wpdb->get_var( "SELECT VERSION()" ),
			'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
			'wp_memory_limit' => ini_get( 'memory_limit' ),
			'wp_debug'        => defined( 'WP_DEBUG' ) && WP_DEBUG ? esc_html__( 'Enabled', 'max-addons' ) : esc_html__( 'Disabled', 'max-addons' ),
			'wp_multisite'    => is_multisite() ? 'Yes' : 'No',
			'wp_language'     => get_locale(),
			'active_theme'    => wp_get_theme()->get( 'Name' ),
			'active_plugins' => $this->get_active_plugins_info()
		];
	}

	/**
	 * Get active plugins information
	 *
	 * @return array Active plugins info
	 */
	private function get_active_plugins_info() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$active_plugins = get_option( 'active_plugins', [] );
		$plugins_info   = [];

		foreach ( $active_plugins as $plugin_path ) {
			$plugin_data    = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_path );
			$plugins_info[] = [
				'name'    => $plugin_data['Name'],
				'version' => $plugin_data['Version']
			];
		}

		return $plugins_info;
	}

	/**
	 * Send feedback to API
	 *
	 * @param array $data Feedback data
	 * @return array|WP_Error Response
	 */
	private function send_feedback( $data ) {
		$api_url = $this->config['feedback_api_url'];

		if ( empty( $api_url ) ) {
			return new WP_Error( 'no_api_url', esc_html__( 'No feedback API URL configured', 'max-addons' ) );
		}

		$json_data = json_encode( $data );

		if ( false === $json_data ) {
			return new WP_Error( 'json_encode_error', json_last_error_msg() );
		}

		return wp_remote_post(
			$api_url,
			[
				'timeout' => 30,
				'body'    => $json_data,
				'headers' => [
					'Content-Type' => 'application/json'
				]
			]
		);
	}

	/**
	 * Set installation date (call this on plugin activation)
	 */
	public function set_installation_date() {
		$installation_date_option = str_replace( '{plugin_slug}', $this->plugin_slug, $this->config['installation_date_option'] );

		if ( ! get_option( $installation_date_option ) ) {
			update_option( $installation_date_option, current_time( 'mysql' ) );
		}
	}

	/**
	 * Clean up options (call this on plugin deactivation)
	 */
	public function cleanup() {
		$installation_date_option = str_replace( '{plugin_slug}', $this->plugin_slug, $this->config['installation_date_option'] );
		$review_option            = str_replace( '{plugin_slug}', $this->plugin_slug, $this->config['review_option'] );

		delete_option( $installation_date_option );
		delete_option( $review_option );
	}
}
