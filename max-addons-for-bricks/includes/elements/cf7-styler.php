<?php
namespace MaxAddons\Elements;

use MaxAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class CF7_Styler_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-cf7-styler'; // Make sure to prefix your elements
	public $icon         = 'ti-layout-accordion-merged max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Contact Form 7 Styler', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-forms' );
		wp_enqueue_style( 'mab-cf7-styler' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['form'] = [ // Unique group identifier (lowercase, no spaces)
			'title' => esc_html__( 'Contact Form', 'max-addons' ), // Localized control group title
			'tab'   => 'content', // Set to either "content" or "style"
		];

		$this->control_groups['inputFields'] = [
			'title' => esc_html__( 'Input Fields', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['spacing'] = [
			'title' => esc_html__( 'Spacing', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['customCheckbox'] = [
			'title' => esc_html__( 'Radio And Checkbox', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['submitButton'] = [
			'title' => esc_html__( 'Submit Button', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	// Set builder controls
	public function set_controls() {

		$this->set_form_controls();

		$this->set_input_controls();

		$this->set_spacing_controls();

		$this->set_radio_checkbox_controls();

		$this->set_submit_button_controls();
	}

	// Set before controls
	public function set_form_controls() {
		$this->controls['selectForm'] = [
			'tab'         => 'content',
			'group'       => 'form',
			'label'       => esc_html__( 'Select Form', 'max-addons' ),
			'type'        => 'select',
			'options'     => bricks_is_builder() ? Helper::get_contact_forms( 'Contact_Form_7' ) : [],
			'inline'      => false,
			'default'     => '',
			'placeholder' => esc_html__( 'Select', 'max-addons' ),
		];

		$this->controls['showTitle'] = [
			'tab'   => 'content',
			'group' => 'form',
			'label' => esc_html__( 'Show Custom Title', 'max-addons' ),
			'type'  => 'checkbox',
		];

		$this->controls['formTitle'] = [
			'tab'      => 'content',
			'group'    => 'form',
			'type'     => 'text',
			'label'    => esc_html__( 'Title', 'max-addons' ),
			'default'  => esc_html__( 'Contact Form', 'max-addons' ),
			'required' => [ 'showTitle', '!=', '' ],
		];

		$this->controls['titleTypography'] = [
			'tab'      => 'content',
			'group'    => 'form',
			'label'    => esc_html__( 'Title Typography', 'max-addons' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-cf7-styler .mab-contact-form-title',
				],
			],
			'inline'   => true,
			'required' => [ 'showTitle', '!=', '' ],
		];
	}

	// Set input & textarea controls
	public function set_input_controls() {
		$this->controls['labelsTypography'] = [
			'tab'    => 'style',
			'group'  => 'inputFields',
			'type'   => 'typography',
			'label'  => esc_html__( 'Labels Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.wpcf7 form.wpcf7-form label',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['placeholderTypography'] = [
			'tab'    => 'style',
			'group'  => 'inputFields',
			'type'   => 'typography',
			'label'  => esc_html__( 'Placeholder Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.wpcf7-form-control::placeholder',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputTypography'] = [
			'tab'    => 'style',
			'group'  => 'inputFields',
			'type'   => 'typography',
			'label'  => esc_html__( 'Fields Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.wpcf7-form-control.wpcf7-text',
				],
				[
					'property' => 'font',
					'selector' => '.wpcf7-form-control.wpcf7-textarea',
				],
				[
					'property' => 'font',
					'selector' => '.wpcf7-form-control.wpcf7-select',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputBackgroundColor'] = [
			'tab'    => 'style',
			'group'  => 'inputFields',
			'type'   => 'color',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.wpcf7-form-control.wpcf7-text',
				],
				[
					'property' => 'background-color',
					'selector' => '.wpcf7-form-control.wpcf7-textarea',
				],
				[
					'property' => 'background-color',
					'selector' => '.wpcf7-form-control.wpcf7-select',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputBorder'] = [
			'tab'    => 'style',
			'group'  => 'inputFields',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.wpcf7-form-control.wpcf7-text',
				],
				[
					'property' => 'border',
					'selector' => '.wpcf7-form-control.wpcf7-textarea',
				],
				[
					'property' => 'border',
					'selector' => '.wpcf7-form-control.wpcf7-select',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputBoxShadow'] = [
			'tab'     => 'content',
			'group'   => 'inputFields',
			'label'   => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'    => 'box-shadow',
			'css'     => [
				[
					'property' => 'box-shadow',
					'selector' => '.wpcf7-form-control.wpcf7-text',
				],
				[
					'property' => 'box-shadow',
					'selector' => '.wpcf7-form-control.wpcf7-textarea',
				],
				[
					'property' => 'box-shadow',
					'selector' => '.wpcf7-form-control.wpcf7-select',
				],
			],
			'inline'  => true,
			'small'   => true,
			'default' => [
				'values' => [
					'offsetX' => 0,
					'offsetY' => 0,
					'blur'    => 2,
					'spread'  => 0,
				],
				'color'  => [
					'rgb' => 'rgba(0, 0, 0, .1)',
				],
			],
		];

		$this->controls['inputWidth'] = [
			'tab'   => 'content',
			'group' => 'inputFields',
			'label' => esc_html__( 'Input Width', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => '.wpcf7-form-control.wpcf7-text',
				],
				[
					'property' => 'width',
					'selector' => '.wpcf7-form-control.wpcf7-select',
				],
			],
		];

		$this->controls['textareaWidth'] = [
			'tab'   => 'content',
			'group' => 'inputFields',
			'label' => esc_html__( 'Textarea Width', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property'  => 'width',
					'selector'  => '.wpcf7-form-control.wpcf7-textarea',
					'important' => 'true',
				],
			],
		];

		$this->controls['inputPadding'] = [
			'tab'   => 'content',
			'group' => 'inputFields',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.wpcf7-form-control.wpcf7-text',
				],
				[
					'property' => 'padding',
					'selector' => '.wpcf7-form-control.wpcf7-textarea',
				],
			],
		];

		$this->controls['inputTextAlign'] = [
			'tab'         => 'content',
			'group'       => 'inputFields',
			'label'       => esc_html__( 'Text align', 'max-addons' ),
			'type'        => 'text-align',
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.wpcf7-form-control.wpcf7-text',
				],
				[
					'property' => 'text-align',
					'selector' => '.wpcf7-form-control.wpcf7-textarea',
				],
				[
					'property' => 'text-align',
					'selector' => '.wpcf7-form-control.wpcf7-select',
				],
			],
			'inline'      => true,
			'default'     => '',
			'placeholder' => '',
		];
	}

	// Set spacing controls
	public function set_spacing_controls() {
		$this->controls['labelSpacing'] = [
			'tab'   => 'content',
			'group' => 'spacing',
			'label' => esc_html__( 'Labels Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.wpcf7-form label',
				],
			],
		];

		$this->controls['inputSpacing'] = [
			'tab'   => 'content',
			'group' => 'spacing',
			'label' => esc_html__( 'Fields Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.wpcf7-form p:not(:last-of-type) .wpcf7-form-control-wrap',
				],
			],
		];
	}

	// Set radio & checkbox controls
	public function set_radio_checkbox_controls() {
		$this->controls['customRadioCheckbox'] = [
			'tab'   => 'content',
			'group' => 'customCheckbox',
			'label' => esc_html__( 'Custom Styles', 'max-addons' ),
			'type'  => 'checkbox',
		];

		$this->controls['radioCheckboxSize'] = [
			'tab'      => 'content',
			'group'    => 'customCheckbox',
			'label'    => esc_html__( 'Size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property'  => 'width',
					'selector'  => '.mab-custom-radio-checkbox input[type="checkbox"]',
					'important' => 'true',
				],
				[
					'property'  => 'width',
					'selector'  => '.mab-custom-radio-checkbox input[type="radio"]',
					'important' => 'true',
				],
				[
					'property' => 'height',
					'selector' => '.mab-custom-radio-checkbox input[type="checkbox"]',
				],
				[
					'property' => 'height',
					'selector' => '.mab-custom-radio-checkbox input[type="radio"]',
				],
			],
			'required' => [ 'customRadioCheckbox', '!=', '' ],
		];

		$this->controls['radioCheckboxColor'] = [
			'tab'      => 'content',
			'group'    => 'customCheckbox',
			'label'    => esc_html__( 'Color', 'max-addons' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background',
					'selector' => '.mab-custom-radio-checkbox input[type="checkbox"], .mab-custom-radio-checkbox input[type="radio"]',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'customRadioCheckbox', '!=', '' ],
		];

		$this->controls['checkboxBorder'] = [
			'tab'      => 'content',
			'group'    => 'customCheckbox',
			'label'    => esc_html__( 'Checkbox Border', 'max-addons' ),
			'type'     => 'border',
			'inline'   => true,
			'small'    => true,
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-custom-radio-checkbox input[type="checkbox"]',
				],
			],
			'required' => [ 'customRadioCheckbox', '!=', '' ],
		];

		$this->controls['radioBorder'] = [
			'tab'      => 'content',
			'group'    => 'customCheckbox',
			'label'    => esc_html__( 'Radio Border', 'max-addons' ),
			'type'     => 'border',
			'inline'   => true,
			'small'    => true,
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-custom-radio-checkbox input[type="radio"]',
				],
			],
			'required' => [ 'customRadioCheckbox', '!=', '' ],
		];
	}

	// Set submit button controls
	public function set_submit_button_controls() {

		$this->controls['buttonAlign'] = [
			'tab'         => 'content',
			'group'       => 'submitButton',
			'label'       => esc_html__( 'Alignment', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'left'   => esc_html__( 'Left', 'max-addons' ),
				'center' => esc_html__( 'Center', 'max-addons' ),
				'right'  => esc_html__( 'Right', 'max-addons' ),
			],
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.wpcf7-form p:nth-last-of-type(1)',
				],
				[
					'property' => 'display',
					'selector' => '.wpcf7-form input[type="submit"]',
					'value'    => 'inline-block',
				],
			],
			'inline'      => true,
			'clearable'   => false,
			'pasteStyles' => false,
			'default'     => 'left',
		];

		$this->controls['submitButtonWidth'] = [
			'tab'   => 'content',
			'group' => 'submitButton',
			'label' => esc_html__( 'Width', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => '.wpcf7-form input[type="submit"]',
				],
				[
					'property' => 'text-align',
					'selector' => '.wpcf7-form input[type="submit"]',
					'value'    => 'center',
				],
			],
		];

		$this->controls['submitButtonTypography'] = [
			'tab'    => 'content',
			'group'  => 'submitButton',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.wpcf7-form input[type="submit"]',
				],
			],
			'inline' => true,
		];

		$this->controls['submitButtonBackgroundColor'] = [
			'tab'    => 'content',
			'group'  => 'submitButton',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.wpcf7-form input[type="submit"]',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['submitButtonBorder'] = [
			'tab'    => 'content',
			'group'  => 'submitButton',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'type'   => 'border',
			'inline' => true,
			'small'  => true,
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.wpcf7-form input[type="submit"]',
				],
			],
		];

		$this->controls['buttonBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'submitButton',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.wpcf7-form input[type="submit"]',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonSpacing'] = [
			'tab'   => 'content',
			'group' => 'submitButton',
			'label' => esc_html__( 'Spacing from Top', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-top',
					'selector' => '.wpcf7-form input[type="submit"]',
				],
			],
			'units' => [
				'px' => [
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				],
				'%'  => [
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				],
			],
		];

		$this->controls['buttonPadding'] = [
			'tab'   => 'content',
			'group' => 'submitButton',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.wpcf7-form input[type="submit"]',
				],
			],
		];
	}

	// Render element HTML
	public function render() {
		$settings = $this->settings;

		if ( ! isset( $settings['selectForm'] ) || empty( $settings['selectForm'] ) ) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'No contact form selected.', 'max-addons' ) ] );
		}

		$this->set_attribute( '_root', 'class', 'mab-contact-form-container' );

		// Set element attributes
		$wrapper_classes[] = 'mab-contact-form mab-cf7-styler';

		if ( isset( $settings['customRadioCheckbox'] ) ) {
			$wrapper_classes[] = 'mab-custom-radio-checkbox';
		}

		// Set attribute tag for 'container'
		$this->set_attribute( 'container', 'class', $wrapper_classes );
		?>
		<div <?php echo $this->render_attributes( '_root' ); ?>>
			<div <?php echo $this->render_attributes( 'container' ); ?>>
				<?php if ( class_exists( 'WPCF7_ContactForm' ) ) { ?>
					<?php if ( isset( $settings['showTitle'] ) ) { ?>
						<h3 class="mab-contact-form-title">
							<?php echo esc_attr( $settings['formTitle'] ); ?>
						</h3>
					<?php } ?>
					<?php echo do_shortcode( '[contact-form-7 id="' . $settings['selectForm'] . '" ]' ); ?>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}
