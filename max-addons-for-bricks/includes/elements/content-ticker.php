<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Content_Ticker_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-content-ticker'; // Make sure to prefix your elements
	public $icon         = 'ti-announcement max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $loop_index   = 0;
	public $scripts      = [ 'mabTicker' ]; // Script(s) run when element is rendered on frontend or updated in builder

	public function get_label() {
		return esc_html__( 'Content Ticker', 'max-addons' );
	}

	public function get_keywords() {
		return [ 'slider', 'carousel', 'query', 'posts' ];
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_script( 'bricks-swiper' );
		wp_enqueue_style( 'bricks-swiper' );
		wp_enqueue_style( 'mab-content-ticker' );
		wp_enqueue_script( 'mab-ticker' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['tickerSettings'] = [
			'title' => esc_html__( 'Settings', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['content'] = [
			'title' => esc_html__( 'Content', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['header'] = [
			'title' => esc_html__( 'Header', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['arrowsStyle'] = [
			'title' => esc_html__( 'Arrows', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {

		$this->controls['_background']['css'][0]['selector'] = '';
		$this->controls['_gradient']['css'][0]['selector'] = '';

		$this->set_ticker_setting_controls();
		$this->set_content_controls();
		$this->set_header_controls();
		$this->set_arrow_style_controls();
	}

	// Set items controls
	public function set_content_controls() {

		$this->controls['items'] = [
			'tab'           => 'content',
			'label'         => esc_html__( 'Ticker Items', 'max-addons' ),
			'type'          => 'repeater',
			'checkLoop'     => true,
			'placeholder'   => esc_html__( 'Ticker Items', 'max-addons' ),
			'titleProperty' => 'tickerTitle',
			'fields'        => [
				'tickerTitle' => [
					'label'          => esc_html__( 'Title', 'max-addons' ),
					'type'           => 'text',
					'hasDynamicData' => 'text',
				],

				'link'         => [
					'label' => esc_html__( 'Link', 'max-addons' ),
					'type'  => 'link',
				],

				'image'        => [
					'label'    => esc_html__( 'Image', 'max-addons' ),
					'type'     => 'image',
				],

			],
			'default'       => [
				[
					'tickerTitle' => esc_html__( 'Content Ticker Item 1', 'max-addons' ),
				],
				[
					'tickerTitle' => esc_html__( 'Content Ticker Item 2', 'max-addons' ),
				],
				[
					'tickerTitle' => esc_html__( 'Content Ticker Item 3', 'max-addons' ),
				],
				[
					'tickerTitle' => esc_html__( 'Content Ticker Item 4', 'max-addons' ),
				],
			],
		];

		$this->controls = array_replace_recursive( $this->controls, $this->get_loop_builder_controls() );

		$this->controls['applyLinkTo'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Apply Link To', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'title' => esc_html__( 'Title', 'max-addons' ),
				'image' => esc_html__( 'Image', 'max-addons' ),
				'both'  => esc_html__( 'Title + Image', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => true,
			'pasteStyles' => false,
			'default'     => '',
		];

		// Title
		$this->controls['titleSeparator'] = [
			'tab'   => 'content',
			'group' => 'content',
			'label' => esc_html__( 'Title', 'max-addons' ),
			'type'  => 'separator',
		];

		$this->controls['titleHtmlTag'] = [
			'tab'         => 'content',
			'group'       => 'content',
			'label'       => esc_html__( 'HTML Tag', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'h1'   => esc_html__( 'Heading 1 (h1)', 'max-addons' ),
				'h2'   => esc_html__( 'Heading 2 (h2)', 'max-addons' ),
				'h3'   => esc_html__( 'Heading 3 (h3)', 'max-addons' ),
				'h4'   => esc_html__( 'Heading 4 (h4)', 'max-addons' ),
				'h5'   => esc_html__( 'Heading 5 (h5)', 'max-addons' ),
				'h6'   => esc_html__( 'Heading 6 (h6)', 'max-addons' ),
				'div'  => esc_html__( 'Div (div)', 'max-addons' ),
				'span' => esc_html__( 'Span (span)', 'max-addons' ),
				'p'    => esc_html__( 'Paragraph (p)', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => true,
			'pasteStyles' => false,
			'default'     => 'h4',
		];

		$this->controls['titleTypographyBody'] = [
			'tab'     => 'content',
			'group'   => 'content',
			'type'    => 'typography',
			'label'   => esc_html__( 'Typography', 'max-addons' ),
			'css'     => [
				[
					'property' => 'font',
					'selector' => '.repeater-item',
				],
			],
			'inline'  => true,
			'small'   => true,
		];

		// Image
		$this->controls['imageSeparator'] = [
			'tab'   => 'content',
			'group' => 'content',
			'label' => esc_html__( 'Image', 'max-addons' ),
			'type'  => 'separator',
		];

		$this->controls['imageBorder'] = [
			'tab'    => 'content',
			'group'  => 'content',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-ticker-image',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['imageWidth'] = [
			'tab'   => 'content',
			'group' => 'content',
			'label' => esc_html__( 'Width', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'width',
					'selector' => '.mab-ticker-image',
				],
			],
		];

		$this->controls['imageMargin'] = [
			'tab'   => 'content',
			'group' => 'content',
			'type'  => 'spacing',
			'label' => esc_html__( 'Margin', 'max-addons' ),
			'css'   => [
				[
					'property' => 'margin',
					'selector' => '.mab-ticker-image',
				],
			],
		];
	}

	// Set header style controls
	public function set_header_controls() {

		$this->controls['showHeading'] = [
			'tab'     => 'content',
			'group'   => 'header',
			'label'   => esc_html__( 'Show Heading', 'max-addons' ),
			'type'    => 'checkbox',
			'inline'  => true,
			'reset'   => true,
			'default' => true,
		];

		$this->controls['heading'] = [
			'tab'            => 'content',
			'group'          => 'header',
			'label'          => esc_html__( 'Heading Text', 'max-addons' ),
			'type'           => 'text',
			'spellcheck'     => true,
			'inlineEditing'  => false,
			'default'        => 'Trending Now',
			'hasDynamicData' => 'text',
			'inline'         => true,
			'required'       => [ 'showHeading', '!=', '' ],
		];

		$this->controls['headingIcon'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Icon', 'max-addons' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-announcement',
			],
			'required' => [ 'showHeading', '!=', '' ],
		];

		$this->controls['iconPosition'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Icon position', 'max-addons' ),
			'type'     => 'select',
			'options'  => [
				'top'    => esc_html__( 'Top', 'max-addons' ),
				'right'  => esc_html__( 'Right', 'max-addons' ),
				'bottom' => esc_html__( 'Bottom', 'max-addons' ),
				'left'   => esc_html__( 'Left', 'max-addons' ),
			],
			'inline'   => true,
			'default'  => 'left',
			'required' => [
				[ 'showHeading', '!=', '' ],
				[ 'headingIcon.icon', '!=', '' ],
			],
		];

		$this->controls['headingArrow'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Show Arrow', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'reset'    => true,
			'default'  => true,
			'required' => [ 'showHeading', '!=', '' ],
		];

		$this->controls['headingStyleSeparator'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Style', 'max-addons' ),
			'type'     => 'separator',
			'required' => [ 'showHeading', '!=', '' ],
		];

		$this->controls['headerTextAlignVertical'] = [
			'tab'         => 'content',
			'group'       => 'header',
			'label'       => esc_html__( 'Text align vertical', 'max-addons' ),
			'type'        => 'justify-content',
			'css'         => [
				[
					'property' => 'align-items',
					'selector' => '.mab-ticker-heading',
				],
			],
			'inline'      => true,
			'exclude'     => 'space',
			'placeholder' => esc_html__( 'Center', 'max-addons' ),
			'required'    => [ 'showHeading', '!=', '' ],
		];

		$this->controls['headerPadding'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'type'     => 'spacing',
			'label'    => esc_html__( 'Padding', 'max-addons' ),
			'css'      => [
				[
					'property' => 'padding',
					'selector' => '.mab-ticker-heading',
				],
			],
			'required' => [ 'showHeading', '!=', '' ],
		];

		$this->controls['headerBackgroundColor'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Background', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'css'      => [
				[
					'property' => 'background',
					'selector' => '.mab-ticker-heading',
				],
				[
					'property' => 'border-left-color',
					'selector' => '.mab-ticker-heading:after',
				],
			],
			'required' => [ 'showHeading', '!=', '' ],
		];

		$this->controls['headerTypography'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'type'     => 'typography',
			'label'    => esc_html__( 'Typography', 'max-addons' ),
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-ticker-heading-text',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [
				[ 'showHeading', '!=', '' ],
				[ 'heading', '!=', '' ],
			],
		];

		$this->controls['headerBorder'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'type'     => 'border',
			'label'    => esc_html__( 'Border', 'max-addons' ),
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-ticker-heading',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'showHeading', '!=', '' ],
		];

		$this->controls['headerWidth'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Width', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'width',
					'selector' => '.mab-ticker-heading',
				],
			],
			'required' => [ 'showHeading', '!=', '' ],
		];

		// Icon Style
		$this->controls['headingIconStyleSeparator'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Icon Style', 'max-addons' ),
			'type'     => 'separator',
			'required' => [
				[ 'showHeading', '!=', '' ],
				[ 'headingIcon.icon', '!=', '' ],
			],
		];

		$this->controls['headerIconTypography'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Icon Typography', 'max-addons' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-ticker-heading-icon',
				],
			],
			'exclude'  => [
				'font-family',
				'font-weight',
				'font-style',
				'text-align',
				'letter-spacing',
				'line-height',
				'text-transform',
				'text-decoration',
			],
			'inline'   => true,
			'small'    => true,
			'required' => [
				[ 'showHeading', '!=', '' ],
				[ 'headingIcon.icon', '!=', '' ],
			],
		];

		$this->controls['headerIconSpacing'] = [
			'tab'      => 'content',
			'group'    => 'header',
			'label'    => esc_html__( 'Icon spacing', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'   => [
				[
					'property' => 'margin-left',
					'selector' => '.mab-ticker-icon-right .mab-ticker-heading-icon',
				],
				[
					'property' => 'margin-right',
					'selector' => '.mab-ticker-icon-left .mab-ticker-heading-icon',
				],
				[
					'property' => 'margin-bottom',
					'selector' => '.mab-ticker-icon-top .mab-ticker-heading-icon',
				],
				[
					'property' => 'margin-top',
					'selector' => '.mab-ticker-icon-bottom .mab-ticker-heading-icon',
				],
			],
			'required' => [
				[ 'showHeading', '!=', '' ],
				[ 'headingIcon.icon', '!=', '' ],
			],
		];
	}

	// Set heading style controls
	public function set_ticker_setting_controls() {

		$this->controls['tickerDirection'] = [
			'tab'       => 'content',
			'group'     => 'tickerSettings',
			'label'     => esc_html__( 'Mode', 'max-addons' ),
			'type'      => 'select',
			'options'   => [
				'horizontal' => esc_html__( 'Horizontal', 'max-addons' ),
				'vertical'   => esc_html__( 'Vertical', 'max-addons' ),
				'fade'  	 => esc_html__( 'Fade', 'max-addons' ),
			],
			'inline'    => true,
			'clearable' => false,
			'default'   => 'vertical',
		];

		$this->controls['sliderSpeed'] = [
			'tab'         => 'content',
			'group'       => 'tickerSettings',
			'label'       => esc_html__( 'Slider Speed', 'max-addons' ),
			'description' => __( 'Duration of transition between slides (in ms)', 'max-addons' ),
			'type'        => 'number',
			'min'         => 100,
			'max'         => 3000,
			'step'        => 1,
			'inline'      => true,
			'default'     => 500,
		];

		$this->controls['infiniteLoop'] = [
			'tab'     => 'content',
			'group'   => 'tickerSettings',
			'label'   => esc_html__( 'Loop', 'max-addons' ),
			'type'    => 'checkbox',
			'default' => true,
			'inline'  => true,
			'reset'   => true,
		];

		$this->controls['autoPlay'] = [
			'tab'     => 'content',
			'group'   => 'tickerSettings',
			'label'   => esc_html__( 'Autoplay', 'max-addons' ),
			'type'    => 'checkbox',
			'inline'  => true,
			'reset'   => true,
		];

		$this->controls['pauseOnHover'] = [
			'tab'      => 'content',
			'group'    => 'tickerSettings',
			'label'    => esc_html__( 'Pause on Hover', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'reset'    => true,
			'required' => [ 'autoPlay', '!=', '' ],
		];

		$this->controls['autoplaySpeed'] = [
			'tab'      => 'content',
			'group'    => 'tickerSettings',
			'label'    => esc_html__( 'Autoplay Speed in Ms', 'max-addons' ),
			'type'     => 'number',
			'default'  => 4000,
			'min'      => 500,
			'max'      => 5000,
			'step'     => 1,
			'inline'   => true,
			'required' => [ 'autoPlay', '!=', '' ],
		];
	}

	// Set arrow style controls
	public function set_arrow_style_controls() {

		$this->controls['arrows'] = [
			'tab'       => 'content',
			'group'     => 'arrowsStyle',
			'label'     => esc_html__( 'Show Arrows', 'max-addons' ),
			'type'      => 'checkbox',
			'inline'    => true,
			'reset'     => true,
			'clearable' => false,
			'default'   => true,
		];

		$this->controls['arrowHeight'] = [
			'tab'         => 'content',
			'group'       => 'arrowsStyle',
			'label'       => esc_html__( 'Height in px', 'max-addons' ),
			'type'        => 'number',
			'unit'        => 'px',
			'css'         => [
				[
					'property' => 'height',
					'selector' => '.mab-slider-arrow',
				],
				[
					'property' => 'line-height',
					'selector' => '.mab-slider-arrow',
				],
			],
			'inline'      => true,
			'small'       => true,
			'placeholder' => 40,
			'required'    => [ 'arrows', '!=', '' ],
		];

		$this->controls['arrowWidth'] = [
			'tab'         => 'content',
			'group'       => 'arrowsStyle',
			'label'       => esc_html__( 'Width in px', 'max-addons' ),
			'type'        => 'number',
			'unit'        => 'px',
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.mab-slider-arrow',
				],
			],
			'inline'      => true,
			'small'       => true,
			'placeholder' => 40,
			'required'    => [ 'arrows', '!=', '' ],
		];

		$this->controls['arrowBackground'] = [
			'tab'      => 'content',
			'group'    => 'arrowsStyle',
			'label'    => esc_html__( 'Background', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.mab-slider-arrow',
				],
			],
			'required' => [ 'arrows', '!=', '' ],
		];

		$this->controls['arrowBorder'] = [
			'tab'      => 'content',
			'group'    => 'arrowsStyle',
			'type'     => 'border',
			'label'    => esc_html__( 'Border', 'max-addons' ),
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.mab-slider-arrow',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'arrows', '!=', '' ],
		];

		$this->controls['arrowTypography'] = [
			'tab'      => 'content',
			'group'    => 'arrowsStyle',
			'label'    => esc_html__( 'Typography', 'max-addons' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-slider-arrow',
				],
			],
			'exclude'  => [
				'font-family',
				'font-weight',
				'font-style',
				'text-align',
				'letter-spacing',
				'line-height',
				'text-transform',
				'text-decoration',
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'arrows', '!=', '' ],
		];

		$this->controls['prevArrow'] = [
			'tab'      => 'content',
			'group'    => 'arrowsStyle',
			'label'    => esc_html__( 'Prev arrow', 'max-addons' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-angle-left',
			],
			'required' => [ 'arrows', '!=', '' ],
		];

		$this->controls['nextArrow'] = [
			'tab'      => 'content',
			'group'    => 'arrowsStyle',
			'label'    => esc_html__( 'Next arrow', 'max-addons' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-angle-right',
			],
			'required' => [ 'arrows', '!=', '' ],
		];

		$this->controls['arrowSpacing'] = [
			'tab'      => 'content',
			'group'    => 'arrowsStyle',
			'label'    => esc_html__( 'Spacing', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'margin-right',
					'selector' => '.abx-prev',
				],
			],
			'required' => [ 'arrows', '!=', '' ],
		];
	}

	/**
	 * Slider Settings.
	 *
	 * @access public
	 */
	public function slider_settings() {
		$settings = $this->settings;

		$direction = ( isset( $settings['tickerDirection'] ) && 'fade' !== $settings['tickerDirection'] ) ? $settings['tickerDirection'] : 'horizontal';
		$effect    = ( isset( $settings['tickerDirection'] ) && 'fade' === $settings['tickerDirection'] ) ? 'fade' : 'slide';

		$options = [
			'direction'      => $direction,
			'effect'         => $effect,
			'speed'          => isset( $settings['speed'] ) ? intval( $settings['speed'] ) : 300,
			'autoHeight'     => true, // isset( $settings['adaptiveHeight'] ),
			'spaceBetween'   => isset( $settings['gutter'] ) ? intval( $settings['gutter'] ) : 0,
			'slidesPerView'  => 1,
			'slidesPerGroup' => 1,
			'loop'           => isset( $settings['infiniteLoop'] ),
		];

		if ( 'fade' === $effect ) {
			$options['fadeEffect'] = array(
				'crossFade' => true,
			);
		}

		if ( isset( $settings['autoPlay'] ) ) {
			$options['autoplay'] = [
				'delay'                => isset( $settings['autoplaySpeed'] ) ? intval( $settings['autoplaySpeed'] ) : 3000,
				'disableOnInteraction' => true,
			];

			// Custom as SwiperJS does not provide this option
			if ( isset( $settings['pauseOnHover'] ) ) {
				$options['pauseOnHover'] = true;
			}
		}

		// Arrow navigation
		if ( isset( $settings['arrows'] ) ) {
			$options['arrows'] = true;
		}

		// Dots
		if ( isset( $settings['dots'] ) ) {
			$options['pagination'] = [
				'el'   => '.swiper-pagination',
				'type' => 'bullets',
			];

			if ( isset( $settings['dotsDynamic'] ) ) {
				$options['dynamicBullets'] = true;
			}
		}

		$this->set_attribute( 'content-ticker', 'data-script-args', wp_json_encode( $options ) );
	}

	public function get_normalized_image_settings( $settings, $image_type ) {
		if ( ! isset( $image_type ) ) {
			$image_type = [
				'id'  => 0,
				'url' => '',
			];
			return $settings;
		}

		$image = $image_type;

		if ( isset( $image['useDynamicData']['name'] ) ) {
			$images = $this->render_dynamic_data_tag( $image['useDynamicData']['name'] );
			$image['id'] = empty( $images ) ? 0 : $images[0];
		} else {
			$image['id'] = isset( $image['id'] ) ? $image['id'] : 0;
		}

		// Image Size
		$image['size'] = isset( $image['size'] ) ? $image_type['size'] : BRICKS_DEFAULT_IMAGE_SIZE;

		// Image URL
		if ( ! isset( $image['url'] ) ) {
			$image['url'] = wp_get_attachment_image_url( $image['id'], $image['size'] );
		}

		$image_type = $image;

		return $settings;
	}

	// Render element HTML
	public function render_image( $image_type ) {
		$settings = $this->settings;
		$settings = $this->get_normalized_image_settings( $settings, $image_type );

		// Dynamic Data is empty
		if ( isset( $image_type['useDynamicData']['name'] ) ) {

			if ( empty( $settings[ $image_type ]['id'] ) ) {

				if ( 'ACF' === $settings[ $image_type ]['useDynamicData']['group'] && ! class_exists( 'ACF' ) ) {
					$message = esc_html__( 'Can\'t render element, as the selected ACF field is not available. Please activate ACF or edit the element to select different data.', 'max-addons' );
				} elseif ( '{featured_image}' == $settings[ $image_type ]['useDynamicData']['name'] ) {
					$message = esc_html__( 'No featured image set.', 'max-addons' );
				} else {
					$message = esc_html__( 'Dynamic Data %1$s (%2$s) is empty.', 'max-addons' );
				}

				return $this->render_element_placeholder( [
					'icon-class' => 'ti-image',
					'title'      => sprintf(
						$message,
						$settings[ $image_type ]['useDynamicData']['label'],
						$settings[ $image_type ]['useDynamicData']['group']
					),
				] );
			}
		}

		// Image id is empty or doesn't exist
		else {

			// No image
			if ( empty( $image_type['id'] ) ) {
				return $this->render_element_placeholder( [
					'icon-class' => 'ti-image',
					'title'      => esc_html__( 'No image selected.', 'max-addons' ),
				] );
			}

			// Return if image ID does not exist
			if ( ! wp_get_attachment_image_src( $image_type['id'] ) ) {
				return $this->render_element_placeholder( [
					'icon-class' => 'ti-image',
					'title'      => sprintf( esc_html__( 'Image ID (%s) no longer exist. Please select another image.', 'max-addons' ), $settings[ $image_type ]['id'] ),
				] );
			}
		}

		$image_atts = [];
		$image_atts['id'] = 'image-' . $image_type['id'];

		$image_wrapper_classes = [ 'image-wrapper' ];
		$img_classes = [ 'post-thumbnail', 'css-filter' ];

		$img_classes[] = 'size-' . $image_type['size'];
		$image_atts['class'] = join( ' ', $img_classes );

		if ( isset( $image_type['id'] ) ) {
			$show_image = wp_get_attachment_image( $image_type['id'], $image_type['size'], false, $image_atts );
		} elseif ( ! empty( $image_type['url'] ) ) {
			$show_image = '<img src="' . $image_type['url'] . '">';
		}

		return $show_image;
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
		$index    = $this->loop_index;
		$output   = '';

		$this->set_attribute( "items-$index", 'class', [ 'repeater-item', 'swiper-slide' ] );

		$this->set_attribute( "ticker-title-$index", 'class', 'mab-ticker-item-title' );

		// Link
		if ( isset( $item['link'] ) ) {
			$link_key = "link-{$index}";
			$this->set_link_attributes( $link_key, $item['link'] );
		}

		$title_tag = isset( $settings['titleHtmlTag'] ) ? $settings['titleHtmlTag'] : 'h4';

		$output .= '<div ' . wp_kses_post( $this->render_attributes( "items-$index" ) ) . '>';
			$output .= '<div class="mab-ticker-content">';
				if ( isset( $item['image'] ) && ! empty( $item['image'] ) ) {
					$output .= '<div class="mab-ticker-image">';
						if ( ( isset( $settings['applyLinkTo'] ) && ( 'image' === $settings['applyLinkTo'] || 'both' === $settings['applyLinkTo'] ) ) && isset( $item['link'] ) ) {
							$output .= '<a ' . wp_kses_post( $this->render_attributes( $link_key ) ) . '>';
							$output .= $this->render_image( $item['image'] );
							$output .= '</a>';
						} else {
							$output .= $this->render_image( $item['image'] );
						}
					$output .= '</div>';
				}

				if ( $item['tickerTitle'] ) {
					$output .= '<' . esc_html( $title_tag ) . ' ' .  wp_kses_post( $this->render_attributes( "ticker-title-$index" ) ) . '>';
					if ( ( isset( $settings['applyLinkTo'] ) && ( 'title' === $settings['applyLinkTo'] || 'both' === $settings['applyLinkTo'] ) ) && isset( $item['link'] ) ) {
						$output .= '<a ' . wp_kses_post( $this->render_attributes( $link_key ) ) . '>';
						$output .= wp_kses_post( $item['tickerTitle'] );
						$output .= '</a>';
					} else {
						$output .= wp_kses_post( $item['tickerTitle'] );
					}
					$output .= '</' . esc_html( $title_tag ) . '>';
				}
			$output .= '</div>';
		$output .= '</div>';

		$this->loop_index++;

		return $output;
	}

	public function render() {
		$settings = $this->settings;

		$ticker = empty( $settings['items'] ) ? false : $settings['items'];

		if ( ! $ticker ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No ticker item added.', 'max-addons' ),
				]
			);
		}

		if ( isset( $settings['showHeading'] ) && isset( $settings['headingArrow'] ) ) {
			$this->set_attribute( '_root', 'class', 'mab-ticker-heading-arrow' );
		}

		if ( isset( $settings['tickerDirection'] ) ) {
			$this->set_attribute( '_root', 'class', 'mab-ticker-' . $settings['tickerDirection'] );
		}

		$this->set_attribute( 'content-ticker', 'class', 'mab-ticker bricks-swiper-container' );
		$this->set_attribute( 'content-ticker', 'id', 'mab-ticker-' . esc_attr( $this->id ) );

		$this->slider_settings();

		$icon_html = isset( $settings['headingIcon'] ) ? self::render_icon( $settings['headingIcon'] ) : false;
		$icon_position = isset( $settings['iconPosition'] ) ? $settings['iconPosition'] : 'right';
		$has_heading_text = isset( $settings['heading'] );
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?>>
			<?php if ( isset( $settings['showHeading'] ) ) { ?>
				<?php if ( $icon_html || $has_heading_text ) { ?>
					<div class="mab-ticker-heading mab-ticker-icon-<?php echo $icon_position; ?> ">
						<?php if ( $icon_html ) { ?>
							<span class="mab-ticker-heading-icon">
								<?php echo wp_kses_post( $icon_html ); ?>
							</span>	
						<?php } ?>
						<?php if ( $has_heading_text ) { ?>
							<span class="mab-ticker-heading-text">
								<?php echo wp_kses_post( $settings['heading'] ); ?>
							</span>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } ?>
			<div <?php echo wp_kses_post( $this->render_attributes( 'content-ticker' ) ); ?>>
				<div class="swiper-wrapper">
					<?php
					$output = '';

					// Query Loop
					if ( isset( $settings['hasLoop'] ) ) {
						$query = new \Bricks\Query( [
							'id'       => $this->id,
							'settings' => $settings,
						] );

						$item = $ticker[0];

						$output .= $query->render( [ $this, 'render_repeater_item' ], compact( 'item' ) );

						// We need to destroy the Query to explicitly remove it from the global store
						$query->destroy();
						unset( $query );
					} else {
						foreach ( $ticker as $index => $item ) {
							$output .= self::render_repeater_item( $item );
						}
					}

					echo $output;
					?>
				</div>
			</div>
			<?php if ( isset( $settings['arrows'] ) ) { ?>
				<div class="mab-ticker-navigation">
				<?php
					echo $this->render_swiper_nav();
				?>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Render content ticker arrows output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_arrows() {
		$settings = $this->settings;

		if ( isset( $settings['arrows'] ) ) {
			if ( isset( $settings['prevArrow'] ) ) {
				$prev_arrow = self::render_icon( $settings['prevArrow'] );

				if ( $prev_arrow ) {
					echo '<div id="bx-prev-' . esc_attr( $this->id ) . '" class="mab-slider-arrow abx-prev bx-button-prev-' . esc_attr( $this->id ) . '" data-prev-icon="'.esc_attr($prev_arrow).'"></div>';
				}
			}

			if ( isset( $settings['nextArrow'] ) ) {
				$next_arrow = self::render_icon( $settings['nextArrow'] );

				if ( $next_arrow ) {
					echo '<div id="bx-next-' . esc_attr( $this->id ) . '" class="mab-slider-arrow abx-next bx-button-next-' . esc_attr( $this->id ) . '" data-next-icon="'.esc_attr($next_arrow).'"></div>';
				}
			}
		}
	}
}
