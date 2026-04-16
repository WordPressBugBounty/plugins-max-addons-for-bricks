<?php
namespace MaxAddons\Elements;

use MaxAddons\Base\Element_Base;
use MaxAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Toggle_Element extends Element_Base {
	// Element properties
	public $name         = 'max-content-toggle'; // Make sure to prefix your elements
	public $icon         = 'ti-direction-alt max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = [ 'mabToggle' ]; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Content Toggle', 'max-addons-for-bricks' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-toggle' );
		wp_enqueue_script( 'mab-toggle' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['toggle'] = [
			'title' => esc_html__( 'Tabs', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['toggleStyle'] = [
			'title' => esc_html__( 'Toggle Style', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['contentStyle'] = [
			'title' => esc_html__( 'Content Style', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {

		$this->set_toggle_controls();
		$this->set_toggle_settings_controls();
		$this->set_toggle_style_controls();
		$this->set_toggle_content_style_controls();
	}

	// Set primary controls
	public function set_toggle_controls() {

		$this->controls['switchStyle'] = [
			'tab'       => 'content',
			'group'     => 'toggle',
			'label'     => esc_html__( 'Switch Style', 'max-addons-for-bricks' ),
			'type'      => 'select',
			'options'   => [
				'round'          => esc_html__( 'Round', 'max-addons-for-bricks' ),
				'rectangle'      => esc_html__( 'Rectangular', 'max-addons-for-bricks' ),
				'round-line'     => esc_html__( 'Round Line', 'max-addons-for-bricks' ),
				'rectangle-line' => esc_html__( 'Rectangular Line', 'max-addons-for-bricks' ),
				'button'         => esc_html__( 'Button', 'max-addons-for-bricks' ),
			],
			'inline'    => true,
			'clearable' => false,
			'default'   => 'round',
		];

		$this->controls['contentList'] = [
			'tab'           => 'content',
			'group'         => 'toggle',
			'label'         => esc_html__( 'Tabs', 'max-addons-for-bricks' ),
			'type'          => 'repeater',
			'placeholder'   => esc_html__( 'Toggle', 'max-addons-for-bricks' ),
			'titleProperty' => 'label',
			'fields'        => [
				'label'          => [
					'label'          => esc_html__( 'Label', 'max-addons-for-bricks' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],

				'contentType'    => [
					'label'     => esc_html__( 'Content Type', 'max-addons-for-bricks' ),
					'type'      => 'select',
					'options'   => [
						'content'  => esc_html__( 'Content', 'max-addons-for-bricks' ),
						'template' => esc_html__( 'Saved Template', 'max-addons-for-bricks' ),
					],
					'clearable' => false,
				],

				'toggleContent'  => [
					'label'    => esc_html__( 'Content', 'max-addons-for-bricks' ),
					'type'     => 'editor',
					'required' => [ 'contentType', '=', [ 'content' ] ],
				],

				'toggleTemplate' => [
					'label'       => esc_html__( 'Template', 'max-addons-for-bricks' ),
					'type'        => 'select',
					'options'     => bricks_is_builder() ? Helper::get_templates_list( get_the_ID() ) : [],
					'placeholder' => esc_html__( 'Select Template', 'max-addons-for-bricks' ),
					'description' => esc_html__( 'Please refresh the page to properly load the styles of the template.', 'max-addons-for-bricks' ),
					'searchable'  => true,
					'required'    => [ 'contentType', '=', [ 'template' ] ],
				],

				'icon'           => [
					'label' => esc_html__( 'Icon', 'max-addons-for-bricks' ),
					'type'  => 'icon',
				],

				'iconPosition'   => [
					'label'     => esc_html__( 'Icon Position', 'max-addons-for-bricks' ),
					'type'      => 'select',
					'options'   => $this->control_options['iconPosition'],
					'inline'    => true,
					'clearable' => false,
					'required'  => [ 'icon', '!=', '' ],
				],

				'active'         => [
					'label' => esc_html__( 'Active', 'max-addons-for-bricks' ),
					'type'  => 'checkbox',
				],
			],
			'default'       => [
				[
					'label'         => esc_html__( 'Primary', 'max-addons-for-bricks' ),
					'contentType'   => 'content',
					'toggleContent' => 'Primary Content.',
					'active'        => true,
					'iconPosition'  => 'right',
				],
				[
					'label'         => esc_html__( 'Secondary', 'max-addons-for-bricks' ),
					'contentType'   => 'content',
					'toggleContent' => 'Secondary Content.',
					'iconPosition'  => 'right',
				],
				[
					'label'         => esc_html__( 'Others', 'max-addons-for-bricks' ),
					'contentType'   => 'content',
					'toggleContent' => 'Other Content.',
					'iconPosition'  => 'right',
				],
			],
		];

	}

	// Set settings controls
	public function set_toggle_settings_controls() {
		$this->controls['toggleAlign'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Alignment', 'max-addons-for-bricks' ),
			'type'    => 'justify-content',
			'css'     => [
				[
					'property' => 'justify-content',
					'selector' => '.mab-toggle-switch-container',
				],
			],
			'exclude' => [
				'space',
			],
			'inline'  => true,
		];

		$this->controls['togglePosition'] = [
			'tab'       => 'content',
			'group'     => 'settings',
			'label'     => esc_html__( 'Toggle Position', 'max-addons-for-bricks' ),
			'type'      => 'select',
			'options'   => [
				'before' => esc_html__( 'Before Content', 'max-addons-for-bricks' ),
				'after'  => esc_html__( 'After Content', 'max-addons-for-bricks' ),
			],
			'inline'    => true,
			'clearable' => false,
			'default'   => 'before',
		];

		$this->controls['toggleSpacing'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Spacing', 'max-addons-for-bricks' ),
			'type'        => 'number',
			'units'       => true,
			'css'         => [
				[
					'property' => 'margin-bottom',
					'selector' => '.mab-toggle-switch-before.mab-toggle-switch-container',
				],
				[
					'property' => 'margin-top',
					'selector' => '.mab-toggle-switch-after.mab-toggle-switch-container',
				],
			],
			'placeholder' => 20,
		];
	}

	// Set toggle style controls
	public function set_toggle_style_controls() {
		$this->controls['toggleTypography'] = [
			'tab'    => 'content',
			'group'  => 'toggleStyle',
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button span, .mab-toggle-switch-wrapper .mab-toggle-switch',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['iconSpacing'] = [
			'tab'         => 'content',
			'group'       => 'toggleStyle',
			'label'       => esc_html__( 'Icon Spacing', 'max-addons-for-bricks' ),
			'type'        => 'number',
			'units'       => true,
			'css'         => [
				[
					'property' => 'margin-right',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.mab-toggle-icon-left i, .mab-toggle-switch-wrapper .mab-toggle-switch.mab-toggle-icon-left i',
				],
				[
					'property' => 'margin-left',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.mab-toggle-icon-right i, .mab-toggle-switch-wrapper .mab-toggle-switch.mab-toggle-icon-right i',
				],
			],
			'placeholder' => '',
		];

		$this->controls['labelSpacing'] = [
			'tab'         => 'content',
			'group'       => 'toggleStyle',
			'label'       => esc_html__( 'Title Spacing', 'max-addons-for-bricks' ),
			'type'        => 'number',
			'units'       => true,
			'css'         => [
				[
					'property' => 'margin-right',
					'selector' => '.mab-toggle-switch.primary',
				],
				[
					'property' => 'margin-left',
					'selector' => '.mab-toggle-switch.secondary',
				],
			],
			'placeholder' => '',
			'required'    => [ 'switchStyle', '=', [ 'round', 'round-line', 'rectangle', 'rectangle-line' ] ],
		];

		$this->controls['colorSeparator'] = [
			'tab'   => 'content',
			'group' => 'toggleStyle',
			'type'  => 'separator',
			'label' => esc_html__( 'Color', 'max-addons-for-bricks' ),
		];

		$this->controls['titleActiveColor'] = [
			'tab'    => 'content',
			'group'  => 'toggleStyle',
			'label'  => esc_html__( 'Title Active Color', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'color',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.active span, .mab-toggle-switch-wrapper .mab-toggle-switch.active span',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['iconColor'] = [
			'tab'    => 'content',
			'group'  => 'toggleStyle',
			'label'  => esc_html__( 'Icon Color', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'fill',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button div > svg, .mab-toggle-switch-wrapper .mab-toggle-switch div > svg',
				],
				[
					'property' => 'color',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button div > i, .mab-toggle-switch-wrapper .mab-toggle-switch div > i',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['iconActiveColor'] = [
			'tab'    => 'content',
			'group'  => 'toggleStyle',
			'label'  => esc_html__( 'Icon Active Color', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'fill',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.active div > svg, .mab-toggle-switch-wrapper .mab-toggle-switch.active div > svg',
				],
				[
					'property' => 'color',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.active div > i, .mab-toggle-switch-wrapper .mab-toggle-switch.active div > i',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['titleBgColor'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Background Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['titleBgActiveColor'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Background Active Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.active',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['buttonBorder'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Border', 'max-addons-for-bricks' ),
			'type'     => 'border',
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['buttonActiveBorder'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Active Button Border', 'max-addons-for-bricks' ),
			'type'     => 'border',
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.active',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['buttonBoxShadow'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Box Shadow', 'max-addons-for-bricks' ),
			'type'     => 'box-shadow',
			'css'      => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['buttonActiveBoxShadow'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Active Button Box Shadow', 'max-addons-for-bricks' ),
			'type'     => 'box-shadow',
			'css'      => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button.active',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['toggleSeparator'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'type'     => 'separator',
			'label'    => esc_html__( 'Toggle Switch Style', 'max-addons-for-bricks' ),
			'required' => [ 'switchStyle', '=', [ 'round', 'round-line', 'rectangle', 'rectangle-line' ] ],
		];

		$this->controls['switchSize'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Size', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'font-size',
					'selector' => '.mab-toggle-switch-container .mab-toggle-switch.mab-input-label',
				],
			],
			'required' => [ 'switchStyle', '=', [ 'round', 'round-line', 'rectangle', 'rectangle-line' ] ],
		];

		$this->controls['switchColor'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-input-label .mab-toggle-slider:before',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'round', 'round-line', 'rectangle', 'rectangle-line' ] ],
		];

		$this->controls['switchActiveColor'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Active Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-input-label input:checked+.mab-toggle-slider:before',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'round', 'round-line', 'rectangle', 'rectangle-line' ] ],
		];

		$this->controls['switchBgColor'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Background Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-input-label .mab-toggle-slider',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'round', 'round-line', 'rectangle', 'rectangle-line' ] ],
		];

		$this->controls['switchBgActiveColor'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Background Active Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-input-label input:checked+.mab-toggle-slider',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'round', 'round-line', 'rectangle', 'rectangle-line' ] ],
		];

		$this->controls['spacingSeparator'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'type'     => 'separator',
			'label'    => esc_html__( 'Spacing', 'max-addons-for-bricks' ),
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['buttonMargin'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Margin', 'max-addons-for-bricks' ),
			'type'     => 'spacing',
			'css'      => [
				[
					'property' => 'margin',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button',
				],
			],
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['buttonPadding'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Padding', 'max-addons-for-bricks' ),
			'type'     => 'spacing',
			'css'      => [
				[
					'property' => 'padding',
					'selector' => '.mab-toggle-switch-wrapper .mab-toggle-button',
				],
			],
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['boxStyleSeparator'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'type'     => 'separator',
			'label'    => esc_html__( 'Box Style', 'max-addons-for-bricks' ),
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['titleBoxBgColor'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Background Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-toggle-switch-wrapper',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['boxPadding'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Padding', 'max-addons-for-bricks' ),
			'type'     => 'spacing',
			'css'      => [
				[
					'property' => 'padding',
					'selector' => '.mab-toggle-switch-wrapper',
				],
			],
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['boxBorder'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Border', 'max-addons-for-bricks' ),
			'type'     => 'border',
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-toggle-switch-wrapper',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];

		$this->controls['wrapperBoxShadow'] = [
			'tab'      => 'content',
			'group'    => 'toggleStyle',
			'label'    => esc_html__( 'Box Shadow', 'max-addons-for-bricks' ),
			'type'     => 'box-shadow',
			'css'      => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-toggle-switch-wrapper',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'switchStyle', '=', [ 'button' ] ],
		];
	}

	// Set toggle content style controls
	public function set_toggle_content_style_controls() {
		$this->controls['contentPadding'] = [
			'tab'   => 'content',
			'group' => 'contentStyle',
			'label' => esc_html__( 'Padding', 'max-addons-for-bricks' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-toggle-content',
				],
			],
		];

		$this->controls['contentTextAlign'] = [
			'tab'     => 'content',
			'group'   => 'contentStyle',
			'label'   => esc_html__( 'Text Align', 'max-addons-for-bricks' ),
			'type'    => 'text-align',
			'default' => 'center',
			'css'     => [
				[
					'property' => 'text-align',
					'selector' => '.mab-toggle-content',
				],
			],
			'inline'  => true,
		];

		$this->controls['contentTypography'] = [
			'tab'    => 'content',
			'group'  => 'contentStyle',
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-toggle-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentBackground'] = [
			'tab'    => 'content',
			'group'  => 'contentStyle',
			'label'  => esc_html__( 'Background', 'max-addons-for-bricks' ),
			'type'   => 'background',
			'css'    => [
				[
					'property' => 'background',
					'selector' => '.mab-toggle-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentBorder'] = [
			'tab'    => 'content',
			'group'  => 'contentStyle',
			'label'  => esc_html__( 'Border', 'max-addons-for-bricks' ),
			'type'   => 'border',
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-toggle-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'contentStyle',
			'label'  => esc_html__( 'Box Shadow', 'max-addons-for-bricks' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-toggle-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];
	}

	/**
	 * Get toggle content.
	 *
	 * @since 1.0.0
	 */
	protected function get_toggle_content( $item ) {
		$content_type = ( isset( $item['contentType'] ) ? $item['contentType'] : '' );
		$output       = '';

		switch ( $content_type ) {
			case 'content':
				$output = wp_kses_post( $item['toggleContent'] );
				break;

			case 'template':
				$template_id = ! empty( $item['toggleTemplate'] ) ? intval( $item['toggleTemplate'] ) : false;

				if ( ! $template_id ) {
					$output = esc_html__( 'No template selected.', 'max-addons-for-bricks' );
				}

				if ( $template_id == $this->post_id || $template_id == get_the_ID() ) {
					$output = esc_html__( 'Not allowed: Infinite template loop.', 'max-addons-for-bricks' );
				}

				$output = do_shortcode( '[bricks_template id="' . $template_id . '" ]' );
				break;

			default:
				return;
		}

		return $output;
	}

	public function render_toggle() {
		$settings  = $this->settings;
		$primary   = ( isset( $settings['contentList'][0] ) ? $settings['contentList'][0] : '' );
		$secondary = ( isset( $settings['contentList'][1] ) ? $settings['contentList'][1] : '' );

		$this->set_attribute( 'switchContainer', 'class', 'mab-toggle-switch-container' );

		if ( isset( $settings['togglePosition'] ) ) {
			$this->set_attribute( 'switchContainer', 'class', 'mab-toggle-switch-' . $settings['togglePosition'] );
		}
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( 'switchContainer' ) ); ?>>
			<div class="mab-toggle-switch-wrapper">
				<?php if ( $settings['switchStyle'] == 'button' ) : ?>
					<?php foreach ( $settings['contentList'] as $i => $item ) : ?>
						<?php $icon_position = ( isset( $item['iconPosition'] ) ? $item['iconPosition'] : 'right' ); ?>
						<button class="mab-toggle-button <?php echo esc_attr( isset( $item['active'] ) ? 'active' : '' ); ?> mab-toggle-icon-<?php echo esc_attr( $item['iconPosition'] ); ?>" data-content-id="<?php echo esc_attr( $item['id'] ); ?>">
							<?php if ( isset( $item['icon'] ) ) : ?>
								<div class="mab-toggle-icon-wrapper">
									<?php echo self::render_icon( $item['icon'] ); ?>
								</div>
							<?php endif; ?>
							<span><?php echo esc_html( $item['label'] ); ?></span>
						</button>
					<?php endforeach; ?>
				<?php else :
					?>
					<div class="mab-toggle-switch primary <?php echo esc_attr( isset( $primary['active'] ) ? 'active' : '' ); ?> mab-toggle-icon-<?php echo esc_attr( $primary['iconPosition'] ); ?>">
						<?php if ( isset( $primary['icon'] ) ) : ?>
							<div class="mab-toggle-icon-wrapper">
								<?php echo self::render_icon( $primary['icon'] ); ?>
							</div>
						<?php endif; ?>
						<span><?php echo esc_html( $primary['label'] ); ?></span>
					</div>

					<label class="mab-toggle-switch mab-input-label">
						<input class="mab-toggle-toggle-switch" type="checkbox" <?php echo esc_attr( isset( $secondary['active'] ) ? 'checked' : '' ); ?>>
						<span class="mab-toggle-slider mab-toggle-<?php echo esc_attr( $settings['switchStyle'] ); ?>"></span>
					</label>

					<div class="mab-toggle-switch secondary <?php echo esc_attr( isset( $secondary['active'] ) ? 'active' : '' ); ?> mab-toggle-icon-<?php echo esc_attr( $secondary['iconPosition'] ); ?>">
						<?php if ( isset( $secondary['icon'] ) ) : ?>
							<div class="mab-toggle-icon-wrapper">
								<?php echo self::render_icon( $secondary['icon'] ); ?>
							</div>
						<?php endif; ?>
						<span><?php echo esc_html( $secondary['label'] ); ?></span>
					</div>

				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public function render() {
		$settings  = $this->settings;
		$primary   = ( isset( $settings['contentList'][0] ) ? $settings['contentList'][0] : '' );
		$secondary = ( isset( $settings['contentList'][1] ) ? $settings['contentList'][1] : '' );

		// Set element attributes
		$wrapper_classes = [];

		if ( isset( $settings['switchStyle'] ) ) {
			$wrapper_classes[] = 'mab-toggle-design-' . esc_attr( $settings['switchStyle'] );
		}

		// Set attribute tag for '_root'
		$this->set_attribute( '_root', 'class', $wrapper_classes );

		if ( isset( $settings['switchStyle'] ) ) {
			$this->set_attribute( '_root', 'data-design-type', $settings['switchStyle'] );
		}
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?>>
			<?php
			if ( isset( $settings['togglePosition'] ) && $settings['togglePosition'] == 'before' ) {
				$this->render_toggle();
			}
			?>
			<div class="mab-toggle-content-container">
				<?php if ( $settings['switchStyle'] == 'button' ) : ?>
					<?php foreach ( $settings['contentList'] as $i => $item ) : ?>
						<div id="<?php echo esc_attr( $item['id'] ); ?>" class="mab-toggle-content <?php echo esc_attr( isset( $item['active'] ) ? 'active' : '' ); ?>">
							<?php echo $this->get_toggle_content( $item ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					<?php endforeach; ?>
				<?php else :
					?>
					<div class="mab-toggle-content primary <?php echo esc_attr( isset( $primary['active'] ) ? 'active' : '' ); ?>">
						<?php echo $this->get_toggle_content( $primary ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>

					<div class="mab-toggle-content secondary <?php echo esc_attr( isset( $secondary['active'] ) ? 'active' : '' ); ?>">
						<?php echo $this->get_toggle_content( $secondary ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>

				<?php endif; ?>
			</div>
			<?php
			if ( isset( $settings['togglePosition'] ) && $settings['togglePosition'] == 'after' ) {
				$this->render_toggle();
			}
			?>
		</div>
		<?php
	}
}
