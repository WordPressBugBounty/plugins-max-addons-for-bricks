<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Multi_Heading_Element extends \Bricks\Element {
	// Element properties
	public $category = 'max-addons-elements'; // Use predefined element category 'general'
	public $name     = 'max-multi-heading'; // Make sure to prefix your elements
	public $icon     = 'ti-uppercase max-element'; // Themify icon font class
	public $tag      = 'h3';

	public function get_label() {
		return esc_html__( 'Multi Heading', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-multi-heading' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['heading'] = [
			'title' => esc_html__( 'Heading', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['backgroundText'] = [
			'title' => esc_html__( 'Background Text', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['separator'] = [
			'title'      => esc_html__( 'Separator', 'max-addons' ),
			'tab'        => 'content',
			'fullAccess' => true, // NOTE: Undocumented (show if user role has full_access capability)
		];

		$this->control_groups['headingStyle'] = [
			'title' => esc_html__( 'Heading Style', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {

		$this->controls['_background']['css'][0]['selector'] = '';
		$this->controls['_gradient']['css'][0]['selector'] = '';

		$this->set_items_controls();
		$this->set_bg_text_controls();
		$this->set_separator_controls();
		$this->set_style_controls();
	}

	// Set items controls
	public function set_items_controls() {

		$this->controls['items'] = [
			'tab'           => 'content',
			'group'         => 'heading',
			'label'         => esc_html__( 'Heading', 'max-addons' ),
			'type'          => 'repeater',
			'placeholder'   => esc_html__( 'Heading', 'max-addons' ),
			'titleProperty' => 'heading',
			'fields'        => [
				'heading'            => [
					'label'          => esc_html__( 'Heading', 'max-addons' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],

				'headingTypography'  => [
					'label'  => esc_html__( 'Typography', 'max-addons' ),
					'type'   => 'typography',
					'css'    => [
						[
							'property'         => 'font',
							'repeaterSelector' => '.repeater-item',
						],
					],
					'inline' => true,
					'small'  => true,
				],

				'headingBackground'  => [
					'type'    => 'background',
					'label'   => esc_html__( 'Background', 'max-addons' ),
					'css'     => [
						[
							'property'         => 'background',
							'repeaterSelector' => '.repeater-item',
						],
					],
					'exclude' => [
						'parallax',
						'videoUrl',
						'videoScale',
					],
					'inline'  => true,
					'small'   => true,
				],

				'applyGradient'      => [
					'label'  => esc_html__( 'Gradient Background', 'max-addons' ),
					'type'   => 'checkbox',
					'inline' => true,
					'reset'  => true,
				],

				'backgroundGradient' => [
					'label'    => '',
					'type'     => 'gradient',
					'css'      => [
						[
							'property'         => 'background-image',
							'repeaterSelector' => '.repeater-item',
						],
					],
					'required' => array( 'applyGradient', '=', true ),
				],

				'headingBorder'      => [
					'label'  => esc_html__( 'Border', 'max-addons' ),
					'type'   => 'border',
					'css'    => [
						[
							'property'         => 'border',
							'repeaterSelector' => '.repeater-item',
						],
					],
					'inline' => true,
					'small'  => true,
				],

				'headingBoxShadow' => [
					'label'  => esc_html__( 'Box shadow', 'max-addons' ),
					'type'   => 'box-shadow',
					'css'    => [
						[
							'property'         => 'box-shadow',
							'repeaterSelector' => '.repeater-item',
						],
					],
					'inline' => true,
					'small'  => true,
				],

				'headingPadding'     => [
					'label' => esc_html__( 'Padding', 'max-addons' ),
					'type'  => 'spacing',
					'css'   => [
						[
							'property'         => 'padding',
							'repeaterSelector' => '.repeater-item',
						],
					],
				],
			],
			'default'       => [
				[
					'heading' => esc_html__( 'Heading Text #1', 'max-addons' ),
				],
				[
					'heading' => esc_html__( 'Heading Text #2', 'max-addons' ),
				],
			],
		];

		$this->controls['tag'] = [
			'tab'         => 'content',
			'group'       => 'heading',
			'label'       => esc_html__( 'Tag', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'h1'     => 'h1',
				'h2'     => 'h2',
				'h3'     => 'h3',
				'h4'     => 'h4',
				'h5'     => 'h5',
				'h6'     => 'h6',
				'div'    => 'div',
				'custom' => esc_html__( 'Custom', 'max-addons' ),
			],
			'inline'      => true,
			'default'     => 'h3',
			'placeholder' => ! empty( $this->theme_styles['tag'] ) ? $this->theme_styles['tag'] : 'h3',
		];

		$this->controls['customTag'] = [
			'tab'         => 'content',
			'group'       => 'heading',
			'label'       => esc_html__( 'Custom tag', 'max-addons' ),
			'type'        => 'text',
			'inline'      => true,
			'placeholder' => 'div',
			'required'    => [ 'tag', '=', 'custom' ],
		];

		$this->controls['link'] = [
			'tab'         => 'content',
			'group'       => 'heading',
			'label'       => esc_html__( 'Link to', 'max-addons' ),
			'type'        => 'link',
			'pasteStyles' => false,
		];
	}

	// Set background text controls
	public function set_bg_text_controls() {

		$this->controls['bgText'] = [
			'tab'            => 'content',
			'group'          => 'backgroundText',
			'label'          => esc_html__( 'Background Text', 'max-addons' ),
			'type'           => 'text',
			'hasDynamicData' => 'text',
		];

		$this->controls['bgTextTypography'] = [
			'tab'      => 'content',
			'group'    => 'backgroundText',
			'label'    => esc_html__( 'Typography', 'max-addons' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-multi-heading-bg-text',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'bgText', '!=', '' ],
		];

		$this->controls['bgTextHorizontalPosition'] = [
			'tab'      => 'content',
			'group'    => 'backgroundText',
			'label'    => esc_html__( 'Horizontal Position', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'left',
					'selector' => '.mab-multi-heading-bg-text',
				],
			],
			'required' => [ 'bgText', '!=', '' ],
		];

		$this->controls['bgTextVerticalPosition'] = [
			'tab'      => 'content',
			'group'    => 'backgroundText',
			'label'    => esc_html__( 'Vertical Position', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'top',
					'selector' => '.mab-multi-heading-bg-text',
				],
			],
			'required' => [ 'bgText', '!=', '' ],
		];
	}

	// Set separator controls
	public function set_separator_controls() {
		$this->controls['separator'] = [
			'tab'         => 'content',
			'group'       => 'separator',
			'label'       => esc_html__( 'Separator', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'right' => esc_html__( 'Right', 'max-addons' ),
				'left'  => esc_html__( 'Left', 'max-addons' ),
				'both'  => esc_html__( 'Both', 'max-addons' ),
				'none'  => esc_html__( 'None', 'max-addons' ),
			],
			'inline'      => true,
			'pasteStyles' => true,
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['separatorWidth'] = [
			'tab'   => 'content',
			'group' => 'separator',
			'label' => esc_html__( 'Width', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => '.separator',
				],
				[
					'property' => 'flex-grow',
					'selector' => '.separator',
					'value'    => 0,
				],
				// To allow self-align heading
				[
					'property' => 'width',
					'selector' => '',
					'value'    => 'auto',
				],
			],
		];

		$this->controls['separatorHeight'] = [
			'tab'   => 'content',
			'group' => 'separator',
			'label' => esc_html__( 'Height', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'border-top-width',
					'selector' => '.separator',
				],
				[
					'property' => 'height',
					'selector' => '.separator',
				],
			],
		];

		$this->controls['separatorSpacing'] = [
			'tab'         => 'content',
			'group'       => 'separator',
			'label'       => esc_html__( 'Spacing', 'max-addons' ),
			'type'        => 'number',
			'units'       => true,
			'small'       => false,
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '&.has-separator',
				],
			],
			'placeholder' => 20,
		];

		$this->controls['separatorStyle'] = [
			'tab'     => 'content',
			'group'   => 'separator',
			'label'   => esc_html__( 'Style', 'max-addons' ),
			'type'    => 'select',
			'options' => $this->control_options['borderStyle'],
			'css'     => [
				[
					'property' => 'border-top-style',
					'selector' => '.separator',
				],
			],
			'inline'  => true,
		];

		$this->controls['separatorAlignItems'] = [
			'tab'       => 'content',
			'group'     => 'separator',
			'label'     => esc_html__( 'Align', 'max-addons' ),
			'type'      => 'align-items',
			'direction' => 'row',
			'exclude'   => 'stretch',
			'inline'    => true,
			'css'       => [
				[
					'property'  => 'align-items',
					'selector'  => '&.has-separator',
					'important' => true,
				],
			],
		];

		$this->controls['separatorColor'] = [
			'tab'   => 'content',
			'group' => 'separator',
			'label' => esc_html__( 'Color', 'max-addons' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'border-top-color',
					'selector' => '.separator',
				],
			],
		];
	}

	// Set heading style controls
	public function set_style_controls() {

		$this->controls['spacing'] = [
			'tab'   => 'content',
			'group' => 'headingStyle',
			'label' => esc_html__( 'Gap between headings', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-right',
					'selector' => '&.mab-multi-heading-inline span:not(:last-child)',
				],
				[
					'property' => 'margin-bottom',
					'selector' => '&.mab-multi-heading-block span:not(:last-child)',
				],
			],
		];

		$this->controls['style'] = [
			'tab'         => 'content',
			'group'       => 'headingStyle',
			'label'       => esc_html__( 'Style', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['styles'],
			'inline'      => true,
			'reset'       => true,
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['stackOrder'] = [
			'tab'     => 'content',
			'group'   => 'headingStyle',
			'label'   => esc_html__( 'Display', 'max-addons' ),
			'type'    => 'select',
			'default' => 'inline',
			'options' => [
				'inline' => esc_html__( 'Inline', 'max-addons' ),
				'block'  => esc_html__( 'Stack', 'max-addons' ),
			],
			'inline'  => true,
			'css'     => [
				[
					'property' => 'display',
					'selector' => '.repeater-item',
				],
			],
		];
	}

	public function render() {
		$settings = $this->settings;

		// Element placeholder
		if ( ! isset( $settings['items'] ) || empty( $settings['items'] ) ) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'No heading added.', 'max-addons' ) ] );
		}

		$heading_classes = [
			'brxe-heading',
		];

		if ( isset( $settings['stackOrder'] ) ) {
			$heading_classes[] = 'mab-multi-heading-' . $settings['stackOrder'];
		}

		if ( isset( $settings['style'] ) ) {
			$heading_classes[] = 'bricks-color-' . $settings['style'];
		}

		$this->set_attribute( '_root', 'class', $heading_classes );

		// Separator (check theme style, then element settings)
		$separator = ! empty( $this->theme_styles['separator'] ) ? $this->theme_styles['separator'] : 'none';

		if ( ! empty( $settings['separator'] ) ) {
			$separator = $settings['separator'];
		}

		if ( $separator !== 'none' ) {
			$this->set_attribute( '_root', 'class', 'has-separator' );
		}

		$output = '<' . esc_html( $this->tag ) . ' ' . $this->render_attributes( '_root' ) . '>';

		if ( $separator === 'left' || $separator === 'both' ) {
			$output .= '<span class="separator left"></span>';
		}

		// Link
		if ( isset( $settings['link'] ) ) {
			$this->set_link_attributes( 'heading-link', $settings['link'] );
			$output .= '<a ' . $this->render_attributes( 'heading-link' ) . '>';
		}

		if ( isset( $settings['separator'] ) ) {
			$output .= '<span class="text">';
		}

		foreach ( $settings['items'] as $index => $item ) {
			$this->set_attribute( "heading-$index", 'class', 'repeater-item' );

			$output .= '<span ' . $this->render_attributes( "heading-$index" ) . '>';

			if ( isset( $item['heading'] ) && ! empty( $item['heading'] ) ) {

				$output .= wp_kses_post( $item['heading'] );

			}

			$output .= '</span>';
		}

		if ( isset( $settings['bgText'] ) ) {
			$output .= '<div class="mab-multi-heading-bg-text">';
			$output .= esc_attr( $settings['bgText'] );
			$output .= '</div>';
		}

		if ( isset( $settings['separator'] ) ) {
			$output .= '</span>';
		}

		if ( isset( $settings['link'] ) ) {
			$output .= '</a>';
		}

		// Separator
		if ( $separator === 'right' || $separator === 'both' ) {
			$output .= '<span class="separator right"></span>';
		}

		$output .= '</' . esc_html( $this->tag ) . '>';

		echo $output; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
