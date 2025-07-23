<?php
namespace MaxAddons\Classes;

/**
 * Handles logic for the admin settings page.
 *
 * @since 1.0.0
 */
final class MAB_Admin_Settings {
	/**
	 * Holds any errors that may arise from
	 * saving admin settings.
	 *
	 * @since 1.0.0
	 * @var array $errors
	 */
	public static $errors = array();

	public static $settings = array();

	/**
	 * Initializes the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function init() {
		self::migrate_settings();

		add_action( 'plugins_loaded', __CLASS__ . '::init_hooks' );

		add_action( 'plugins_loaded', __CLASS__ . '::save_elements' );
	}

	/**
	 * Adds the admin menu and enqueues CSS/JS if we are on
	 * the plugin's admin settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function init_hooks() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_menu', __CLASS__ . '::add_menu_page', 601 );

		if ( isset( $_REQUEST['page'] ) && 'mab-settings' == $_REQUEST['page'] ) {
			//add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles_scripts' );
			self::save();
			self::reset_settings();
		}
	}

	/**
	 * Enqueues the needed CSS/JS for the builder's admin settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function styles_scripts() {
		// Styles
		//wp_enqueue_style( 'mab-admin-settings', MAB_URL . 'assets/css/admin-settings.css', array(), MAB_VER );
	}

	/**
	 * Get settings.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_elements() {
		$elements = array(
			'cta-button'       => esc_html__( 'CTA Button', 'max-addons' ),
			'content-ticker'   => esc_html__( 'Content Ticker', 'max-addons' ),
			'flip-box'         => esc_html__( 'Flip Box', 'max-addons' ),
			'hotspots'         => esc_html__( 'Hotspots', 'max-addons' ),
			'icon-list'        => esc_html__( 'Dynamic List', 'max-addons' ),
			'image-accordion'  => esc_html__( 'Image Accordion', 'max-addons' ),
			'image-comparison' => esc_html__( 'Image Comparison', 'max-addons' ),
			'lottie'           => esc_html__( 'Lottie', 'max-addons' ),
			'multi-heading'    => esc_html__( 'Multi Heading', 'max-addons' ),
			'random-image'     => esc_html__( 'Random Image', 'max-addons' ),
			'rating'           => esc_html__( 'Rating', 'max-addons' ),
			'scroll-image'     => esc_html__( 'Scroll Image', 'max-addons' ),
			'svg-animation'    => esc_html__( 'SVG Animation', 'max-addons' ),
			'unfold'           => esc_html__( 'Unfold', 'max-addons' ),
		);

		// Contact Form 7
		if ( function_exists( 'wpcf7' ) ) {
			$elements['cf7-styler'] = esc_html__( 'Contact Form 7 Styler', 'max-addons' );
		}

		// Gravity Forms
		if ( class_exists( 'GFForms' ) ) {
			$elements['gravity-forms-styler'] = esc_html__( 'Gravity Forms Styler', 'max-addons' );
		}

		// Fluent Forms
		if ( function_exists( 'wpFluentForm' ) ) {
			$elements['fluent-forms-styler'] = esc_html__( 'Fluent Forms Styler', 'max-addons' );
		}

		// Formidable Forms
		if ( class_exists( 'FrmForm' ) ) {
			$elements['formidable-forms-styler'] = __( 'Formidable Forms Styler', 'max-addons' );
		}

		asort( $elements );

		return $elements;
	}

	public static function get_enabled_elements() {
		$enabled_elements = get_option( 'max_bricks_elements' );

		if ( is_array( $enabled_elements ) ) {
			return $enabled_elements;
		}

		if ( 'disabled' == $enabled_elements ) {
			return $enabled_elements;
		}

		return self::get_elements();
	}

	/**
	 * Get settings.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_settings() {
		$default_settings = array();

		$settings = get_option( 'mab_elements_settings' );

		if ( ! is_array( $settings ) || empty( $settings ) ) {
			$settings = $default_settings;
		}

		if ( is_array( $settings ) && ! empty( $settings ) ) {
			$settings = array_merge( $default_settings, $settings );
		}

		return apply_filters( 'mab_elements_admin_settings', $settings );
	}

	/**
	 * Get admin label from settings.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_admin_label() {

		return 'Max Addons';
	}

	/**
	 * Renders the update message.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function render_update_message() {
		if ( ! empty( self::$errors ) ) {
			foreach ( self::$errors as $message ) {
				echo '<div class="error"><p>' . wp_kses_post( $message ) . '</p></div>';
			}
		} elseif ( ! empty( $_POST ) && ! isset( $_POST['email'] ) ) {
			echo '<div class="updated"><p>' . esc_html__( 'Settings updated!', 'max-addons' ) . '</p></div>';
		}
	}

	/**
	 * Adds an error message to be rendered.
	 *
	 * @since 1.0.0
	 * @param string $message The error message to add.
	 * @return void
	 */
	public static function add_error( $message ) {
		self::$errors[] = $message;
	}

	/**
	 * Renders the admin settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function add_menu_page() {
		$admin_label = self::get_admin_label();

		$title = $admin_label;
		$cap   = 'manage_options';
		$slug  = 'mab-settings';
		$func  = __CLASS__ . '::render';

		add_submenu_page( 'bricks', $title, $title, $cap, $slug, $func );
	}

	public static function render() {
		include MAB_DIR . 'includes/admin/admin-settings.php';
	}

	public static function get_tabs() {
		$settings = self::get_settings();

		return apply_filters( 'mab_elements_admin_settings_tabs', array(
			'elements' => array(
				'title'    => esc_html__( 'Elements', 'max-addons' ),
				'show'     => true,
				'cap'      => 'edit_posts',
				'file'     => MAB_DIR . 'includes/admin/admin-settings-elements.php',
				'priority' => 150,
			),
		) );
	}

	public static function render_tabs( $current_tab ) {
		$tabs = self::get_tabs();
		$sorted_data = array();

		foreach ( $tabs as $key => $data ) {
			$data['key'] = $key;
			$sorted_data[ $data['priority'] ] = $data;
		}

		ksort( $sorted_data );

		foreach ( $sorted_data as $data ) {
			if ( $data['show'] ) {
				if ( isset( $data['cap'] ) && ! current_user_can( $data['cap'] ) ) {
					continue;
				}
				?>
				<a href="<?php echo esc_url( self::get_form_action( '&tab=' . $data['key'] ) ); ?>" class="nav-tab<?php echo ( $current_tab == $data['key'] ? ' nav-tab-active' : '' ); ?>"><span><?php echo esc_html( $data['title'] ); ?></span></a>
				<?php
			}
		}
	}

	public static function render_setting_page() {
		$tabs = self::get_tabs();
		$current_tab = self::get_current_tab();

		if ( isset( $tabs[ $current_tab ] ) ) {
			$no_setting_file_msg = esc_html__( 'Setting page file could not be located.', 'max-addons' );

			if ( ! isset( $tabs[ $current_tab ]['file'] ) || empty( $tabs[ $current_tab ]['file'] ) ) {
				echo esc_html( $no_setting_file_msg );
				return;
			}

			if ( ! file_exists( $tabs[ $current_tab ]['file'] ) ) {
				echo esc_html( $no_setting_file_msg );
				return;
			}

			$render = ! isset( $tabs[ $current_tab ]['show'] ) ? true : $tabs[ $current_tab ]['show'];
			$cap = 'manage_options';

			if ( isset( $tabs[ $current_tab ]['cap'] ) && ! empty( $tabs[ $current_tab ]['cap'] ) ) {
				$cap = $tabs[ $current_tab ]['cap'];
			} else {
				$cap = ! is_network_admin() ? 'manage_options' : 'manage_network_plugins';
			}

			if ( ! $render || ! current_user_can( $cap ) ) {
				esc_html_e( 'You do not have permission to view this setting.', 'max-addons' );
				return;
			}

			include $tabs[ $current_tab ]['file'];
		}
	}

	/**
	 * Get current tab.
	 */
	public static function get_current_tab() {
		$current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'elements';

		return $current_tab;
	}

	/**
	 * Renders the action for a form.
	 *
	 * @since 1.0.0
	 * @param string $type The type of form being rendered.
	 * @return void
	 */
	public static function get_form_action( $type = '' ) {
		if ( is_network_admin() ) {
			return network_admin_url( '/admin.php?page=mab-settings' . $type );
		} else {
			return admin_url( '/admin.php?page=mab-settings' . $type );
		}
	}

	public static function get_user_roles() {
		global $wp_roles;

		return $wp_roles->get_names();
	}

	/**
	 * Returns an option from the database for
	 * the admin settings page.
	 *
	 * @since 1.0.0
	 * @param string $key The option key.
	 * @return mixed
	 */
	public static function get_option( $key, $network_override = true ) {
		if ( is_network_admin() ) {
			$value = get_site_option( $key );
		} elseif ( ! $network_override && is_multisite() ) {
			$value = get_site_option( $key );
		} elseif ( $network_override && is_multisite() ) {
			$value = get_option( $key );
			$value = ( false === $value || ( is_array( $value ) && in_array( 'disabled', $value ) && get_option( 'mab_override_ms' ) != 1 ) ) ? get_site_option( $key ) : $value;
		} else {
			$value = get_option( $key );
		}

		return $value;
	}

	/**
	 * Updates an option from the admin settings page.
	 *
	 * @since 1.0.0
	 * @param string $key The option key.
	 * @param mixed $value The value to update.
	 * @return mixed
	 */
	public static function update_option( $key, $value, $network_override = true ) {
		if ( is_network_admin() ) {
			update_site_option( $key, $value );
		}
		// Delete the option if network overrides are allowed and the override checkbox isn't checked.
		elseif ( $network_override && is_multisite() && ! isset( $_POST['mab_override_ms'] ) ) {
			delete_option( $key );
		} else {
			update_option( $key, $value );
		}
	}

	/**
	 * Delete an option from the admin settings page.
	 *
	 * @since 1.0.0
	 * @param string $key The option key.
	 * @param mixed $value The value to delete.
	 * @return mixed
	 */
	public static function delete_option( $key ) {
		if ( is_network_admin() ) {
			delete_site_option( $key );
		} else {
			delete_option( $key );
		}
	}

	public static function save() {
		// Only admins can save settings.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		self::save_elements();

		do_action( 'mab_elements_admin_settings_save' );
	}

	public static function save_elements() {
		if ( ! isset( $_POST['mab-elements-settings-nonce'] ) || ! wp_verify_nonce( $_POST['mab-elements-settings-nonce'], 'mab-elements-settings' ) ) {
			return;
		}

		$enabled_elements = array();

		if ( isset( $_POST['mab_enabled_elements'] ) && ! empty( $_POST['mab_enabled_elements'] ) ) {
			foreach ( $_POST['mab_enabled_elements'] as $enabled_element ) {
				$enabled_elements[] = sanitize_text_field( $enabled_element );
			}
		}

		if ( ! empty( $_POST['mab_enabled_elements'] ) ) {
			update_option( 'max_bricks_elements', wp_unslash( $enabled_elements ) );
		} else {
			update_option( 'max_bricks_elements', 'disabled' );
		}
	}

	public static function reset_settings() {
		if ( isset( $_GET['reset_elements'] ) ) {
			delete_option( 'max_bricks_elements' );
			self::$errors[] = __( 'Elements settings updated!', 'max-addons' );
		}
	}

	public static function migrate_settings() {
		if ( ! is_multisite() ) {
			return;
		}

		if ( 'yes' === get_option( 'mab_multisite_settings_migrated' ) ) {
			return;
		}

		$fields = array(
			'mab_elements_settings',
			'max_bricks_elements',
		);

		foreach ( $fields as $field ) {
			$value = get_site_option( $field );
			if ( $value ) {
				update_option( $field, $value );
			}
		}

		update_option( 'mab_multisite_settings_migrated', 'yes' );
	}
}

MAB_Admin_Settings::init();
