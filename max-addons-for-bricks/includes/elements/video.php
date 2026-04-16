<?php
namespace MaxAddons\Elements;

use MaxAddons\Base\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Video_Element extends Element_Base {
	// Element properties
	public $category            = 'max-addons-elements'; // Use predefined element category 'general'
	public $name                = 'max-video'; // Make sure to prefix your elements
	public $icon                = 'ti-video-clapper max-element'; // Themify icon font class
	public $css_selector        = ''; // Default CSS selector
	public $scripts             = [ 'mabVideo' ]; // Script(s) run when element is rendered on frontend or updated in builder
	private static $breakpoints = null;

	public function get_label() {
		return esc_html__( 'Video', 'max-addons-for-bricks' );
	}

	public function get_keywords() {
		return [ 'youtube', 'vimeo' ];
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-video' );
		wp_enqueue_script( 'mab-video' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['video'] = [
			'title' => esc_html__( 'Video', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['thumbnail'] = [
			'title' => esc_html__( 'Thumbnail', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['playIcon'] = [
			'title' => esc_html__( 'Overlay', 'max-addons-for-bricks' ) . ' / ' . esc_html__( 'Icon', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['stickyVideo'] = [
			'title' => esc_html__( 'Sticky Video', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['videoSchema'] = [
			'title' => esc_html__( 'Video Schema', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {

		$this->set_video_controls();
		$this->set_thumbnail_controls();
		$this->set_play_icon_controls();
		$this->set_sticky_video_controls();
		$this->set_video_schema_controls();
	}

	// Set items controls
	public function set_video_controls() {

		$this->controls['videoType'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => esc_html__( 'Source', 'max-addons-for-bricks' ),
			'type'      => 'select',
			'options'   => [
				'youtube' => 'YouTube',
				'vimeo'   => 'Vimeo',
				'media'   => esc_html__( 'Media', 'max-addons-for-bricks' ),
				'file'    => esc_html__( 'File URL', 'max-addons-for-bricks' ),
				'meta'    => esc_html__( 'Dynamic Data', 'max-addons-for-bricks' ),
			],
			'default'   => 'youtube',
			'inline'    => true,
			'clearable' => false,
		];

		$this->controls['youTubeId'] = [
			'tab'      => 'content',
			'group'    => 'video',
			'label'    => esc_html__( 'YouTube Video ID', 'max-addons-for-bricks' ),
			'type'     => 'text',
			'inline'   => true,
			'required' => [ 'videoType', '=', 'youtube' ],
			'default'  => 'Rk6_hdRtJOE',
		];

		$this->controls['vimeoId'] = [
			'tab'      => 'content',
			'group'    => 'video',
			'label'    => esc_html__( 'Vimeo Video ID', 'max-addons-for-bricks' ),
			'type'     => 'text',
			'inline'   => true,
			'required' => [ 'videoType', '=', 'vimeo' ],
		];

		// Support unlisted vimeo videos.
		$this->controls['vimeoHash'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Vimeo privacy hash', 'max-addons-for-bricks' ),
			'type'     => 'text',
			'inline'   => true,
			'info'     => esc_html__( 'If the video is unlisted, you will need to enter the video privacy hash.', 'max-addons-for-bricks' ),
			'required' => [ 'videoType', '=', 'vimeo' ],
		];

		$this->controls['mediaUrl'] = [
			'tab'      => 'content',
			'group'    => 'video',
			'label'    => esc_html__( 'Media', 'max-addons-for-bricks' ),
			'type'     => 'video',
			'required' => [ 'videoType', '=', 'media' ],
		];

		$this->controls['fileUrl'] = [
			'tab'      => 'content',
			'group'	   => 'video',
			'label'    => esc_html__( 'Video File URL', 'max-addons-for-bricks' ),
			'type'     => 'text',
			// 'default' => 'https://storage.googleapis.com/webfundamentals-assets/videos/chrome.mp4',
			'required' => [ 'videoType', '=', 'file' ],
		];

		$this->controls['useDynamicData'] = [
			'tab'            => 'content',
			'group'          => 'video',
			'label'          => '',
			'type'           => 'text',
			'placeholder'    => esc_html__( 'Select dynamic data', 'max-addons-for-bricks' ),
			'hasDynamicData' => 'link',
			'required'       => [ 'videoType', '=', 'meta' ],
		];

		$this->controls['start'] = [
			'tab'         => 'content',
			'group'    	  => 'video',
			'label'       => esc_html__( 'Start Time', 'max-addons-for-bricks' ),
			'description' => esc_html__( 'Specify start time (in seconds)', 'max-addons-for-bricks' ),
			'type'        => 'number',
			'inline'      => true,
			'small'       => true,
		];

		$this->controls['end'] = [
			'tab'         => 'content',
			'group'		  => 'video',
			'label'       => esc_html__( 'End Time', 'max-addons-for-bricks' ),
			'description' => esc_html__( 'Specify end time (in seconds)', 'max-addons-for-bricks' ),
			'type'        => 'number',
			'inline'      => true,
			'small'       => true,
			'required'    => [ 'videoType', '=', [ 'youtube', 'media', 'file', 'meta' ] ],
		];

		$this->controls['aspectRatio'] = [
			'tab'         => 'content',
			'group'       => 'video',
			'label'       => esc_html__( 'Aspect Ratio', 'max-addons-for-bricks' ),
			'placeholder' => '16:9',
			'type'        => 'select',
			'options'     => [
				'169' => '16:9',
				'219' => '21:9',
				'916' => '9:16',
				'43'  => '4:3',
				'32'  => '3:2',
				'11'  => '1:1',
			],
			'default'     => '169',
			'inline'      => true,
			'clearable'   => true,
		];

		$this->controls['videoOptions'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Video Options', 'max-addons-for-bricks' ),
			'type'      => 'separator',
		];

		$this->controls['preload'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Preload', 'max-addons-for-bricks' ),
			'type'      => 'select',
			'options'   => array(
				'auto'     => 'Auto',
				'metadata' => 'Meta data',
				'none'     => 'None',
			),
			'default'   => 'auto',
			'inline'    => true,
			'required'    => [ 'videoType', '=', [ 'hosted' ] ],
		];

		$this->controls['lightbox'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label' => __( 'Lightbox', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
			'inline'    => true,
		];

		$this->controls['autoplay'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'		=> __( 'Autoplay', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'inline' 	=> true,
			'required'  => [ 'lightbox', '=', '' ],
		];

		$this->controls['play_on_mobile'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Play On Mobile', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'inline'    => true,
			'required'    => [ 'autoplay', '=', true ],
		];

		$this->controls['mute'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'         => __( 'Mute', 'max-addons-for-bricks' ),
			'type'          => 'checkbox',
			'default'		=> '',
			'inline' 		=> true,
		];

		$this->controls['loop'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Loop', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'default'   => true,
			'inline'    => true,
		];

		$this->controls['controls'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Player Controls', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'default'   => true,
			'inline'    => true,
			'required'  => [ 'videoType', '!=', 'vimeo'],
		];

		$this->controls['color'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Controls Color', 'max-addons-for-bricks' ),
			'type'      => 'color',
			'required'  => [ 'videoType', '=', 'vimeo'],
		];

		$this->controls['cc_load_policy'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'       => __( 'Captions', 'max-addons-for-bricks' ),
			'type'        => 'checkbox',
			'inline'    => true,
			'required'  => [ 
				[ 'videoType', '=', 'youtube' ],
				[ 'controls', '=', true ],
			],
		];

		$this->controls['yt_privacy'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'       => __( 'Privacy Mode', 'max-addons-for-bricks' ),
			'type'        => 'checkbox',
			'description' => __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'max-addons-for-bricks' ),
			'inline'    => true,
			'required'  => [ 'videoType', '=', 'youtube'],
		];

		$this->controls['rel'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Show related videos', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'required'  => [ 'videoType', '=', 'youtube'],
		];

		// Vimeo.
		$this->controls['vimeo_title'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Intro Title', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'default'   => true,
			'inline'    => true,
			'required'  => [ 'videoType', '=', 'vimeo'],
		];

		$this->controls['vimeo_portrait'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Intro Portrait', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'default'   => true,
			'inline'    => true,
			'required'  => [ 'videoType', '=', 'vimeo'],
		];

		$this->controls['vimeo_byline'] = [
			'tab'       => 'content',
			'group'     => 'video',
			'label'     => __( 'Intro Byline', 'max-addons-for-bricks' ),
			'type'      => 'checkbox',
			'default'   => true,
			'inline'    => true,
			'required'  => [ 'videoType', '=', 'vimeo'],
		];
	}

	// Set thumbnail controls
	public function set_thumbnail_controls() {

		$this->controls['thumbnail_size'] = [
			'tab'       => 'content',
			'group'     => 'thumbnail',
			'label'     => esc_html__( 'Thumbnail Size', 'max-addons-for-bricks' ),
			'type'      => 'select',
			'options'   => [
				'maxresdefault' => esc_html__( 'Maximum Resolution', 'max-addons-for-bricks' ),
				'hqdefault'     => esc_html__( 'High Quality', 'max-addons-for-bricks' ),
				'mqdefault'     => esc_html__( 'Medium Quality', 'max-addons-for-bricks' ),
				'sddefault'     => esc_html__( 'Standard Quality', 'max-addons-for-bricks' ),
			],
			'inline'    => false,
			'clearable' => false,
			'default'   => 'hqdefault',
		];

		$this->controls['custom_thumbnail'] = [
			'tab'      => 'content',
			'group'    => 'thumbnail',
			'label'    => esc_html__( 'Custom Thumbnail', 'max-addons-for-bricks' ),
			'type'     => 'checkbox',
			'inline'   => true,
		];

		$this->controls['custom_image'] = [
			'tab'   => 'content',
			'group' => 'thumbnail',
			'type'  => 'image',
			'label' => esc_html__( 'Image', 'max-addons-for-bricks' ),
			'required' => [ 'custom_thumbnail', '=', true ],
		];
	}

	// Set play icon controls
	public function set_play_icon_controls() {

		$this->controls['overlay'] = [
			'tab'      => 'content',
			'group'    => 'playIcon',
			'type'     => 'background',
			'label'    => esc_html__( 'Overlay', 'max-addons-for-bricks' ),
			'exclude'  => 'video',
			'rerender' => true,
			'css'      => [
				[
					'property' => 'background',
					'selector' => '.mab-media-overlay',
				],
			],
		];

		$this->controls['play_icon_type'] = [
			'tab'         => 'content',
			'group'       => 'playIcon',
			'label'       => esc_html__( 'Icon Type', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => array(
				'icon'   => esc_html__( 'Icon', 'max-addons-for-bricks' ),
				'image'  => esc_html__( 'Image', 'max-addons-for-bricks' ),
			),
			'inline'      => true,
			'clearable'   => true,
			'default'     => 'icon',
		];

		$this->controls['play_icon'] = [
			'tab'      => 'content',
			'group'    => 'playIcon',
			'label'    => esc_html__( 'Icon', 'max-addons-for-bricks' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-control-play',
			],
			'required' => [ 'play_icon_type', '=', [ 'icon' ] ],
		];

		$this->controls['play_icon_image'] = [
			'tab'      => 'content',
			'group'    => 'playIcon',
			'type'     => 'image',
			'label'    => esc_html__( 'Image', 'max-addons-for-bricks' ),
			'required' => [ 'play_icon_type', '=', [ 'image' ] ],
		];

		// aria-label for icon/overlay (@since 1.13.4)
		$this->controls['overlayAriaLabel'] = [
			'tab'            => 'content',
			'group'          => 'playIcon',
			'label'          => 'aria-label',
			'type'           => 'text',
			'inline'         => true,
			'hasDynamicData' => true,
		];

		$this->controls['iconTypography'] = [
			'tab'      => 'content',
			'group'    => 'playIcon',
			'label'    => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-video-play-icon',
				],
			],
			'exclude'  => [
				'font-family',
				'font-weight',
				'font-style',
				'text-align',
				'text-decoration',
				'text-transform',
				'line-height',
				'letter-spacing',
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'play_icon_type', '=', [ 'icon' ] ],
		];

		$this->controls['iconImageHeight'] = [
			'tab'      => 'content',
			'group'    => 'playIcon',
			'label'    => esc_html__( 'Height', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'height',
					'selector' => '.mab-play-icon-image img',
				],
			],
			'required' => [ 'play_icon_type', '=', [ 'image' ] ],
		];

		$this->controls['iconImageWidth'] = [
			'tab'      => 'content',
			'group'    => 'playIcon',
			'label'    => esc_html__( 'Width', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'width',
					'selector' => '.mab-play-icon-image img',
				],
			],
			'required' => [ 'play_icon_type', '=', [ 'image' ] ],
		];
	}

	// Set sticky video controls
	public function set_sticky_video_controls() {
		$this->controls['stickyVideo'] = [
			'tab'      => 'content',
			'group'    => 'stickyVideo',
			'label'    => esc_html__( 'Sticky Video', 'max-addons-for-bricks' ),
			'type'     => 'checkbox',
			'inline'   => true,
		];

		$this->controls['stickyPosition'] = [
			'tab'         => 'content',
			'group'       => 'stickyVideo',
			'label'       => esc_html__( 'Position', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'inline'      => true,
			'options'     => [
				'topLeft'      => esc_html__( 'Top left', 'max-addons-for-bricks' ),
				'topRight'     => esc_html__( 'Top right', 'max-addons-for-bricks' ),
				'bottomLeft'   => esc_html__( 'Bottom left', 'max-addons-for-bricks' ),
				'bottomRight'  => esc_html__( 'Bottom right', 'max-addons-for-bricks' ),
			],
			'placeholder' => esc_html__( 'Top left', 'max-addons-for-bricks' ),
			'required'    => [ 'stickyVideo', '!=', '' ],
		];

		$breakpoints        = self::get_breakpoints();
		$breakpoint_options = [];

		foreach ( $breakpoints as $index => $breakpoint ) {
			$breakpoint_options[ $breakpoint['key'] ] = $breakpoint['label'];
		}

		$this->controls['hideStickyOn'] = [
			'tab'      => 'content',
			'group'    => 'stickyVideo',
			'label'    => esc_html__( 'Hide Sticky Video On', 'max-addons-for-bricks' ),
			'type'     => 'select',
			'options'  => $breakpoint_options,
			'multiple' => true,
			'rerender' => true,
			'placeholder' => esc_html__( 'None', 'max-addons-for-bricks' ),
			'required' => [ 'stickyVideo', '!=', '' ],
		];

		$this->controls['stickyCloseButtonHeading'] = [
			'tab'      => 'content',
			'group'    => 'stickyVideo',
			'label'    => __( 'Close Button', 'max-addons-for-bricks' ),
			'type'     => 'separator',
			'required' => [ 'stickyVideo', '!=', '' ],
		];
		
		$this->controls['stickyCloseButton'] = [
			'tab'      => 'content',
			'group'    => 'stickyVideo',
			'label'    => esc_html__( 'Close Button', 'max-addons-for-bricks' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'required' => [ 'stickyVideo', '!=', '' ],
		];

		$this->controls['stickyCloseButtonIconColor'] = [
			'tab'    => 'content',
			'group'  => 'stickyVideo',
			'type'   => 'color',
			'label'  => esc_html__( 'Icon Color', 'max-addons-for-bricks' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.mab-sticky-close:before, .mab-sticky-close:after',
				],
			],
			'inline' => true,
			'small'  => true,
			'required' => [
				[ 'stickyVideo', '!=', '' ],
				[ 'stickyCloseButton', '!=', '' ]
			],
		];

		$this->controls['stickyCloseButtonBgColor'] = [
			'tab'    => 'content',
			'group'  => 'stickyVideo',
			'type'   => 'color',
			'label'  => esc_html__( 'Background Color', 'max-addons-for-bricks' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.mab-sticky-close',
				],
			],
			'inline' => true,
			'small'  => true,
			'required' => [
				[ 'stickyVideo', '!=', '' ],
				[ 'stickyCloseButton', '!=', '' ]
			],
		];
	}

	// Set video schema controls
	public function set_video_schema_controls() {
		$this->controls['videoSchema'] = [
			'tab'      => 'content',
			'group'    => 'videoSchema',
			'label'    => esc_html__( 'Video Schema', 'max-addons-for-bricks' ),
			'type'     => 'checkbox',
			'inline'   => true,
		];

		$this->controls['videoTitle'] = [
			'tab'            => 'content',
			'group'          => 'videoSchema',
			'label'          => esc_html__( 'Video Title', 'max-addons-for-bricks' ),
			'type'           => 'text',
			'hasDynamicData' => 'text',
			'required'       => [ 'videoSchema', '!=', '' ],
		];

		$this->controls['videoDescription'] = [
			'tab'            => 'content',
			'group'          => 'videoSchema',
			'label'          => esc_html__( 'Video Description', 'max-addons-for-bricks' ),
			'type'           => 'textarea',
			'rows'           => 3,
			'hasDynamicData' => 'text',
			'required'       => [ 'videoSchema', '!=', '' ],
		];

		$this->controls['videoThumbnail'] = [
			'tab'      => 'content',
			'group'    => 'videoSchema',
			'type'     => 'image',
			'label'    => esc_html__( 'Video Thumbnail', 'max-addons-for-bricks' ),
			'required' => [ 'videoSchema', '!=', '' ],
		];

		$this->controls['videoUploadDate'] = [
			'tab'      => 'content',
			'group'    => 'videoSchema',
			'label'    => esc_html__( 'Video Upload Date & Time', 'max-addons-for-bricks' ),
			'type'    => 'datepicker',
			'default' => '',
			'required' => [ 'videoSchema', '!=', '' ],
		];
	}

	/**
	 * Get structured data - https://schema.org/VideoObject
	 *
	 * @since 1.15.0
	 * @return string
	 */
	public function get_structured_data() {
		$settings = $this->settings;
		
		if ( ! isset( $settings['videoSchema'] ) ) {
			return false;
		}

		$markup = '';
		$url 	= $this->get_video_url();

		if ( empty( $settings['videoTitle'] ) || empty( $settings['videoDescription'] ) || ! isset( $settings['videoThumbnail'] ) || empty( $settings['videoUploadDate'] ) ) {
			return false;
		}
	
		$markup .= sprintf( '<meta itemprop="name" content="%s" />', esc_attr( $settings['videoTitle'] ) );
		$markup .= sprintf( '<meta itemprop="description" content="%s" />', esc_attr( $settings['videoDescription'] ) );
		$markup .= sprintf( '<meta itemprop="uploadDate" content="%s" />', esc_attr( $settings['videoUploadDate'] ) );
		$markup .= sprintf( '<meta itemprop="thumbnailUrl" content="%s" />', $settings['videoThumbnail']['url'] );

		if ( ! empty( $url ) ) {
			$markup .= sprintf( '<meta itemprop="contentUrl" content="%s" />', $url );
			$markup .= sprintf( '<meta itemprop="embedUrl" content="%s" />', $url );
		}

		return $markup;
	}

	/**
	 * Get breakpoints helper function
	 *
	 * @since 1.x
	 */
	private static function get_breakpoints() {
		if ( self::$breakpoints === null ) {
			self::$breakpoints = \Bricks\Breakpoints::get_breakpoints();
		}

		return self::$breakpoints;
	}

	public function get_normalized_image_settings( $settings ) {
		if ( empty( $settings['custom_image'] ) ) {
			return [
				'id'   => 0,
				'url'  => false,
				'size' => BRICKS_DEFAULT_IMAGE_SIZE,
			];
		}

		$image = $settings['custom_image'];

		// Size
		$image['size'] = empty( $image['size'] ) ? BRICKS_DEFAULT_IMAGE_SIZE : $settings['custom_image']['size'];

		// Image ID or URL from dynamic data
		if ( ! empty( $image['useDynamicData'] ) ) {

			$images = $this->render_dynamic_data_tag( $image['useDynamicData'], 'custom_image', [ 'size' => $image['size'] ] );

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
	 * Clean string - Removes spaces and special chars.
	 *
	 * @since 1.0.0
	 * @param  String $string String to be cleaned.
	 * @return array Google Map languages List.
	 */
	public function clean( $string ) {

		// Replaces all spaces with hyphens.
		$string = str_replace( ' ', '-', $string );

		// Removes special chars.
		$string = preg_replace( '/[^A-Za-z0-9\-]/', '', $string );

		// Turn into lower case characters.
		return strtolower( $string );
	}

	/**
	 * Render filter keys array.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_filter_keys( $item ) {
		if ( isset( $item['filterLabel'] ) ) {
			$filters = explode( ',', $item['filterLabel'] );
			$filters = array_map( 'trim', $filters );
		} else {
			$filters = [];
		}

		$filters_array = [];

		foreach ( $filters as $key => $value ) {
			$filters_array[ $this->clean( $value ) ] = $value;
		}

		return $filters_array;
	}

	/**
	 * Get Filter values array.
	 *
	 * Returns the Filter array of objects.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_filter_values() {
		$settings = $this->settings;

		$filters = array();

		if ( isset( $settings['items'] ) && ! empty( $settings['items'] ) ) {

			foreach ( $settings['items'] as $key => $value ) {

				$filter_keys = $this->get_filter_keys( $value );

				if ( ! empty( $filter_keys ) ) {

					$filters = array_unique( array_merge( $filters, $filter_keys ) );
				}
			}
		}

		return $filters;
	}

	/**
	 * Render Video Gallery Filters
	 *
	 * @since 1.0.0
	 * @return void
	 */
	protected function render_filters() {
		$settings = $this->settings;

		if ( isset( $settings['layout'] ) && 'grid' === $settings['layout'] ) {
			if ( isset( $settings['filtersEnable'] ) ) {
				$all_text = ( isset( $settings['allFilterLabel'] ) ) ? $settings['allFilterLabel'] : esc_html__( 'All', 'max-addons-for-bricks' );
				$gallery  = $this->get_filter_values();
				?>
				<div class="mab-gallery-filters">
					
						<div class="mab-gallery-filter mab-active" data-filter="*" data-gallery-index="all">
								<?php echo esc_attr( $all_text ); ?>
						</div>
						<?php
						foreach ( $gallery as $index => $item ) {
							$filter_label = $item;
							if ( $item ) {
								?>
							<div class="mab-gallery-filter" data-filter="<?php echo '.' . esc_attr( $index ); ?>" data-gallery-index="<?php echo esc_attr( $index ); ?>">
								<?php echo esc_attr( $filter_label ); ?>
							</div>
							<?php } ?>
						<?php } ?>

				</div>
				<?php
			}
		}
	}

	/**
	 * Embed patterns.
	 *
	 * Holds a list of supported providers with their embed patters.
	 *
	 */
	private static $embed_patterns = [
		'youtube'     => 'https://www.youtube{NO_COOKIE}.com/embed/{VIDEO_ID}?feature=oembed',
		'vimeo'       => 'https://player.vimeo.com/video/{VIDEO_ID}#t={TIME}',
		'dailymotion' => 'https://dailymotion.com/embed/video/{VIDEO_ID}',
	];

	/**
	 * Get video properties.
	 *
	 * Retrieve the video properties for a given video URL.
	 *
	 */
	public static function get_video_properties( $settings ) {
		$video_type = isset( $settings['videoType'] ) ? $settings['videoType'] : false;

		// Video Type: YouTube
		if ( $video_type === 'youtube' && isset( $settings['youTubeId'] ) ) {
			$provider = 'youtube';
			$video_id = $settings['youTubeId'];
		}

		// Video Type: Vimeo
		if ( $video_type === 'vimeo' && isset( $settings['vimeoId'] ) ) {
			$provider = 'vimeo';
			$video_id = $settings['vimeoId'];
		}

		if ( $video_type ) {
			return [
				'provider' => $provider,
				'video_id' => $video_id,
			];
		}

		return null;
	}

	/**
	 * Get embed URL.
	 *
	 * Retrieve the embed URL for a given video.
	 *
	 */
	public static function get_embed_url( $settings, array $embed_url_params = [], array $options = [] ) {
		$video_properties = self::get_video_properties( $settings );

		if ( ! $video_properties ) {
			return null;
		}

		$embed_pattern = self::$embed_patterns[ $video_properties['provider'] ];

		$replacements = [
			'{VIDEO_ID}' => $video_properties['video_id'],
		];

		if ( 'youtube' === $video_properties['provider'] ) {
			$replacements['{NO_COOKIE}'] = ! empty( $options['privacy'] ) ? '-nocookie' : '';
		} elseif ( 'vimeo' === $video_properties['provider'] ) {
			$time_text = '';

			if ( ! empty( $options['start'] ) ) {
				$time_text = date( 'H\hi\ms\s', $options['start'] ); // PHPCS:Ignore WordPress.DateTime.RestrictedFunctions.date_date
			}

			$replacements['{TIME}'] = $time_text;
		}

		$embed_pattern = str_replace( array_keys( $replacements ), $replacements, $embed_pattern );

		return add_query_arg( $embed_url_params, $embed_pattern );
	}

	/**
	 * @param bool $from_media
	 *
	 * @return string
	 * @since 1.0.0
	 * @access private
	 */
	protected function get_hosted_video_url() {
		$settings = $this->settings;
		if ( isset( $settings['fileUrl'] ) || isset( $settings['mediaUrl'] ) ) {
			if ( isset( $settings['fileUrl'] ) ) {
				$video_url = $settings['fileUrl'];
			} else {
				$video_url = $settings['mediaUrl']['url'];
			}
		}

		if ( empty( $video_url ) ) {
			return '';
		}

		if ( isset( $settings['start'] ) || isset( $settings['end'] ) ) {
			$video_url .= '#t=';
		}

		if ( isset( $settings['start'] ) ) {
			$video_url .= $settings['start'];
		}

		if ( isset( $settings['end'] ) ) {
			$video_url .= ',' . $settings['end'];
		}

		return $video_url;
	}

	/**
	 * Get URL of video.
	 *
	 * @since 1.15.0
	 *
	 * @return string|bool Video URL or false.
	 */
	public function get_video_url() {
		$settings   = $this->settings;
		$video_type = $settings['videoType'];
		$video_url  = false;

		$embed_params  = $this->get_embed_params();
		$embed_options = $this->get_embed_options();

		if ( 'media' === $video_type || 'file' === $video_type ) {
			$video_url = $this->get_hosted_video_url();

			if ( empty( $video_url ) ) {
				$video_url = $settings['fileUrl'];
			}
		} else {
			$video_id = $this->get_video_id();

			if ( 'youtube' === $video_type && '' !== $video_id ) {
				$video_url = 'https://www.youtube.com/watch?v=' . $video_id;
			} elseif ( 'vimeo' === $settings['videoType'] && '' !== $video_id ) {
				$video_url = 'https://vimeo.com/watch?v=' . $video_id;
			}
		}

		return $video_url;
	}

	/**
	 * @since 1.0.0
	 * @access private
	 */
	protected function get_hosted_params() {
		$settings = $this->settings;

		$video_params = [];

		$video_params['controls'] = '';

		$video_params['controlsList'] = 'nodownload';

		if ( $settings['mute'] ) {
			$video_params['muted'] = 'muted';
		}

		if ( isset( $settings['custom_thumbnail'] ) ) {
			if ( isset( $settings['custom_image'] ) ) {
				$video_params['poster'] = $settings['custom_image'];
			}
		}

		return $video_params;
	}

	/**
	 * Returns Video Thumbnail.
	 *
	 * @access protected
	 */
	public function get_video_thumbnail( $thumb_size ) {
		$settings = $this->settings;
		
		$thumb_url = '';
		$video_id  = $this->get_video_id();
		$settings  = $this->get_normalized_video_settings( $settings );
		$image     = $this->get_normalized_image_settings( $settings );
		$image_url = $image['url'];

		if ( 'media' === $settings['videoType'] || 'file' === $settings['videoType'] ) {
			if ( isset( $settings['custom_thumbnail'] ) ) {
				if ( $image_url ) {
					$thumb_url = $image_url;
				}
			}
		}

		if ( isset( $settings['custom_thumbnail'] ) ) {
			if ( $image_url ) {
				$thumb_url = $image_url;
			}
		} elseif ( 'youtube' === $settings['videoType'] ) {
			if ( $video_id ) {
				$thumb_url = 'https://i.ytimg.com/vi/' . $video_id . '/' . $thumb_size . '.jpg';
			}
		} elseif ( 'vimeo' === $settings['videoType'] ) {
			if ( $video_id ) {
				$response = wp_remote_get( "https://vimeo.com/api/v2/video/$video_id.php" );

				if ( is_wp_error( $response ) ) {
					return;
				}
				$vimeo = maybe_unserialize( $response['body'] );
				$thumb_url = $vimeo[0]['thumbnail_large'];
			}
		}

		return $thumb_url;

	}

	/**
	 * Returns Video ID.
	 *
	 * @access protected
	 */
	protected function get_video_id() {
		$settings = $this->settings;
		$settings = $this->get_normalized_video_settings( $settings );

		$video_id = '';

		if ( 'youtube' === $settings['videoType'] && isset( $settings['youTubeId'] ) ) {

			$video_id = $this->render_dynamic_data( $settings['youTubeId'] );

			// Get YouTube video ID, if it's a full URL (@since 1.16.10)
			$video_id = $this->get_youtube_id_from_url( $video_id );

		} elseif ( 'vimeo' === $settings['videoType'] && isset( $settings['vimeoId'] ) ) {

			$video_id = $this->render_dynamic_data( $settings['vimeoId'] );

			// Get YouTube video ID, if it's a full URL (@since 1.16.10)
			$video_id = $this->get_vimeo_id_from_url( $video_id );

		}

		return $video_id;

	}

	/**
	 * Get the YouTube video ID from a URL
	 *
	 * @param string $url
	 * @return string $video_id
	 *
	 * @since 1.16.10
	 */
	public function get_youtube_id_from_url( $url = '' ) {
		// If it's valid URL, extract the video ID
		if ( filter_var( $url, FILTER_VALIDATE_URL ) && preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|shorts/|live/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches ) ) {
			// Regex from @see: https://gist.github.com/ghalusa/6c7f3a00fd2383e5ef33
			// @since 1.16.10: Support for YouTube Shorts and Live URLs
			return $matches[1];
		}

		return $url;
	}

	/**
	 * Get the Vimeo video ID from a URL
	 *
	 * @param string $url
	 * @return string $video_id
	 *
	 * @since 1.16.10
	 */
	public function get_vimeo_id_from_url( $url = '' ) {
		// If it's valid URL, extract the video ID
		if ( filter_var( $url, FILTER_VALIDATE_URL ) && preg_match( '%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $matches ) ) {
			// Regex from @see: https://gist.github.com/anjan011/1fcecdc236594e6d700f
			return $matches[3];
		}

		return $url;
	}

	/**
	 * Get embed params.
	 *
	 * Retrieve video widget embed parameters.
	 *
	 * @access public
	 *
	 * @return array Video embed parameters.
	 */
	public function get_embed_params() {
		$settings = $this->settings;

		$params = array();

		$params_dictionary = array();

		if ( 'youtube' === $settings['videoType'] ) {

			$params_dictionary = array(
				'loop',
				'controls',
				'mute',
				'rel',
				'cc_load_policy',
			);

			if ( isset( $settings['loop'] ) ) {
				$video_id = $this->get_video_id();

				$params['playlist'] = $video_id;
			}

			$params['autoplay'] = 1;

			if ( isset( $settings['play_on_mobile'] ) ) {
				$params['playsinline'] = '1';
			}

			$params['wmode'] = 'opaque';

			if ( isset( $settings['start'] ) ) {
				$params['start'] = (int) $settings['start'];
			}

			if ( isset( $settings['end'] ) ) {
				$params['end'] = (int) $settings['end'];
			}
		} elseif ( 'vimeo' === $settings['videoType'] ) {

			$params_dictionary = array(
				'loop',
				'mute'           => 'muted',
				'vimeo_title'    => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline'   => 'byline',
			);

			if ( isset($settings['color']) ) {
				$params['color'] = str_replace( '#', '', $settings['color'] );
			}

			$params['autopause'] = '0';
			$params['autoplay']  = '1';

			if ( isset( $settings['vimeoHash'] ) ) {
				$params['h'] = $settings['vimeoHash'];
			}

			if ( isset( $settings['play_on_mobile'] ) ) {
				$params['playsinline'] = '1';
			}
		} elseif ( 'dailymotion' === $settings['videoType'] ) {

			$params_dictionary = array(
				'controls',
				'mute',
				'showinfo' => 'ui-start-screen-info',
				'logo'     => 'ui-logo',
			);

			$params['ui-highlight'] = str_replace( '#', '', $settings['color'] );

			if( isset( $settings['start'] ) ) {
				$params['start'] = $settings['start'];
			}

			$params['endscreen-enable'] = '0';
			$params['autoplay']         = 1;

			if ( $settings['play_on_mobile'] ) {
				$params['playsinline'] = '1';
			}
		}

		foreach ( $params_dictionary as $key => $param_name ) {
			$setting_name = $param_name;

			if ( 'rel' === $setting_name ) {
				if ( isset( $settings['lightbox'] ) && ! isset( $settings['rel'] ) ) {
					continue;
				}
			}

			if ( is_string( $key ) ) {
				$setting_name = $key;
			}

			$setting_value = isset( $settings[ $setting_name ] ) ? '1' : '0';

			$params[ $param_name ] = $setting_value;
		}

		return $params;
	}

	/**
	 * Get embed options.
	 *
	 * @access private
	 *
	 * @return array Video embed options.
	 */
	private function get_embed_options() {
		$settings = $this->settings;

		$embed_options = array();

		if ( 'youtube' === $settings['videoType'] ) {
			if ( isset( $settings['yt_privacy'] ) ) {
				$embed_options['privacy'] = $settings['yt_privacy'];
			}
		} elseif ( 'vimeo' === $settings['videoType'] ) {
			if ( isset( $settings['start'] ) ) {
				$embed_options['start'] = $settings['start'];
			}
		}

		// $embed_options['lazy_load'] = ! empty( $settings['lazy_load'] );

		return $embed_options;
	}

	/**
	 * Helper function to parse the settings when videoType = meta
	 *
	 * @return array
	 */
	public function get_normalized_video_settings( $settings = [] ) {
		if ( empty( $settings['videoType'] ) ) {
			return $settings;
		}

		if ( $settings['videoType'] === 'youtube' ) {

			if ( ! empty( $settings['youTubeId'] ) ) {
				$settings['youTubeId'] = $this->render_dynamic_data( $settings['youTubeId'] );

				// Get YouTube video ID, if it's a full URL (@since 1.16.10)
				$settings['youTubeId'] = $this->get_youtube_id_from_url( $settings['youTubeId'] );
			}

			return $settings;
		}

		if ( $settings['videoType'] === 'vimeo' && ! empty( $settings['vimeoId'] ) ) {
			$settings['vimeoId'] = $this->render_dynamic_data( $settings['vimeoId'] );

			return $settings;
		}

		if ( $settings['videoType'] === 'vimeo' ) {

			if ( ! empty( $settings['vimeoId'] ) ) {
				$settings['vimeoId'] = $this->render_dynamic_data( $settings['vimeoId'] );

				// Get Vimeo ID, if it's a full URL (@since 1.16.10)
				$settings['vimeoId'] = $this->get_vimeo_id_from_url( $settings['vimeoId'] );

			}

			if ( ! empty( $settings['vimeoHash'] ) ) {
				$settings['vimeoHash'] = $this->render_dynamic_data( $settings['vimeoHash'] );
			}

			return $settings;
		}

		// Check 'file' and 'meta' videoType for dynamic data
		$dynamic_data = false;

		if ( $settings['videoType'] === 'file' && ! empty( $settings['fileUrl'] ) && strpos( $settings['fileUrl'], '{' ) === 0 ) {
			$dynamic_data = $settings['fileUrl'];
		}

		if ( $settings['videoType'] === 'meta' && ! empty( $settings['useDynamicData'] ) ) {
			$dynamic_data = $settings['useDynamicData'];
		}

		if ( ! $dynamic_data ) {
			return $settings;
		}

		$meta_video_url = '';

		// Set context to 'media' (@since 1.16.10)
		$meta_media_value = $this->render_dynamic_data_tag( $dynamic_data, 'media' );

		/**
		 * Ensure we have a non-empty array and the first element is an array
		 *
		 * Check includes/integrations/dynamic-data/providers/base.php
		 *
		 * @since 1.16.10
		 */
		if ( is_array( $meta_media_value ) && ! empty( $meta_media_value[0] ) && is_array( $meta_media_value[0] ) ) {
			$url_or_id = $meta_media_value[0]['url'] ?? '';

			if ( ! empty( $url_or_id ) ) {
				if ( is_numeric( $url_or_id ) ) {
					// Cast to int safely and get the attachment URL
					$attachment_url = wp_get_attachment_url( (int) $url_or_id );
					if ( $attachment_url ) {
						// Force URL as string as we will be using preg_match, unknown plugin might change the type via wp_get_attachment_url
						$meta_video_url = (string) $attachment_url;
					}
				} else {
					// Force URL as string as we will be using preg_match
					$meta_video_url = (string) $url_or_id;
				}
			}
		} elseif ( is_string( $meta_media_value ) && ! empty( $meta_media_value ) ) {
			// If the value is a string, use it directly (the full URL can be provided via @fallback)
			$meta_video_url = $meta_media_value;
		}

		if ( empty( $meta_video_url ) ) {
			return $settings;
		}

		// Is YouTube video
		if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|shorts/|live/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $meta_video_url, $matches ) ) {
			// Regex from @see: https://gist.github.com/ghalusa/6c7f3a00fd2383e5ef33
			$settings['youTubeId'] = $matches[1];
			$settings['videoType'] = 'youtube';
		}

		// Is Vimeo video
		elseif ( preg_match( '%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $meta_video_url, $matches ) ) {
			// Regex from @see: https://gist.github.com/anjan011/1fcecdc236594e6d700f
			$settings['vimeoId']   = $matches[3];
			$settings['videoType'] = 'vimeo';
		} else {
			// Url of a video file (either hosted or external)
			$settings['fileUrl']   = $meta_video_url;
			$settings['videoType'] = 'file';
		}

		// Later the settings are used to control the video and the custom field should not be present
		unset( $settings['useDynamicData'] );

		return $settings;
	}

	protected function render_video( $settings ) {
		$thumb_size = '';

		if ( 'youtube' === $settings['videoType'] ) {
			if ( isset( $settings['thumbnail_size'] ) ) {
				$thumb_size = isset( $settings['thumbnail_size'] ) ? $settings['thumbnail_size'] : 'maxresdefault';
			}
		}

		$embed_params  = $this->get_embed_params();
		$embed_options = $this->get_embed_options();

		if ( 'media' === $settings['videoType'] || 'file' === $settings['videoType'] ) {
			$video_url = $this->get_hosted_video_url();

			if ( empty( $video_url ) ) {
				$video_url = $settings['fileUrl'];
			}
		} else {
			$video_url = $this->get_embed_url( $settings, $embed_params, $embed_options );
		}

		$autoplay = isset( $settings['autoplay'] ) ? '1' : '0';

		$this->set_attribute( 'video-container', 'class', [ 'mab-video-container' ] );
		$this->set_attribute( 'video-wrap', 'class', [ 'mab-video-wrap' ] );
		$this->set_attribute( 'video-play', 'class', 'mab-video-play' );
		$this->set_attribute( 'video-player', 'class', 'mab-video-player' );

		if ( ! empty( $settings['overlayAriaLabel'] ) ) {
			$this->set_attribute( 'video-play', 'aria-label', wp_strip_all_tags( $this->render_dynamic_data( $settings['overlayAriaLabel'] ) ) );
		}

		$action = 'inline';

		if ( isset( $settings['lightbox'] ) ) {
			$action = 'lightbox';

			// Lightbox: Photoswipe required width & height
			$lightbox_width  = \Bricks\Theme_Styles::$active_settings['general']['lightboxWidth'] ?? 1280;
			$lightbox_height = \Bricks\Theme_Styles::$active_settings['general']['lightboxHeight'] ?? 720;

			$this->set_attribute( 'video-play', 'href', $video_url );
			$this->set_attribute( 'video-play', 'class', 'mab-video-play-lightbox bricks-lightbox' );
			$this->set_attribute( 'video-play', 'data-pswp-width', $lightbox_width );
			$this->set_attribute( 'video-play', 'data-pswp-height', $lightbox_height );
			$this->set_attribute( 'video-play', 'data-pswp-video-url', $video_url );

		} else {
			$this->set_attribute( 'video-play', 'data-autoplay', $autoplay );
			$this->set_attribute( 'video-player', 'data-src', $video_url );
		}

		$this->set_attribute( 'video-play', 'data-action', $action );

		if ( 'media' === $settings['videoType'] || 'file' === $settings['videoType'] ) {
			//$video_url = $this->get_hosted_video_url();
			$poster = '';

			if ( isset( $settings['custom_thumbnail'] ) ) {
				$image      = $this->get_normalized_image_settings( $settings );
				$image_id   = $image['id'];
				$image_url  = $image['url'];
				$image_size = $image['size'];

				if ( $image_url ) {
					$poster = $image_url;
				}
			}

			$this->set_attribute( 'hosted-video', 'class', 'mab-hosted-video' );
			$this->set_attribute( 'hosted-video', 'src', esc_url( $video_url ) );
			$this->set_attribute( 'hosted-video', 'preload', $settings['preload'] );
			$this->set_attribute( 'hosted-video', 'poster', $poster );
		}
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( 'video-container' ) ); ?>>
			<?php if ( isset( $settings['stickyVideo'] ) ) { ?>
			<div <?php echo wp_kses_post( $this->render_attributes( 'video-wrap' ) ); ?>>
			<?php } ?>
				<a <?php echo wp_kses_post( $this->render_attributes( 'video-play' ) ); ?>>
					<?php
						// Video Overlay
						echo wp_kses_post( $this->render_video_overlay() );
					?>
					<div <?php echo wp_kses_post( $this->render_attributes( 'video-player' ) ); ?>>
						<?php if ( 'media' === $settings['videoType'] || 'file' === $settings['videoType'] ) { ?>
							<?php
							if ( isset( $settings['custom_thumbnail'] ) ) {
								if ( $image_url ) {
									$poster = $image_url;
								}
							}
							?>
							<?php if ( $poster ) { ?>
								<img class="mab-video-thumb" src="<?php echo esc_url( $poster ); ?>" alt="">
							<?php } else { ?>
								<video <?php echo wp_kses_post( $this->render_attributes( 'hosted-video' ) ); ?>></video>
							<?php } ?>
						<?php } else { ?>
							<img class="mab-video-thumb" src="<?php echo $this->get_video_thumbnail( $thumb_size ); ?>" alt="">
						<?php } ?>
						<?php $this->render_play_icon(); ?>
					</div>
				</a>
			<?php if ( isset( $settings['stickyVideo'] ) ) { ?>
				<?php if ( isset( $settings['stickyCloseButton'] ) ) { ?>
					<span class="mab-sticky-close"></span>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php
	}

	protected function render_video_overlay() {
		$this->set_attribute(
			'overlay',
			'class',
			array(
				'mab-media-overlay',
				'mab-video-gallery-overlay',
			)
		);

		return '<div ' . $this->render_attributes( 'overlay' ) . '></div>';
	}

	/**
	 * Render play icon output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_play_icon() {
		$settings = $this->settings;

		if ( ! isset( $settings['play_icon_type'] ) ) {
			return;
		}

		$this->set_attribute( 'play-icon', 'class', 'mab-video-play-icon' );

		if ( 'icon' === $settings['play_icon_type'] ) {
			$this->set_attribute( 'play-icon', 'class', 'mab-icon' );

			// Icon
			$icon_html = isset( $settings['play_icon'] ) ? self::render_icon( $settings['play_icon'] ) : false;
			?>
			<span <?php echo wp_kses_post( $this->render_attributes( 'play-icon' ) ); ?>>
				<?php echo $icon_html; ?>
			</span>
			<?php

		} elseif ( 'image' === $settings['play_icon_type'] ) {

			if ( $settings['play_icon_image']['url'] ) {
				?>
				<span <?php echo wp_kses_post( $this->render_attributes( 'play-icon' ) ); ?>>
					<img src="<?php echo esc_url( $settings['play_icon_image']['url'] ); ?>" >
				</span>
				<?php
			}
		}
	}

	public function sticky_position() {
		$settings = $this->settings;

		$sticky_video_styles  = [];

		if ( isset( $settings['stickyPosition'] ) ) {
			switch ( $settings['stickyPosition'] ) {
				case 'topLeft':
					$sticky_video_styles[] = "--top: 30px; --left: 30px; --right: auto";
					break;

				case 'topRight':
					$sticky_video_styles[] = "--top: 30px; --right: 30px; --left: auto";
					break;

				case 'bottomLeft':
					$sticky_video_styles[] = "--top: auto; --bottom: 30px; --left: 30px; --right: auto";
					break;

				case 'bottomRight':
					$sticky_video_styles[] = "--top: auto; --bottom: 30px; --right: 30px; --left: auto";
					break;

				default:
					$sticky_video_styles[] = "--top: 30px; --left: 30px; --right: auto";
					break;
			}
		}

		$sticky_video_css = join( '; ', $sticky_video_styles );

		return $sticky_video_css;
	}

	public function sticky_breakpoints() {
		$settings = $this->settings;

		$breakpoints = bricks_is_frontend() ? self::get_breakpoints() : [];

		// Get all 'width' values from breakpoints
		$all_widths = array_column( $breakpoints, 'width' );

		// Determine the minimum and maximum widths from the available breakpoints
		$min_available_width = min( $all_widths );
		$max_available_width = max( $all_widths );

		// This will store the range of widths for each breakpoint
		$width_ranges = [];

		// STEP: Loop through each breakpoint selected by the user
		foreach ( $settings['hideStickyOn'] as $selected_breakpoint_key ) {
			// Retrieve the details of the selected breakpoint
			$selected_breakpoint_details = \Bricks\Breakpoints::get_breakpoint_by( 'key', $selected_breakpoint_key );

			// If no matching breakpoint is found, continue to the next breakpoint
			if ( ! $selected_breakpoint_details ) {
				continue;
			}

			$current_width = $selected_breakpoint_details['width'];

			$min_range = 0;
			$max_range = '9999';

			// STEP: Find all breakpoints that have a width lesser than the current breakpoint's width
			$lesser_breakpoints = array_filter(
				$breakpoints,
				function ( $breakpoint ) use ( $current_width ) {
					return $breakpoint['width'] < $current_width;
				}
			);

			// Extract all the widths of these lesser breakpoints
			$lesser_breakpoint_widths = array_column( $lesser_breakpoints, 'width' );
			$max_lesser_width         = ( ! empty( $lesser_breakpoint_widths ) ) ? max( $lesser_breakpoint_widths ) : null;

			// STEP: Determine the range

			// Adjust the minimum range if this is not the smallest breakpoint
			if ( $current_width !== $min_available_width ) {
				$min_range = $max_lesser_width + 1;
			}

			// Adjust the max range if this is not the largest breakpoint
			if ( $current_width !== $max_available_width ) {
				$max_range = $current_width;
			}

			// Store the width range
			$width_ranges[] = "$min_range-$max_range";
		}

		return implode( ',', $width_ranges );
	}

	public function render() {
		$settings = $this->settings;

		// Return: No video type selected
		if ( empty( $settings['videoType'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No video selected.', 'max-addons-for-bricks' ),
				]
			);
		}

		// Parse settings if videoType = 'meta' try fitting content into the other 'videoType' flows
		$settings = $this->get_normalized_video_settings( $settings );

		$source = ! empty( $settings['videoType'] ) ? $settings['videoType'] : false;

		if ( $source === 'youtube' && empty( $settings['youTubeId'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No YouTube ID provided.', 'max-addons-for-bricks' ),
				]
			);
		}

		if ( $source === 'vimeo' && empty( $settings['vimeoId'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No Vimeo ID provided.', 'max-addons-for-bricks' ),
				]
			);
		}

		if ( $source === 'media' && empty( $settings['mediaUrl'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No video selected.', 'max-addons-for-bricks' ),
				]
			);
		}

		if ( $source === 'file' && empty( $settings['fileUrl'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No file URL provided.', 'max-addons-for-bricks' ),
				]
			);
		}

		// Parse settings and if videoType = meta tries to fit the content into the other videoType flows
		//$settings = $this->get_normalized_video_settings( $settings );

		// If meta is still set, then something failed
		if ( $settings['videoType'] === 'meta' ) {

			if ( empty( $settings['useDynamicData'] ) ) {
				$message = esc_html__( 'No dynamic data set.', 'max-addons-for-bricks' );
			} else {
				$message = esc_html__( 'Dynamic data is empty.', 'max-addons-for-bricks' );
			}

			if ( ! empty( $message ) ) {
				return $this->render_element_placeholder(
					[
						'title' => $message
					]
				);
			}
		}

		$schema = $this->get_structured_data();

		$this->set_attribute( '_root', 'class', [ 'mab-video', 'mab-video-type-' . $settings['videoType'] ] );

		if ( $schema ) {
			$this->set_attribute( '_root', 'itemscope', '' );
			$this->set_attribute( '_root', 'itemtype', 'https://schema.org/VideoObject' );
		}

		if ( isset( $settings['aspectRatio'] ) && '169' !== $settings['aspectRatio'] ) {
			$this->set_attribute( '_root', 'class', 'mab-video-ar-' . $settings['aspectRatio'] );
		}

		if ( isset( $settings['stickyVideo'] ) ) {
			if ( bricks_is_frontend() ) {
				$width_ranges = isset( $settings['hideStickyOn'] ) ? $this->sticky_breakpoints() : '';

				$this->set_attribute( '_root', 'data-sticky-video', $width_ranges );
				
				if ( isset( $settings['stickyPosition'] ) ) {
					$this->set_attribute( '_root', 'style', $this->sticky_position() );
				}
			}
		}
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?>>
			<?php
				if ( $schema ) {
					echo $schema;
				}

				$this->render_video( $settings );
			?>
		</div>
		<?php
	}
}
