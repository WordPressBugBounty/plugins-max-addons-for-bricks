<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Random_Image_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-random-image'; // Make sure to prefix your elements
	public $icon         = 'ti-image max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	public function get_label() {
		return esc_html__( 'Random Image', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-random-image' );

		if ( isset( $this->settings['link'] ) && $this->settings['link'] === 'lightbox' ) {
			wp_enqueue_script( 'bricks-photoswipe' );
			wp_enqueue_style( 'bricks-photoswipe' );

			// Lightbox caption (@since 1.12.0)
			if ( isset( $this->settings['lightboxCaption'] ) ) {
				wp_enqueue_script( 'bricks-photoswipe-caption' );
			}
		}
	}

	public function set_controls() {

		$this->controls['_background']['css'][0]['selector'] = '';
		$this->controls['_gradient']['css'][0]['selector'] = '';

		// Image Gallery Control
		$this->controls['randomImages'] = [
			'tab'  => 'content',
			'type' => 'image-gallery',
		];

		$this->controls['tag'] = [
			'label'       => esc_html__( 'HTML tag', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'figure'  => 'figure',
				'picture' => 'picture',
				'div'     => 'div',
				'custom'  => esc_html__( 'Custom', 'max-addons' ),
			],
			'lowercase'   => true,
			'inline'      => true,
			'placeholder' => '-',
		];

		$this->controls['customTag'] = [
			'label'       => esc_html__( 'Custom tag', 'max-addons' ),
			'type'        => 'text',
			'inline'      => true,
			'dd'          => false,
			'placeholder' => 'div',
			'required'    => [ 'tag', '=', 'custom' ],
		];

		// Delete '_aspectRatio' control to add it here before the '_objectFit' (@since 1.9)
		if ( isset( $this->controls['_aspectRatio'] ) ) {
			unset( $this->controls['_aspectRatio'] );

			$this->controls['_aspectRatio'] = [
				'label'       => esc_html__( 'Aspect ratio', 'max-addons' ),
				'type'        => 'text',
				'inline'      => true,
				'dd'          => false,
				'placeholder' => '',
				'css'         => [
					[
						'property' => 'aspect-ratio',
						'selector' => '&:not(.tag)',
					],
					[
						'property' => 'aspect-ratio',
						'selector' => 'img',
					],
				],
			];
		}

		$this->controls['_objectFit'] = [
			'label'   => esc_html__( 'Object fit', 'max-addons' ),
			'type'    => 'select',
			'inline'  => true,
			'options' => $this->control_options['objectFit'],
			'css'     => [
				[
					'property' => 'object-fit',
					'selector' => '&:not(.tag)',
				],
				[
					'property' => 'object-fit',
					'selector' => 'img',
				],
			],
		];

		$this->controls['_objectPosition'] = [
			'label'  => esc_html__( 'Object position', 'max-addons' ),
			'type'   => 'text',
			'inline' => true,
			'dd'     => false,
			'css'    => [
				[
					'property' => 'object-position',
					'selector' => '&:not(.tag)',
				],
				[
					'property' => 'object-position',
					'selector' => 'img',
				],
			],
		];

		// Alt text
		$this->controls['altText'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Custom alt text', 'max-addons' ),
			'type'     => 'text',
			'inline'   => true,
			'rerender' => false,
		];

		// Caption
		$caption_options = [
			'none'       => esc_html__( 'No caption', 'max-addons' ),
			'attachment' => esc_html__( 'Attachment', 'max-addons' ),
			'custom'     => esc_html__( 'Custom', 'max-addons' ),
		];

		// Get caption placeholder from theme option value
		$show_caption = ! empty( $this->theme_styles['caption'] ) ? $this->theme_styles['caption'] : 'attachment';

		$this->controls['caption'] = [
			'label'       => esc_html__( 'Caption Type', 'max-addons' ),
			'type'        => 'select',
			'options'     => $caption_options,
			'inline'      => true,
			'placeholder' => ! empty( $caption_options[ $show_caption ] ) ? $caption_options[ $show_caption ] : esc_html__( 'Attachment', 'max-addons' ),
		];

		$this->controls['captionCustom'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Custom caption', 'max-addons' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Here goes your caption ...', 'max-addons' ),
			'required'    => [ 'caption', '=', 'custom' ],
		];

		$this->controls['loading'] = [
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
			'label'    => esc_html__( 'Show title', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'required' => [ 'randomImages', '!=', '' ],
		];

		$this->controls['stretch'] = [
			'label' => esc_html__( 'Stretch', 'max-addons' ),
			'type'  => 'checkbox',
			'css'   => [
				[
					'property' => 'width',
					'value'    => '100%',
				],
			],
		];

		$this->controls['popupOverlay'] = [
			// 'deprecated' => true, // Redundant: Use _gradient settings instead
			'label'    => esc_html__( 'Image Overlay', 'max-addons' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '&.overlay::before',
				],
			],
			'rerender' => true,
		];

		// Link To
		$this->controls['linkToSep'] = [
			'type'  => 'separator',
			'label' => esc_html__( 'Link To', 'max-addons' ),
		];

		$this->controls['link'] = [
			'type'        => 'select',
			'options'     => [
				'lightbox'   => esc_html__( 'Lightbox', 'max-addons' ),
				'attachment' => esc_html__( 'Attachment Page', 'max-addons' ),
				'media'      => esc_html__( 'Media File', 'max-addons' ),
				'url'        => esc_html__( 'Other (URL)', 'max-addons' ),
			],
			'rerender'    => true,
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['lightboxImageSize'] = [
			'label'       => esc_html__( 'Lightbox', 'max-addons' ) . ': ' . esc_html__( 'Image size', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['imageSizes'],
			'placeholder' => esc_html__( 'Full', 'max-addons' ),
			'required'    => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxAnimationType'] = [
			'label'       => esc_html__( 'Lightbox', 'max-addons' ) . ': ' . esc_html__( 'Animation', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['lightboxAnimationTypes'],
			'placeholder' => esc_html__( 'Zoom', 'max-addons' ),
			'required'    => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxCaption'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Lightbox', 'max-addons' ) . ': ' . esc_html__( 'Caption', 'max-addons' ),
			'type'     => 'checkbox',
			'required' => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxPadding'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Lightbox', 'max-addons' ) . ': ' . esc_html__( 'Padding', 'max-addons' ) . ' (px)',
			'type'     => 'dimensions',
			'required' => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxId'] = [
			'label'       => esc_html__( 'Lightbox', 'max-addons' ) . ': ID',
			'type'        => 'text',
			'inline'      => true,
			'required'    => [ 'link', '=', 'lightbox' ],
			'description' => esc_html__( 'Images of the same lightbox ID are grouped together.', 'max-addons' ),
		];

		$this->controls['newTab'] = [
			'label'    => esc_html__( 'Open in new tab', 'max-addons' ),
			'type'     => 'checkbox',
			'required' => [ 'link', '=', [ 'attachment', 'media' ] ],
		];

		$this->controls['url'] = [
			'type'     => 'link',
			'required' => [ 'link', '=', 'url' ],
		];

		// Icon
		$this->controls['popupSep'] = [
			'label'  => esc_html__( 'Icon', 'max-addons' ),
			'type'   => 'separator',
			'inline' => true,
			'small'  => true,
		];

		// To hide icon for specific elements when image icon set in theme styles
		$this->controls['popupIconDisable'] = [
			'label' => esc_html__( 'Disable icon', 'max-addons' ),
			'info'  => esc_html__( 'Settings', 'max-addons' ) . ' > ' . esc_html__( 'Theme styles', 'max-addons' ) . ' > ' . esc_html__( 'Image', 'max-addons' ),
			'type'  => 'checkbox',
		];

		$this->controls['popupIcon'] = [
			'label'    => esc_html__( 'Icon', 'max-addons' ),
			'type'     => 'icon',
			'inline'   => true,
			'small'    => true,
			'rerender' => true,
		];

		// NOTE: Set popup CSS control outside of control 'link' (CSS is not applied to nested controls)
		$this->controls['popupIconBackgroundColor'] = [
			'label'    => esc_html__( 'Icon background color', 'max-addons' ),
			'type'     => 'color',
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '&{pseudo} .icon',
				],
			],
			'required' => [ 'popupIcon', '!=', '' ],
		];

		$this->controls['popupIconBorder'] = [
			'label'    => esc_html__( 'Icon border', 'max-addons' ),
			'type'     => 'border',
			'css'      => [
				[
					'property' => 'border',
					'selector' => '&{pseudo} .icon',
				],
			],
			'required' => [ 'popupIcon', '!=', '' ],
		];

		$this->controls['popupIconBoxShadow'] = [
			'label'    => esc_html__( 'Icon box shadow', 'max-addons' ),
			'type'     => 'box-shadow',
			'css'      => [
				[
					'property' => 'box-shadow',
					'selector' => '&{pseudo} .icon',
				],
			],
			'required' => [ 'popupIcon', '!=', '' ],
		];

		$this->controls['popupIconTypography'] = [
			'label'       => esc_html__( 'Icon typography', 'max-addons' ),
			'type'        => 'typography',
			'css'         => [
				[
					'property' => 'font',
					'selector' => '&{pseudo} .icon',
				],
			],
			'exclude'     => [
				'font-family',
				'font-weight',
				'font-style',
				'text-align',
				'text-decoration',
				'text-transform',
				'line-height',
				'letter-spacing',
			],
			'placeholder' => [
				'font-size' => 60,
			],
			'required'    => [ 'popupIcon.icon', '!=', '' ],
		];

		$this->controls['popupIconHeight'] = [
			'label'    => esc_html__( 'Icon height', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'line-height',
					'selector' => '&{pseudo} .icon',
				],
			],
			'required' => [ 'popupIcon', '!=', '' ],
		];

		$this->controls['popupIconWidth'] = [
			'label'    => esc_html__( 'Icon width', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'width',
					'selector' => '&{pseudo} .icon',
				],
			],
			'required' => [ 'popupIcon', '!=', '' ],
		];

		$this->controls['popupIconTransition'] = [
			'label'    => esc_html__( 'Icon transition', 'max-addons' ),
			'type'     => 'text',
			'inline'   => true,
			'css'      => [
				[
					'property' => 'transition',
					'selector' => '&{pseudo} .icon',
				],
			],
			'required' => [ 'popupIcon', '!=', '' ],
		];

		// Image masking (@since 1.12.0)

		$this->controls['maskSep'] = [
			'type'  => 'separator',
			'label' => esc_html__( 'Mask', 'max-addons' ),
		];

		$this->controls['mask'] = [
			'label'       => esc_html__( 'Mask', 'max-addons' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'custom'                          => esc_html__( 'Custom', 'max-addons' ),
				'mask-boom'                       => 'Boom',
				'mask-box'                        => 'Box',
				'mask-bubbles'                    => 'Bubbles',
				'mask-cirlce-dots'                => 'Circle dots',
				'mask-circle-line'                => 'Circle line',
				'mask-circle-waves'               => 'Circle waves',
				'mask-circle'                     => 'Circle',
				'mask-drop-2'                     => 'Drop 2',
				'mask-drop'                       => 'Drop',
				'mask-fire'                       => 'Fire',
				'mask-grid-circles'               => 'Grid circles',
				'mask-grid-dots'                  => 'Grid dots',
				'mask-grid-filled-diagonal'       => 'Grid filled diagonal',
				'mask-grid-lines-diagonal'        => 'Grid lines diagonal',
				'mask-grid'                       => 'Grid',
				'mask-heart'                      => 'Heart',
				'mask-hexagon-dent'               => 'Hexagon dent',
				'mask-hexagon'                    => 'Hexagon',
				'mask-hourglass'                  => 'Hourglass',
				'mask-masonry'                    => 'Masonry',
				'mask-ninja-star'                 => 'Ninja star',
				'mask-octagon-dent'               => 'Octagon dent',
				'mask-play'                       => 'Play',
				'mask-plus'                       => 'Plus',
				'mask-round-zig-zag'              => 'Round zig zag',
				'mask-splash'                     => 'Splash',
				'mask-square-rounded'             => 'Square rounded',
				'mask-squares-3-by-3'             => 'Squares 3x3',
				'mask-squares-4-by-4'             => 'Squares 4x4',
				'mask-squares-4-diagonal-rounded' => 'Squares 4 diagonal rounded',
				'mask-squares-4-diagonal'         => 'Squares 4 diagonal',
				'mask-squares-diagonal'           => 'Squares diagonal',
				'mask-squares-merged'             => 'Squares merged',
				'mask-tiles-2'                    => 'Tiles 2',
				'mask-tiles'                      => 'Tiles',
				'mask-waves'                      => 'Waves',
			],
			'placeholder' => esc_html__( 'Select', 'max-addons' ),
		];

		$this->controls['maskCustom'] = [
			'type'     => 'image',
			'unsplash' => false,
			'required' => [ 'mask', '=', 'custom' ],
		];

		$this->controls['maskSize'] = [
			'label'       => esc_html__( 'Size', 'max-addons' ),
			'type'        => 'select',
			'inline'      => true,
			'large'       => true,
			'options'     => [
				'auto'    => esc_html__( 'Auto', 'max-addons' ),
				'cover'   => esc_html__( 'Cover', 'max-addons' ),
				'contain' => esc_html__( 'Contain', 'max-addons' ),
				'custom'  => esc_html__( 'Custom', 'max-addons' ),
			],
			'placeholder' => esc_html__( 'Contain', 'max-addons' ),
			'required'    => [ 'mask', '!=', '' ],
		];

		$this->controls['maskSizeCustom'] = [
			'label'    => esc_html__( 'Custom size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'large'    => true,
			'required' => [ 'maskSize', '=', 'custom' ],
		];

		$this->controls['maskPosition'] = [
			'label'       => esc_html__( 'Position', 'max-addons' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'center center' => esc_html__( 'Center center', 'max-addons' ),
				'center left'   => esc_html__( 'Center left', 'max-addons' ),
				'center right'  => esc_html__( 'Center right', 'max-addons' ),
				'top center'    => esc_html__( 'Top center', 'max-addons' ),
				'top left'      => esc_html__( 'Top left', 'max-addons' ),
				'top right'     => esc_html__( 'Top right', 'max-addons' ),
				'bottom center' => esc_html__( 'Bottom center', 'max-addons' ),
				'bottom left'   => esc_html__( 'Bottom left', 'max-addons' ),
				'bottom right'  => esc_html__( 'Bottom right', 'max-addons' ),
			],
			'placeholder' => esc_html__( 'Center center', 'max-addons' ),
			'required'    => [ 'mask', '!=', '' ],
		];

		$this->controls['maskRepeat'] = [
			'label'       => esc_html__( 'Repeat', 'max-addons' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'no-repeat' => esc_html__( 'No repeat', 'max-addons' ),
				'repeat'    => esc_html__( 'Repeat', 'max-addons' ),
				'repeat-x'  => esc_html__( 'Repeat-x', 'max-addons' ),
				'repeat-y'  => esc_html__( 'Repeat-y', 'max-addons' ),
				'round'     => esc_html__( 'Round', 'max-addons' ),
				'space'     => esc_html__( 'Space', 'max-addons' ),
			],
			'placeholder' => esc_html__( 'No repeat', 'max-addons' ),
			'required'    => [ 'mask', '!=', '' ],
		];
	}

	public function get_mask_url( $settings ) {
		$mask     = ! empty( $settings['mask'] ) ? $settings['mask'] : '';
		$mask_url = '';

		// Custom mask file (SVG, PNG)
		if ( $mask === 'custom' ) {
			// Custom mask image from media library
			if ( ! empty( $settings['maskCustom']['id'] ) ) {
				$image_src = wp_get_attachment_image_src( $settings['maskCustom']['id'], 'full' );
				$mask_url  = ! empty( $image_src[0] ) ? $image_src[0] : '';
			}

			// Dynamic data mask image
			elseif ( ! empty( $settings['maskCustom']['useDynamicData'] ) ) {
				$image_src = $this->render_dynamic_data_tag( $settings['maskCustom']['useDynamicData'], 'image' );

				// Extract URL from the image tag 'src' attribute
				preg_match( '/src="([^"]*)"/', $image_tag, $matches );
				$mask_url = ! empty( $matches[1] ) ? $matches[1] : '';
			}

			// Custom URL image mask
			elseif ( ! empty( $settings['maskCustom']['url'] ) ) {
				$mask_url = $settings['maskCustom']['url'];
			}
		}

		// Predefined mask file (SVG)
		else {
			$mask_url = BRICKS_URL_ASSETS . "svg/masks/{$mask}.svg";
		}

		return $mask_url;
	}

	protected function set_mask_attributes( $mask_url, $mask_settings ) {
		if ( empty( $mask_settings['mask'] ) ) {
			return;
		}

		// Mask size
		$mask_size = ! empty( $mask_settings['maskSize'] ) ? $mask_settings['maskSize'] : 'contain';

		// Custom mask size
		if ( $mask_size === 'custom' && ! empty( $mask_settings['maskSizeCustom'] ) ) {
			$mask_size = is_numeric( $mask_settings['maskSizeCustom'] ) ? $mask_settings['maskSizeCustom'] . 'px' : $mask_settings['maskSizeCustom'];
		}

		$mask_position = $mask_settings['maskPosition'] ?? 'center center';
		$mask_repeat   = $mask_settings['maskRepeat'] ?? 'no-repeat';

		// Mask inline style (webkit and standard)
		$mask_style  = "-webkit-mask-image: url('{$mask_url}'); -webkit-mask-size: {$mask_size}; -webkit-mask-position: {$mask_position}; -webkit-mask-repeat: {$mask_repeat};";
		$mask_style .= "mask-image: url('{$mask_url}'); mask-size: {$mask_size}; mask-position: {$mask_position}; mask-repeat: {$mask_repeat};";

		// Apply mask style to image
		$this->set_attribute( 'img', 'style', $mask_style );
	}

	public function get_normalized_image_settings( $settings ) {
		$items = isset( $settings['randomImages'] ) ? $settings['randomImages'] : [];

		$size = ! empty( $items['size'] ) ? $items['size'] : BRICKS_DEFAULT_IMAGE_SIZE;

		// Dynamic Data
		if ( ! empty( $items['useDynamicData'] ) ) {
			$items['images'] = [];

			$images = $this->render_dynamic_data_tag( $items['useDynamicData'], 'image' );

			if ( is_array( $images ) ) {
				foreach ( $images as $image_id ) {
					$items['images'][] = [
						'id'   => $image_id,
						'full' => wp_get_attachment_image_url( $image_id, 'full' ),
						'url'  => wp_get_attachment_image_url( $image_id, $size )
					];
				}
			}
		}

		// Either empty OR old data structure used before 1.0 (images were saved as one array directly on $items)
		if ( ! isset( $items['images'] ) ) {
			$images = ! empty( $items ) ? $items : [];

			unset( $items );

			$items['images'] = $images;
		}

		// Get 'size' from first image if not set (previous to 1.4-RC)
		$first_image_size = ! empty( $items['images'][0]['size'] ) ? $items['images'][0]['size'] : false;
		$size             = empty( $items['size'] ) && $first_image_size ? $first_image_size : $size;

		// Calculate new image URL if size is not the same as from the Media Library
		if ( $first_image_size && $first_image_size !== $size ) {
			foreach ( $items['images'] as $key => $image ) {
				$items['images'][ $key ]['size'] = $size;
				$items['images'][ $key ]['url']  = wp_get_attachment_image_url( $image['id'], $size );
			}
		}

		$settings['randomImages'] = $items;

		$settings['randomImages']['size'] = $size;

		return $settings;
	}

	// NOTE: Use WP function 'wp_get_attachment_image' to render image (built-in responsive image implementation)
	public function render() {
		$settings   = $this->settings;
		$link       = ! empty( $settings['link'] ) ? $settings['link'] : false;
		$settings   = $this->get_normalized_image_settings( $settings );
		$images     = ! empty( $settings['randomImages']['images'] ) ? $settings['randomImages']['images'] : false;
		$image_size = ! empty( $settings['randomImages']['size'] ) ? $settings['randomImages']['size'] : BRICKS_DEFAULT_IMAGE_SIZE;

		// Return placeholder
		if ( ! $images ) {
			if ( ! empty( $settings['randomImages']['useDynamicData'] ) ) {
				if ( BRICKS_DB_TEMPLATE_SLUG !== get_post_type( $this->post_id ) ) {
					return $this->render_element_placeholder(
						[
							'title' => esc_html__( 'Dynamic data is empty.', 'max-addons' )
						]
					);
				}
			} else {
				return $this->render_element_placeholder(
					[
						'title' => esc_html__( 'No image selected.', 'max-addons' ),
					]
				);
			}
		}

		if ( isset( $settings['randomImages'] ) ) {
			$count    = count( $settings['randomImages']['images'] );
			$index    = ( $count > 1 ) ? rand( 0, $count - 1 ) : 0;
			$image_id = $settings['randomImages']['images'][ $index ]['id'];
		}

		// Render
		/* $image_atts = [];
		$image_atts['id'] = 'image-' . $image_id;

		// Check for alternartive "Alt Text" setting
		if ( isset( $settings['altText'] ) ) {
			$image_atts['alt'] = esc_attr( $settings['altText'] );
		}

		$image_wrapper_classes = [ 'mab-random-image image-wrapper' ];

		$img_classes = [ 'post-thumbnail', 'css-filter' ];

		if ( isset( $settings['link'] ) ) {
			$image_wrapper_classes[] = 'image-overlay';
		}

		$img_classes[] = 'size-' . $size;
		$image_atts['class'] = join( ' ', $img_classes ); */

		// STEP: Image caption
		$show_caption = isset( $this->theme_styles['caption'] ) ? $this->theme_styles['caption'] : 'attachment';

		if ( isset( $settings['caption'] ) ) {
			$show_caption = $settings['caption'];
		}

		$image_caption = false;

		if ( $show_caption === 'none' ) {
			$image_caption = false;
		} elseif ( $show_caption === 'custom' && isset( $settings['captionCustom'] ) ) {
			$image_caption = trim( $settings['captionCustom'] );
		} else {
			$image_data = get_post( $image_id );
			$image_caption = $image_data ? $image_data->post_excerpt : '';
		}

		$has_overlay = isset( $settings['popupOverlay'] );

		$has_html_tag = $image_caption || $has_overlay || isset( $settings['_gradient'] ) || isset( $settings['tag'] );

		// Check: Element classes for 'popupOverlay' setting to add .overlay class to make ::before work
		if ( ! $has_overlay && $this->element_classes_have( 'popupOverlay' ) ) {
			$has_overlay = true;
		}

		// Default: 'figure' HTML tag (needed to apply overlay::before to as not possible on self-closing 'img' tag)
		if ( $has_overlay ) {
			$has_html_tag = true;
		}

		// Check: Element classes for 'gradient' setting to add HTML tag to Image element to make ::before work
		if ( ! $has_html_tag && $this->element_classes_have( '_gradient' ) ) {
			$has_html_tag = true;
		}

		$this->set_attribute( 'img', 'class', 'css-filter' );

		$this->set_attribute( 'img', 'class', "size-$image_size" );

		// Check for custom "Alt Text" setting
		if ( ! empty( $settings['altText'] ) ) {
			$this->set_attribute( 'img', 'alt', esc_attr( $settings['altText'] ) );
		}

		// Set 'loading' attribute: eager or lazy
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

		// Wrap image element in 'figure' to allow for image caption, overlay, icon
		if ( $has_overlay ) {
			$this->set_attribute( '_root', 'class', 'overlay' );
		}

		$output = '';

		// Add _root attributes to outermost tag
		if ( $has_html_tag ) {
			$this->set_attribute( '_root', 'class', 'tag' );

			// Has image caption (add position: relative through class)
			if ( $image_caption ) {
				$this->set_attribute( '_root', 'class', 'caption' );
			}

			$output .= "<{$this->tag} {$this->render_attributes( '_root' )}>";
		}

		/* if ( $image_caption ) {
			echo '<figure>';
		} */

		// $this->set_attribute( '_root', 'class', $image_wrapper_classes );

		// echo '<div ' . $this->render_attributes( '_root' ) . '>';

		// $close_a_tag = false;

		if ( $link ) {
			// Link is outermost tag: Merge _root attributes into link attributes it
			if ( ! $has_html_tag ) {
				foreach ( $this->attributes['_root'] as $key => $value ) {
					$this->attributes['link'][ $key ] = $value;
					unset( $this->attributes['_root'][ $key ] );
				}
			}

			$this->set_attribute( 'link', 'class', 'tag' );

			if ( isset( $settings['newTab'] ) ) {
				$this->set_attribute( 'link', 'target', '_blank' );
			}

			if ( $link === 'media' && $image_id ) {
				$this->set_attribute( 'link', 'href', wp_get_attachment_url( $image_id ) );
			} elseif ( $link === 'attachment' && $image_id ) {
				$this->set_attribute( 'link', 'href', get_permalink( $image_id ) );
			} elseif ( $link === 'url' && ! empty( $settings['url'] ) ) {
				$this->set_link_attributes( 'link', $settings['url'] );
			} elseif ( $link === 'lightbox' ) {
				$this->set_attribute( 'link', 'class', 'bricks-lightbox' );

				// Lightbox image size (@since 1.8.1)
				$lightbox_image_size = ! empty( $settings['lightboxImageSize'] ) ? $settings['lightboxImageSize'] : 'full';
				$lightbox_image_src  = $image_id ? wp_get_attachment_image_src( $image_id, $lightbox_image_size ) : [ $image_placeholder_url, 800, 600 ];

				$this->set_attribute( 'link', 'href', $lightbox_image_src[0] );
				$this->set_attribute( 'link', 'data-pswp-src', $lightbox_image_src[0] );
				$this->set_attribute( 'link', 'data-pswp-width', $lightbox_image_src[1] );
				$this->set_attribute( 'link', 'data-pswp-height', $lightbox_image_src[2] );

				if ( ! empty( $settings['lightboxId'] ) ) {
					$this->set_attribute( 'link', 'data-pswp-id', esc_attr( $settings['lightboxId'] ) );
				}

				if ( ! empty( $settings['lightboxAnimationType'] ) ) {
					$this->set_attribute( 'link', 'data-animation-type', esc_attr( $settings['lightboxAnimationType'] ) );
				}

				if ( ! empty( $settings['lightboxPadding'] ) ) {
					$this->set_attribute( 'link', 'data-lightbox-padding', wp_json_encode( $settings['lightboxPadding'] ) );
				}

				// Lightbox caption (@since 1.10)
				if ( isset( $settings['lightboxCaption'] ) ) {
					$this->set_attribute( 'link', 'class', 'has-lightbox-caption' );

					$lightbox_caption = $image_id ? wp_get_attachment_caption( $image_id ) : false;
					if ( $lightbox_caption ) {
						$this->set_attribute( 'link', 'data-lightbox-caption', esc_attr( $lightbox_caption ) );
					}
				}
			}

			$output .= "<a {$this->render_attributes( 'link' )}>";
		}

		// Show popup icon if link is set
		$icon = ! empty( $settings['popupIcon'] ) ? $settings['popupIcon'] : false;

		// Check: Theme style for video 'popupIcon' setting
		if ( ! $icon && ! empty( $this->theme_styles['popupIcon'] ) ) {
			$icon = $this->theme_styles['popupIcon'];
		}

		if ( ! isset( $settings['popupIconDisable'] ) && $link && $icon ) {
			$output .= self::render_icon( $icon, [ 'icon' ] );
		}

		// Determine the URL of the mask image
		$mask_url = $this->get_mask_url( $settings );

		// If a mask URL was found, apply the mask to the image
		if ( $mask_url ) {
			$this->set_mask_attributes( $mask_url, $settings );
		}

		// Lazy load atts set via 'wp_get_attachment_image_attributes' filter
		if ( $image_id ) {
			$image_attributes = [];

			// 'img' is root (no caption, no overlay)
			if ( ! $has_html_tag && ! $link ) {
				foreach ( $this->attributes['_root'] as $key => $value ) {
					$image_attributes[ $key ] = is_array( $value ) ? join( ' ', $value ) : $value;
				}
			}

			foreach ( $this->attributes['img'] as $key => $value ) {
				if ( isset( $image_attributes[ $key ] ) ) {
					$image_attributes[ $key ] .= ' ' . ( is_array( $value ) ? join( ' ', $value ) : $value );
				} else {
					$image_attributes[ $key ] = is_array( $value ) ? join( ' ', $value ) : $value;
				}
			}

			// Merge custom attributes with img attributes
			$custom_attributes = $this->get_custom_attributes( $settings );
			$image_attributes  = array_merge( $image_attributes, $custom_attributes );

			$output .= wp_get_attachment_image( $image_id, $image_size, false, $image_attributes );
		} elseif ( $image_url ) {
			if ( ! $has_html_tag && ! $link ) {
				foreach ( $this->attributes['_root'] as $key => $value ) {
					$this->attributes['img'][ $key ] = $value;
				}
			}

			$this->set_attribute( 'img', 'src', $image_url );

			// Set empty 'alt' attribute for a11y (@since 1.9.2)
			if ( ! isset( $this->attributes['img']['alt'] ) ) {
				$this->set_attribute( 'img', 'alt', '' );
			}

			$output .= "<img {$this->render_attributes( 'img', true )}>";
		}

		/* if ( $close_a_tag ) {
			echo '</a>';
		} */

		if ( $image_caption ) {
			$output .= '<figcaption class="bricks-image-caption">' . $image_caption . '</figcaption>';
		}

		if ( $link ) {
			$output .= '</a>';
		}

		if ( $has_html_tag ) {
			$output .= "</{$this->tag}>";
		}

		// echo '</div>';

		echo $output;
	}
}
