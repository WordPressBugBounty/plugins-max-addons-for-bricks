<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \MaxAddons\Classes\MAB_Admin_Settings;

$maxaddons_current_tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'elements'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<div class="wrap mab-settings-wrap">
	<h1 class="title">
		<span>
			<?php esc_html_e( 'Max Addons Settings', 'max-addons-for-bricks' ); ?>
		</span>
	</h1>
	<div class="nav-tab-wrapper wp-clearfix">
		<?php self::render_tabs( $maxaddons_current_tab ); ?>
	</div>

	<div class="mab-admin-wrapper">
		<h2 class="mab-notices-target"></h2>
		<?php MAB_Admin_Settings::render_update_message(); ?>
		<form method="post" id="mab-settings-form" action="<?php echo esc_url( self::get_form_action( '&tab=' . esc_html( $maxaddons_current_tab ) ) ); ?>">
			<?php self::render_setting_page(); ?>
			<?php
				submit_button();
			?>
		</form>
	</div>
</div>
