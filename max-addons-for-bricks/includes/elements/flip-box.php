<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class FlipBox_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-flipbox'; // Make sure to prefix your elements
	public $icon         = 'ti-loop max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Flip Box', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-flip-box' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->controls['text'] = [ // Unique group identifier (lowercase, no spaces)
			'title' => esc_html__( 'Text', 'max-addons' ), // Localized control group title
			'tab'   => 'content', // Set to either "content" or "style"
		];

		$this->control_groups['front'] = [
			'title' => esc_html__( 'Front', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['back'] = [
			'title' => esc_html__( 'Back', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['frontIconStyle'] = [
			'title' => esc_html__( 'Front Icon Style', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['frontStyle'] = [
			'title' => esc_html__( 'Front Style', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['backIconStyle'] = [
			'title' => esc_html__( 'Back Icon Style', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['backStyle'] = [
			'title' => esc_html__( 'Back Style', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	// Set builder controls
	public function set_controls() {

		$this->set_front_controls();

		$this->set_back_controls();

		$this->set_settings_controls();

		$this->set_front_icon_controls();

		$this->set_front_style_controls();

		$this->set_back_icon_controls();

		$this->set_back_style_controls();
	}

	// Set front controls
	public function set_front_controls() {

		$this->controls['frontIconType'] = [
			'tab'     => 'content',
			'group'   => 'front',
			'label'   => esc_html__( 'Icon Type', 'max-addons' ),
			'type'    => 'select',
			'options' => [
				'icon'  => esc_html__( 'Icon', 'max-addons' ),
				'image' => esc_html__( 'Image', 'max-addons' ),
			],
			'inline'  => true,
			'default' => 'icon',
		];

		$this->controls['frontIcon'] = [
			'tab'      => 'content',
			'group'    => 'front',
			'label'    => esc_html__( 'Icon', 'max-addons' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-wordpress',
			],
			'css' => [
				[
					'selector' => '.mab-flipbox-front .mab-icon svg',
				],
			],
			'required' => [ 'frontIconType', '=', [ 'icon' ] ],
		];

		$this->controls['frontImage'] = [
			'tab'      => 'content',
			'group'    => 'front',
			'type'     => 'image',
			'label'    => esc_html__( 'Image', 'max-addons' ),
			'required' => [ 'frontIconType', '=', [ 'image' ] ],
		];

		$this->controls['frontHeading'] = [
			'tab'            => 'content',
			'group'          => 'front',
			'label'          => esc_html__( 'Heading', 'max-addons' ),
			'type'           => 'text',
			'spellcheck'     => true,
			'inlineEditing'  => false,
			'default'        => 'Flip box front heading',
			'hasDynamicData' => 'text',
		];

		$this->controls['frontHeadingTag'] = [
			'tab'         => 'content',
			'group'       => 'front',
			'label'       => esc_html__( 'Heading Tag', 'max-addons' ),
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
			'default'     => 'h3',
		];

		$this->controls['frontContent'] = [
			'tab'     => 'content',
			'group'   => 'front',
			'label'   => esc_html__( 'Description', 'max-addons' ),
			'type'    => 'editor',
			'default' => 'Aenean commodo ligula egget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
		];

		$this->controls['frontBackground'] = [
			'tab'     => 'content',
			'group'   => 'front',
			'label'   => esc_html__( 'Background', 'max-addons' ),
			'type'    => 'background',
			'css'     => [
				[
					'property' => 'background',
					'selector' => '.mab-flipbox-front',
				],
			],
			'exclude' => [
				'parallax',
				'videoUrl',
				'videoScale',
			],
			'inline'  => true,
			'small'   => true,
			'default' => [
				'color' => [
					'rgb' => 'rgba(241, 241, 241, 1)',
					'hex' => '#f1f1f1',
				],
			],
		];

		$this->controls['applyFrontGradient'] = array(
			'tab'    => 'style',
			'group'  => 'front',
			'label'  => esc_html__( 'Gradient Background', 'max-addons' ),
			'type'   => 'checkbox',
			'inline' => true,
			'reset'  => true,
		);

		$this->controls['frontBackgroundGradient'] = [
			'tab'      => 'content',
			'group'    => 'front',
			'label'    => '',
			'type'     => 'gradient',
			'css'      => [
				[
					'property' => 'background-image',
					'selector' => '.mab-flipbox-front',
				],
			],
			'required' => array( 'applyFrontGradient', '=', true ),
		];
	}

	// Set Back controls
	public function set_back_controls() {

		$this->controls['backIconType'] = [
			'tab'     => 'content',
			'group'   => 'back',
			'label'   => esc_html__( 'Icon Type', 'max-addons' ),
			'type'    => 'select',
			'options' => [
				'icon'  => esc_html__( 'Icon', 'max-addons' ),
				'image' => esc_html__( 'Image', 'max-addons' ),
			],
			'inline'  => true,
			'default' => 'icon',
		];

		$this->controls['backIcon'] = [
			'tab'      => 'content',
			'group'    => 'back',
			'label'    => esc_html__( 'Icon', 'max-addons' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-wordpress',
			],
			'css' => [
				[
					'selector' => '.mab-flipbox-back .mab-icon svg',
				],
			],
			'required' => [ 'backIconType', '=', [ 'icon' ] ],
		];

		$this->controls['backImage'] = [
			'tab'      => 'content',
			'group'    => 'back',
			'type'     => 'image',
			'label'    => esc_html__( 'Image', 'max-addons' ),
			'required' => [ 'backIconType', '=', [ 'image' ] ],
		];

		$this->controls['backHeading'] = [
			'tab'            => 'content',
			'group'          => 'back',
			'label'          => esc_html__( 'Heading', 'max-addons' ),
			'type'           => 'text',
			'spellcheck'     => true,
			'inlineEditing'  => false,
			'default'        => 'Flip box back heading',
			'hasDynamicData' => 'text',
		];

		$this->controls['backHeadingTag'] = [
			'tab'         => 'content',
			'group'       => 'back',
			'label'       => esc_html__( 'Heading Tag', 'max-addons' ),
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
			'default'     => 'h3',
		];

		$this->controls['backContent'] = [
			'tab'     => 'content',
			'group'   => 'back',
			'label'   => esc_html__( 'Description', 'max-addons' ),
			'type'    => 'editor',
			'default' => 'Aenean commodo ligula egget dolor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
		];

		$this->controls['link'] = [
			'tab'   => 'content',
			'group' => 'back',
			'label' => esc_html__( 'Link', 'max-addons' ),
			'type'  => 'link',
		];

		$this->controls['applyLinkOn'] = [
			'tab'      => 'content',
			'group'    => 'back',
			'label'    => esc_html__( 'Apply Link On', 'max-addons' ),
			'type'     => 'select',
			'options'  => [
				'box'    => esc_html__( 'Whole Box', 'max-addons' ),
				'button' => esc_html__( 'Button Only', 'max-addons' ),
			],
			'inline'   => true,
			'default'  => 'button',
			'required' => [ 'link', '!=', '' ],
		];

		$this->controls['buttonText'] = [
			'tab'            => 'content',
			'group'          => 'back',
			'label'          => esc_html__( 'Button Text', 'max-addons' ),
			'type'           => 'text',
			'default'        => esc_html__( 'Click Here', 'max-addons' ),
			'spellcheck'     => true,
			'inlineEditing'  => false,
			'hasDynamicData' => 'text',
		];

		$this->controls['backBackground'] = [
			'tab'     => 'content',
			'group'   => 'back',
			'label'   => esc_html__( 'Background', 'max-addons' ),
			'type'    => 'background',
			'css'     => [
				[
					'property' => 'background',
					'selector' => '.mab-flipbox-back',
				],
			],
			'exclude' => [
				'parallax',
				'videoUrl',
				'videoScale',
			],
			'inline'  => true,
			'small'   => true,
			'default' => [
				'color' => [
					'rgb' => 'rgba(241, 241, 241, 1)',
					'hex' => '#f1f1f1',
				],
			],
		];

		$this->controls['applyBackGradient'] = array(
			'tab'    => 'style',
			'group'  => 'back',
			'label'  => esc_html__( 'Gradient Background', 'max-addons' ),
			'type'   => 'checkbox',
			'inline' => true,
			'reset'  => true,
		);

		$this->controls['backBackgroundGradient'] = [
			'tab'      => 'content',
			'group'    => 'back',
			'label'    => '',
			'type'     => 'gradient',
			'css'      => [
				[
					'property' => 'background-image',
					'selector' => '.mab-flipbox-back',
				],
			],
			'required' => array( 'applyBackGradient', '=', true ),
		];
	}

	// Set settings controls
	public function set_settings_controls() {
		$this->controls['height'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Height', 'max-addons' ),
			'type'    => 'number',
			'units'   => true,
			'css'     => [
				[
					'property' => 'height',
					'selector' => '.mab-flipbox',
				],
			],
			'default' => '280px',
		];

		$this->controls['borderRadius'] = [
			'tab'   => 'content',
			'group' => 'settings',
			'label' => esc_html__( 'Border Radius', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'border-radius',
					'selector' => '.mab-flipbox-container, .mab-flipbox-overlay',
				],
			],
		];

		$this->controls['flipEffect'] = [
			'tab'       => 'content',
			'group'     => 'settings',
			'label'     => esc_html__( 'Flip Effect', 'max-addons' ),
			'type'      => 'select',
			'options'   => [
				'flip'     => esc_html__( 'Flip', 'max-addons' ),
				'slide'    => esc_html__( 'Slide', 'max-addons' ),
				'push'     => esc_html__( 'Push', 'max-addons' ),
				'zoom-in'  => esc_html__( 'Zoom In', 'max-addons' ),
				'zoom-out' => esc_html__( 'Zoom Out', 'max-addons' ),
				'fade'     => esc_html__( 'Fade', 'max-addons' ),
			],
			'inline'    => true,
			'clearable' => false,
			'default'   => 'flip',
		];

		$this->controls['flipDirection'] = [
			'tab'       => 'content',
			'group'     => 'settings',
			'label'     => esc_html__( 'Flip Direction', 'max-addons' ),
			'type'      => 'select',
			'options'   => [
				'left'  => esc_html__( 'Left', 'max-addons' ),
				'right' => esc_html__( 'Right', 'max-addons' ),
				'up'    => esc_html__( 'Up', 'max-addons' ),
				'down'  => esc_html__( 'Down', 'max-addons' ),
			],
			'inline'    => true,
			'clearable' => false,
			'default'   => 'up',
			'required'  => [ 'flipEffect', '!=', [ 'fade', 'zoom-in', 'zoom-out' ] ],
		];

		$this->controls['flip3d'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( '3D Effect', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'required' => [ 'flipEffect', '=', 'flip' ],
		];
	}

	// Set icon controls
	public function set_front_icon_controls() {

		$this->controls['frontIconPosition'] = [
			'tab'         => 'content',
			'group'       => 'frontIconStyle',
			'label'       => esc_html__( 'Position', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'top'    => esc_html__( 'Top', 'max-addons' ),
				'right'  => esc_html__( 'Right', 'max-addons' ),
				'bottom' => esc_html__( 'Bottom', 'max-addons' ),
				'left'   => esc_html__( 'Left', 'max-addons' ),
			],
			'inline'      => true,
			'placeholder' => esc_html__( 'Top', 'max-addons' ),
		];

		$this->controls['frontIconSpacing'] = [
			'tab'   => 'content',
			'group' => 'frontIconStyle',
			'label' => esc_html__( 'Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.mab-flipbox-front .mab-flipbox-icon-position-top .mab-icon, .mab-flipbox-front .mab-flipbox-icon-position-top .mab-flipbox-image',
				],
				[
					'property' => 'margin-left',
					'selector' => '.mab-flipbox-front .mab-flipbox-icon-position-right .mab-icon, .mab-flipbox-front .mab-flipbox-icon-position-right .mab-flipbox-image',
				],
				[
					'property' => 'margin-right',
					'selector' => '.mab-flipbox-front .mab-flipbox-icon-position-left .mab-icon, .mab-flipbox-front .mab-flipbox-icon-position-left .mab-flipbox-image',
				],
				[
					'property' => 'margin-top',
					'selector' => '.mab-flipbox-front .mab-flipbox-icon-position-bottom .mab-icon, .mab-flipbox-front .mab-flipbox-icon-position-bottom .mab-flipbox-image',
				],
			],
		];

		$this->controls['frontIconSize'] = [
			'tab'      => 'content',
			'group'    => 'frontIconStyle',
			'label'    => esc_html__( 'Size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'font-size',
					'selector' => '.mab-flipbox-front .mab-icon',
				],
			],
			'required' => [ 'frontIconType', '=', [ 'icon' ] ],
		];

		$this->controls['frontIconColor'] = [
			'tab'      => 'content',
			'group'    => 'frontIconStyle',
			'label'    => esc_html__( 'Color', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'css'      => [
				[
					'property' => 'color',
					'selector' => '.mab-flipbox-front .mab-icon i',
				],
				[
					'property' => 'fill',
					'selector' => '.mab-flipbox-front .mab-icon svg',
				],
			],
			'required' => [ 'frontIconType', '=', [ 'icon' ] ],
		];

		$this->controls['frontImageSize'] = [
			'tab'      => 'content',
			'group'    => 'frontIconStyle',
			'label'    => esc_html__( 'Size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'width',
					'selector' => '.mab-flipbox-front .mab-flipbox-image img',
				],
			],
			'required' => [ 'frontIconType', '=', [ 'image' ] ],
		];

		$this->controls['frontImageBorder'] = [
			'tab'      => 'content',
			'group'    => 'frontIconStyle',
			'type'     => 'border',
			'label'    => esc_html__( 'Border', 'max-addons' ),
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-flipbox-front .mab-flipbox-image img',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'frontIconType', '=', [ 'image' ] ],
		];
	}

	// Set flip box style controls
	public function set_front_style_controls() {

		$this->controls['frontTextAlign'] = [
			'tab'         => 'content',
			'group'       => 'frontStyle',
			'label'       => esc_html__( 'Text align', 'max-addons' ),
			'type'        => 'text-align',
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.mab-flipbox-front .mab-flipbox-overlay',
				],
			],
			'default'     => 'center',
			'placeholder' => esc_html__( 'Center', 'max-addons' ),
			'inline'      => true,
		];

		$this->controls['frontVerticalAlign'] = [
			'tab'         => 'content',
			'group'       => 'frontStyle',
			'label'       => esc_html__( 'Vertical align', 'max-addons' ),
			'type'        => 'justify-content',
			'exclude'     => [
				'space',
			],
			'css'         => [
				[
					'property' => 'justify-content',
					'selector' => '.mab-flipbox-front .mab-flipbox-overlay',
				],
			],
			'inline'      => true,
			'default'     => 'center',
			'placeholder' => esc_html__( 'Center', 'max-addons' ),
		];

		$this->controls['frontTypographyHeading'] = [
			'tab'    => 'content',
			'group'  => 'frontStyle',
			'type'   => 'typography',
			'label'  => esc_html__( 'Heading typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-flipbox-front .mab-flipbox-title',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['frontHeadingSpacing'] = [
			'tab'   => 'content',
			'group' => 'frontStyle',
			'label' => esc_html__( 'Heading spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.mab-flipbox-front .mab-flipbox-title',
				],
			],
		];

		$this->controls['frontTypographyBody'] = [
			'tab'    => 'content',
			'group'  => 'frontStyle',
			'type'   => 'typography',
			'label'  => esc_html__( 'Content typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-flipbox-front .mab-flipbox-description',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['frontBorder'] = [
			'tab'    => 'content',
			'group'  => 'frontStyle',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-flipbox-front',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['frontPadding'] = [
			'tab'   => 'content',
			'group' => 'frontStyle',
			'type'  => 'spacing',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-flipbox-front .mab-flipbox-overlay',
				],
			],
		];
	}

	// Set back icon controls
	public function set_back_icon_controls() {

		$this->controls['backIconPosition'] = [
			'tab'         => 'content',
			'group'       => 'backIconStyle',
			'label'       => esc_html__( 'Position', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'top'    => esc_html__( 'Top', 'max-addons' ),
				'right'  => esc_html__( 'Right', 'max-addons' ),
				'bottom' => esc_html__( 'Bottom', 'max-addons' ),
				'left'   => esc_html__( 'Left', 'max-addons' ),
			],
			'inline'      => true,
			'placeholder' => esc_html__( 'Top', 'max-addons' ),
		];

		$this->controls['backIconSpacing'] = [
			'tab'   => 'content',
			'group' => 'backIconStyle',
			'label' => esc_html__( 'Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.mab-flipbox-back .mab-flipbox-icon-position-top .mab-icon, .mab-flipbox-back .mab-flipbox-icon-position-top .mab-flipbox-image',
				],
				[
					'property' => 'margin-left',
					'selector' => '.mab-flipbox-back .mab-flipbox-icon-position-right .mab-icon, .mab-flipbox-back .mab-flipbox-icon-position-right .mab-flipbox-image',
				],
				[
					'property' => 'margin-right',
					'selector' => '.mab-flipbox-back .mab-flipbox-icon-position-left .mab-icon, .mab-flipbox-back .mab-flipbox-icon-position-left .mab-flipbox-image',
				],
				[
					'property' => 'margin-top',
					'selector' => '.mab-flipbox-back .mab-flipbox-icon-position-bottom .mab-icon, .mab-flipbox-back .mab-flipbox-icon-position-bottom .mab-flipbox-image',
				],
				[
					'property' => 'display',
					'selector' => '.mab-flipbox-back .mab-flipbox-icon-position-bottom .mab-icon',
					'value'    => 'block',
				],
			],
		];

		$this->controls['backIconSize'] = [
			'tab'      => 'content',
			'group'    => 'backIconStyle',
			'label'    => esc_html__( 'Size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'font-size',
					'selector' => '.mab-flipbox-back .mab-icon',
				],
			],
			'required' => [ 'backIconType', '=', [ 'icon' ] ],
		];

		$this->controls['backIconColor'] = [
			'tab'      => 'content',
			'group'    => 'backIconStyle',
			'label'    => esc_html__( 'Color', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'css'      => [
				[
					'property' => 'color',
					'selector' => '.mab-flipbox-back .mab-icon i',
				],
				[
					'property' => 'fill',
					'selector' => '.mab-flipbox-back .mab-icon svg',
				],
			],
			'required' => [ 'backIconType', '=', [ 'icon' ] ],
		];

		$this->controls['backImageSize'] = [
			'tab'      => 'content',
			'group'    => 'backIconStyle',
			'label'    => esc_html__( 'Size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'width',
					'selector' => '.mab-flipbox-back .mab-flipbox-image img',
				],
			],
			'required' => [ 'backIconType', '=', [ 'image' ] ],
		];

		$this->controls['backImageBorder'] = [
			'tab'      => 'content',
			'group'    => 'backIconStyle',
			'type'     => 'border',
			'label'    => esc_html__( 'Border', 'max-addons' ),
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-flipbox-back .mab-flipbox-image img',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'backIconType', '=', [ 'image' ] ],
		];
	}

	// Set flip box back style controls
	public function set_back_style_controls() {

		$this->controls['backTextAlign'] = [
			'tab'         => 'content',
			'group'       => 'backStyle',
			'label'       => esc_html__( 'Text align', 'max-addons' ),
			'type'        => 'text-align',
			'css'         => [
				[
					'property' => 'text-align',
					'selector' => '.mab-flipbox-back .mab-flipbox-overlay',
				],
			],
			'default'     => 'center',
			'placeholder' => esc_html__( 'Center', 'max-addons' ),
			'inline'      => true,
		];

		$this->controls['backVerticalAlign'] = [
			'tab'         => 'content',
			'group'       => 'backStyle',
			'label'       => esc_html__( 'Vertical align', 'max-addons' ),
			'type'        => 'justify-content',
			'exclude'     => [
				'space',
			],
			'css'         => [
				[
					'property' => 'justify-content',
					'selector' => '.mab-flipbox-back .mab-flipbox-overlay',
				],
			],
			'inline'      => true,
			'default'     => 'center',
			'placeholder' => esc_html__( 'Center', 'max-addons' ),
		];

		$this->controls['backTypographyHeading'] = [
			'tab'    => 'content',
			'group'  => 'backStyle',
			'type'   => 'typography',
			'label'  => esc_html__( 'Heading typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-flipbox-back .mab-flipbox-title',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['backHeadingSpacing'] = [
			'tab'   => 'content',
			'group' => 'backStyle',
			'label' => esc_html__( 'Heading spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-bottom',
					'selector' => '.mab-flipbox-back .mab-flipbox-title',
				],
			],
		];

		$this->controls['backTypographyBody'] = [
			'tab'    => 'content',
			'group'  => 'backStyle',
			'type'   => 'typography',
			'label'  => esc_html__( 'Content typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-flipbox-back .mab-flipbox-description',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['backBorder'] = [
			'tab'    => 'content',
			'group'  => 'backStyle',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-flipbox-back',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['backPadding'] = [
			'tab'   => 'content',
			'group' => 'backStyle',
			'type'  => 'spacing',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-flipbox-back .mab-flipbox-overlay',
				],
			],
		];

		//Button Style
		$this->controls['buttonSeparator'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'label'    => esc_html__( 'Button', 'max-addons' ),
			'type'     => 'separator',
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonSize'] = [
			'tab'         => 'content',
			'group'       => 'backStyle',
			'label'       => esc_html__( 'Size', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['buttonSizes'],
			'inline'      => true,
			'reset'       => true,
			'placeholder' => esc_html__( 'Medium', 'max-addons' ),
			'required'    => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonStyle'] = [
			'tab'         => 'content',
			'group'       => 'backStyle',
			'label'       => esc_html__( 'Style', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['styles'],
			'inline'      => true,
			'reset'       => true,
			'default'     => 'primary',
			'placeholder' => esc_html__( 'None', 'max-addons' ),
			'required'    => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonCircle'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'label'    => esc_html__( 'Circle', 'max-addons' ),
			'type'     => 'checkbox',
			'reset'    => true,
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonBlock'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'label'    => esc_html__( 'Stretch', 'max-addons' ),
			'type'     => 'checkbox',
			'reset'    => true,
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonOutline'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'label'    => esc_html__( 'Outline', 'max-addons' ),
			'type'     => 'checkbox',
			'reset'    => true,
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonTypography'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'type'     => 'typography',
			'label'    => esc_html__( 'Button typography', 'max-addons' ),
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-flipbox-button',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonBackgroundColor'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'type'     => 'color',
			'label'    => esc_html__( 'Background', 'max-addons' ),
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-flipbox-button',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonBorder'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'type'     => 'border',
			'label'    => esc_html__( 'Border', 'max-addons' ),
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-flipbox-button',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonSpacing'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'label'    => esc_html__( 'Spacing', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'margin-top',
					'selector' => '.mab-flipbox-button',
				],
			],
			'default'  => '20px',
			'required' => [ 'buttonText', '!=', '' ],
		];

		$this->controls['buttonPadding'] = [
			'tab'      => 'content',
			'group'    => 'backStyle',
			'type'     => 'spacing',
			'label'    => esc_html__( 'Padding', 'max-addons' ),
			'css'      => [
				[
					'property' => 'padding',
					'selector' => '.mab-flipbox-button',
				],
			],
			'required' => [ 'buttonText', '!=', '' ],
		];
	}

	public function get_normalized_image_settings( $settings, $image_type ) {
		if ( empty( $settings[ $image_type ] ) ) {
			return [
				'id'   => 0,
				'url'  => false,
				'size' => BRICKS_DEFAULT_IMAGE_SIZE,
			];
		}

		$image = $settings[ $image_type ];

		// Size
		$image['size'] = empty( $image['size'] ) ? BRICKS_DEFAULT_IMAGE_SIZE : $settings[ $image_type ]['size'];

		// Image ID or URL from dynamic data
		if ( ! empty( $image['useDynamicData'] ) ) {
			$images = $this->render_dynamic_data_tag( $image['useDynamicData'], $image_type, [ 'size' => $image['size'] ] );

			if ( ! empty( $images[0] ) ) {
				if ( is_numeric( $images[0] ) ) {
					$image['id'] = $images[0];
				} else {
					$image['url'] = $images[0];
				}
			}

			// No dynamic data image found (@since 1.6)
			else {
				return;
			}
		}

		$image['id'] = empty( $image['id'] ) ? 0 : $image['id'];

		// If External URL, $image['url'] is already set
		if ( ! isset( $image['url'] ) ) {
			$image['url'] = ! empty( $image['id'] ) ? wp_get_attachment_image_url( $image['id'], $image['size'] ) : false;
		} else {
			// Parse dynamic data in the external URL
			$image['url'] = $this->render_dynamic_data( $image['url'] );
		}

		return $image;
	}

	// Render element HTML
	public function render_image( $image_type ) {
		$settings   = $this->settings;
		$image      = $this->get_normalized_image_settings( $settings, $image_type );
		$image_id   = isset( $image['id'] ) ? $image['id'] : '';
		$image_url  = isset( $image['url'] ) ? $image['url'] : '';
		$image_size = isset( $image['size'] ) ? $image['size'] : '';

		// STEP: Dynamic data image not found: Show placeholder text
		if ( ! empty( $settings[ $image_type ]['useDynamicData'] ) && ! $image ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'Dynamic data is empty.', 'max-addons' )
				]
			);
		}

		// Check: No image selected: No image ID provided && not a placeholder URL
		if ( ! isset( $image['external'] ) && ! $image_id && ! $image_url ) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'No image selected.', 'max-addons' ) ] );
		}

		// Check: Image with ID doesn't exist
		if ( ! isset( $image['external'] ) && ! $image_url ) {
			// translators: %s: Image ID
			return $this->render_element_placeholder( [ 'title' => sprintf( esc_html__( 'Image ID (%s) no longer exist. Please select another image.', 'max-addons' ), $image_id ) ] );
		}

		$image_attributes = [];
		$img_classes      = [ 'css-filter' ];
		$img_classes[]    = 'attachment-' . $image_size;
		$img_classes[]    = 'size-' . $image_size;

		$image_attributes['class'] = join( ' ', $img_classes );

		if ( isset( $image_id ) ) {
			$show_image = wp_get_attachment_image( $image_id, $image_size, false, $image_attributes );
		} elseif ( ! empty( $image_url ) ) {
			$show_image = '<img src="' . esc_url( $image_url ) . '">';
		}

		return $show_image;
	}

	// Render front icon
	public function render_flipbox_icon( $icon_position ) {
		$settings = $this->settings;

		$icon_html = '';
		$icon_type = isset( $settings[ $icon_position . 'IconType' ] ) ? $settings[ $icon_position . 'IconType' ] : 'icon';

		if ( 'icon' === $icon_type && isset( $settings[ $icon_position . 'Icon' ] ) ) {
			$icon_html .= '<div class="mab-icon">';
			$icon_html .= self::render_icon( $settings[ $icon_position . 'Icon' ] );
			$icon_html .= '</div>';
		} elseif ( 'image' === $icon_type && isset( $settings[ $icon_position . 'Image' ] ) ) {
			$icon_html .= '<div class="mab-flipbox-image">';
			$icon_html .= wp_kses_post( $this->render_image( $icon_position . 'Image' ) );
			$icon_html .= '</div>';
		}

		return $icon_html;
	}

	// Render front HTML
	public function render_front() {
		$settings = $this->settings;

		$icon_position     = isset( $settings['frontIconPosition'] ) ? $settings['frontIconPosition'] : 'top';
		$front_heading_tag = isset( $settings['frontHeadingTag'] ) ? $settings['frontHeadingTag'] : 'h3';

		$this->set_attribute( 'front-wrapper', 'class', 'mab-flipbox-container mab-flipbox-front' );
		$this->set_attribute( 'front-inner', 'class', 'mab-flipbox-inner mab-flipbox-icon-position-' . esc_attr( $icon_position ) );

		$front_html  = '<div ' . wp_kses_post( $this->render_attributes( 'front-wrapper' ) ) . '>';
		$front_html .= '<div class="mab-flipbox-overlay">';
		$front_html .= '<div ' . wp_kses_post( $this->render_attributes( 'front-inner' ) ) . '>';

		if ( 'bottom' !== $icon_position ) {
			$front_html .= $this->render_flipbox_icon( 'front' );
		}

		$front_html .= '<div class="mab-flipbox-content-wrapper">';

		if ( isset( $settings['frontHeading'] ) ) {
			$front_html .= '<' . esc_html( $front_heading_tag ) . ' class="mab-flipbox-title">' . wp_kses_post( $settings['frontHeading'] ) . '</' . esc_html( $front_heading_tag ) . '>';
		}

		if ( isset( $settings['frontContent'] ) ) {
			$front_html .= '<div class="mab-flipbox-description">' . wp_kses_post( $settings['frontContent'] ) . '</div>';
		}

		if ( 'bottom' === $icon_position ) {
			$front_html .= $this->render_flipbox_icon( 'front' );
		}

		$front_html .= '</div></div></div></div>';

		echo $front_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	// Render front HTML
	public function render_back() {
		$settings = $this->settings;
	
		$icon_position    = isset( $settings['backIconPosition'] ) ? $settings['backIconPosition'] : 'top';
		$back_heading_tag = isset( $settings['backHeadingTag'] ) ? $settings['backHeadingTag'] : 'h3';
		$wrapper_tag      = 'div';
		$button_tag       = 'a';
	
		$button_classes = [
			'mab-flipbox-button',
			'bricks-button',
			isset( $settings['buttonSize'] ) ? esc_attr( $settings['buttonSize'] ) : '',
			isset( $settings['buttonStyle'] ) ? ( isset( $settings['buttonOutline'] ) ? 'outline bricks-color-' . esc_attr( $settings['buttonStyle'] ) : 'bricks-background-' . esc_attr( $settings['buttonStyle'] ) ) : '',
			isset( $settings['buttonCircle'] ) ? 'circle' : '',
			isset( $settings['buttonBlock'] ) ? 'block' : '',
		];
	
		$this->set_attribute( 'button', 'class', array_filter( $button_classes ) );
		$this->set_attribute( 'back-wrapper', 'class', 'mab-flipbox-container mab-flipbox-back' );
	
		if ( isset( $settings['link'] ) ) {
			$link_element = 'button';
	
			if ( 'box' === $settings['applyLinkOn'] ) {
				$wrapper_tag  = 'a';
				$button_tag   = 'span';
				$link_element = 'back-wrapper';
			}
	
			$this->set_link_attributes( $link_element, $settings['link'] );
		}
	
		$this->set_attribute( 'back-inner', 'class', 'mab-flipbox-inner mab-flipbox-icon-position-' . esc_attr( $icon_position ) );
	
		$back_html  = '<' . esc_html( $wrapper_tag ) . ' ' . wp_kses_post( $this->render_attributes( 'back-wrapper' ) ) . '>';
		$back_html .= '<div class="mab-flipbox-overlay">';
		$back_html .= '<div ' . wp_kses_post( $this->render_attributes( 'back-inner' ) ) . '>';
	
		if ( 'bottom' !== $icon_position ) {
			$back_html .= $this->render_flipbox_icon( 'back' );
		}
	
		$back_html .= '<div class="mab-flipbox-content-wrapper">';
	
		if ( isset( $settings['backHeading'] ) ) {
			$back_html .= '<' . esc_html( $back_heading_tag ) . ' class="mab-flipbox-title">' . wp_kses_post( $settings['backHeading'] ) . '</' . esc_html( $back_heading_tag ) . '>';
		}
	
		if ( isset( $settings['backContent'] ) ) {
			$back_html .= '<div class="mab-flipbox-description">' . wp_kses_post( $settings['backContent'] ) . '</div>';
		}
	
		if ( 'bottom' === $icon_position ) {
			$back_html .= $this->render_flipbox_icon( 'back' );
		}
	
		if ( isset( $settings['buttonText'] ) ) {
			$back_html .= '<' . esc_html( $button_tag ) . ' ' . wp_kses_post( $this->render_attributes( 'button' ) ) . '>' . wp_kses_post( $settings['buttonText'] ) . '</' . esc_html( $button_tag ) . '>';
		}
	
		$back_html .= '</div></div></div></' . esc_html( $wrapper_tag ) . '>';
	
		echo $back_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	// Render element HTML
	public function render() {
		$settings = $this->settings;
	
		$wrapper_classes = [
			'mab-flipbox-wrap',
			isset( $settings['flipEffect'] ) ? 'mab-flipbox-effect-' . esc_attr( $settings['flipEffect'] ) : '',
			isset( $settings['flipDirection'] ) ? 'mab-flipbox-direction-' . esc_attr( $settings['flipDirection'] ) : '',
			isset( $settings['flip3d'] ) && isset( $settings['flipEffect'] ) && 'flip' === $settings['flipEffect'] ? 'mab-flipbox-3d' : '',
		];
	
		$this->set_attribute( '_root', 'class', array_filter( $wrapper_classes ) );
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?>>
			<div class="mab-flipbox">
				<?php $this->render_front(); ?>
				<?php $this->render_back(); ?>
			</div>
		</div>
		<?php
	}
}
