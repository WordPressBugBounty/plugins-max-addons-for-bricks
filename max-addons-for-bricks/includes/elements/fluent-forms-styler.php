<?php
namespace MaxAddons\Elements;

use MaxAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Fluent_Forms_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-fluent-forms'; // Make sure to prefix your elements
	public $icon         = 'ti-layout-accordion-merged max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Fluent Forms Styler', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-forms' );
		wp_enqueue_style( 'mab-fluent-forms' );
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

		$this->control_groups['helpMessage'] = [
			'title' => esc_html__( 'Help Message', 'max-addons' ),
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

		$this->control_groups['errors'] = [
			'title' => esc_html__( 'Errors', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['confirmation'] = [
			'title' => esc_html__( 'Confirmation Message', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	// Set builder controls
	public function set_controls() {

		$this->set_form_controls();

		$this->set_spacing_controls();

		$this->set_input_controls();

		$this->set_field_description_controls();

		$this->set_radio_checkbox_controls();

		$this->set_submit_button_controls();

		$this->set_errors_controls();

		$this->set_confirmation_message_controls();
	}

	// Set before controls
	public function set_form_controls() {
		$this->controls['selectForm'] = array(
			'tab'         => 'content',
			'group'       => 'form',
			'label'       => esc_html__( 'Select Form', 'max-addons' ),
			'type'        => 'select',
			'options'     => bricks_is_builder() ? Helper::get_contact_forms( 'Fluent_Forms' ) : [],
			'inline'      => false,
			'default'     => '',
			'placeholder' => esc_html__( 'Select', 'max-addons' ),
		);

		$this->controls['showTitle'] = [
			'tab'      => 'content',
			'group'    => 'form',
			'label'    => esc_html__( 'Show Custom Title', 'max-addons' ),
			'type'     => 'checkbox',
			'required' => [ 'selectForm', '!=', '' ],
		];

		$this->controls['formTitle'] = [
			'tab'      => 'content',
			'group'    => 'form',
			'type'     => 'text',
			'label'    => esc_html__( 'Title', 'max-addons' ),
			'default'  => esc_html__( 'Contact Form', 'max-addons' ),
			'inline'   => true,
			'required' => [
				[ 'selectForm', '!=', '' ],
				[ 'showTitle', '!=', '' ]
			],
		];

		$this->controls['titleTag'] = [
			'tab'         => 'content',
			'group'       => 'form',
			'label'       => esc_html__( 'Title Tag', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'h1'  => esc_html__( 'Heading 1 (h1)', 'max-addons' ),
				'h2'  => esc_html__( 'Heading 2 (h2)', 'max-addons' ),
				'h3'  => esc_html__( 'Heading 3 (h3)', 'max-addons' ),
				'h4'  => esc_html__( 'Heading 4 (h4)', 'max-addons' ),
				'h5'  => esc_html__( 'Heading 5 (h5)', 'max-addons' ),
				'h6'  => esc_html__( 'Heading 6 (h6)', 'max-addons' ),
				'div' => esc_html__( 'Division (div)', 'max-addons' ),
			],
			'clearable'   => false,
			'pasteStyles' => false,
			'inline'      => true,
			'default'     => 'h3',
			'required'    => [
				[ 'selectForm', '!=', '' ],
				[ 'showTitle', '!=', '' ]
			],
		];

		$this->controls['titleTypography'] = [
			'tab'      => 'content',
			'group'    => 'form',
			'label'    => esc_html__( 'Title Typography', 'max-addons' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-contact-form-title',
				],
			],
			'inline'   => true,
			'required' => [
				[ 'selectForm', '!=', '' ],
				[ 'showTitle', '!=', '' ]
			],
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
					'selector' => '.ff-el-input--label label',
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
					'selector' => '.ff-el-group',
				],
			],
		];

		$this->controls['fieldDescriptionSpacing'] = [
			'tab'   => 'content',
			'group' => 'spacing',
			'label' => esc_html__( 'Help Message Top Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'padding-top',
					'selector' => '.ff-el-input--content .ff-el-help-message',
				],
			],
		];

		$this->controls['buttonTopSpacing'] = [
			'tab'   => 'content',
			'group' => 'spacing',
			'label' => esc_html__( 'Button Top Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-top',
					'selector' => '.ff-el-group .ff-btn-submit',
				],
			],
		];
	}

	// Set input controls
	public function set_input_controls() {
		$this->controls['labelsTypography'] = [
			'tab'    => 'content',
			'group'  => 'inputFields',
			'type'   => 'typography',
			'label'  => esc_html__( 'Labels Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.ff-el-input--label label',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['placeholderTypography'] = [
			'tab'    => 'content',
			'group'  => 'inputFields',
			'type'   => 'typography',
			'label'  => esc_html__( 'Placeholder Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.ff-el-group input::-webkit-input-placeholder',
				],
				[
					'property' => 'font',
					'selector' => '.ff-el-group textarea::-webkit-input-placeholder',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputTypography'] = [
			'tab'    => 'content',
			'group'  => 'inputFields',
			'type'   => 'typography',
			'label'  => esc_html__( 'Fields Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.ff-el-group input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'font',
					'selector' => '.ff-el-group textarea',
				],
				[
					'property' => 'font',
					'selector' => '.ff-el-group select',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputBackgroundColor'] = [
			'tab'    => 'content',
			'group'  => 'inputFields',
			'type'   => 'color',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.ff-el-group input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'background-color',
					'selector' => '.ff-el-group textarea',
				],
				[
					'property' => 'background-color',
					'selector' => '.ff-el-group select',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputBorder'] = [
			'tab'    => 'content',
			'group'  => 'inputFields',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.ff-el-group input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'border',
					'selector' => '.ff-el-group textarea',
				],
				[
					'property' => 'border',
					'selector' => '.ff-el-group select',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['inputBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'inputFields',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.ff-el-group input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'box-shadow',
					'selector' => '.ff-el-group textarea',
				],
				[
					'property' => 'box-shadow',
					'selector' => '.ff-el-group select',
				],
			],
			'inline' => true,
			'small'  => true,
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
					'selector' => '.ff-el-group input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'width',
					'selector' => '.ff-el-group select',
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
					'selector'  => '.ff-el-group textarea',
					'important' => 'true',
				],
			],
		];

		$this->controls['textareaHeight'] = [
			'tab'   => 'content',
			'group' => 'inputFields',
			'label' => esc_html__( 'Textarea Height', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'height',
					'selector' => '.ff-el-group textarea',
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
					'selector' => '.ff-el-group input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'padding',
					'selector' => '.ff-el-group textarea',
				],
				[
					'property' => 'padding',
					'selector' => '.ff-el-group select',
				],
			],
		];

		$this->controls['inputTextAlign'] = array(
			'tab'         => 'content',
			'group'       => 'inputFields',
			'label'       => esc_html__( 'Text align', 'max-addons' ),
			'type'        => 'text-align',
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.ff-el-group input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'text-align',
					'selector' => '.ff-el-group textarea',
				],
				[
					'property' => 'text-align',
					'selector' => '.ff-el-group select',
				],
			],
			'inline'      => true,
			'default'     => '',
			'placeholder' => '',
		);
	}

	// Set field description controls
	public function set_field_description_controls() {
		$this->controls['helpMessageTypography'] = [
			'tab'    => 'content',
			'group'  => 'helpMessage',
			'type'   => 'typography',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.ff-el-input--content .ff-el-help-message',
				],
			],
			'inline' => true,
			'small'  => true,
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
					'selector' => '.mab-custom-radio-checkbox input[type="checkbox"]',
				],
				[
					'property' => 'background',
					'selector' => '.mab-custom-radio-checkbox input[type="radio"]',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'customRadioCheckbox', '!=', '' ],
		];

		$this->controls['radioCheckboxColorChecked'] = [
			'tab'      => 'content',
			'group'    => 'customCheckbox',
			'label'    => esc_html__( 'Checked Color', 'max-addons' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background',
					'selector' => '.mab-custom-radio-checkbox input[type="checkbox"]:checked:before',
				],
				[
					'property' => 'background',
					'selector' => '.mab-custom-radio-checkbox input[type="radio"]:checked:before',
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
					'selector' => '.frm-fluent-form > .ff-el-group:last-child',
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
					'selector' => '.ff-el-group .ff-btn-submit',
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
					'selector' => '.ff-el-group .ff-btn-submit',
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
					'selector' => '.ff-el-group .ff-btn-submit',
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
					'selector' => '.ff-el-group .ff-btn-submit',
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
					'selector' => '.ff-el-group .ff-btn-submit',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonPadding'] = [
			'tab'   => 'content',
			'group' => 'submitButton',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.ff-el-group .ff-btn-submit',
				],
			],
		];
	}

	// Set errors controls
	public function set_errors_controls() {
		$this->controls['errorMessageSeparator'] = array(
			'tab'   => 'content',
			'group' => 'errors',
			'type'  => 'separator',
			'label' => esc_html__( 'Error Message', 'max-addons' ),
		);

		$this->controls['errorTypography'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.ff-el-is-error .error',
				],
			],
			'inline' => true,
		];
		$this->controls['errorFieldSeparator'] = array(
			'tab'   => 'content',
			'group' => 'errors',
			'type'  => 'separator',
			'label' => esc_html__( 'Error Field', 'max-addons' ),
		);

		$this->controls['errorFieldBorder'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'type'   => 'border',
			'inline' => true,
			'small'  => true,
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.ff-el-is-error .ff-el-form-control',
				],
			],
		];

		$this->controls['errorFieldBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.ff-el-is-error .ff-el-form-control',
				],
			],
			'inline' => true,
			'small'  => true,
		];
	}

	// Set confirmation message controls
	public function set_confirmation_message_controls() {
		$this->controls['tyMessageTypography'] = [
			'tab'    => 'content',
			'group'  => 'confirmation',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.ff-message-success',
				],
			],
			'inline' => true,
		];

		$this->controls['tyBackgroundColor'] = [
			'tab'    => 'content',
			'group'  => 'confirmation',
			'label'  => esc_html__( 'Background Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.ff-message-success',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tyMessageBorder'] = [
			'tab'    => 'content',
			'group'  => 'confirmation',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.ff-message-success',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tyBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'confirmation',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.ff-message-success',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tyPadding'] = [
			'tab'     => 'content',
			'group'   => 'confirmation',
			'label'   => esc_html__( 'Padding', 'max-addons' ),
			'type'    => 'spacing',
			'css'     => [
				[
					'property' => 'padding',
					'selector' => '.ff-message-success',
				],
			],
			'default' => [
				'top'    => 10,
				'right'  => 10,
				'bottom' => 10,
				'left'   => 10,
			],
		];
	}

	// Render element HTML
	public function render() {
		$settings = $this->settings;

		if ( ! function_exists( 'wpFluentForm' ) ) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'Fluent Forms is not installed or activated.', 'max-addons' ) ] );
		}

		if ( ! isset( $settings['selectForm'] ) || empty( $settings['selectForm'] ) ) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'No contact form selected.', 'max-addons' ) ] );
		}

		$this->set_attribute( '_root', 'class', 'mab-contact-form-container' );

		$this->set_attribute(
			'container',
			'class',
			array(
				'mab-contact-form',
				'mab-fluent-forms',
			)
		);

		if ( isset( $settings['customRadioCheckbox'] ) ) {
			$this->set_attribute( 'container', 'class', 'mab-custom-radio-checkbox' );
		}

		$form_title = '';
		$form_description = '';
		?>
		<div <?php echo $this->render_attributes( '_root' ); ?>>
			<div <?php echo $this->render_attributes( 'container' ); ?>>
				<?php
				if ( isset( $settings['showTitle'] ) ) {
					$title_tag = isset( $settings['titleTag'] ) ? $settings['titleTag'] : 'h3';
					?>
					<<?php echo esc_html( $title_tag ); ?> class="mab-contact-form-title">
						<?php echo esc_attr( $settings['formTitle'] ); ?>
					</<?php echo esc_html( $title_tag ); ?>>
					<?php
				}

				$form_id = $settings['selectForm'];

				echo do_shortcode( '[fluentform id="' . $settings['selectForm'] . '" ]' );
				?>
			</div>
		</div>
		<?php
	}
}
