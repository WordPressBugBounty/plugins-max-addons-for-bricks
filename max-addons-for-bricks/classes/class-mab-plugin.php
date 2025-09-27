<?php
/**
 * Plugin loader class.
 *
 * Loads the plugin and all the required classes and functions when the
 * plugin is activate.
 *
 * @package MaxAddons\Classes
 * @since 1.0.0
 */

namespace MaxAddons\Classes;

use MaxAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * MaxAddons Plugin.
 *
 * Main plugin class responsible for initiazling MaxAddons Plugin. The class
 * registers all the components required to run the plugin.
 */
class MAB_Plugin {

	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var $instance
	 */
	private static $instance = null;

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return MAB_Plugin An instance of the class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->includes();

		add_action( 'init', array( $this, 'init' ), 11 );
	}

	/**
	 * Shows an admin notice if you're not using the Bricks Builder.
	 */
	public function max_addons_admin_notice_message() {
		if ( ! is_admin() ) {
			return;
		} elseif ( ! is_user_logged_in() ) {
			return;
		} elseif ( ! current_user_can( 'update_core' ) ) {
			return;
		}
	
		$message = sprintf(
			/* translators: 1: Max Addons 2: Bricks Builder */
			esc_html__( '%1$s requires %2$s to be installed and activated.', 'max-addons' ),
			'<strong>Max Addons</strong>',
			'<strong>Bricks Builder</strong>'
		);

		$html = sprintf( '<div class="notice notice-warning">%s</div>', wpautop( $message ) );

		echo wp_kses_post( $html );
	}

	/**
	 * AutoLoad
	 *
	 * @since 1.0.0
	 * @param string $class class.
	 */
	public function autoload( $class ) {

		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$class_to_load = $class;

		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					array( '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ),
					array( '', '$1-$2', '-', DIRECTORY_SEPARATOR ),
					$class_to_load
				)
			);
			$filename = MAB_DIR . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include $filename;
			}
		}
	}

	/**
	 * Includes.
	 *
	 * @since 1.0.0
	 */
	private function includes() {

		require MAB_DIR . 'classes/class-mab-admin-settings.php';
		require MAB_DIR . 'classes/class-mab-helper.php';

		if ( is_admin() ) {
			require_once MAB_DIR . 'includes/admin/feedback/plugin-feedback.php';

			$this->init_feedback_system();
		}
	}

	/**
	 * Init.
	 *
	 * Initialize plugin components.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		if ( ! defined( 'BRICKS_VERSION' ) ) {
			add_action( 'admin_notices', array( $this, 'max_addons_admin_notice_message' ) );
			add_action( 'network_admin_notices', array( $this, 'max_addons_admin_notice_message' ) );

			return;
		}

		$this->load_textdomain();
		$this->init_actions_filters();
		$this->load_elements();
	}

	/**
	 * Loads Max Addons text domain.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'max-addons', false, basename( MAB_DIR ) . '/languages' );
	}

	/**
	 * Init action and filters.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_actions_filters() {
		$enabled_elements = \MaxAddons\Classes\MAB_Admin_Settings::get_enabled_elements();

		if ( 'disabled' !== $enabled_elements ) {
			// Provide translatable string for element category 'Max Addons'
			add_filter( 'bricks/builder/i18n', array( $this, 'elements_category' ) );
			add_filter( 'bricks/element/set_root_attributes', array( $this, 'filter_element_root_attrs' ), 10, 2 );
		}

		// Action to include script.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Provide translatable string for element category 'max addons'
	 *
	 * @since 1.0.0
	 * @param array $i18n.
	 */
	public function elements_category( $i18n ) {
		$i18n['max-addons-elements'] = esc_html__( 'Max Addons', 'max-addons' );

		return $i18n;
	}

	public function filter_element_root_attrs( $attrs, $element ) {
		if ( false !== strpos( $element->name, 'max-' ) ) {
			// Sometimes bricksIsFrontend in JS is not enough to check.
			// So adding mab-backend class to the element's root.
			if ( isset( $element->is_frontend ) && ! $element->is_frontend ) {
				$attrs['class'][] = 'mab-backend';
			}

			if ( ! isset( $attrs['data-mab-id'] ) && isset( $element->id ) ) {
				$attrs['data-mab-id'] = $element->id;
			}
		}

		return $attrs;
	}

	public function get_script_url( $filename ) {
		$script_route  = defined( 'MAB_DEVELOPMENT' ) ? 'src/' : '';
		$script_suffix = defined( 'MAB_DEVELOPMENT' ) ? '' : '.min';

		if ( 'frontend' === $filename ) {
			return MAB_URL . 'assets/js/' . $filename . $script_suffix . '.js';
		}

		return MAB_URL . 'assets/js/elements/' . $script_route . $filename . $script_suffix . '.js';
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		$debug_suffix = ( Helper::is_script_debug() ) ? '' : '.min';

		/**
		 * Styles.
		 */
		if ( bricks_is_builder() ) {
			wp_enqueue_style( 'mab-editor', MAB_URL . 'assets/css/editor.css', array(), MAB_VER );
		}

		foreach ( $this->get_css_files() as $file_name ) {
			wp_register_style(
				'mab-' . $file_name,
				MAB_URL . 'assets/css/elements/' . $file_name . $debug_suffix . '.css',
				array(),
				MAB_VER,
				'all'
			);
		}

		wp_register_style(
			'mab-contact-form',
			MAB_URL . 'assets/css/elements/forms' . $debug_suffix . '.css',
			array(),
			MAB_VER,
			'all'
		);

		/**
		 * Scripts.
		 */
		
		// Vendor scripts.
		wp_register_script(
			'image-compare',
			MAB_URL . 'assets/lib/image-compare/image-compare-viewer' . $debug_suffix . '.js',
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'lottie-player',
			MAB_URL . 'assets/lib/lottie/lottie-player.js',
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'lottie-interactivity',
			MAB_URL . 'assets/lib/lottie/lottie-interactivity.min.js',
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'tippy',
			MAB_URL . 'assets/lib/tippy/tippy.js',
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'vivus',
			MAB_URL . 'assets/lib/vivus/vivus.min.js',
			'',
			MAB_VER,
			true
		);

		// Internal scripts.
		wp_register_script(
			'mab-hotspots',
			$this->get_script_url( 'hotspots' ),
			[ 'tippy' ],
			MAB_VER,
			true
		);
	
		wp_register_script(
			'mab-image-accordion',
			$this->get_script_url( 'image-accordion' ),
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'mab-lottie',
			$this->get_script_url( 'lottie' ),
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'mab-scroll-image',
			$this->get_script_url( 'scroll-image' ),
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'mab-svg-animation',
			$this->get_script_url( 'svg-animation' ),
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'mab-ticker',
			$this->get_script_url( 'content-ticker' ),
			'',
			MAB_VER,
			true
		);

		wp_register_script(
			'mab-unfold',
			$this->get_script_url( 'unfold' ),
			'',
			MAB_VER,
			true
		);

		if ( bricks_is_builder_iframe() ) {
			wp_enqueue_script( 'image-compare' );
			wp_enqueue_script( 'vivus' );
			wp_enqueue_script( 'lottie-player' );
			wp_enqueue_script( 'lottie-interactivity' );
			wp_enqueue_script( 'mab-lottie' );
		}
	}

	/**
	 * Get CSS files for all the elements
	 */
	public function get_css_files() {
		$paths = glob( MAB_DIR . 'assets/css/elements/*' );

		// Make sure we have an array.
		if ( ! is_array( $paths ) ) {
			return;
		}

		$file_names = array();

		foreach ( $paths as $path ) {
			// Get the CSS file slug.
			$slug = basename( $path, '.css' );

			if ( file_exists( $path ) ) {
				if ( ! str_contains( $slug, '.min' ) ) {
					$file_names[] = $slug;
				}
			}
		}

		return $file_names;
	}

	/**
	 * Loading the elements
	 */
	public function load_elements() {
		$deactivated_components = \MaxAddons\Classes\MAB_Admin_Settings::get_enabled_elements();

		if ( 'disabled' === $deactivated_components ) {
			return;
		}

		$paths = glob( MAB_DIR . 'includes/elements/*' );

		// Make sure we have an array.
		if ( ! is_array( $paths ) ) {
			return;
		}

		// Load all found modules.
		foreach ( $paths as $path ) {

			// Get the module slug.
			$slug = basename( $path, '.php' );

			if ( ! in_array( $slug, $deactivated_components ) ) {
				continue;
			}

			if ( file_exists( $path ) ) {
				\Bricks\Elements::register_element( $path );
			}
		}
	}

	/**
	 * Add plugin deactivation feedback
	 *
	 * @since 1.6.3
	 */
	public function init_feedback_system() {
		$config = [
			// Required settings.
			'plugin_slug'    => 'max-addons-for-bricks',
			'plugin_name'    => 'Max Addons for Bricks',
			'plugin_url'     => MAB_URL,
			'plugin_version' => MAB_VER,
			'assets_url'     => MAB_URL . 'includes/admin/feedback/',

			// Optional settings.
			'review_link'        => 'https://wordpress.org/support/plugin/max-addons-for-bricks/reviews/#new-post',
			'buy_link'           => '',
			'plugin_logo'        => MAB_URL . 'assets/images/max-addons-logo-sm.png',
			'review_notice_days' => 10, // Show review notice after 10 days.

			// Customization options.
			'show_review_notice'         => true,
			'show_deactivation_feedback' => true,
			'collect_system_info'        => true,

			// Custom deactivation reasons (optional)
			'custom_deactivation_reasons' => [],

			'installation_date_option' => '{plugin_slug}_install_date',
			'review_option'            => '{plugin_slug}_review_dismissed',
		];

		$feedback_system = new Mab_Plugin_Feedback($config);
		$feedback_system->cleanup();
	}
}

/**
 *  Prepare if class 'MAB_Plugin' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
MAB_Plugin::get_instance();
