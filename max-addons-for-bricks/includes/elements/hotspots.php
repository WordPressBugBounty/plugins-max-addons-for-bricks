<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Hotspots_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-hotspots'; // Make sure to prefix your elements
	public $icon         = 'ti-bolt-alt max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $loop_index   = 0;
	public $scripts      = [ 'mabHotspots' ]; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Hotspots', 'max-addons' );
	}

	public function get_keywords() {
		return [ 'hotspots', 'image' ];
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-hotspots' );
		wp_enqueue_script( 'mab-hotspots' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->controls['text'] = [ // Unique group identifier (lowercase, no spaces)
			'title' => esc_html__( 'Text', 'max-addons' ), // Localized control group title
			'tab'   => 'content', // Set to either "content" or "style"
		];

		$this->control_groups['image'] = [
			'title' => esc_html__( 'Image', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['hotspots'] = [
			'title' => esc_html__( 'Hotspots', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['hotspotStyle'] = [
			'title' => esc_html__( 'Hotspot Style', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['tooltipStyle'] = [
			'title' => esc_html__( 'Tooltip', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	// Set builder controls
	public function set_controls() {

		$this->set_image_controls();

		$this->set_hotspot_controls();

		$this->set_hotspot_styles();

		$this->set_tooltip_styles();
	}

	// Set front controls
	public function set_image_controls() {
		$this->controls['image'] = [
			'tab'   => 'content',
			'group' => 'image',
			'type'  => 'image',
		];
	}

	// Set Hotspot controls
	public function set_hotspot_controls() {
		$this->controls['hasLoop'] = [
			'tab'      => 'content',
			'group'    => 'hotspots',
			'label'    => esc_html__( 'Query loop', 'max-addons' ),
			'type'     => 'checkbox',
		];

		$this->controls['hasLoopInfo'] = [
			'tab'      => 'content',
			'group'    => 'hotspots',
			'content'  => esc_html__( 'Query loop option is available in Max Addons Pro.', 'max-addons' ) . ' ' . sprintf( esc_html__( 'Upgrade to %1$s Pro Version %2$s for 50+ creative elements, exciting extensions and advanced features.', 'max-addons' ), '<a href="https://wpbricksaddons.com/pricing/" target="_blank" rel="noopener">', '</a>' ),
			'type'     => 'info',
			'required' => ['hasLoop', '!=', ''],
		];

		$this->controls['hotspots'] = [
			'tab'           => 'content',
			'group'         => 'hotspots',
			'placeholder'   => esc_html__( 'Hotspots', 'max-addons' ),
			'type'          => 'repeater',
			'titleProperty' => 'title',
			'fields'        => [
				'title' => [
					'label' => esc_html__( 'Admin Label', 'max-addons' ),
					'type'  => 'text',
				],

				'horizontalPosition' => [
					'label'       => esc_html__( 'Horizontal Position', 'max-addons' ) . ' (%)',
					'type'        => 'text',
					'placeholder' => '30',
				],

				'verticalPosition' => [
					'label'       => esc_html__( 'Vertical Position', 'max-addons' ) . ' (%)',
					'type'        => 'text',
					'placeholder' => '30',
				],

				'hotspotType' => [
					'label'     => esc_html__( 'Type', 'max-addons' ),
					'type'      => 'select',
					'options'   => array(
						'icon'  => esc_html__( 'Icon', 'max-addons' ),
						'image' => esc_html__( 'Image', 'max-addons' ),
						'text'  => esc_html__( 'Text', 'max-addons' ),
					),
					'inline'    => true,
					'clearable' => true,
					'default'   => 'icon',
				],

				'hotspotIcon' => [
					'label'    => esc_html__( 'Icon', 'max-addons' ),
					'type'     => 'icon',
					'default'  => [
						'library' => 'themify',
						'icon'    => 'ti-wordpress',
					],
					'required' => [ 'hotspotType', '=', [ 'icon' ] ],
				],

				'hotspotImage' => [
					'label'    => esc_html__( 'Image', 'max-addons' ),
					'type'     => 'image',
					'required' => [ 'hotspotType', '=', [ 'image' ] ],
				],

				'hotspotText' => [
					'label'    => esc_html__( 'Text', 'max-addons' ),
					'type'     => 'text',
					'required' => [ 'hotspotType', '=', [ 'text' ] ],
				],

				'hotspotLink' => [
					'label'   => esc_html__( 'Link', 'max-addons' ),
					'type'    => 'link',
					'default' => '#',
				],

				'showTooltip' => [
					'label' => esc_html__( 'Tooltip', 'max-addons' ),
					'type'  => 'checkbox',
				],

				'tooltipContent' => [
					'label'    => esc_html__( 'Tooltip Content', 'max-addons' ),
					'type'     => 'textarea',
					'required' => [ 'showTooltip', '!=', '' ],
				],

				'customStyleSeparator' => [
					'label' => esc_html__( 'Custom Style', 'max-addons' ),
					'type'  => 'separator',
				],

				'customHotspotColor' => [
					'type'   => 'color',
					'label'  => esc_html__( 'Color', 'max-addons' ),
					'css'    => [
						[
							'property' => 'color',
							'selector' => '.mab-hotspot-content',
						]
					],
					'inline' => true,
					'small'  => true,
				],

				'customHotspotBgColor' => [
					'type'   => 'color',
					'label'  => esc_html__( 'Background Color', 'max-addons' ),
					'css'    => [
						[
							'property' => 'background-color',
							'selector' => '.mab-hotspot-content',
						]
					],
					'inline' => true,
					'small'  => true,
				],
			],
			'default' => [
				[
					'title'          => esc_html__( 'Hotspot #1', 'max-addons' ),
					'hotspotType'    => 'icon',
					'hotspotIcon'    => [
						'library' => 'themify',
						'icon'    => 'ti-wordpress',
					],
					'tooltipContent' => 'This is tooltip content',
				],
			],
		];

		$this->controls['hotspotAnimation'] = [
			'label'       => esc_html__( 'Animation', 'max-addons' ),
			'tab'         => 'content',
			'group'       => 'hotspots',
			'placeholder' => esc_html__( 'None', 'max-addons' ),
			'type'        => 'select',
			'options'     => array(
				'heartbeat' => esc_html__( 'Heart Beat', 'max-addons' ),
				'expand'    => esc_html__( 'Expand', 'max-addons' ),
			),
			'inline'      => true,
			'default'     => 'expand',
		];
	}

	// Set Hotspots Styles
	public function set_hotspot_styles() {

		$this->controls['hotspotSize'] = [
			'tab'   => 'style',
			'group' => 'hotspotStyle',
			'label' => esc_html__( 'Size', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'min-width',
					'selector' => '.mab-hotspot-content',
				],
				[
					'property' => 'width',
					'selector' => '.mab-hotspot-has-icon .mab-hotspot-content',
				],
				[
					'property' => 'min-height',
					'selector' => '.mab-hotspot-content',
				],
				[
					'property' => 'height',
					'selector' => '.mab-hotspot-has-icon .mab-hotspot-content',
				],
				[
					'property' => 'font-size',
					'selector' => '.mab-hotspot-content',
				],
				[
					'property' => 'font-size',
					'selector' => '.mab-hotspot-icon',
				],
			],
		];

		$this->controls['hotspotTypography'] = [
			'tab'    => 'style',
			'group'  => 'hotspotStyle',
			'type'   => 'typography',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-hotspot-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['hotspotBackgroundColor'] = [
			'tab'    => 'style',
			'group'  => 'hotspotStyle',
			'type'   => 'color',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background',
					'selector' => '.mab-hotspot-content, .mab-hotspot-animation-expand:before',
				]
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['hotspotBorder'] = [
			'type'   => 'border',
			'group'  => 'hotspotStyle',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-hotspot-content',
				]
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['hotspotBoxShadow'] = [
			'type'   => 'box-shadow',
			'group'  => 'hotspotStyle',
			'label'  => esc_html__( 'Box shadow', 'max-addons' ),
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-hotspot-content',
				]
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['hotspotPadding'] = [
			'type'  => 'spacing',
			'group' => 'hotspotStyle',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-hotspot-content',
				],
			],
		];

		$this->controls['hotspotIconImageSeparator'] = [
			'tab'   => 'content',
			'group' => 'hotspotStyle',
			'type'  => 'separator',
			'label' => esc_html__( 'Image', 'max-addons' ),
		];

		$this->controls['hotspotImageSize'] = [
			'tab'   => 'style',
			'group' => 'hotspotStyle',
			'label' => esc_html__( 'Size', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => '.mab-hotspot-icon-image img',
				],
				[
					'property' => 'height',
					'selector' => '.mab-hotspot-icon-image img',
				],
			],
		];

		$this->controls['hotspotImageBorder'] = [
			'type'   => 'border',
			'group'  => 'hotspotStyle',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-hotspot-icon-image img',
				]
			],
			'inline' => true,
			'small'  => true,
		];
	}

	// Set Tooltip
	public function set_tooltip_styles() {

		$this->controls['tooltipTrigger'] = [
			'tab'         => 'content',
			'group'       => 'tooltipStyle',
			'label'       => esc_html__( 'Trigger', 'max-addons' ),
			'placeholder' => esc_html__( 'Hover', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'hover' => esc_html__( 'Hover', 'max-addons' ),
				'click' => esc_html__( 'Click', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => false,
			'pasteStyles' => false,
			'required'    => [ 'tooltip_always_open', '=', '' ],
		];

		$this->controls['tooltipPosition'] = [
			'tab'     => 'content',
			'group'   => 'tooltipStyle',
			'label'   => esc_html__( 'Tooltip Position', 'max-addons' ),
			'placeholder' => esc_html__( 'Top', 'max-addons' ),
			'type'    => 'select',
			'options' => [
				'topleft'		=> __( 'Top Left', 'max-addons' ),
				'top'    		=> __( 'Top', 'max-addons' ),
				'topright'    	=> __( 'Top Right', 'max-addons' ),
				'bottomleft' 	=> __( 'Bottom Left', 'max-addons' ),
				'bottom' 		=> __( 'Bottom', 'max-addons' ),
				'bottomright' 	=> __( 'Bottom Right', 'max-addons' ),
				'lefttop'   	=> __( 'Left Top', 'max-addons' ),
				'left'   		=> __( 'Left', 'max-addons' ),
				'leftbottom'   	=> __( 'Left Bottom', 'max-addons' ),
				'righttop'  	=> __( 'Right Top', 'max-addons' ),
				'right'  		=> __( 'Right', 'max-addons' ),
				'rightbottom'  	=> __( 'Right Bottom', 'max-addons' ),
			],
			'inline'  => true,
			'reset'   => true,
		];

		$this->controls['tooltipArrow'] = [
			'tab'   => 'content',
			'group' => 'tooltipStyle',
			'label' => esc_html__( 'Show Arrow', 'max-addons' ),
			'type'  => 'checkbox',
			'default' => true,
		];

		$this->controls['tooltipMaxWidth'] = [
			'tab'     => 'style',
			'group'   => 'tooltipStyle',
			'label'   => esc_html__( 'Max Width', 'max-addons' ),
			'type'    => 'number',
			'min'  	  => 1,
			'step' 	  => 1,
			'default' => 200,
			'inline'  => true,
		];

		$this->controls['tooltipDistance'] = [
			'tab'         => 'style',
			'group'       => 'tooltipStyle',
			'label'       => esc_html__( 'Distance', 'max-addons' ),
			'description' => esc_html__( 'Distance between hotspot and tooltip', 'max-addons' ),
			'type'        => 'number',
			'min'  	      => 1,
			'step' 	      => 1,
			'inline'      => true,
		];

		$this->controls['tooltipBackgroundColor'] = [
			'tab'    => 'style',
			'group'  => 'tooltipStyle',
			'type'   => 'color',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.tippy-box',
					'important' => true
				],
				[
					'property' => 'color',
					'selector' => '.tippy-arrow',
					'important' => true
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tooltipTypography'] = [
			'tab'    => 'style',
			'group'  => 'tooltipStyle',
			'type'   => 'typography',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.tippy-box',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tooltipBorder'] = [
			'type'   => 'border',
			'group'  => 'tooltipStyle',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.tippy-box',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tooltipBoxShadow'] = [
			'type'   => 'box-shadow',
			'group'  => 'tooltipStyle',
			'label'  => esc_html__( 'Box shadow', 'max-addons' ),
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.tippy-box',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['tooltipPadding'] = [
			'type'  => 'spacing',
			'group' => 'tooltipStyle',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.tippy-content',
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
	public function render_image() {
		$settings   = $this->settings;
		$image      = $this->get_normalized_image_settings( $settings );
		$image_id   = isset( $image['id'] ) ? $image['id'] : '';
		$image_url  = isset( $image['url'] ) ? $image['url'] : '';
		$image_size = isset( $image['size'] ) ? $image['size'] : '';

		$image_classes = [
			'css-filter',
			'attachment-' . sanitize_html_class( $image_size ),
			'size-' . sanitize_html_class( $image_size ),
		];

		$image_attributes = [
			'class' => implode( ' ', $image_classes ),
		];

		if ( $image_id ) {
			echo wp_get_attachment_image( $image_id, $image_size, false, $image_attributes );
		} elseif ( ! empty( $image_url ) ) {
			printf(
				'<img src="%1$s" class="%2$s" alt="" />',
				esc_url( $image_url ),
				esc_attr( implode( ' ', $image_classes ) )
			);
		}
	}

	/**
	 * Render custom content output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access public
	 */
	public function render_repeater_item( $hotspot ) {
		$settings            = $this->settings;
		$index               = $this->loop_index;
		$hotspot_tag         = 'span';
		$tooltip_position    = 'top';
		$is_icon_only        = ! isset( $hotspot['hotspotText'] ) && isset( $hotspot['hotspotIcon'] ) && $hotspot['hotspotIcon']['icon'];
		$hotspot_wrap_key    = 'hotspot-wrap-' . $index;
		$hotspot_key         = 'hotspot-' . $index;
		$hotspot_content_key = 'hotspot-inner-' . $index;
		$icon_key            = 'icon-' . $index;
		$output              = '';

		$this->set_attribute( $hotspot_wrap_key, 'class', 'mab-hotspot-wrap repeater-item' );

		$horizontal_position = ! empty( $hotspot['horizontalPosition'] ) ? $this->render_dynamic_data( $hotspot['horizontalPosition'] ) : '30';
		$vertical_position   = ! empty( $hotspot['verticalPosition'] ) ? $this->render_dynamic_data( $hotspot['verticalPosition'] ) : '30';

		$horizontal_position = '' === $horizontal_position ? '30' : $horizontal_position;
		$vertical_position   = '' === $vertical_position ? '30' : $vertical_position;

		$this->set_attribute( $hotspot_key, 'class', 'mab-hotspot' . ( $is_icon_only ? ' mab-hotspot-has-icon' : '' ) );
		$this->set_attribute( $hotspot_key, 'style', [
			'left: ' . $horizontal_position . '%;',
			'top: ' . $vertical_position . '%;',
		] );

		$content_classes = [ 'mab-hotspot-content' ];

		if ( ! empty( $settings['hotspotAnimation'] ) ) {
			$content_classes[] = 'mab-hotspot-animation-' . sanitize_html_class( $settings['hotspotAnimation'] );
		}

		$this->set_attribute( $hotspot_content_key, 'class', $content_classes );

		// Hotsppot icon
		if ( isset( $hotspot['hotspotIcon']['icon'] ) ) {
			$this->set_attribute( $icon_key, 'class', [
				'icon',
				$hotspot['hotspotIcon']['icon'], // Dont' sanitize_html_class (Font Awesome uses two class names, so we need spaces)
			] );
		}

		if ( ! empty( $hotspot['hotspotLink'] ) ) {
			$tooltip_trigger = isset( $settings['tooltipTrigger'] ) ? $settings['tooltipTrigger'] : 'hover';

			if ( ! isset( $hotspot['showTooltip'] ) || ( isset( $hotspot['showTooltip'] ) && 'hover' === $tooltip_trigger ) ) {
				$hotspot_tag = 'a';

				$this->set_link_attributes( $hotspot_key, $hotspot['hotspotLink'] );
			}
		}

		if ( isset( $hotspot['showTooltip'] ) && isset( $hotspot['tooltipContent'] ) ) {
			$this->set_attribute( $hotspot_wrap_key, 'class', 'mab-hotspot-tooptip' );
		}

		$output .= '<div ' . $this->render_attributes( $hotspot_wrap_key ) . '>';
		$output .= '<' . esc_html( $hotspot_tag ) . ' ' . $this->render_attributes( $hotspot_key ) . '>';
		$output .= '<span ' . $this->render_attributes( $hotspot_content_key ) . '>';

		if ( isset( $hotspot['hotspotType'] ) ) {
			switch ( $hotspot['hotspotType'] ) {
				case 'icon':
					if ( ! empty( $hotspot['hotspotIcon']['icon'] ) ) {
						$output .= '<span class="mab-hotspot-icon mab-icon">';
						$output .= '<i ' . $this->render_attributes( $icon_key ) . '></i>';
						$output .= '</span>';
					}
					break;

				case 'text':
					if ( ! empty( $hotspot['hotspotText'] ) ) {
						$output .= sprintf(
							'<span class="mab-hotspot-icon mab-hotspot-text">%s</span>',
							esc_html( $hotspot['hotspotText'] )
						);
					}
					break;

				case 'image':
					$url = '';

					if ( ! empty( $hotspot['hotspotImage']['useDynamicData']['name'] ) ) {
						$images = $this->render_dynamic_data_tag( $hotspot['hotspotImage']['useDynamicData']['name'], 'image' );
						$size   = $hotspot['hotspotImage']['size'] ?? BRICKS_DEFAULT_IMAGE_SIZE;
						$url    = $images ? wp_get_attachment_image_url( $images[0], $size ) : ( $hotspot['hotspotImage']['url'] ?? '' );
					} elseif ( ! empty( $hotspot['hotspotImage']['url'] ) ) {
						$url = $hotspot['hotspotImage']['url'];
					}

					if ( ! empty( $url ) ) {
						$output .= sprintf(
							'<span class="mab-hotspot-icon mab-hotspot-icon-image"><img src="%s" alt="" /></span>',
							esc_url( $url )
						);
					}
					break;
			}
		}

		$output .= '</span>'; // Close hotspot content
		$output .= '</' . esc_html( $hotspot_tag ) . '>';

		if ( isset( $hotspot['showTooltip'] ) && isset( $hotspot['tooltipContent'] ) ) {
			$output .= '<div class="mab-tooltip">';
				$output .= '<div class="mab-tooltip-content">';
					$output .= wp_kses_post( $hotspot['tooltipContent'] );
				$output .= '</div>';
			$output .= '</div>';
		}

		$output .= '</div>';

		$this->loop_index++;

		return $output;
	}

	// Render element HTML
	public function render() {
		$settings   = $this->settings;
		$image      = $this->get_normalized_image_settings( $settings );
		$image_id   = isset( $image['id'] ) ? $image['id'] : '';
		$image_url  = isset( $image['url'] ) ? $image['url'] : '';

		// STEP: Dynamic data image not found: Show placeholder text
		if ( ! empty( $settings['image']['useDynamicData'] ) && ! $image ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'Dynamic data is empty.', 'max-addons' )
				]
			);
		}

		// Check: No image selected: No image ID provided && not a placeholder URL
		if ( ! isset( $image['external'] ) && ! $image_id && ! $image_url) {
			return $this->render_element_placeholder( [ 'title' => esc_html__( 'No image selected.', 'max-addons' ) ] );
		}

		// Check: Image with ID doesn't exist
		if ( ! isset( $image['external'] ) && ! $image_url ) {
			// translators: %s: Image ID
			return $this->render_element_placeholder(
				[
					'title' => sprintf(
						// Translators: %s: Image ID.
						esc_html__( 'Image ID (%s) no longer exist. Please select another image.', 'max-addons' ),
						$image_id
					)
				]
			);
		}

		$this->set_attribute( '_root', 'class', 'mab-image-hotspots' );

		$tooltip_position = isset( $settings['tooltipPosition'] ) ? $settings['tooltipPosition'] : 'top';
		$tooltip_position = str_replace(
			[
				'topright', 'topleft', 'bottomright', 'bottomleft',
				'lefttop', 'leftbottom', 'righttop', 'rightbottom',
			],
			[
				'top-start', 'top-end', 'bottom-start', 'bottom-end',
				'left-end', 'left-start', 'right-end', 'right-start',
			],
			$tooltip_position
		);

		$tooltip_trigger = isset( $settings['tooltipTrigger'] ) ? $settings['tooltipTrigger'] : 'hover';

		$tooltip_settings = array(
			'position' => $tooltip_position,
			'trigger'  => ( 'click' === $tooltip_trigger ) ? 'click' : 'mouseenter',
			'arrow'    => isset( $settings['tooltipArrow'] ) ? true : false,
			'width'    => isset( $settings['tooltipMaxWidth'] ) ? $settings['tooltipMaxWidth'] : '',
			'distance' => isset( $settings['tooltipDistance'] ) ? $settings['tooltipDistance'] : 10,
		);

		$this->set_attribute( '_root', 'data-tooltip-options', wp_json_encode( $tooltip_settings ) );
		?>
		<div <?php echo $this->render_attributes( '_root' ); ?>>
			<?php
			$hotspots = ! empty( $settings['hotspots'] ) ? $settings['hotspots'] : false;
			$output   = '';

			foreach ( $hotspots as $index => $item ) {
				$output .= self::render_repeater_item( $item );
			}

			echo $output;
			?>

			<?php $this->render_image(); ?>
		</div>
		<?php
	}
}
