<?php
namespace MaxAddons\Elements;

use MaxAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Formidable_Forms_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-formidable-forms'; // Make sure to prefix your elements
	public $icon         = 'ti-layout-accordion-merged max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Formidable Forms Styler', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-forms' );
		wp_enqueue_style( 'mab-formidable-forms' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['form'] = [ // Unique group identifier (lowercase, no spaces)
			'title' => esc_html__( 'Contact Form', 'max-addons' ), // Localized control group title
			'tab'   => 'content', // Set to either "content" or "style"
		];

		$this->control_groups['titleDescriptionStyle'] = [
			'title' => esc_html__( 'Title and Description', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['inputFields'] = [
			'title' => esc_html__( 'Input Fields', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['spacing'] = [
			'title' => esc_html__( 'Spacing', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['fieldDescription'] = [
			'title' => esc_html__( 'Field Description', 'max-addons' ),
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

		$this->set_title_description_controls();

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
			'options'     => bricks_is_builder() ? Helper::get_contact_forms( 'Formidable_Forms' ) : [],
			'inline'      => false,
			'default'     => '',
			'placeholder' => esc_html__( 'Select', 'max-addons' ),
		);

		$this->controls['formTitle'] = [
			'tab'     => 'content',
			'group'   => 'form',
			'label'   => esc_html__( 'Title', 'max-addons' ),
			'type'    => 'checkbox',
			'default' => false,
		];

		$this->controls['formDescription'] = [
			'tab'     => 'content',
			'group'   => 'form',
			'label'   => esc_html__( 'Description', 'max-addons' ),
			'type'    => 'checkbox',
			'default' => false,
		];
	}

	// Set title and description controls
	public function set_title_description_controls() {
		$this->controls['titleAlign'] = array(
			'tab'         => 'content',
			'group'       => 'titleDescriptionStyle',
			'label'       => esc_html__( 'Alignment', 'max-addons' ),
			'type'        => 'text-align',
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.mab-formidable-forms .frm_form_title',
				],
				[
					'property' => 'text-align',
					'selector' => '.mab-formidable-forms .frm_description p',
				],
			],
			'inline'      => true,
			'default'     => '',
			'placeholder' => '',
		);

		$this->controls['titleSeparator'] = array(
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'separator',
			'label'    => esc_html__( 'Title', 'max-addons' ),
			'required' => [ 'formTitle', '!=', '' ],
		);

		$this->controls['titleTypography'] = [
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'typography',
			'label'    => esc_html__( 'Title Typography', 'max-addons' ),
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .frm_form_title',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'formTitle', '!=', '' ],
		];

		$this->controls['titleMargin'] = [
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'spacing',
			'label'    => esc_html__( 'Margin', 'max-addons' ),
			'css'      => [
				[
					'property' => 'margin',
					'selector' => '.mab-formidable-forms .frm_form_title',
				],
			],
			'required' => [ 'formTitle', '!=', '' ],
		];

		$this->controls['descriptionSeparator'] = array(
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'separator',
			'label'    => esc_html__( 'Description', 'max-addons' ),
			'required' => [ 'formDescription', '!=', '' ],
		);

		$this->controls['descriptionTypography'] = [
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'typography',
			'label'    => esc_html__( 'Description Typography', 'max-addons' ),
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .frm_description p',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'formDescription', '!=', '' ],
		];

		$this->controls['descriptionMargin'] = [
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'spacing',
			'label'    => esc_html__( 'Margin', 'max-addons' ),
			'css'      => [
				[
					'property' => 'margin',
					'selector' => '.mab-formidable-forms .frm_description p',
				],
			],
			'required' => [ 'formDescription', '!=', '' ],
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
					'selector' => '.mab-formidable-forms .form-field label',
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
					'selector' => '.mab-formidable-forms .form-field',
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
					'selector' => '.mab-formidable-forms .frm_submit .frm_button_submit',
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
					'selector' => '.mab-formidable-forms .form-field label',
				],
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .vertical_radio .frm_primary_label',
				],
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .form-field .frm_primary_label',
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
					'selector' => '.mab-formidable-forms .form-field input::-webkit-input-placeholder',
				],
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .form-field textarea::-webkit-input-placeholder',
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
					'selector' => '.mab-formidable-forms .form-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .form-field textarea',
				],
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .form-field select',
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
					'selector' => '.mab-formidable-forms .form-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'background-color',
					'selector' => '.mab-formidable-forms .form-field textarea',
				],
				[
					'property' => 'background-color',
					'selector' => '.mab-formidable-forms .form-field select',
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
					'selector' => '.mab-formidable-forms .form-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'border',
					'selector' => '.mab-formidable-forms .form-field textarea',
				],
				[
					'property' => 'border',
					'selector' => '.mab-formidable-forms .form-field select',
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
					'selector' => '.mab-formidable-forms .form-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'box-shadow',
					'selector' => '.mab-formidable-forms .form-field textarea',
				],
				[
					'property' => 'box-shadow',
					'selector' => '.mab-formidable-forms .form-field select',
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
					'selector' => '.mab-formidable-forms .form-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'width',
					'selector' => '.mab-formidable-forms .form-field select',
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
					'selector'  => '.mab-formidable-forms .form-field textarea',
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
					'selector' => '.mab-formidable-forms .form-field textarea',
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
					'selector' => '.mab-formidable-forms .form-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'padding',
					'selector' => '.mab-formidable-forms .form-field textarea',
				],
				[
					'property' => 'padding',
					'selector' => '.mab-formidable-forms .form-field select',
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
					'selector' => '.mab-formidable-forms .form-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
				],
				[
					'property' => 'text-align',
					'selector' => '.mab-formidable-forms .form-field textarea',
				],
				[
					'property' => 'text-align',
					'selector' => '.mab-formidable-forms .form-field select',
				],
			],
			'inline'      => true,
			'default'     => '',
			'placeholder' => '',
		);
	}

	// Set field description controls
	public function set_field_description_controls() {
		$this->controls['fieldDescTypography'] = [
			'tab'    => 'content',
			'group'  => 'fieldDescription',
			'type'   => 'typography',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-formidable-forms .form-field .frm_description',
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
					'property'  => 'height',
					'selector'  => '.mab-custom-radio-checkbox input[type="checkbox"]',
					'important' => 'true',
				],
				[
					'property'  => 'height',
					'selector'  => '.mab-custom-radio-checkbox input[type="radio"]',
					'important' => 'true',
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
			'placeholder' => esc_html__( 'Left', 'max-addons' ),
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.mab-formidable-forms .frm_submit',
				],
			],
			'inline'      => true,
			'clearable'   => true,
			'pasteStyles' => false,
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
					'selector' => '.mab-formidable-forms .frm_submit .frm_button_submit',
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
					'selector' => '.mab-formidable-forms .frm_submit .frm_button_submit',
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
					'selector' => '.mab-formidable-forms .frm_submit .frm_button_submit',
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
					'selector' => '.mab-formidable-forms .frm_submit .frm_button_submit',
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
					'selector' => '.mab-formidable-forms .frm_submit .frm_button_submit',
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
					'selector' => '.mab-formidable-forms .frm_submit .frm_button_submit',
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
					'selector' => '.mab-formidable-forms .frm_message',
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
					'selector' => '.mab-formidable-forms .frm_message',
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
					'selector' => '.mab-formidable-forms .frm_message',
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
					'selector' => '.mab-formidable-forms .frm_message',
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
					'selector' => '.mab-formidable-forms .frm_message',
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

		if ( ! class_exists( 'FrmForm' ) ) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'Formidable Forms is not installed or activated.', 'max-addons' ) ] );
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
				'mab-formidable-forms',
			)
		);

		if ( isset( $settings['customRadioCheckbox'] ) ) {
			$this->set_attribute( 'container', 'class', 'mab-custom-radio-checkbox' );
		}
		?>
		<div <?php echo $this->render_attributes( '_root' ); ?>>
			<div <?php echo $this->render_attributes( 'container' ); ?>>
				<?php
				$form_id          = $settings['selectForm'];
				$form_title       = ! empty( $settings['formTitle'] ) ? 1 : 0;
				$form_description = ! empty( $settings['formDescription'] ) ? 1 : 0;

				echo do_shortcode( '[formidable id=' . $settings['selectForm'] . ' title=' . $form_title . ' description=' . $form_description . ']' );
				?>
			</div>
		</div>
		<?php
	}
}
