<?php
namespace MaxAddons\Elements;

use MaxAddons\Base\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Random_Image_Element extends Element_Base {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-random-image'; // Make sure to prefix your elements
	public $icon         = 'ti-image max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	public function get_label() {
		return esc_html__( 'Random Image', 'max-addons-for-bricks' );
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
			'label'       => esc_html__( 'HTML tag', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => [
				'figure'  => 'figure',
				'picture' => 'picture',
				'div'     => 'div',
				'custom'  => esc_html__( 'Custom', 'max-addons-for-bricks' ),
			],
			'lowercase'   => true,
			'inline'      => true,
			'placeholder' => '-',
		];

		$this->controls['customTag'] = [
			'label'       => esc_html__( 'Custom tag', 'max-addons-for-bricks' ),
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
				'label'       => esc_html__( 'Aspect ratio', 'max-addons-for-bricks' ),
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
			'label'   => esc_html__( 'Object fit', 'max-addons-for-bricks' ),
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
			'label'  => esc_html__( 'Object position', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Custom alt text', 'max-addons-for-bricks' ),
			'type'     => 'text',
			'inline'   => true,
			'rerender' => false,
		];

		// Caption
		$caption_options = [
			'none'       => esc_html__( 'No caption', 'max-addons-for-bricks' ),
			'attachment' => esc_html__( 'Attachment', 'max-addons-for-bricks' ),
			'custom'     => esc_html__( 'Custom', 'max-addons-for-bricks' ),
		];

		// Get caption placeholder from theme option value
		$show_caption = ! empty( $this->theme_styles['caption'] ) ? $this->theme_styles['caption'] : 'attachment';

		$this->controls['caption'] = [
			'label'       => esc_html__( 'Caption Type', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => $caption_options,
			'inline'      => true,
			'placeholder' => ! empty( $caption_options[ $show_caption ] ) ? $caption_options[ $show_caption ] : esc_html__( 'Attachment', 'max-addons-for-bricks' ),
		];

		$this->controls['captionCustom'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Custom caption', 'max-addons-for-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Here goes your caption ...', 'max-addons-for-bricks' ),
			'required'    => [ 'caption', '=', 'custom' ],
		];

		$this->controls['loading'] = [
			'label'       => esc_html__( 'Loading', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'eager' => 'eager',
				'lazy'  => 'lazy',
			],
			'placeholder' => 'lazy',
		];

		$this->controls['showTitle'] = [
			'label'    => esc_html__( 'Show title', 'max-addons-for-bricks' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'required' => [ 'randomImages', '!=', '' ],
		];

		$this->controls['stretch'] = [
			'label' => esc_html__( 'Stretch', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Image Overlay', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Link To', 'max-addons-for-bricks' ),
		];

		$this->controls['link'] = [
			'type'        => 'select',
			'options'     => [
				'lightbox'   => esc_html__( 'Lightbox', 'max-addons-for-bricks' ),
				'attachment' => esc_html__( 'Attachment Page', 'max-addons-for-bricks' ),
				'media'      => esc_html__( 'Media File', 'max-addons-for-bricks' ),
				'url'        => esc_html__( 'Other (URL)', 'max-addons-for-bricks' ),
			],
			'rerender'    => true,
			'placeholder' => esc_html__( 'None', 'max-addons-for-bricks' ),
		];

		$this->controls['lightboxImageSize'] = [
			'label'       => esc_html__( 'Lightbox', 'max-addons-for-bricks' ) . ': ' . esc_html__( 'Image size', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => $this->control_options['imageSizes'],
			'placeholder' => esc_html__( 'Full', 'max-addons-for-bricks' ),
			'required'    => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxAnimationType'] = [
			'label'       => esc_html__( 'Lightbox', 'max-addons-for-bricks' ) . ': ' . esc_html__( 'Animation', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => $this->control_options['lightboxAnimationTypes'],
			'placeholder' => esc_html__( 'Zoom', 'max-addons-for-bricks' ),
			'required'    => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxCaption'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Lightbox', 'max-addons-for-bricks' ) . ': ' . esc_html__( 'Caption', 'max-addons-for-bricks' ),
			'type'     => 'checkbox',
			'required' => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxPadding'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Lightbox', 'max-addons-for-bricks' ) . ': ' . esc_html__( 'Padding', 'max-addons-for-bricks' ) . ' (px)',
			'type'     => 'dimensions',
			'required' => [ 'link', '=', 'lightbox' ],
		];

		$this->controls['lightboxId'] = [
			'label'       => esc_html__( 'Lightbox', 'max-addons-for-bricks' ) . ': ID',
			'type'        => 'text',
			'inline'      => true,
			'required'    => [ 'link', '=', 'lightbox' ],
			'description' => esc_html__( 'Images of the same lightbox ID are grouped together.', 'max-addons-for-bricks' ),
		];

		$this->controls['newTab'] = [
			'label'    => esc_html__( 'Open in new tab', 'max-addons-for-bricks' ),
			'type'     => 'checkbox',
			'required' => [ 'link', '=', [ 'attachment', 'media' ] ],
		];

		$this->controls['url'] = [
			'type'     => 'link',
			'required' => [ 'link', '=', 'url' ],
		];

		// Icon
		$this->controls['popupSep'] = [
			'label'  => esc_html__( 'Icon', 'max-addons-for-bricks' ),
			'type'   => 'separator',
			'inline' => true,
			'small'  => true,
		];

		// To hide icon for specific elements when image icon set in theme styles
		$this->controls['popupIconDisable'] = [
			'label' => esc_html__( 'Disable icon', 'max-addons-for-bricks' ),
			'info'  => esc_html__( 'Settings', 'max-addons-for-bricks' ) . ' > ' . esc_html__( 'Theme styles', 'max-addons-for-bricks' ) . ' > ' . esc_html__( 'Image', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
		];

		$this->controls['popupIcon'] = [
			'label'    => esc_html__( 'Icon', 'max-addons-for-bricks' ),
			'type'     => 'icon',
			'inline'   => true,
			'small'    => true,
			'rerender' => true,
		];

		// NOTE: Set popup CSS control outside of control 'link' (CSS is not applied to nested controls)
		$this->controls['popupIconBackgroundColor'] = [
			'label'    => esc_html__( 'Icon background color', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Icon border', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Icon box shadow', 'max-addons-for-bricks' ),
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
			'label'       => esc_html__( 'Icon typography', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Icon height', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Icon width', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Icon transition', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Mask', 'max-addons-for-bricks' ),
		];

		$this->controls['mask'] = [
			'label'       => esc_html__( 'Mask', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'custom'                          => esc_html__( 'Custom', 'max-addons-for-bricks' ),
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
			'placeholder' => esc_html__( 'Select', 'max-addons-for-bricks' ),
		];

		$this->controls['maskCustom'] = [
			'type'     => 'image',
			'unsplash' => false,
			'required' => [ 'mask', '=', 'custom' ],
		];

		$this->controls['maskSize'] = [
			'label'       => esc_html__( 'Size', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'inline'      => true,
			'large'       => true,
			'options'     => [
				'auto'    => esc_html__( 'Auto', 'max-addons-for-bricks' ),
				'cover'   => esc_html__( 'Cover', 'max-addons-for-bricks' ),
				'contain' => esc_html__( 'Contain', 'max-addons-for-bricks' ),
				'custom'  => esc_html__( 'Custom', 'max-addons-for-bricks' ),
			],
			'placeholder' => esc_html__( 'Contain', 'max-addons-for-bricks' ),
			'required'    => [ 'mask', '!=', '' ],
		];

		$this->controls['maskSizeCustom'] = [
			'label'    => esc_html__( 'Custom size', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'units'    => true,
			'large'    => true,
			'required' => [ 'maskSize', '=', 'custom' ],
		];

		$this->controls['maskPosition'] = [
			'label'       => esc_html__( 'Position', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'center center' => esc_html__( 'Center center', 'max-addons-for-bricks' ),
				'center left'   => esc_html__( 'Center left', 'max-addons-for-bricks' ),
				'center right'  => esc_html__( 'Center right', 'max-addons-for-bricks' ),
				'top center'    => esc_html__( 'Top center', 'max-addons-for-bricks' ),
				'top left'      => esc_html__( 'Top left', 'max-addons-for-bricks' ),
				'top right'     => esc_html__( 'Top right', 'max-addons-for-bricks' ),
				'bottom center' => esc_html__( 'Bottom center', 'max-addons-for-bricks' ),
				'bottom left'   => esc_html__( 'Bottom left', 'max-addons-for-bricks' ),
				'bottom right'  => esc_html__( 'Bottom right', 'max-addons-for-bricks' ),
			],
			'placeholder' => esc_html__( 'Center center', 'max-addons-for-bricks' ),
			'required'    => [ 'mask', '!=', '' ],
		];

		$this->controls['maskRepeat'] = [
			'label'       => esc_html__( 'Repeat', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'no-repeat' => esc_html__( 'No repeat', 'max-addons-for-bricks' ),
				'repeat'    => esc_html__( 'Repeat', 'max-addons-for-bricks' ),
				'repeat-x'  => esc_html__( 'Repeat-x', 'max-addons-for-bricks' ),
				'repeat-y'  => esc_html__( 'Repeat-y', 'max-addons-for-bricks' ),
				'round'     => esc_html__( 'Round', 'max-addons-for-bricks' ),
				'space'     => esc_html__( 'Space', 'max-addons-for-bricks' ),
			],
			'placeholder' => esc_html__( 'No repeat', 'max-addons-for-bricks' ),
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

	/**
	 * Get random image ID from settings.
	 *
	 * @param array $settings Element settings.
	 * @return int Image ID or 0.
	 */
	protected function get_random_image_id( $settings ) {

		if ( empty( $settings['randomImages']['images'] ) || ! is_array( $settings['randomImages']['images'] ) ) {
			return 0;
		}

		$images = $settings['randomImages']['images'];
		$count  = count( $images );

		if ( 0 === $count ) {
			return 0;
		}

		$index = ( $count > 1 ) ? wp_rand( 0, $count - 1 ) : 0;

		return ! empty( $images[ $index ]['id'] ) ? absint( $images[ $index ]['id'] ) : 0;
	}

	/**
	 * Prepare image attributes for wp_get_attachment_image().
	 *
	 * @param int    $image_id  Image ID.
	 * @param array  $settings  Element settings.
	 * @param string $image_size Image size.
	 * @return array
	 */
	protected function prepare_image_attributes( $image_id, $settings, $image_size ) {

		$this->set_attribute( 'img', 'class', 'css-filter' );
		$this->set_attribute( 'img', 'class', 'size-' . sanitize_html_class( $image_size ) );

		// Image Alt.
		if ( ! empty( $settings['altText'] ) ) {
			$this->set_attribute( 'img', 'alt', esc_attr( $settings['altText'] ) );
		}

		// Loading.
		if ( ! empty( $settings['loading'] ) ) {
			$this->set_attribute( 'img', 'loading', esc_attr( $settings['loading'] ) );
		}

		// Title.
		if ( ! empty( $settings['showTitle'] ) ) {
			$title = get_the_title( $image_id );
			if ( $title ) {
				$this->set_attribute( 'img', 'title', esc_attr( $title ) );
			}
		}

		// Mask.
		$mask_url = $this->get_mask_url( $settings );
		if ( $mask_url ) {
			$this->set_mask_attributes( esc_url_raw( $mask_url ), $settings );
		}

		$image_attributes = $this->attributes['img'] ?? [];

		// Flatten attribute values
		foreach ( $image_attributes as $key => $value ) {
			if ( is_array( $value ) ) {
				$image_attributes[ $key ] = implode( ' ', array_map( 'esc_attr', $value ) );
			}
		}

		// Merge custom attributes (flattened too)
		$custom_attributes = $this->get_custom_attributes( $settings );

		foreach ( $custom_attributes as $key => $value ) {
			if ( is_array( $value ) ) {
				$custom_attributes[ $key ] = implode( ' ', array_map( 'esc_attr', $value ) );
			}
		}

		return array_merge( $image_attributes, $custom_attributes );
	}

	/**
	 * Build link attributes.
	 *
	 * @param int   $image_id Image ID.
	 * @param array $settings Element settings.
	 * @return bool Whether link should be rendered.
	 */
	protected function build_link_attributes( $image_id, $settings ) {

		if ( empty( $settings['link'] ) ) {
			return false;
		}

		$link = $settings['link'];

		if ( ! empty( $settings['newTab'] ) ) {
			$this->set_attribute( 'link', 'target', '_blank' );
			$this->set_attribute( 'link', 'rel', 'noopener noreferrer' );
		}

		switch ( $link ) {

			case 'media':
				$this->set_attribute( 'link', 'href', esc_url( wp_get_attachment_url( $image_id ) ) );
				break;

			case 'attachment':
				$this->set_attribute( 'link', 'href', esc_url( get_permalink( $image_id ) ) );
				break;

			case 'url':
				if ( ! empty( $settings['url'] ) ) {
					$this->set_link_attributes( 'link', $settings['url'] );
				}
				break;

			case 'lightbox':
				$this->set_attribute( 'link', 'class', 'bricks-lightbox' );

				$size = ! empty( $settings['lightboxImageSize'] ) ? $settings['lightboxImageSize'] : 'full';

				$src = wp_get_attachment_image_src( $image_id, $size );

				if ( $src ) {
					$this->set_attribute( 'link', 'href', esc_url( $src[0] ) );
					$this->set_attribute( 'link', 'data-pswp-src', esc_url( $src[0] ) );
					$this->set_attribute( 'link', 'data-pswp-width', absint( $src[1] ) );
					$this->set_attribute( 'link', 'data-pswp-height', absint( $src[2] ) );
				}

				if ( ! empty( $settings['lightboxId'] ) ) {
					$this->set_attribute( 'link', 'data-pswp-id', esc_attr( $settings['lightboxId'] ) );
				}

				if ( ! empty( $settings['lightboxAnimationType'] ) ) {
					$this->set_attribute( 'link', 'data-animation-type', esc_attr( $settings['lightboxAnimationType'] ) );
				}

				if ( ! empty( $settings['lightboxPadding'] ) ) {
					$this->set_attribute( 'link', 'data-lightbox-padding', wp_json_encode( $settings['lightboxPadding'] ) );
				}

				if ( ! empty( $settings['lightboxCaption'] ) ) {
					$caption = wp_get_attachment_caption( $image_id );
					if ( $caption ) {
						$this->set_attribute( 'link', 'data-lightbox-caption', esc_attr( $caption ) );
						$this->set_attribute( 'link', 'class', 'has-lightbox-caption' );
					}
				}
				break;
		}

		return true;
	}

	/**
	 * Build wrapper opening tag.
	 *
	 * @param array  $settings Element settings.
	 * @param string $image_caption Image caption.
	 * @return bool Whether wrapper is used.
	 */
	protected function build_wrapper( $settings, $image_caption ) {

		$has_overlay  = ! empty( $settings['popupOverlay'] ) || $this->element_classes_have( 'popupOverlay' );
		$has_gradient = ! empty( $settings['_gradient'] ) || $this->element_classes_have( '_gradient' );

		$has_wrapper = $image_caption || $has_overlay || $has_gradient || ! empty( $settings['tag'] );

		if ( ! $has_wrapper ) {
			return false;
		}

		if ( $has_overlay ) {
			$this->set_attribute( '_root', 'class', 'overlay' );
		}

		if ( $image_caption ) {
			$this->set_attribute( '_root', 'class', 'caption' );
		}

		echo '<' . tag_escape( $this->tag ) . ' ';
		$this->print_render_attributes( '_root' );
		echo '>';

		return true;
	}

	public function render() {
		$settings   = $this->get_normalized_image_settings( $this->settings );
		$image_size = ! empty( $settings['randomImages']['size'] ) ? $settings['randomImages']['size'] : BRICKS_DEFAULT_IMAGE_SIZE;

		$image_id = $this->get_random_image_id( $settings );

		if ( ! $image_id ) {
			return;
		}

		$image_caption = wp_get_attachment_caption( $image_id );

		$has_wrapper = $this->build_wrapper( $settings, $image_caption );

		$has_link = $this->build_link_attributes( $image_id, $settings );

		if ( $has_link ) {
			echo '<a ';
			$this->print_render_attributes( 'link' );
			echo '>';
		}

		$image_attributes = $this->prepare_image_attributes( $image_id, $settings, $image_size );

		echo wp_get_attachment_image( $image_id, $image_size, false, $image_attributes );

		if ( $image_caption ) {
			echo '<figcaption class="bricks-image-caption">' . wp_kses_post( $image_caption ) . '</figcaption>';
		}

		if ( $has_link ) {
			echo '</a>';
		}

		if ( $has_wrapper ) {
			echo '</' . tag_escape( $this->tag ) . '>';
		}
	}
}
