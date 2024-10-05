<?php
use \MaxAddons\Classes\MAB_Admin_Settings;

$elements         = MAB_Admin_Settings::get_elements();
$enabled_elements = MAB_Admin_Settings::get_enabled_elements();
?>
<div class="mab-settings-section">
	<div class="mab-settings-section-content">
		<table class="mab-settings-form">
			<tr>
				<th>
					<label for="elements">
						<?php esc_html_e( 'Elements', 'max-addons' ); ?>
					</label>
				</th>
				<td>
					<button type="button" class="button toggle-all-widgets"><?php esc_html_e( 'Toggle All', 'max-addons' ); ?></button>

					<table class="form-table mab-settings-elements-grid">
						<?php
						foreach ( $elements as $element_name => $element_title ) :
							if ( ! is_array( $enabled_elements ) && 'disabled' != $enabled_elements ) {
								$element_enabled = true;
							} elseif ( ! is_array( $enabled_elements ) && 'disabled' === $enabled_elements ) {
								$element_enabled = false;
							} else {
								$element_enabled = in_array( $element_name, $enabled_elements ) || isset( $enabled_elements[ $element_name ] );
							}
							?>
							<tr valign="top">
								<th>
									<label for="<?php echo esc_attr( $element_name ); ?>">
										<?php echo esc_attr( $element_title ); ?>
									</label>
								</th>
								<td>
									<label class="mab-admin-field-toggle">
										<input
											id="<?php echo esc_attr( $element_name ); ?>"
											name="mab_enabled_elements[]"
											type="checkbox"
											value="<?php echo esc_attr( $element_name ); ?>"
											<?php echo $element_enabled ? ' checked="checked"' : ''; ?>
										/>
										<span class="mab-admin-field-toggle-slider" aria-hidden="true"></span>
									</label>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>

<?php wp_nonce_field( 'mab-elements-settings', 'mab-elements-settings-nonce' ); ?>

<script>
(function($) {
	if ( $('input[name="mab_enabled_elements[]"]:checked').length > 0 ) {
		$('.toggle-all-widgets').addClass('checked');
	}
	$('.toggle-all-widgets').on('click', function() {
		if ( $(this).hasClass('checked') ) {
			$('input[name="mab_enabled_elements[]"]').prop('checked', false);
			$(this).removeClass('checked');
		} else {
			$('input[name="mab_enabled_elements[]"]').prop('checked', true);
			$(this).addClass('checked');
		}
	});
})(jQuery);
</script>
