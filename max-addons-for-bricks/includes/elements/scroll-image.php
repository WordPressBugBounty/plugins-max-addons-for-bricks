<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Scroll_Image_Element extends \Bricks\Element {
	public $category     = 'max-addons-elements';
	public $name         = 'max-scroll-image'; // Make sure to prefix your elements
	public $icon         = 'ti-image max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	public function get_label() {
		return esc_html__( 'Scroll Image', 'max-addons' );
	}

	public function get_keywords() {
		return [ 'scroll', 'images' ];
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-scroll-image' );
		wp_enqueue_script( 'mab-scroll-image' );
	}

	public function set_control_groups() {
		$this->control_groups['image']        = [
			'title' => esc_html__( 'Image', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['settings']     = [
			'title' => esc_html__( 'Settings', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['overlaySettings'] = [
			'title' => esc_html__( 'Overlay', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['iconSettings'] = [
			'title' => esc_html__( 'Icon', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {
		$this->add_image_controls();
		$this->add_settings_controls();
		$this->add_overlay_controls();
		$this->add_icon_controls();
	}

	public function add_image_controls() {
		$this->controls['image'] = [
			'tab'   => 'content',
			'group' => 'image',
			'type'  => 'image',
		];

		$this->controls['altText'] = [
			'tab'      => 'content',
			'group'    => 'image',
			'label'    => esc_html__( 'Custom alt text', 'max-addons' ),
			'type'     => 'text',
			'inline'   => true,
			'rerender' => false,
			'required' => [ 'image', '!=', '' ],
		];

		$this->controls['loading'] = [
			'tab'         => 'content',
			'group'       => 'image',
			'label'       => esc_html__( 'Loading', 'max-addons' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'eager' => 'eager',
				'lazy'  => 'lazy',
			],
			'placeholder' => 'lazy',
		];

		$this->controls['showTitle'] = [
			'tab'      => 'content',
			'group'    => 'image',
			'label'    => esc_html__( 'Show title', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'required' => [ 'image', '!=', '' ],
		];

		$this->controls['stretch'] = [
			'tab'   => 'content',
			'group' => 'image',
			'label' => esc_html__( 'Stretch', 'max-addons' ),
			'type'  => 'checkbox',
			'css'   => [
				[
					'property' => 'width',
					'selector' => '',
					'value'    => '100%',
				],
				[
					'property' => 'width',
					'selector' => '.max-scroll-image',
					'value'    => '100%',
				],
			],
		];

		$this->controls['linkToSeparator'] = [
			'tab'   => 'content',
			'group' => 'image',
			'type'  => 'separator',
			'label' => esc_html__( 'Link To', 'max-addons' ),
		];

		$this->controls['link'] = [
			'tab'         => 'content',
			'group'       => 'image',
			'type'        => 'select',
			'options'     => [
				'url'        => esc_html__( 'Other (URL)', 'max-addons' ),
			],
			'rerender'    => true,
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['newTab'] = [
			'tab'      => 'content',
			'group'    => 'image',
			'label'    => esc_html__( 'Open in new tab', 'max-addons' ),
			'type'     => 'checkbox',
			'required' => [ 'link', '=', [ 'attachment', 'media'] ],
		];

		$this->controls['url'] = [
			'tab'      => 'content',
			'group'    => 'image',
			'type'     => 'link',
			'required' => [ 'link', '=', 'url' ],
		];

		$this->controls['frameSeparator'] = [
			'tab'   => 'content',
			'group' => 'image',
			'type'  => 'separator',
			'label' => esc_html__( 'Frame', 'max-addons' ),
		];

		$this->controls['imageFrame'] = [
			'tab'         => 'content',
			'group'       => 'image',
			'label'       => esc_html__( 'Image frame', 'max-addons' ) . ' (' . esc_html__( 'Pro', 'max-addons' ) . ')',
			'type'        => 'select',
			'options'     => [
				'phone'     => esc_html__( 'Phone', 'max-addons' ),
				'tablet'    => esc_html__( 'Tablet', 'max-addons' ),
				'laptop'    => esc_html__( 'Laptop', 'max-addons' ),
				'desktop'   => esc_html__( 'Desktop', 'max-addons' ),
				'window'    => esc_html__( 'Window', 'max-addons' ),
			],
			'inline'      => true,
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['imageFrameInfo'] = [
			'tab'      => 'content',
			'group'    => 'image',
			'content'  => sprintf(
				__( 'Image Frame option is available in %1$sMax Addons Pro%2$s.', 'max-addons' ),
				'<a href="https://wpbricksaddons.com/"><strong>',
				'</strong></a>'
			),
			'type'     => 'info',
			'required' => [ 'imageFrame', '!=', '' ],
		];
	}

	public function add_settings_controls() {
		$this->controls['trigger'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Trigger', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'hover'    => esc_html__( 'Hover', 'max-addons' ),
				'click'    => esc_html__( 'Click', 'max-addons' ),
				'scroll'   => esc_html__( 'Scroll', 'max-addons' ),
				'viewport' => esc_html__( 'Viewport', 'max-addons' ),
			],
			'inline'      => true,
			'placeholder' => esc_html__( 'Hover', 'max-addons' ),
		];

		$this->controls['scrollDirection'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Scroll Direction', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'top'    => esc_html__( 'Top to Bottom', 'max-addons' ),
				'bottom' => esc_html__( 'Bottom to Top', 'max-addons' ),
				'left'   => esc_html__( 'Left to Right', 'max-addons' ),
				'right'  => esc_html__( 'Right to Left', 'max-addons' ),
			],
			'inline'      => true,
			'placeholder' => esc_html__( 'Top to Bottom', 'max-addons' ),
			'required'    => [ 'trigger', '!=', 'scroll' ],
		];

		$this->controls['scrollSpeed'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Scroll speed (s)', 'max-addons' ),
			'type'        => 'number',
			'css'         => [
				[
					'property' => 'transition-duration',
					'selector' => '.max-scroll-image-container .max-scroll-image',
				],
				[
					'property' => '-webkit-transition-duration',
					'selector' => '.max-scroll-image-container .max-scroll-image',
				],
			],
			'unit'        => 's',
			'placeholder' => '3s',
			'inline'      => true,
		];

		$this->controls['imageHeight'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Image height', 'max-addons' ),
			'type'        => 'number',
			'css'         => [
				[
					'property' => 'height',
					'selector' => '& > .max-scroll-image-container',
				],
			],
			'units'       => [ 'px', '%', 'vh' ],
			'placeholder' => '350px',
			'inline'      => false,
		];
	}

	public function add_overlay_controls() {
		$this->controls['overlay'] = [
			'tab'      => 'content',
			'group'    => 'overlaySettings',
			'label'    => esc_html__( 'Image overlay', 'max-addons' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '& .overlay:before',
				],
			],
			'rerender' => true,
		];

		$this->controls['overlayVisibility'] = [
			'tab'         => 'content',
			'group'       => 'overlaySettings',
			'label'       => esc_html__( 'Overlay visibility', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'always'        => esc_html__( 'Always Visible', 'max-addons' ),
				'show_on_hover' => esc_html__( 'Show on Hover', 'max-addons' ),
				'hide_on_hover' => esc_html__( 'Hide on Hover', 'max-addons' ),
			],
			'default'     => '',
			'inline'      => true,
			'placeholder' => esc_html__( 'Hide on Hover', 'max-addons' ),
		];
	}

	public function add_icon_controls() {
		$this->controls['overlayIcon'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Icon', 'max-addons' ),
			'type'     => 'icon',
			'rerender' => true,
		];

		$this->controls['iconSize'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'selector' => '.icon',
					'property' => 'font-size',
				],
			],
			'required' => [ 'overlayIcon.icon', '!=', '' ],
		];

		$this->controls['overlayIconWidth'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Width', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'selector' => '.icon',
					'property' => 'width',
				],
			],
			'required' => [ 'overlayIcon.icon', '!=', '' ],
		];

		$this->controls['overlayIconHeight'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Height', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'selector' => '.icon',
					'property' => 'line-height',
				],
			],
			'required' => [ 'overlayIcon.icon', '!=', '' ],
		];

		$this->controls['overlayIconColor'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Color', 'max-addons' ),
			'type'     => 'color',
			'css'      => [
				[
					'selector' => '.icon',
					'property' => 'color',
				],
				[
					'selector' => '.icon',
					'property' => 'fill',
				],
			],
			'required' => [ 'overlayIcon.icon', '!=', '' ],
		];

		$this->controls['overlayIconBackground'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Background color', 'max-addons' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.icon',
				],
			],
			'required' => [ 'overlayIcon', '!=', '' ],
		];

		$this->controls['overlayIconBorder'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Border', 'max-addons' ),
			'type'     => 'border',
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.icon',
				],
			],
			'required' => [ 'overlayIcon', '!=', '' ],
		];

		$this->controls['overlayIconBoxShadow'] = [
			'tab'      => 'content',
			'group'    => 'iconSettings',
			'label'    => esc_html__( 'Box shadow', 'max-addons' ),
			'type'     => 'box-shadow',
			'css'      => [
				[
					'property' => 'box-shadow',
					'selector' => '.icon',
				],
			],
			'required' => [ 'overlayIcon', '!=', '' ],
		];

		$this->controls['overlayIconVisibility'] = [
			'tab'         => 'content',
			'group'       => 'iconSettings',
			'label'       => esc_html__( 'Icon visibility', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'always'        => esc_html__( 'Always Visible', 'max-addons' ),
				'show_on_hover' => esc_html__( 'Show on Hover', 'max-addons' ),
				'hide_on_hover' => esc_html__( 'Hide on Hover', 'max-addons' ),
			],
			'default'     => '',
			'inline'      => true,
			'placeholder' => esc_html__( 'Hide on Hover', 'max-addons' ),
			'required'    => [ 'overlayIcon', '!=', '' ],
		];

		$this->controls['overlayIconTransition'] = [
			'tab'         => 'content',
			'group'       => 'iconSettings',
			'label'       => esc_html__( 'Transition duration (ms)', 'max-addons' ),
			'type'        => 'number',
			'css'         => [
				[
					'property' => 'transition-duration',
					'selector' => '.icon',
				]
			],
			'unit'        => 'ms',
			'placeholder' => '300',
			'inline'      => true,
			'required'    => [ 'overlayIcon', '!=', '' ],
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

		$image        = $settings['image'];
		$image['size'] = ! empty( $image['size'] ) ? esc_attr( $image['size'] ) : BRICKS_DEFAULT_IMAGE_SIZE;

		// Handle dynamic data.
		if ( ! empty( $image['useDynamicData'] ) ) {
			$image = $this->get_dynamic_image_data( $image );
			if ( empty( $image ) ) {
				return [
					'id'   => 0,
					'url'  => false,
					'size' => $image['size'],
				];
			}
		}

		// Ensure image ID is always set.
		$image['id'] = isset( $image['id'] ) ? intval( $image['id'] ) : 0;

		// Handle image URL.
		if ( ! isset( $image['url'] ) ) {
			$image['url'] = ( $image['id'] ) ? wp_get_attachment_image_url( $image['id'], $image['size'] ) : false;
		} else {
			$image['url'] = esc_url( $this->render_dynamic_data( $image['url'] ) );
		}

		return $image;
	}

	/**
	 * Get image data from dynamic sources.
	 *
	 * @param array $image Image data array.
	 * @return array|false Processed image data or false if not found.
	 */
	private function get_dynamic_image_data( $image ) {
		$images = $this->render_dynamic_data_tag( $image['useDynamicData'], 'image', [ 'size' => $image['size'] ] );

		if ( empty( $images[0] ) ) {
			return false;
		}

		if ( is_numeric( $images[0] ) ) {
			$image['id'] = intval( $images[0] );
		} else {
			$image['url'] = esc_url( $images[0] );
		}

		return $image;
	}

	/**
	 * Get image attributes.
	 *
	 * @return array
	 */
	private function get_image_attributes() {
		$image_attributes = [];

		if ( ! empty( $this->attributes['img'] ) ) {
			foreach ( $this->attributes['img'] as $key => $value ) {
				$image_attributes[ $key ] = is_array( $value ) ? join( ' ', array_map( 'esc_attr', $value ) ) : esc_attr( $value );
			}
		}

		return $image_attributes;
	}

	public function render_image() {
		$settings   = $this->settings;
		$image      = $this->get_normalized_image_settings( $settings );
		$image_id   = $image['id'] ?? '';
		$image_url  = $image['url'] ?? '';
		$image_size = $image['size'] ?? '';

		$this->set_attribute( 'img', 'class', [ 'css-filter', 'max-scroll-image' ] );

		if ( ! empty( $settings['altText'] ) ) {
			$this->set_attribute( 'img', 'alt', esc_attr( $settings['altText'] ) );
		}

		if ( ! empty( $settings['loading'] ) ) {
			$this->set_attribute( 'img', 'loading', esc_attr( $settings['loading'] ) );
		}

		// Show image 'title' attribute
		if ( isset( $settings['showTitle'] ) ) {
			$image_title = $image_id ? get_the_title( $image_id ) : false;

			if ( $image_title ) {
				$this->set_attribute( 'img', 'title', esc_attr( $image_title ) );
			}
		}

		$scroll_trigger     = ! empty( $settings['trigger'] ) ? $settings['trigger'] : 'hover';
		$icon_visibility    = ! empty( $settings['overlayIconVisibility'] ) ? $settings['overlayIconVisibility'] : 'hide_on_hover';
		$overlay_visibility = ! empty( $settings['overlayVisibility'] ) ? $settings['overlayVisibility'] : 'hide_on_hover';
		$output = '';

		if ( 'scroll' === $scroll_trigger ) {
			$scroll_direction = '';
		} else {
			$scroll_direction = ! empty( $settings['scrollDirection'] ) ? $settings['scrollDirection'] : 'top';
		}

		$trigger_options = array(
			'trigger'   => $scroll_trigger,
			'direction' => $scroll_direction,
		);

		$wrap_classes = ['max-scroll-image-wrap'];
		$container_classes = ['max-scroll-image-container'];
		$dynamic_classes = ['max-scroll-image-trigger-' . $scroll_trigger];

		if ( in_array( $scroll_direction, ['top', 'bottom'] ) ) {
			$dynamic_classes[] = 'max-image-scroll-vertical';
		}

		if ( in_array( $scroll_direction, ['left', 'right'] ) ) {
			$dynamic_classes[] = 'max-image-scroll-horizontal';
		}

		if ( ! empty( $settings['overlay'] ) ) {
			$dynamic_classes[] = 'overlay';
		}

		if ( 'hide_on_hover' === $overlay_visibility ) {
			$dynamic_classes[] = 'max-scroll-image-overlay-hide-hover';
		}

		if ( 'show_on_hover' === $overlay_visibility ) {
			$dynamic_classes[] = 'max-scroll-image-overlay-hover';
		}

		if ( 'hide_on_hover' === $icon_visibility ) {
			$dynamic_classes[] = 'max-scroll-image-icon-hide-hover';
		}

		if ( 'show_on_hover' === $icon_visibility ) {
			$dynamic_classes[] = 'max-scroll-image-icon-hover';
		}

		if ( 'scroll' === $scroll_trigger ) {
			$wrap_classes = array_merge( $wrap_classes, $dynamic_classes );
		} else {
			$container_classes = array_merge( $container_classes, $dynamic_classes );
		}

		$this->set_attribute( 'container', 'class', $container_classes );
		$this->set_attribute( 'container', 'data-settings', wp_json_encode( $trigger_options ) );

		if ( 'scroll' === $scroll_trigger ) {
			$this->set_attribute( 'wrap', 'class', $wrap_classes );
			$output .= sprintf( '<div %1$s>', $this->render_attributes( 'wrap' ) );
		}

		$output .= sprintf( '<div %1$s>', $this->render_attributes( 'container' ) );

		// Render icon if applicable.
		$icon = $settings['overlayIcon'] ?? $this->theme_styles['overlayIcon'] ?? false;

		if ( empty( $settings['overlayIconDisable'] ) && $icon ) {
			$output .= self::render_icon( $icon, [ 'icon' ] );
		}

		// Render the image.
		if ( $image_id ) {
			$image_attributes = $this->get_image_attributes();
			$output .= wp_get_attachment_image( $image_id, $image_size, false, $image_attributes );
		}

		$output .= '</div>';

		if ( 'scroll' === $scroll_trigger ) {
			$output .= '</div>';
		}

		return $output;
	}

	public function render() {
		$settings    = $this->settings;
		$link        = ! empty( $settings['link'] ) ? $settings['link'] : false;
		$image       = $this->get_normalized_image_settings( $settings );
		$image_id    = $image['id'] ?? '';
		$image_url   = $image['url'] ?? '';
		$image_size  = $image['size'] ?? '';

		// Handle empty dynamic data.
		if ( ! empty( $settings['image']['useDynamicData'] ) && empty( $image ) ) {
			return $this->render_element_placeholder(
				[ 'title' => esc_html__( 'Dynamic data is empty.', 'max-addons' ) ]
			);
		}

		$image_placeholder_url = \Bricks\Builder::get_template_placeholder_image();

		// Handle missing images.
		if ( ! isset( $image['external'] ) && ! $image_id && ! $image_url && $image_url !== $image_placeholder_url ) {
			return $this->render_element_placeholder(
				[ 'title' => esc_html__( 'No image selected.', 'max-addons' ) ]
			);
		}

		if ( ! isset( $image['external'] ) && empty( $image_url ) ) {
			return $this->render_element_placeholder(
				[ 'title' => sprintf( esc_html__( 'Image ID (%s) no longer exists. Please select another image.', 'max-addons' ), esc_html( $image_id ) ) ]
			);
		}

		$output = sprintf( '<%1$s %2$s>', esc_attr( $this->tag ), $this->render_attributes( '_root' ) );

		// Handle links.
		if ( $link ) {
			if ( ! empty( $settings['newTab'] ) ) {
				$this->set_attribute( 'link', 'target', '_blank' );
			}

			if ( 'url' === $link && ! empty( $settings['url'] ) ) {
				$this->set_link_attributes( 'link', $settings['url'] );
			}

			$this->set_attribute( 'link', 'class', 'max-tag' );
			$output .= sprintf( '<a %s>', $this->render_attributes( 'link' ) );
		}

		$output .= $this->render_image();

		if ( $link ) {
			$output .= '</a>';
		}

		$output .= sprintf( '</%s>', esc_attr( $this->tag ) );

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
