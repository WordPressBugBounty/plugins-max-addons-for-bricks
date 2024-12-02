<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Image_Accordion_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-image-accordion'; // Make sure to prefix your elements
	public $icon         = 'ti-layout-accordion-separated max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $loop_index   = 0;
	public $scripts      = [ 'mabImageAccordion' ]; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Image Accordion', 'max-addons' );
	}

	public function get_keywords() {
		return [ 'query', 'posts' ];
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-image-accordion' );
		wp_enqueue_script( 'mab-image-accordion' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['accordionItems'] = [
			'title' => esc_html__( 'Items', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['accordionContent'] = [
			'title' => esc_html__( 'Content', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['accordionButton'] = [
			'title' => esc_html__( 'Button', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	// Set builder controls
	public function set_controls() {

		$this->set_accordion_controls();

		$this->set_settings_controls();

		$this->set_accordion_items_controls();

		$this->set_accordion_content_controls();

		$this->set_accordion_button_controls();
	}

	// Set accordion controls
	public function set_accordion_controls() {
		$this->controls['accordionItems'] = [
			'tab'         => 'content',
			'placeholder' => esc_html__( 'Accordion', 'max-addons' ),
			'type'        => 'repeater',
			'checkLoop'   => true,
			'fields'      => [
				'itemLabel'              => [
					'label'          => esc_html__( 'Item Label', 'max-addons' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],
				'title'              => [
					'label'          => esc_html__( 'Title', 'max-addons' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],
				'content'            => [
					'label' => esc_html__( 'Content', 'max-addons' ),
					'type'  => 'editor',
				],
				'image'              => [
					'label' => esc_html__( 'Image', 'max-addons' ),
					'type'  => 'image',
				],
				'showButton'         => [
					'label' => esc_html__( 'Show Button', 'max-addons' ),
					'type'  => 'checkbox',
				],
				'link'               => [
					'label'    => esc_html__( 'Link', 'max-addons' ),
					'type'     => 'link',
					'required' => [ 'showButton', '!=', '' ],
				],
				'buttonText'         => [
					'label'          => esc_html__( 'Button Text', 'max-addons' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
					'required'       => [ 'showButton', '!=', '' ],
				],
				'buttonIcon'         => [
					'label'    => esc_html__( 'Button Icon', 'max-addons' ),
					'type'     => 'icon',
					'css' => [
						[
							'repeaterSelector' => '.icon-svg',
						],
					],
					'required' => [ 'showButton', '!=', '' ],
				],
				'buttonIconPosition' => [
					'label'       => esc_html__( 'Icon Position', 'max-addons' ),
					'type'        => 'select',
					'options'     => $this->control_options['iconPosition'],
					'inline'      => true,
					'clearable'   => true,
					'pasteStyles' => false,
					'default'     => 'after',
					'required'    => [ 'showButton', '!=', '' ],
				],
				'overlay'            => [
					'label' => esc_html__( 'Overlay', 'max-addons' ),
					'type'  => 'color',
					'css'   => [
						[
							'property' => 'background-color',
							'selector' => '.mab-image-accordion-overlay',
						],
					],
				],
			],
			'default'     => [
				[
					'title'   => esc_html__( 'Accordion title 1', 'max-addons' ),
					'content' => esc_html__( 'Accordion content goes here ..', 'max-addons' ),
					'buttonText' => esc_html__( 'Click Here', 'max-addons' ),
				],
				[
					'title'   => esc_html__( 'Accordion title 2', 'max-addons' ),
					'content' => esc_html__( 'Accordion content goes here ..', 'max-addons' ),
					'buttonText' => esc_html__( 'Click Here', 'max-addons' ),
				],
			],
		];

		$this->controls = array_replace_recursive( $this->controls, $this->get_loop_builder_controls() );
	}

	// Set settings controls
	public function set_settings_controls() {
		$this->controls['activeTab'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Default Active Item', 'max-addons' ),
			'description' => __( 'Add item index to make an item active by default', 'max-addons' ),
			'type'        => 'number',
			'min'         => 0,
			'max'         => 100,
			'step'        => 1,
			'inline'      => true,
			'default'     => 1,
		];

		$this->controls['disableActiveTab'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Disable Default Active Item on Stack', 'max-addons' ),
			'description' => __( 'Turn on this option to disable default active item when items are stacked', 'max-addons' ),
			'type'        => 'checkbox',
			'reset'       => true,
			'required'    => [
				[ 'activeTab', '>=', 1 ],
				[ 'orientation', '=', [ 'vertical' ] ],
				[ 'stackOn', '!=', [ '', 'none' ] ],
			],
		];

		$this->controls['wordsLimit'] = [
			'tab'   => 'content',
			'group' => 'settings',
			'label' => esc_html__( 'Words limit', 'max-addons' ),
			'type'  => 'number',
			'min'   => 1,
		];

		$this->controls['readMore'] = [
			'tab'            => 'content',
			'group'          => 'settings',
			'label'          => esc_html__( 'Read more', 'max-addons' ),
			'type'           => 'text',
			'inline'         => true,
			'hasDynamicData' => false,
			'required'       => [ 'wordsLimit', '!=', '' ],
		];

		$this->controls['accordionHeight'] = [
			'tab'   => 'content',
			'group' => 'settings',
			'label' => esc_html__( 'Height', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'height',
					'selector' => '',
				],
			],
		];

		$this->controls['accordionAction'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Accordion Action', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'on-hover' => esc_html__( 'On Hover', 'max-addons' ),
				'on-click' => esc_html__( 'On Click', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => false,
			'pasteStyles' => false,
			'default'     => 'on-hover',
		];

		$this->controls['onMouseOut'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'On Mouse Out', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'close-all'      => esc_html__( 'Close all', 'max-addons' ),
				'last-active'    => esc_html__( 'Open last active', 'max-addons' ),
				'default-active' => esc_html__( 'Open default active', 'max-addons' ),
				'first-item'     => esc_html__( 'Open first item', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => true,
			'pasteStyles' => false,
			'default'     => 'close-all',
			'required'    => [ 'accordionAction', '=', [ 'on-hover' ] ],
		];

		$this->controls['itemLabelType'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Item Label Type', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'item-label' => esc_html__( 'Item Label', 'max-addons' ),
				'title'      => esc_html__( 'Title', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => true,
			'pasteStyles' => false,
			'default'     => 'item-label',
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['orientation'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Orientation', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'vertical'   => esc_html__( 'Vertical', 'max-addons' ),
				'horizontal' => esc_html__( 'Horizontal', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => true,
			'rerender'    => true,
			'default'     => 'vertical',
		];

		$this->controls['itemLabelDirection'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Label Direction', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'vertical'   => esc_html__( 'Vertical', 'max-addons' ),
				'horizontal' => esc_html__( 'Horizontal', 'max-addons' ),
			],
			'placeholder' => esc_html__( 'Vertical', 'max-addons' ),
			'inline'      => true,
			'clearable'   => true,
			'rerender'    => true,
			'default'     => 'vertical',
			'required'    => [ 'orientation', '=', [ 'vertical' ] ],
		];

		$breakpoints        = \Bricks\Breakpoints::$breakpoints;
		$breakpoint_options = [];

		foreach ( $breakpoints as $index => $breakpoint ) {
			$breakpoint_options[ $breakpoint['key'] ] = $breakpoint['label'] . ' (<= ' . $breakpoint['width'] . 'px)';
		}

		$breakpoint_options['none']  = esc_html__( 'None', 'max-addons' );

		$this->controls['stackOn'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Stack On', 'max-addons' ),
			'type'        => 'select',
			'options'     => $breakpoint_options,
			'placeholder' => esc_html__( 'None', 'max-addons' ),
			'clearable'   => true,
			'pasteStyles' => false,
			'default'     => 'mobile_landscape',
			'required'    => [ 'orientation', '=', [ 'vertical' ] ],
		];
	}

	// Set Content Controls
	public function set_accordion_items_controls() {
		$this->controls['itemsGap'] = [
			'tab'   => 'content',
			'group' => 'accordionItems',
			'label' => esc_html__( 'Spacing between Items', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-right',
					'selector' => '&.mab-image-accordion-vertical .mab-image-accordion-item:not(:last-child)',
				],
				[
					'property' => 'margin-bottom',
					'selector' => '&.mab-image-accordion-horizontal .mab-image-accordion-item:not(:last-child)',
				],
			],
		];

		$this->controls['itemBorder'] = [
			'tab'    => 'style',
			'group'  => 'accordionItems',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-image-accordion-item',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['itemBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'accordionItems',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-image-accordion-item',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['overlayColor'] = [
			'tab'     => 'content',
			'group'   => 'accordionItems',
			'label'   => esc_html__( 'Overlay Color', 'max-addons' ),
			'type'    => 'color',
			'inline'  => true,
			'css'     => [
				[
					'property' => 'background-color',
					'selector' => '.mab-image-accordion-item .mab-image-accordion-overlay',
				],
			],
			'default' => [
				'hex' => '#000000',
				'rgb' => 'rgba(0, 0, 0, 0.3)',
			],
		];
	}

	// Set Content Controls
	public function set_accordion_content_controls() {
		$this->controls['itemLabelTypography'] = [
			'tab'      => 'content',
			'group'    => 'accordionContent',
			'label'    => esc_html__( 'Item Label Typography', 'max-addons' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-image-accordion-item-label',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'itemLabelType', '!=', '' ],
		];

		$this->controls['titleTag'] = [
			'tab'         => 'content',
			'group'       => 'accordionContent',
			'label'       => esc_html__( 'Title HTML Tag', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'h1'   => 'h1',
				'h2'   => 'h2',
				'h3'   => 'h3',
				'h4'   => 'h4',
				'h5'   => 'h5',
				'h6'   => 'h6',
				'div'  => 'div',
				'span' => 'span',
				'p'    => 'p',
			],
			'inline'      => true,
			'clearable'   => false,
			'pasteStyles' => false,
			'default'     => 'h2',
		];

		$this->controls['titleTypography'] = [
			'tab'    => 'content',
			'group'  => 'accordionContent',
			'label'  => esc_html__( 'Title Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-image-accordion-title',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['titleSpacing'] = [
			'tab'   => 'content',
			'group' => 'accordionContent',
			'label' => esc_html__( 'Title Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.mab-image-accordion-title',
				],
			],
		];

		$this->controls['contentTypography'] = [
			'tab'    => 'content',
			'group'  => 'accordionContent',
			'label'  => esc_html__( 'Content Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-image-accordion-description',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentBackgroundColor'] = [
			'tab'    => 'style',
			'group'  => 'accordionContent',
			'type'   => 'color',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.mab-image-accordion-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentBorder'] = [
			'tab'    => 'style',
			'group'  => 'accordionContent',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-image-accordion-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentVerticalAlign'] = [
			'tab'         => 'content',
			'group'       => 'accordionContent',
			'label'       => esc_html__( 'Vertical Align', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'flex-start' => esc_html__( 'Top', 'max-addons' ),
				'center'     => esc_html__( 'Middle', 'max-addons' ),
				'flex-end'   => esc_html__( 'Bottom', 'max-addons' ),
			],
			'css'         => [
				[
					'property' => 'align-items',
					'selector' => '.mab-image-accordion-overlay',
				],
			],
			'inline'      => true,
			'clearable'   => false,
			'pasteStyles' => false,
			'default'     => 'center',
		];

		$this->controls['contentHorizontalAlign'] = [
			'tab'         => 'content',
			'group'       => 'accordionContent',
			'label'       => esc_html__( 'Horizontal Align', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'flex-start' => esc_html__( 'Left', 'max-addons' ),
				'center'     => esc_html__( 'Center', 'max-addons' ),
				'flex-end'   => esc_html__( 'Right', 'max-addons' ),
			],
			'css'         => [
				[
					'property' => 'justify-content',
					'selector' => '.mab-image-accordion-overlay',
				],
				[
					'property' => 'align-items',
					'selector' => '.mab-image-accordion-content',
				],
			],
			'inline'      => true,
			'clearable'   => false,
			'pasteStyles' => false,
			'default'     => 'center',
		];

		$this->controls['contentPadding'] = [
			'tab'   => 'content',
			'group' => 'accordionContent',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-image-accordion-content',
				],
			],
		];
	}

	// Set Button Style
	public function set_accordion_button_controls() {
		$this->controls['size'] = [
			'tab'         => 'content',
			'group'       => 'accordionButton',
			'label'       => esc_html__( 'Size', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['buttonSizes'],
			'inline'      => true,
			'reset'       => true,
			'placeholder' => esc_html__( 'Medium', 'max-addons' ),
		];

		$this->controls['buttonStyle'] = [
			'tab'         => 'content',
			'group'       => 'accordionButton',
			'label'       => esc_html__( 'Style', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['styles'],
			'inline'      => true,
			'reset'       => true,
			'default'     => 'primary',
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['buttonCircle'] = [
			'tab'   => 'content',
			'group' => 'accordionButton',
			'label' => esc_html__( 'Circle', 'max-addons' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['buttonOutline'] = [
			'tab'   => 'content',
			'group' => 'accordionButton',
			'label' => esc_html__( 'Outline', 'max-addons' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['buttonTypography'] = [
			'tab'    => 'content',
			'group'  => 'accordionButton',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-image-accordion-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonSpacing'] = [
			'tab'     => 'content',
			'group'   => 'accordionButton',
			'label'   => esc_html__( 'Button Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'     => [
				[
					'property' => 'margin-top',
					'selector' => '.mab-image-accordion-button-wrap',
				],
			],
			'default' => '15px',
		];

		$this->controls['buttonBackgroundColor'] = [
			'tab'    => 'style',
			'group'  => 'accordionButton',
			'type'   => 'color',
			'label'  => esc_html__( 'Background Color', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.mab-image-accordion-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonBorder'] = [
			'tab'    => 'style',
			'group'  => 'accordionButton',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-image-accordion-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'accordionButton',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-image-accordion-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonIconSize'] = [
			'tab'   => 'content',
			'group' => 'accordionButton',
			'label' => esc_html__( 'Icon Size', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'font-size',
					'selector' => '.mab-image-accordion-button i',
				],
			],
		];

		$this->controls['buttonIconSpacing'] = [
			'tab'     => 'content',
			'group'   => 'accordionButton',
			'label'   => esc_html__( 'Icon Spacing', 'max-addons' ),
			'type'    => 'number',
			'units'   => true,
			'css'     => [
				[
					'property' => 'margin-left',
					'selector' => '.mab-image-accordion-button .mab-button-icon-right',
				],
                [
					'property' => 'margin-right',
					'selector' => '.mab-image-accordion-button .mab-button-icon-left',
				],
			],
            'default' => '10px',
		];

		$this->controls['buttonPadding'] = [
			'tab'   => 'content',
			'group' => 'accordionButton',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-image-accordion-button',
				],
			],
		];
	}

	public function get_normalized_image_settings( $settings ) {
		if ( empty( $settings['image'] ) ) {
			return [
				'id'   => 0,
				'url'  => false,
				'size' => BRICKS_DEFAULT_IMAGE_SIZE,
			];
		}

		$image = $settings['image'];

		// Size
		$image['size'] = empty( $image['size'] ) ? BRICKS_DEFAULT_IMAGE_SIZE : $settings['image']['size'];

		// Image ID or URL from dynamic data
		if ( ! empty( $image['useDynamicData'] ) ) {

			$images = $this->render_dynamic_data_tag( $image['useDynamicData'], 'image', [ 'size' => $image['size'] ] );

			if ( ! empty( $images[0] ) ) {
				if ( is_numeric( $images[0] ) ) {
					$image['id'] = $images[0];
				} else {
					$image['url'] = $images[0];
				}
			}
		}

		$image['id'] = empty( $image['id'] ) ? 0 : $image['id'];

		// If External URL, $image['url'] is already set
		if ( ! isset( $image['url'] ) ) {
			$image['url'] = ! empty( $image['id'] ) ? wp_get_attachment_image_url( $image['id'], $image['size'] ) : false;
		}

		return $image;
	}

	/**
	 * Render custom content output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access public
	 */
	public function render_repeater_item( $item ) {
		$settings = $this->settings;
		$image    = $this->get_normalized_image_settings( $item );
		$index    = $this->loop_index;
		$output   = '';

		$this->set_attribute( 'accordion-item-' . $index, 'class', 'mab-image-accordion-item' );

		if ( ! empty( $image['url'] ) ) {
			$this->set_attribute( 'accordion-item-' . $index, 'style', 'background-image: url(' . esc_url( $image['url'] ) . ');' );
		}

		$item_styles = [];

		// Accordion item overlay color
		if ( ! empty( $item['overlay'] ) ) {
			$item_styles[] = 'background-color: ' . \Bricks\Assets::generate_css_color( $item['overlay'] );
		}

		$this->set_attribute( 'accordion-overlay-' . $index, 'class', [ 'mab-image-accordion-overlay', 'mab-media-content' ] );
		$this->set_attribute( 'accordion-overlay-' . $index, 'style', join( '; ', $item_styles ) );

		$this->set_attribute( 'accordion-content-' . $index, 'class', 'mab-image-accordion-content' );

		if ( isset( $item['showButton'] ) ) {
			$button_size    = isset( $settings['size'] ) ? esc_attr( $settings['size'] ) : 'md';
			$icon_html      = '';
			$button_classes = [ 'mab-image-accordion-button', 'bricks-button', $button_size ];

			if ( isset( $settings['buttonStyle'] ) ) {
				// Outline
				if ( isset( $settings['buttonOutline'] ) ) {
					$button_classes[] = 'outline';
					$button_classes[] = 'bricks-color-' . esc_attr( $settings['buttonStyle'] );
				} else {
					// Fill (default)
					$button_classes[] = 'bricks-background-' . esc_attr( $settings['buttonStyle'] );
				}
			}

			// Button circle
			if ( isset( $settings['buttonCircle'] ) ) {
				$button_classes[] = 'circle';
			}

			$this->set_attribute( 'button-' . $index, 'class', $button_classes );

			if ( isset( $item['link'] ) ) {
				$this->set_link_attributes( 'button-' . $index, $item['link'] );
			}

			if ( isset( $item['buttonIcon'] ) ) {
				$icon_html = isset( $item['buttonIcon'] ) ? self::render_icon( $item['buttonIcon'] ) : '';
			}
		}

		if ( isset( $settings['activeTab'] ) ) {
			$tab_count = absint( $settings['activeTab'] ) - 1;

			if ( $index === $tab_count ) {
				$this->set_attribute( 'accordion-item-' . $index, 'class', 'mab-image-accordion-active' );
				$this->set_attribute( 'accordion-item-' . $index, 'style', 'flex: 3 1 0;' );
			}
		}

		$output .= '<div ' . wp_kses_post( $this->render_attributes( 'accordion-item-' . $index ) ) . '>';
		$output .= '<div ' . wp_kses_post( $this->render_attributes( 'accordion-overlay-' . $index ) ) . '>';
	
		if ( ! empty( $settings['itemLabelType'] ) && ( ! empty( $item['itemLabel'] ) || ! empty( $item['title'] ) ) ) {
			$output .= '<div class="mab-image-accordion-item-label">';
			if ( 'item-label' === $settings['itemLabelType'] && ! empty( $item['itemLabel'] ) ) {
				$output .= wp_kses_post( $item['itemLabel'] );
			} else {
				$output .= wp_kses_post( $item['title'] );
			}
			$output .= '</div>';
		}

		$output .= '<div ' . wp_kses_post( $this->render_attributes( 'accordion-content-' . $index ) ) . '>';

			if ( ! empty( $item['title'] ) ) {
				$output .= '<' . esc_html( $settings['titleTag'] ) . ' class="mab-image-accordion-title">';
				$output .= wp_kses_post( $item['title'] );
				$output .= '</' . esc_html( $settings['titleTag'] ) . '>';
			}

			if ( isset( $item['content'] ) ) {
				$content = $item['content'];

				// Enforce words limit (@since 1.4.3)
				if ( ! empty( $settings['wordsLimit'] ) && is_numeric( $settings['wordsLimit'] ) ) {
					$more    = $settings['readMore'] ?? '';
					$content = \Bricks\Helpers::trim_words( $content, $settings['wordsLimit'], $more, true, false );
				}

				$output .= '<div class="mab-image-accordion-description">';
				$output .= wp_kses_post( $content );
				$output .= '</div>';
			}

			if ( isset( $item['showButton'] ) ) {
				$button_icon_position = isset( $item['buttonIconPosition'] ) ? esc_attr( $item['buttonIconPosition'] ) : 'right';
				$button_tag           = isset( $item['link'] ) ? 'a' : 'span';

				$output .= '<div class="mab-image-accordion-button-wrap">';
				$output .= '<' . esc_html( $button_tag ) . ' ' . $this->render_attributes( 'button-' . $index ) . '>';

				if ( ! empty( $icon_html ) && 'left' === $button_icon_position ) {
					$output .= '<span class="mab-button-icon mab-button-icon-left">';
					$output .= $icon_html;
					$output .= '</span>';
				}

				if ( ! empty( $item['buttonText'] ) ) {
					$output .= '<span class="mab-button-text">';
					$output .= esc_html( $item['buttonText'] );
					$output .= '</span>';
				}

				if ( ! empty( $icon_html ) && 'right' === $button_icon_position ) {
					$output .= '<span class="mab-button-icon mab-button-icon-right">';
					$output .= $icon_html;
					$output .= '</span>';
				}

				$output .= '</' . esc_html( $button_tag ) . '>';
				$output .= '</div>';
			}

			$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$this->loop_index++;

		return $output;
	}

	// Render element HTML
	public function render() {
		$settings = $this->settings;

		$accordion_items  = ! empty( $settings['accordionItems'] ) ? $settings['accordionItems'] : false;
		$accordion_action = ! empty( $settings['accordionAction'] ) ? esc_attr( $settings['accordionAction'] ) : 'on-hover';
		$orientation      = ! empty( $settings['orientation'] ) ? esc_attr( $settings['orientation'] ) : 'vertical';
		$label_direction  = ! empty( $settings['itemLabelDirection'] ) ? esc_attr( $settings['itemLabelDirection'] ) : 'vertical';

		$this->set_attribute( '_root', 'class', array(
			'mab-image-accordion',
			'mab-image-accordion-' . esc_attr( $orientation ),
		) );

		$img_accordion_settings = array(
			'action' => esc_attr( $accordion_action ),
		);

		if ( 'on-hover' === $accordion_action && isset( $settings['onMouseOut'] ) ) {
			$img_accordion_settings['onmouseout'] = esc_attr( $settings['onMouseOut'] );

			if ( isset( $settings['activeTab'] ) ) {
				$tab_count = absint( $settings['activeTab'] ) - 1;
				$img_accordion_settings['default'] = $tab_count;
			}
		}

		if ( 'vertical' === $orientation ) {
			if ( $label_direction ) {
				$this->set_attribute( '_root', 'class', 'mab-image-accordion-label-' . esc_attr( $label_direction ) );
			}

			if ( isset( $settings['stackOn'] ) && 'none' !== $settings['stackOn'] ) {
				$breakpoint = \Bricks\Breakpoints::get_breakpoint_by( 'key', esc_attr( $settings['stackOn'] ) );
				$img_accordion_settings['stackOn'] = esc_attr( $breakpoint['width'] );

				if ( isset( $settings['disableActiveTab'] ) ) {
					$img_accordion_settings['disableActiveTab'] = $settings['disableActiveTab'];
				}
			}
		}

		// Element placeholder
		if ( empty( $accordion_items ) ) {
			return $this->render_element_placeholder( [
				'icon-class' => esc_attr( $this->icon ),
				'title'      => esc_html__( 'No accordion items added.', 'max-addons' ),
			] );
		}

		$this->set_attribute( '_root', 'data-settings', wp_json_encode( $img_accordion_settings ) );
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?>>
			<?php
			$output = '';

			// Query Loop
			if ( isset( $settings['hasLoop'] ) ) {
				$query = new \Bricks\Query( [
					'id'       => $this->id,
					'settings' => $settings,
				] );

				$item = $accordion_items[0];

				$output .= $query->render( [ $this, 'render_repeater_item' ], compact( 'item' ) );

				// Destroy the Query to explicitly remove it from the global store
				$query->destroy();
				unset( $query );
			} else {
				foreach ( $accordion_items as $index => $item ) {
					$output .= self::render_repeater_item( $item );
				}
			}

			echo $output;
			?>
		</div>
		<?php
	}
}
