<?php
use \MaxAddons\Classes\MAB_Admin_Settings;

$current_tab  = isset( $_REQUEST['tab'] ) ? sanitize_text_field( $_REQUEST['tab'] ) : 'elements';
$settings     = MAB_Admin_Settings::get_settings();
?>
<style>
#footer-left {
	display: none;
}
.mab-settings-wrap .nav-tab-wrapper {
	margin: 15px 0 0;
}
.mab-settings-wrap * {
	box-sizing: border-box;
}
.mab-notices-target {
	margin: 0;
}
.mab-admin-wrapper {
	max-width: 960px;
	padding: 40px 20px;
}
.mab-settings-form > tbody > tr > th {
	width: 300px;
	max-width: 30%;
	padding: 15px 20px;
	font-weight: 400;
	line-height: 1.7;
	text-align: initial;
	vertical-align: initial;
	background-color: #fff;
	border-right: 1px solid #ddd;
}
.mab-settings-form > tbody > tr > td {
	width: 100%;
	padding: 20px 30px;
	text-align: initial;
	background-color: #fff;
}
.mab-settings-form > tbody > tr > th label {
	font-size: 14px;
	font-weight: 700;
	cursor: default;
	min-width: 120px;
	display: inline-block;
	text-transform: capitalize;
}
.mab-admin-wrapper > form {
}
.mab-admin-wrapper > form .form-table th {
	font-weight: 500;
}
.mab-settings-section {
	background: #fff;
	box-shadow: 1px 1px 10px 0 rgba(0,0,0,0.05);
	margin-bottom: 20px;
}
.mab-settings-section .mab-settings-section-title {
	font-weight: 300;
	font-size: 22px;
	border-bottom: 1px solid #eee;
	padding-bottom: 15px;
}
.mab-settings-section .mab-settings-elements-grid > tbody {
	display: flex;
	align-items: center;
	flex-direction: row;
	flex-wrap: wrap;
}
.mab-settings-section .mab-settings-elements-grid > tbody tr {
	background: #fefefe;
	border: 1px solid rgb(0 4 32 / 7%);
	margin-right: 20px;
	margin-bottom: 20px;
	padding: 12px;
	border-radius: 5px;
}
.mab-settings-section .mab-settings-elements-grid > tbody tr th,
.mab-settings-section .mab-settings-elements-grid > tbody tr td {
	padding: 0;
}
.mab-settings-section .mab-settings-elements-grid th > label {
	user-select: none;
}
.mab-settings-section .toggle-all-widgets {
	margin-bottom: 20px;
}
.mab-settings-section .mab-admin-field-toggle {
	position: relative;
	display: inline-block;
	width: 26px;
	height: 16px;
}
.mab-settings-section .mab-admin-field-toggle input {
	opacity: 0;
	width: 0;
	height: 0;
}
.mab-settings-section .mab-admin-field-toggle .mab-admin-field-toggle-slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #e1e3e8;
	border-radius: 16px;
	height: 16px;
	outline: none;
	-webkit-transition: .4s;
	transition: .4s;
}
.mab-settings-section .mab-admin-field-toggle .mab-admin-field-toggle-slider:before {
	border-radius: 12px;
	position: absolute;
	content: "";
	height: 12px;
	width: 12px;
	left: 2px;
	bottom: 2px;
	background-color: #fff;
	opacity: 0.5;
	-webkit-transition: .4s;
	transition: .4s;
}
.mab-settings-section .mab-admin-field-toggle input[type="checkbox"]:checked + .mab-admin-field-toggle-slider {
	background-color: #2271b1;
}
.mab-settings-section .mab-admin-field-toggle input[type="checkbox"]:checked + .mab-admin-field-toggle-slider:before {
	left: 0;
	opacity: 1;
	-webkit-transform: translateX(100%);
	-ms-transform: translateX(100%);
	transform: translateX(100%);
}
</style>

<div class="wrap mab-settings-wrap">

	<h1 class="title">
		<span>
		<?php
			$admin_label = 'Max Addons';
			echo sprintf( esc_html__( '%s Settings', 'max-addons' ), esc_html( $admin_label ) );
		?>
		</span>
	</h1>
	<div class="nav-tab-wrapper wp-clearfix">
		<?php self::render_tabs( $current_tab ); ?>
	</div>

	<div class="mab-admin-wrapper">
		<h2 class="mab-notices-target"></h2>
		<?php MAB_Admin_Settings::render_update_message(); ?>
		<form method="post" id="mab-settings-form" action="<?php echo esc_url( self::get_form_action( '&tab=' . esc_html( $current_tab ) ) ); ?>">
			<?php self::render_setting_page(); ?>
			<?php
				submit_button();
			?>
		</form>
	</div>
</div>
