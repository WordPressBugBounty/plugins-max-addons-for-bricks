<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Icon_List_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-icon-list'; // Make sure to prefix your elements
	public $icon         = 'ti-layout-list-thumb max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $loop_index   = 0;
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	public function get_label() {
		return esc_html__( 'Dynamic List', 'max-addons-for-bricks' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-icon-list' );
	}

	public function set_control_groups() {

		$this->control_groups['items'] = [
			'title' => esc_html__( 'Items', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['item'] = [
			'title' => esc_html__( 'List item', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['highlight'] = [
			'title' => esc_html__( 'Highlight', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['icon'] = [
			'title' => esc_html__( 'Icon/Image', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['title'] = [
			'title' => esc_html__( 'Text', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['meta'] = [
			'title' => esc_html__( 'Meta', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['description'] = [
			'title' => esc_html__( 'Description', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['separator'] = [
			'title' => esc_html__( 'Separator', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

	}

	public function set_controls() {
		$this->set_items_controls();

		$this->set_list_item_controls();

		$this->set_highlight_controls();

		$this->set_icon_controls();

		$this->set_text_controls();

		$this->set_meta_controls();

		$this->set_description_controls();

		$this->set_separator_controls();
	}

	// Set items controls
	public function set_items_controls() {

		$this->controls['items'] = [
			'tab'           => 'content',
			'group'         => 'items',
			'placeholder'   => esc_html__( 'List items', 'max-addons-for-bricks' ),
			'type'          => 'repeater',
			'titleProperty' => 'title',
			'checkLoop'     => true,
			'fields'        => [
				'title'          => [
					'label'          => esc_html__( 'Title', 'max-addons-for-bricks' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],

				'iconType'       => [
					'label'     => esc_html__( 'Icon Type', 'max-addons-for-bricks' ),
					'type'      => 'select',
					'options'   => [
						'icon'  => esc_html__( 'Icon', 'max-addons-for-bricks' ),
						'image' => esc_html__( 'Image', 'max-addons-for-bricks' ),
						'text'  => esc_html__( 'Text', 'max-addons-for-bricks' ),
					],
					'inline'    => true,
					'clearable' => false,
					'default'   => 'icon',
				],

				'icon' 		=> [
					'label' => esc_html__( 'Icon', 'max-addons-for-bricks' ),
					'type' 	=> 'icon',
					'default' 		=> [
						'library' 	=> 'themify',
						'icon' 		=> 'ti-wordpress',
					],
					'required' => [ 'iconType', '=', [ 'icon' ] ],
				],

				'image'          => [
					'label'    => esc_html__( 'Image', 'max-addons-for-bricks' ),
					'type'     => 'image',
					'required' => [ 'iconType', '=', [ 'image' ] ],
				],

				'iconText'       => [
					'label'          => esc_html__( 'Text', 'max-addons-for-bricks' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
					'inline'         => true,
					'required'       => [ 'iconType', '=', [ 'text' ] ],
				],

				'link'           => [
					'label' => esc_html__( 'Link', 'max-addons-for-bricks' ),
					'type'  => 'link',
				],

				'meta'           => [
					'label'          => esc_html__( 'Meta', 'max-addons-for-bricks' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],

				'description'    => [
					'label'          => esc_html__( 'Description', 'max-addons-for-bricks' ),
					'type'           => 'textarea',
					'hasDynamicData' => 'text',
				],

				'highlight'      => [
					'label' => esc_html__( 'Highlight', 'max-addons-for-bricks' ),
					'type'  => 'checkbox',
				],

				'highlightLabel' => [
					'label'    => esc_html__( 'Highlight label', 'max-addons-for-bricks' ),
					'type'     => 'text',
					'inline'   => true,
					'required' => [ 'highlight', '!=', '' ],
				],
			],
			'default'       => [
				[
					'title'    => esc_html__( 'List item #1', 'max-addons-for-bricks' ),
					'iconType' => 'icon',
					'icon'     => [
						'library' => 'themify',
						'icon'    => 'ti-wordpress',
					],
				],
				[
					'title'    => esc_html__( 'List item #2', 'max-addons-for-bricks' ),
					'iconType' => 'icon',
					'icon'     => [
						'library' => 'themify',
						'icon'    => 'ti-wordpress',
					],
				],
			],
		];

		$this->controls = array_replace_recursive( $this->controls, $this->get_loop_builder_controls('items') );
	}

	// Set list item controls
	public function set_list_item_controls() {

		$this->controls['itemMargin'] = [
			'tab'   => 'content',
			'group' => 'item',
			'label' => esc_html__( 'Margin', 'max-addons-for-bricks' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'margin',
					'selector' => 'li',
				],
			],
		];

		$this->controls['itemPadding'] = [
			'tab'   => 'content',
			'group' => 'item',
			'label' => esc_html__( 'Padding', 'max-addons-for-bricks' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => 'li',
				],
			],
		];

		$this->controls['itemOddBackground'] = [
			'tab'    => 'content',
			'group'  => 'item',
			'label'  => esc_html__( 'Odd background', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => 'li:nth-child(odd)',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['itemEvenBackground'] = [
			'tab'    => 'content',
			'group'  => 'item',
			'label'  => esc_html__( 'Even background', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => 'li:nth-child(even)',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['itemBorder'] = [
			'tab'    => 'content',
			'group'  => 'item',
			'label'  => esc_html__( 'Border', 'max-addons-for-bricks' ),
			'type'   => 'border',
			'css'    => [
				[
					'property' => 'border',
					'selector' => 'li',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['itemAutoWidth'] = [
			'tab'   => 'content',
			'group' => 'item',
			'label' => esc_html__( 'Auto width', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
			'css'   => [
				[
					'property' => 'justify-content',
					'selector' => '.content',
					'value'    => 'initial',
				],
				[
					'property' => 'flex-grow',
					'selector' => '.separator',
					'value'    => '0',
				],
			],
		];
	}

	// Set highlight controls
	public function set_highlight_controls() {
		$this->controls['highlightBlock'] = [
			'tab'   => 'content',
			'group' => 'highlight',
			'label' => esc_html__( 'Block', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
			'css'   => [
				[
					'property' => 'display',
					'selector' => 'li[data-highlight]::before',
					'value'    => 'block',
				],
			],
		];

		$this->controls['highlightLabelPadding'] = [
			'tab'   => 'content',
			'group' => 'highlight',
			'label' => esc_html__( 'Label padding', 'max-addons-for-bricks' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => 'li[data-highlight]::before',
				],
			],
		];

		$this->controls['highlightLabelBackground'] = [
			'tab'    => 'content',
			'group'  => 'highlight',
			'label'  => esc_html__( 'Label background', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => 'li[data-highlight]::before',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['highlightLabelBorder'] = [
			'tab'    => 'content',
			'group'  => 'highlight',
			'label'  => esc_html__( 'Label border', 'max-addons-for-bricks' ),
			'type'   => 'border',
			'css'    => [
				[
					'property' => 'border',
					'selector' => 'li[data-highlight]::before',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['highlightLabelTypography'] = [
			'tab'    => 'content',
			'group'  => 'highlight',
			'label'  => esc_html__( 'Label typography', 'max-addons-for-bricks' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => 'li[data-highlight]::before',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['highlightContentPadding'] = [
			'tab'   => 'content',
			'group' => 'highlight',
			'label' => esc_html__( 'Content padding', 'max-addons-for-bricks' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => 'li[data-highlight] .content',
				],
			],
		];

		$this->controls['highlightContentBackground'] = [
			'tab'    => 'content',
			'group'  => 'highlight',
			'label'  => esc_html__( 'Content background', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => 'li[data-highlight] .content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['highlightContentBorder'] = [
			'tab'    => 'content',
			'group'  => 'highlight',
			'label'  => esc_html__( 'Content border', 'max-addons-for-bricks' ),
			'type'   => 'border',
			'css'    => [
				[
					'property' => 'border',
					'selector' => 'li[data-highlight] .content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['highlightContentColor'] = [
			'tab'    => 'content',
			'group'  => 'highlight',
			'label'  => esc_html__( 'Content text color', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property' => 'color',
					'selector' => 'li[data-highlight] .content .title',
				],
				[
					'property' => 'color',
					'selector' => 'li[data-highlight] .content .meta',
				],
				[
					'property' => 'color',
					'selector' => 'li[data-highlight] .content + .description',
				],
			],
			'inline' => true,
			'small'  => true,
		];
	}

	// Set icon controls
	public function set_icon_controls() {

		$this->controls['iconVerticalAlign'] = [
			'tab'     => 'content',
			'group'   => 'icon',
			'label'   => esc_html__( 'Vertical Align', 'max-addons-for-bricks' ),
			'type'    => 'align-items',
			'exclude' => [
				'stretch',
			],
			'css'     => [
				[
					'property' => 'align-self',
					'selector' => '.mab-icon-list-icon, .mab-icon-list-icon-text',
				],
			],
			'inline'  => true,
		];

		$this->controls['iconSize'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'label' => esc_html__( 'Icon size', 'max-addons-for-bricks' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'font-size',
					'selector' => '.mab-icon-list-icon',
				],
			],
		];

		$this->controls['iconColor'] = [
			'tab'    => 'content',
			'group'  => 'icon',
			'label'  => esc_html__( 'Icon color', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'inline' => true,
			'css'    => [
				[
					'property' => 'color',
					'selector' => '.mab-icon-list-icon',
				],
			],
		];

		$this->controls['svgSeparator'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'type'  => 'separator',
			'label' => esc_html__( 'SVG', 'max-addons-for-bricks' ),
		];

		$this->controls['svgHeight'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'label' => esc_html__( 'Height', 'max-addons-for-bricks' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'height',
					'selector' => 'svg.mab-icon-list-icon',
				],
			],
		];

		$this->controls['svgWidth'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'label' => esc_html__( 'Width', 'max-addons-for-bricks' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => 'svg.mab-icon-list-icon',
				],
			],
		];

		$this->controls['strokeWidth'] = [
			'tab'    => 'content',
			'group'  => 'icon',
			'label'  => esc_html__( 'Stroke width', 'max-addons-for-bricks' ),
			'type'   => 'number',
			'css'    => [
				[
					'property'  => 'stroke-width',
					'selector'  => 'svg.mab-icon-list-icon',
				],
			],
			'min'    => 1,
			'inline' => true,
			'small'  => true,
		];

		$this->controls['stroke'] = [
			'tab'    => 'content',
			'group'  => 'icon',
			'label'  => esc_html__( 'Stroke color', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property'  => 'stroke',
					'selector'  => 'svg.mab-icon-list-icon',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['fill'] = [
			'tab'    => 'content',
			'group'  => 'icon',
			'label'  => esc_html__( 'Fill', 'max-addons-for-bricks' ),
			'type'   => 'color',
			'css'    => [
				[
					'property'  => 'fill',
					'selector'  => 'svg.mab-icon-list-icon',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['imageSeparator'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'type'  => 'separator',
			'label' => esc_html__( 'Image', 'max-addons-for-bricks' ),
		];

		$this->controls['imageObjectFit'] = [
			'tab'     => 'content',
			'group'   => 'icon',
			'label'   => esc_html__( 'Object Fit', 'max-addons-for-bricks' ),
			'type'    => 'select',
			'options' => [
				'contain' => esc_html__( 'Contain', 'max-addons-for-bricks' ),
				'cover'   => esc_html__( 'Cover', 'max-addons-for-bricks' ),
				'fill'    => esc_html__( 'Fill', 'max-addons-for-bricks' ),
			],
			'css'     => [
				[
					'property' => 'object-fit',
					'selector' => '.mab-icon-list-icon img',
				],
			],
			'inline'  => true,
		];

		$this->controls['imageHeight'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'label' => esc_html__( 'Height', 'max-addons-for-bricks' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'height',
					'selector' => '.mab-icon-list-icon img',
				],
			],
		];

		$this->controls['imageWidth'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'label' => esc_html__( 'Width', 'max-addons-for-bricks' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => '.mab-icon-list-icon img',
				],
			],
		];

		$this->controls['textSeparator'] = [
			'tab'   => 'content',
			'group' => 'icon',
			'type'  => 'separator',
			'label' => esc_html__( 'Text', 'max-addons-for-bricks' ),
		];

		$this->controls['iconTextTypography'] = [
			'tab'    => 'content',
			'group'  => 'icon',
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-icon-list-icon-text',
				],
			],
			'inline' => true,
			'small'  => true,
		];
	}

	// Set text controls
	public function set_text_controls() {

		$this->controls['textMargin'] = [
			'tab'   => 'content',
			'group' => 'title',
			'label' => esc_html__( 'Margin', 'max-addons-for-bricks' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'margin',
					'selector' => '.title',
				],
			],
		];

		$this->controls['textTag'] = [
			'tab'         => 'content',
			'group'       => 'title',
			'label'       => esc_html__( 'Tag', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => [
				'h2' => esc_html__( 'Heading 2 (h2)', 'max-addons-for-bricks' ),
				'h3' => esc_html__( 'Heading 3 (h3)', 'max-addons-for-bricks' ),
				'h4' => esc_html__( 'Heading 4 (h4)', 'max-addons-for-bricks' ),
				'h5' => esc_html__( 'Heading 5 (h5)', 'max-addons-for-bricks' ),
				'h6' => esc_html__( 'Heading 6 (h6)', 'max-addons-for-bricks' ),
			],
			'inline'      => true,
			'placeholder' => 'span',
		];

		$this->controls['textTypography'] = [
			'tab'    => 'content',
			'group'  => 'title',
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.title',
				],
			],
			'inline' => true,
			'small'  => true,
		];

	}

	// Set meta controls
	public function set_meta_controls() {
		$this->controls['metaMargin'] = [
			'tab'   => 'content',
			'group' => 'meta',
			'label' => esc_html__( 'Margin', 'max-addons-for-bricks' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'margin',
					'selector' => '.meta',
				],
			],
		];

		$this->controls['metaTypography'] = [
			'tab'    => 'content',
			'group'  => 'meta',
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.meta',
				],
			],
			'inline' => true,
			'small'  => true,
		];
	}

	// Set description controls
	public function set_description_controls() {
		$this->controls['descriptionTypography'] = [
			'tab'    => 'content',
			'group'  => 'description',
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.description',
				],
			],
			'inline' => true,
			'small'  => true,
		];
	}

	// Set separator controls
	public function set_separator_controls() {
		$this->controls['separatorEnable'] = [
			'tab'   => 'content',
			'group' => 'separator',
			'label' => esc_html__( 'Enable', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
		];

		$this->controls['separatorStyle'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Style', 'max-addons-for-bricks' ),
			'type'     => 'select',
			'options'  => $this->control_options['borderStyle'],
			'css'      => [
				[
					'property' => 'border-top-style',
					'selector' => '.separator',
				],
			],
			'inline'   => true,
			'required' => [ 'separatorEnable', '!=', '' ],
		];

		$this->controls['separatorWidth'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Width in px', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'unit'     => 'px',
			'css'      => [
				[
					'property' => 'flex-basis',
					'selector' => '.separator',
				],
				[
					'property' => 'flex-grow',
					'selector' => '.separator',
					'value'    => '0',
				],
			],
			'inline'   => true,
			'required' => [ 'separatorEnable', '!=', '' ],
		];

		$this->controls['separatorHeight'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Height in px', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'unit'     => 'px',
			'css'      => [
				[
					'property' => 'border-top-width',
					'selector' => '.separator',
				],
			],
			'inline'   => true,
			'required' => [ 'separatorEnable', '!=', '' ],
		];

		$this->controls['separatorColor'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'border-top-color',
					'selector' => '.separator',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'separatorEnable', '!=', '' ],
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

		$settings['image'] = $image;

		return $settings;
	}

	public function render_icon_image( $settings ) {

		if ( empty( $settings['image'] ) || ! is_array( $settings['image'] ) ) {
			return;
		}

		$image_settings = $settings['image'];

		if ( ! empty( $image_settings['useDynamicData'] ) && is_array( $image_settings['useDynamicData'] ) && isset( $image_settings['useDynamicData']['name'] ) ) {

			$dynamic_data = $image_settings['useDynamicData'];

			if ( empty( $image_settings['id'] ) ) {

				if ( isset( $dynamic_data['group'] ) && 'ACF' === $dynamic_data['group'] && ! class_exists( 'ACF' ) ) {

					$title = esc_html__(
						'Can\'t render element, as the selected ACF field is not available. Please activate ACF or edit the element to select different data.',
						'max-addons-for-bricks'
					);

				} elseif ( isset( $dynamic_data['name'] ) && '{featured_image}' === $dynamic_data['name'] ) {

					$title = esc_html__(
						'No featured image set.',
						'max-addons-for-bricks'
					);

				} else {

					$title = sprintf(
						/* translators: 1: Dynamic data label, 2: Dynamic data group name. */
						esc_html__(
							'Dynamic Data %1$s (%2$s) is empty.',
							'max-addons-for-bricks'
						),
						isset( $dynamic_data['label'] ) ? esc_html( $dynamic_data['label'] ) : '',
						isset( $dynamic_data['group'] ) ? esc_html( $dynamic_data['group'] ) : ''
					);
				}

				return $this->render_element_placeholder(
					[
						'icon-class' => 'ti-image',
						'title'      => $title,
					]
				);
			}
		}

		$img_size = ! empty( $image_settings['size'] ) ? sanitize_key( $image_settings['size'] ) : 'large';

		$image_atts = [
			'id'    => 'image-' . absint( $image_settings['id'] ),
			'class' => implode(
				' ',
				[
					'post-thumbnail',
					'css-filter',
					'size-' . esc_attr( $img_size ),
				]
			),
		];

		$this->set_attribute( 'image-wrapper', 'class', 'mab-icon-list-icon' );

		$img_html  = '<span ' . $this->render_attributes( 'image-wrapper' ) . '>';

		if ( ! empty( $image_settings['id'] ) ) {

			$img_html .= wp_get_attachment_image(
				absint( $image_settings['id'] ),
				$img_size,
				false,
				$image_atts
			);

		} elseif ( ! empty( $image_settings['url'] ) ) {

			$img_html .= sprintf(
				'<img src="%s" alt="" />',
				esc_url( $image_settings['url'] )
			);
		}

		$img_html .= '</span>';

		return $img_html;
	}

	public function render_repeater_item( $item ) {
		$settings  = $this->settings;
		$index     = $this->loop_index;
		$meta      = false;
		$separator = false;
		$output    = '';

		if ( isset( $settings['separatorEnable'] ) ) {
			$separator = true;
		}

		if ( isset( $item['meta'] ) && ! empty( $item['meta'] ) ) {
			$meta = true;
		}

		$highlight = isset( $item['highlight'] ) && ! empty( $item['highlightLabel'] ) ? $item['highlightLabel'] : false;

		if ( $highlight ) {
			$this->set_attribute( "list-item-$index", 'data-highlight', $highlight );
		}

		if ( isset( $item['icon'] ) ) {
			$icon_html = isset( $item['icon'] ) ? self::render_icon( $item['icon'], [ 'mab-icon-list-icon' ] ) : false;
		}

		$item_link = ! empty( $item['link'] ) ? $item['link'] : false;
		$this->set_attribute( "list-item-{$index}", 'class', 'repeater-item' );
		$this->set_attribute( "list-item-{$index}", 'class', $item_link ? 'has-link' : 'no-link' );

		$output .= '<li ' . $this->render_attributes( "list-item-$index" ) . '>';

		if ( $separator || $meta ) {
			$output .= '<div class="content">';
		}

		if ( isset( $item['title'] ) && ! empty( $item['title'] ) ) {

			if ( isset( $item['link'] ) ) {
				$this->set_link_attributes( "a-$index", $item['link'] );
				$output .= '<a ' . $this->render_attributes( "a-$index" ) . '>';
			}

			$output .= '<div class="title-wrapper">';

			if ( isset( $item['iconType'] ) ) {
				if ( 'image' === $item['iconType'] ) {
					$image_settings = $this->get_normalized_image_settings( $item );
					$output .= $this->render_icon_image( $image_settings );
				} elseif ( 'text' === $item['iconType'] ) {
					$output .= '<span class="mab-icon-list-icon-text">';
					$output .= $item['iconText'];
					$output .= '</span>';
				} else {
					if ( isset( $item['icon'] ) ) {
						$output .= $icon_html;
					}
				}
			}

			$title_tag = isset( $settings['textTag'] ) ? esc_attr( $settings['textTag'] ) : 'span';

			$this->set_attribute( "title-$index", $title_tag );
			$this->set_attribute( "title-$index", 'class', [ 'title' ] );

			$output .= '<' . $this->render_attributes( "title-$index" ) . '>' . $item['title'] . '</' . $title_tag . '>';

			$output .= '</div>'; // .title-wrapper

			if ( isset( $item['link'] ) ) {
				$output .= '</a>';
			}
		}

		if ( isset( $settings['separatorEnable'] ) ) {
			$output .= '<span class="separator"></span>';
		}

		if ( isset( $item['meta'] ) && ! empty( $item['meta'] ) ) {
			$this->set_attribute( "meta-$index", 'class', [ 'meta' ] );

			$output .= '<span ' . $this->render_attributes( "meta-$index" ) . '>' . $item['meta'] . '</span>';
		}

		if ( $separator || $meta ) {
			$output .= '</div>'; // .content
		}

		if ( isset( $item['description'] ) && ! empty( $item['description'] ) ) {
			$this->set_attribute( "description-$index", 'class', [ 'description' ] );

			$output .= '<div ' . $this->render_attributes( "description-$index" ) . '>' . $item['description'] . '</div>';
		}

		$output .= '</li>';

		$this->loop_index++;

		return $output;
	}

	public function render() {
		$settings = $this->settings;

		// Element placeholder
		if ( empty( $settings['items'] ) || ! is_array( $settings['items'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No list items defined.', 'max-addons-for-bricks' ),
				]
			);
		}

		$items = $settings['items'];

		$this->set_attribute( '_root', 'class', 'mab-icon-list' );

		$output = '<ul ' . $this->render_attributes( '_root' ) . '>';

		// Query Loop
		if ( isset( $settings['hasLoop'] ) ) {
			$query = new \Bricks\Query( [
				'id'       => $this->id,
				'settings' => $settings,
			] );

			$item = $items[0];

			$output .= $query->render( [ $this, 'render_repeater_item' ], compact( 'item' ) );

			// We need to destroy the Query to explicitly remove it from the global store
			$query->destroy();
			unset( $query );
		} else {
			foreach ( $items as $index => $item ) {
				$output .= self::render_repeater_item( $item );
			}
		}

		$output .= '</ul>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output escaped in render_repeater_item() and render_attributes().
		echo $output;
	}
}
