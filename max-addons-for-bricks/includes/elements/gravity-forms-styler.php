<?php
namespace MaxAddons\Elements;

use MaxAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Gravity_Forms_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-gravity-forms'; // Make sure to prefix your elements
	public $icon         = 'ti-layout-accordion-merged max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Gravity Forms Styler', 'max-addons' );
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

		$this->control_groups['sectionField'] = [
			'title' => esc_html__( 'Section Field', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['price'] = [
			'title' => esc_html__( 'Price', 'max-addons' ),
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

		$this->control_groups['pagination'] = [
			'title' => esc_html__( 'Pagination', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['progress'] = [
			'title' => esc_html__( 'Progress', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['errors'] = [
			'title' => esc_html__( 'Errors', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['thankyou'] = [
			'title' => esc_html__( 'Thank You Message', 'max-addons' ),
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

		$this->set_section_field_controls();

		$this->set_price_controls();

		$this->set_radio_checkbox_controls();

		$this->set_submit_button_controls();

		$this->set_pagination_controls();

		$this->set_progress_controls();

		$this->set_errors_controls();

		$this->set_thankyou_message_controls();
	}

	// Set before controls
	public function set_form_controls() {
		$this->controls['selectForm'] = array(
			'tab'         => 'content',
			'group'       => 'form',
			'label'       => esc_html__( 'Select Form', 'max-addons' ),
			'type'        => 'select',
			'options'     => bricks_is_builder() ? Helper::get_contact_forms( 'Gravity_Forms' ) : [],
			'inline'      => false,
			'default'     => '',
			'placeholder' => esc_html__( 'Select', 'max-addons' ),
		);

		$this->controls['formTitle'] = [
			'tab'     => 'content',
			'group'   => 'form',
			'label'   => esc_html__( 'Title', 'max-addons' ),
			'type'    => 'checkbox',
			'default' => 'true',
		];

		$this->controls['formDescription'] = [
			'tab'     => 'content',
			'group'   => 'form',
			'label'   => esc_html__( 'Description', 'max-addons' ),
			'type'    => 'checkbox',
			'default' => 'true',
		];

		$this->controls['form_ajax'] = [
			'tab'         => 'content',
			'group'       => 'form',
			'label'       => esc_html__( 'Use Ajax', 'max-addons' ),
			'description' => esc_html__( 'Use ajax to submit the form', 'max-addons' ),
			'type'        => 'checkbox',
		];

		$this->controls['fieldValuesSep'] = [
			'tab'      => 'content',
			'group'    => 'form',
			'type'     => 'separator',
			'label'    => esc_html__( 'Field Values', 'max-addons' ),
		];

		$this->controls['fieldValuesInfo'] = [
			'tab'     => 'content',
			'group'   => 'form',
			'type'    => 'info',
			'content' => sprintf(
				esc_html__( 'Dynamically populate contact form with field values. Read more about field values %1$shere%2$s.', 'max-addons' ),
				'<a href="https://www.gravityforms.com/blog/dynamic-population-tutorial/" target="_blank">',
				'</a>',
			),
		];

		$this->controls['fieldValues'] = [
			'tab'           => 'content',
			'group'         => 'form',
			'label'         => esc_html__( 'Field Values', 'max-addons' ),
			'placeholder'   => esc_html__( 'Field Values', 'max-addons' ),
			'type'          => 'repeater',
			'titleProperty' => 'parameterName',
			'fields'        => [
				'parameterName'         => [
					'label'          => esc_html__( 'Parameter name', 'max-addons' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],
				'fieldValue'         => [
					'label'          => esc_html__( 'Field value', 'max-addons' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],
			],
		];
	}

	// Set labels controls
	public function set_title_description_controls() {
		$this->controls['titleTypography'] = [
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'typography',
			'label'    => esc_html__( 'Title Typography', 'max-addons' ),
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.gform_wrapper .gform_title',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'formTitle', '!=', '' ],
		];

		$this->controls['descriptionTypography'] = [
			'tab'      => 'content',
			'group'    => 'titleDescriptionStyle',
			'type'     => 'typography',
			'label'    => esc_html__( 'Description Typography', 'max-addons' ),
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.gform_wrapper .gform_description',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'formDescription', '!=', '' ],
		];

		$this->controls['titleAlign'] = array(
			'tab'         => 'content',
			'group'       => 'titleDescriptionStyle',
			'label'       => esc_html__( 'Alignment', 'max-addons' ),
			'type'        => 'text-align',
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.gform_wrapper .gform_heading',
				],
			],
			'inline'      => true,
			'default'     => '',
			'placeholder' => '',
		);
	}

	// Set spacing controls
	public function set_spacing_controls() {

		$this->controls['titleSpacing'] = [
			'tab'      => 'content',
			'group'    => 'spacing',
			'label'    => esc_html__( 'Title Spacing', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'margin-bottom',
					'selector' => '.gform_wrapper .gform_title',
				],
			],
			'required' => [ 'formTitle', '!=', '' ],
		];

		$this->controls['descriptionSpacing'] = [
			'tab'      => 'content',
			'group'    => 'spacing',
			'label'    => esc_html__( 'Description Spacing', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'margin-bottom',
					'selector' => '.gform_wrapper .gform_heading',
				],
			],
			'required' => [ 'formDescription', '!=', '' ],
		];

		$this->controls['labelSpacing'] = [
			'tab'   => 'content',
			'group' => 'spacing',
			'label' => esc_html__( 'Labels Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.gfield label',
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
					'selector' => '.gfield',
				],
			],
		];

		$this->controls['fieldDescriptionSpacing'] = [
			'tab'   => 'content',
			'group' => 'spacing',
			'label' => esc_html__( 'Field Description Top Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'padding-top',
					'selector' => '.gfield .gfield_description',
				],
			],
		];

		$this->controls['paginationTopSpacing'] = [
			'tab'   => 'content',
			'group' => 'spacing',
			'label' => esc_html__( 'Pagination Top Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-top',
					'selector' => '.gform_page_footer input[type="button"]',
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
					'selector' => '.gform_footer input[type="submit"], .mab-gravity-form .gform_page_footer input[type="submit"]',
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
					'selector' => '.gfield label',
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
					'selector' => '.gfield input::-webkit-input-placeholder, .mab-gravity-form .gfield textarea::-webkit-input-placeholder',
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
					'selector' => '.gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .mab-gravity-form .gfield textarea, .mab-gravity-form .gfield select',
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
					'selector' => '.gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .mab-gravity-form .gfield textarea, .mab-gravity-form .gfield select',
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
					'selector' => '.gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .mab-gravity-form .gfield textarea, .mab-gravity-form .gfield select',
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
					'selector' => '.gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .mab-gravity-form .gfield textarea, .mab-gravity-form .gfield select',
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
					'selector' => '.gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .mab-gravity-form .gfield select',
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
					'property' => 'width',
					'selector' => '.gfield textarea',
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
					'selector' => '.gfield textarea',
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
					'selector' => '.gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .mab-gravity-form .gfield textarea, .mab-gravity-form .gfield select',
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
					'selector' => '.gfield input[type="text"], .mab-gravity-form .gfield textarea, .mab-gravity-form .gfield select',
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
					'selector' => '.gfield .gfield_description',
				],
			],
			'inline' => true,
			'small'  => true,
		];
	}

	// Set section field controls
	public function set_section_field_controls() {
		$this->controls['sectionFieldTypography'] = [
			'tab'    => 'content',
			'group'  => 'sectionField',
			'type'   => 'typography',
			'label'  => esc_html__( 'Title Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gfield.gsection .gsection_title',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['sectionFieldDescTypography'] = [
			'tab'    => 'content',
			'group'  => 'sectionField',
			'type'   => 'typography',
			'label'  => esc_html__( 'Description Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gfield.gsection .gsection_description',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['sectionFieldBorder'] = [
			'tab'    => 'content',
			'group'  => 'sectionField',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'type'   => 'border',
			'inline' => true,
			'small'  => true,
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.gfield.gsection',
				],
			],
		];

		$this->controls['sectionFieldPadding'] = [
			'tab'   => 'content',
			'group' => 'sectionField',
			'label' => esc_html__( 'Margin', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.gfield.gsection',
				],
			],
		];
	}

	// Set price controls
	public function set_price_controls() {
		$this->controls['priceLabelColor'] = [
			'tab'    => 'content',
			'group'  => 'price',
			'label'  => esc_html__( 'Price Label Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'color',
					'selector' => '.gform_wrapper .ginput_product_price_label',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['priceColor'] = [
			'tab'    => 'content',
			'group'  => 'price',
			'label'  => esc_html__( 'Price Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'color',
					'selector' => '.gform_wrapper .ginput_product_price',
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
					'selector'  => '.mab-custom-radio-checkbox input[type="checkbox"], .mab-custom-radio-checkbox input[type="radio"]',
					'important' => 'true',
				],
				[
					'property' => 'height',
					'selector' => '.mab-custom-radio-checkbox input[type="checkbox"], .mab-custom-radio-checkbox input[type="radio"]',
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

		$this->controls['radioCheckboxColorChecked'] = [
			'tab'      => 'content',
			'group'    => 'customCheckbox',
			'label'    => esc_html__( 'Checked Color', 'max-addons' ),
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
					'selector' => '.gform_footer, .mab-gravity-form .gform_page_footer',
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
					'selector' => '.gform_footer input[type="submit"], .mab-gravity-form .gform_page_footer input[type="submit"]',
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
					'selector' => '.gform_footer input[type="submit"], .mab-gravity-form .gform_page_footer input[type="submit"]',
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
					'selector' => '.gform_footer input[type="submit"], .mab-gravity-form .gform_page_footer input[type="submit"]',
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
					'selector' => '.gform_footer input[type="submit"], .mab-gravity-form .gform_page_footer input[type="submit"]',
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
					'selector' => '.gform_footer input[type="submit"], .mab-gravity-form .gform_page_footer input[type="submit"]',
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
					'selector' => '.gform_footer input[type="submit"], .mab-gravity-form .gform_page_footer input[type="submit"]',
				],
			],
		];
	}

	// Set pagination controls
	public function set_pagination_controls() {
		$this->controls['paginationWidth'] = [
			'tab'   => 'content',
			'group' => 'pagination',
			'label' => esc_html__( 'Width', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => '.gform_page_footer input[type="button"]',
				],
			],
		];

		$this->controls['paginationButtonTypography'] = [
			'tab'    => 'content',
			'group'  => 'pagination',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gform_page_footer input[type="button"]',
				],
			],
			'inline' => true,
		];

		$this->controls['paginationButtonBackgroundColor'] = [
			'tab'    => 'content',
			'group'  => 'pagination',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.gform_page_footer input[type="button"]',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['paginationButtonBorder'] = [
			'tab'    => 'content',
			'group'  => 'pagination',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'type'   => 'border',
			'inline' => true,
			'small'  => true,
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.gform_page_footer input[type="button"]',
				],
			],
		];

		$this->controls['paginationButtonBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'pagination',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.gform_page_footer input[type="button"]',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['paginationButtonPadding'] = [
			'tab'   => 'content',
			'group' => 'pagination',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.gform_page_footer input[type="button"]',
				],
			],
		];
	}

	// Set progress controls
	public function set_progress_controls() {

		$this->controls['progressLabelTypography'] = [
			'tab'    => 'content',
			'group'  => 'progress',
			'label'  => esc_html__( 'Label Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gform_wrapper .gf_progressbar_wrapper .gf_progressbar_title, .mab-gravity-form .gform_wrapper .gf_step',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['percentageTypography'] = [
			'tab'    => 'content',
			'group'  => 'progress',
			'label'  => esc_html__( 'Percentage Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gform_wrapper .gf_progressbar_percentage span',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['progressBarBg'] = [
			'tab'    => 'content',
			'group'  => 'progress',
			'label'  => esc_html__( 'Bar Background Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.gform_wrapper .gf_progressbar',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['progressBarPercentageBg'] = [
			'tab'    => 'content',
			'group'  => 'progress',
			'label'  => esc_html__( 'Percentage Background Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background',
					'selector' => '.gform_wrapper .gf_progressbar_percentage',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['progressBorder'] = [
			'tab'    => 'content',
			'group'  => 'progress',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'type'   => 'border',
			'inline' => true,
			'small'  => true,
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.gform_wrapper .gf_progressbar',
				],
			],
		];

		$this->controls['progressBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'progress',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.gform_wrapper .gf_progressbar',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['progressBarHeight'] = [
			'tab'   => 'content',
			'group' => 'progress',
			'label' => esc_html__( 'Height', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'height',
					'selector' => '.gform_wrapper .gf_progressbar_percentage',
				],
				[
					'property' => 'line-height',
					'selector' => '.gform_wrapper .gf_progressbar_percentage span',
				],
			],
		];
	}

	// Set errors controls
	public function set_errors_controls() {
		$this->controls['errorSeparator'] = array(
			'tab'   => 'content',
			'group' => 'errors',
			'type'  => 'separator',
			'label' => esc_html__( 'Error Messages', 'max-addons' ),
		);

		$this->controls['errorTypography'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gfield .validation_message',
				],
			],
			'inline' => true,
		];

		$this->controls['validationSeparator'] = array(
			'tab'   => 'content',
			'group' => 'errors',
			'type'  => 'separator',
			'label' => esc_html__( 'Validation Errors', 'max-addons' ),
		);

		$this->controls['validationErrorTypography'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Error Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gform_wrapper .validation_error',
				],
			],
			'inline' => true,
		];

		$this->controls['validation_error_border_color'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Error Border Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'border-top-color',
					'selector' => '.gform_wrapper .validation_error, .mab-gravity-form .gfield_error',
				],
				[
					'property' => 'border-bottom-color',
					'selector' => '.gform_wrapper .validation_error, .mab-gravity-form .gfield_error',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['validation_error_bg_color'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Error Field Background Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background',
					'selector' => '.gfield_error',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['validation_error_field_label_typography'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Error Field Label Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gfield_error .gfield_label',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['validation_error_field_input_border_color'] = [
			'tab'    => 'content',
			'group'  => 'errors',
			'label'  => esc_html__( 'Error Field Input Border Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'border-color',
					'selector' => '.gform_wrapper li.gfield_error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .gform_wrapper li.gfield_error textarea',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['validation_error_field_input_border_width'] = [
			'tab'   => 'content',
			'group' => 'errors',
			'label' => esc_html__( 'Error Field Input Border Width', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'border-width',
					'selector' => '.gform_wrapper li.gfield_error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), .gform_wrapper li.gfield_error textarea',
				],
			],
		];
	}

	// Set thank you message controls
	public function set_thankyou_message_controls() {
		$this->controls['ty_message_typography'] = [
			'tab'    => 'content',
			'group'  => 'thankyou',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.gform_confirmation_wrapper',
				],
			],
			'inline' => true,
		];

		$this->controls['ty_bg_color'] = [
			'tab'    => 'content',
			'group'  => 'thankyou',
			'label'  => esc_html__( 'Background Color', 'max-addons' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.gform_confirmation_wrapper',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['ty_message_border'] = [
			'tab'    => 'content',
			'group'  => 'thankyou',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.gform_confirmation_wrapper',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tyPadding'] = [
			'tab'     => 'content',
			'group'   => 'thankyou',
			'label'   => esc_html__( 'Padding', 'max-addons' ),
			'type'    => 'spacing',
			'css'     => [
				[
					'property' => 'padding',
					'selector' => '.gform_confirmation_wrapper',
				],
			],
			'default' => [
				'top'    => 10,
				'right'  => 10,
				'bottom' => 10,
				'left'   => 10,
			],
		];

		$this->controls['tyAlign'] = array(
			'tab'         => 'content',
			'group'       => 'thankyou',
			'label'       => esc_html__( 'Alignment', 'max-addons' ),
			'type'        => 'text-align',
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.gform_confirmation_wrapper',
				],
			],
			'inline'      => true,
			'default'     => '',
			'placeholder' => '',
		);
	}

	// Render element HTML
	public function render() {
		$settings = $this->settings;

		if ( ! class_exists( 'GFCommon' ) ) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'Gravity forms is not installed or activated.', 'max-addons' ) ] );
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
				'mab-gravity-form',
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
				$form_title       = isset( $settings['formTitle'] );
				$form_description = isset( $settings['formDescription'] );

				$field_values = [];

				if ( ! empty( $settings['fieldValues'] ) ) {
					foreach ( $settings['fieldValues'] as $field_value ) {
						$name  = isset( $field_value['parameterName'] ) ? $field_value['parameterName'] : '';
						$value = isset( $field_value['fieldValue'] ) ? $field_value['fieldValue'] : '';

						if ( $name ) {
							$field_values[ $name ] = $value;
						}
					}
				}

				$form_id   = $settings['selectForm'];
				$form_ajax = isset( $settings['form_ajax'] );

				gravity_form( $form_id, $form_title, $form_description, $display_inactive = false, $field_values, $form_ajax, '', $echo = true );
				?>
			</div>
		</div>
		<?php
	}
}
