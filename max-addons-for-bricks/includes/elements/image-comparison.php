<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Image_Comparison_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-image-comparison'; // Make sure to prefix your elements
	public $icon         = 'ti-image max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = [ 'mabImageComparison' ]; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Image Comparison', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-image-comparison' );
		wp_enqueue_script( 'image-compare' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->controls['text'] = [ // Unique group identifier (lowercase, no spaces)
			'title' => esc_html__( 'Text', 'max-addons' ), // Localized control group title
			'tab'   => 'content', // Set to either "content" or "style"
		];

		$this->control_groups['before'] = [
			'title' => esc_html__( 'Before Image', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['after'] = [
			'title' => esc_html__( 'After Image', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['labels'] = [
			'title' => esc_html__( 'Labels', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['handle'] = [
			'title' => esc_html__( 'Handle', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	// Set builder controls
	public function set_controls() {

		$this->set_before_image_controls();

		$this->set_after_image_controls();

		$this->set_labels_controls();

		$this->set_handle_controls();

		$this->set_settings_controls();
	}

	// Set before controls
	public function set_before_image_controls() {
		$this->controls['beforeImage'] = [
			'tab'   => 'content',
			'group' => 'before',
			'type'  => 'image',
			'label' => esc_html__( 'Image', 'max-addons' ),
		];

		$this->controls['beforeLabel'] = [
			'tab'     => 'content',
			'group'   => 'before',
			'type'    => 'text',
			'label'   => esc_html__( 'Label', 'max-addons' ),
			'default' => esc_html__( 'Before', 'max-addons' ),
		];

		$this->controls['beforeImageFilters'] = [
			'tab'    => 'content',
			'group'  => 'before',
			'label'  => esc_html__( 'CSS filters', 'max-addons' ),
			'type'   => 'filters',
			'inline' => true,
			'css'    => [
				[
					'property' => 'filter',
					'selector' => '.max-ic-img-before',
				],
			],
		];
	}

	// Set after controls
	public function set_after_image_controls() {
		$this->controls['afterImage'] = [
			'tab'   => 'content',
			'group' => 'after',
			'type'  => 'image',
			'label' => esc_html__( 'Image', 'max-addons' ),
		];

		$this->controls['afterLabel'] = [
			'tab'     => 'content',
			'group'   => 'after',
			'type'    => 'text',
			'label'   => esc_html__( 'Label', 'max-addons' ),
			'default' => esc_html__( 'After', 'max-addons' ),
		];

		$this->controls['afterImageFilters'] = [
			'tab'    => 'content',
			'group'  => 'after',
			'label'  => esc_html__( 'CSS filters', 'max-addons' ),
			'type'   => 'filters',
			'inline' => true,
			'css'    => [
				[
					'property' => 'filter',
					'selector' => '.max-ic-img-after',
				],
			],
		];
	}

	// Set labels controls
	public function set_labels_controls() {

		$this->controls['showLabels'] = [
			'tab'    => 'content',
			'group'  => 'labels',
			'label'  => esc_html__( 'Show Labels', 'max-addons' ),
			'type'   => 'checkbox',
			'inline' => true,
			'small'  => true,
		];

		$this->controls['labelsTypography'] = [
			'tab'      => 'style',
			'group'    => 'labels',
			'type'     => 'typography',
			'label'    => esc_html__( 'Typography', 'max-addons' ),
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.max-ic-label',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'showLabels', '=', true ],
		];

		$this->controls['labelsBackgroundColor'] = [
			'tab'      => 'style',
			'group'    => 'labels',
			'type'     => 'color',
			'label'    => esc_html__( 'Background', 'max-addons' ),
			'css'      => [
				[
					'property' => 'background-color',
					'selector' => '.max-ic-label',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'showLabels', '=', true ],
		];

		$this->controls['labelsBorder'] = [
			'tab'      => 'style',
			'group'    => 'labels',
			'type'     => 'border',
			'label'    => esc_html__( 'Border', 'max-addons' ),
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.max-ic-label',
				],
			],
			'inline'   => true,
			'small'    => true,
			'required' => [ 'showLabels', '=', true ],
		];

		$this->controls['labelsBoxShadow'] = [
			'tab'      => 'content',
			'group'    => 'labels',
			'label'    => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'     => 'box-shadow',
			'css'      => [
				[
					'property' => 'box-shadow',
					'selector' => '.max-ic-label',
				],
			],
			'inline'   => true,
			'small'    => true,
			'default'  => [
				'values' => [
					'offsetX' => 0,
					'offsetY' => 0,
					'blur'    => 2,
					'spread'  => 0,
				],
				'color'  => [
					'rgb' => 'rgba(0, 0, 0, .1)',
				],
			],
			'required' => [ 'showLabels', '=', true ],
		];

		$this->controls['labelsPadding'] = [
			'tab'      => 'content',
			'group'    => 'labels',
			'label'    => esc_html__( 'Padding', 'max-addons' ),
			'type'     => 'spacing',
			'css'      => [
				[
					'property' => 'padding',
					'selector' => '.max-ic-label',
				],
			],
			'required' => [ 'showLabels', '=', true ],
		];

		$this->controls['labelsPositionHorizontal'] = [
			'tab'      => 'content',
			'group'    => 'labels',
			'label'    => esc_html__( 'Position', 'max-addons' ),
			'type'     => 'justify-content',
			'exclude'  => 'space',
			'css'      => [
				[
					'property' => 'justify-content',
				],
			],
			'required' => [ 'orientation', '=', 'vertical' ],
		];

		$this->controls['labelsPositionVertical'] = [
			'tab'      => 'content',
			'group'    => 'labels',
			'label'    => esc_html__( 'Position', 'max-addons' ),
			'type'     => 'align-items',
			'exclude'  => 'stretch',
			'css'      => [
				[
					'property' => 'align-items',
				],
			],
			'required' => [ 'orientation', '=', 'horizontal' ],
		];

		$this->controls['labelsMargin'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'label' => esc_html__( 'Margin', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'selector' => '.max-ic-label',
					'property' => 'margin',
				],
			],
		];
	}

	// Set handle controls
	public function set_handle_controls() {

		$this->controls['handleColor'] = [
			'tab'    => 'content',
			'group'  => 'handle',
			'type'   => 'color',
			'label'  => esc_html__( 'Handle Color', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border-color',
					'selector' => '.max-ic-circle',
				],
				[
					'property' => 'background-color',
					'selector' => '.max-ic-control-line',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['arrowsColor'] = [
			'tab'    => 'content',
			'group'  => 'handle',
			'type'   => 'color',
			'label'  => esc_html__( 'Arrows Color', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border-bottom-color',
					'selector' => '&.max-ic-vertical .max-ic-arrow-left',
				],
				[
					'property' => 'border-top-color',
					'selector' => '&.max-ic-vertical .max-ic-arrow-right',
				],
				[
					'property' => 'border-right-color',
					'selector' => '&.max-ic-horizontal .max-ic-arrow-left',
				],
				[
					'property' => 'border-left-color',
					'selector' => '&.max-ic-horizontal .max-ic-arrow-right',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['circleBackgroundColor'] = [
			'tab'    => 'content',
			'group'  => 'handle',
			'type'   => 'color',
			'label'  => esc_html__( 'Circle Background Color', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.max-ic-circle',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['circleSize'] = [
			'tab'     => 'content',
			'group'   => 'handle',
			'label'   => esc_html__( 'Circle Size', 'max-addons' ),
			'type'    => 'number',
			'units'   => true,
			'css'     => [
				[
					'property' => 'width',
					'selector' => '.max-ic-circle',
				],
				[
					'property' => 'height',
					'selector' => '.max-ic-circle',
				],
			],
			'default' => '50px',
		];

		$this->controls['handleThickness'] = [
			'tab'     => 'content',
			'group'   => 'handle',
			'label'   => esc_html__( 'Handle Thickness', 'max-addons' ),
			'type'    => 'number',
			'units'   => true,
			'css'     => [
				[
					'property' => 'width',
					'selector' => '&.max-ic-horizontal .max-ic-control-line',
				],
				[
					'property' => 'border-width',
					'selector' => '.max-ic-circle',
				],
				[
					'property' => 'height',
					'selector' => '&.max-ic-vertical .max-ic-control-line',
				],
			],
			'default' => '3px',
		];
	}

	// Set settings controls
	public function set_settings_controls() {

		$this->controls['startingPoint'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Visible Ratio', 'max-addons' ),
			'type'    => 'number',
			'min'     => 0,
			'max'     => 100,
			'step'    => '5',
			'inline'  => true,
			'default' => 50,
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
			'clearable'   => false,
			'pasteStyles' => false,
			'default'     => 'horizontal',
		];

		$this->controls['moveSlider'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Move Slider', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'drag'       => esc_html__( 'Drag', 'max-addons' ),
				'mouse_move' => esc_html__( 'Mouse Move', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => false,
			'pasteStyles' => false,
			'default'     => 'drag',
		];
	}

	public function get_normalized_image_settings( $settings, $image_type ) {
		if ( ! isset( $settings[ $image_type ] ) ) {
			$settings[ $image_type ] = [
				'id'  => 0,
				'url' => '',
			];
			return $settings;
		}

		$image = $settings[ $image_type ];

		if ( isset( $image['useDynamicData']['name'] ) ) {
			$images = $this->render_dynamic_data_tag( $image['useDynamicData']['name'], $image_type, [ 'size' => $image['size'] ] );
			$image['id'] = empty( $images ) ? 0 : $images[0];
		} else {
			$image['id'] = isset( $image['id'] ) ? $image['id'] : 0;
		}

		// Image Size
		$image['size'] = isset( $image['size'] ) ? $settings[ $image_type ]['size'] : BRICKS_DEFAULT_IMAGE_SIZE;

		// Image URL
		if ( ! isset( $image['url'] ) ) {
			$image['url'] = wp_get_attachment_image_url( $image['id'], $image['size'] );
		}

		$settings[ $image_type ] = $image;

		return $settings;
	}

	// Print no image message in editor
	public function no_image_message( $image_type ) {
		$settings = $this->settings;
		$settings = $this->get_normalized_image_settings( $settings, $image_type );
		$no_image_message = '';

		if ( isset( $settings[ $image_type ]['useDynamicData']['name'] ) ) {

			if ( empty( $settings[ $image_type ]['id'] ) ) {

				if ( 'ACF' === $settings[ $image_type ]['useDynamicData']['group'] && ! class_exists( 'ACF' ) ) {
					$message = esc_html__( 'Can\'t render element, as the selected ACF field is not available. Please activate ACF or edit the element to select different data.', 'max-addons' );
				} elseif ( '{featured_image}' == $settings[ $image_type ]['useDynamicData']['name'] ) {
					$message = esc_html__( 'No featured image set.', 'max-addons' );
				} else {
					$message = esc_html__( 'Dynamic Data %1$s (%2$s) is empty.', 'max-addons' );
				}

				return $no_image_message = sprintf( $message, '"' . $settings[ $image_type ]['useDynamicData']['label'] . '"', $settings[ $image_type ]['useDynamicData']['group'] );
			}
		} else {
			// No image
			if ( empty( $settings[ $image_type ]['id'] ) ) {
				$no_image_type = ucfirst( str_replace('Image','',$image_type) );
				$message = esc_html__( '"%1$s Image" is not selected.', 'max-addons' );

				return $no_image_message = sprintf( $message, $no_image_type );
			}

			// Return if image ID does not exist
			if ( ! wp_get_attachment_image_src( $settings[ $image_type ]['id'] ) ) {
				return $no_image_message = sprintf( esc_html__( 'Image ID (%s) no longer exist. Please select another image.', 'max-addons' ), $settings[ $image_type ]['id'] );
			}
		}

		return $no_image_message;
	}

	// Render element HTML
	public function render_image( $image_type ) {
		$settings = $this->settings;
		$settings = $this->get_normalized_image_settings( $settings, $image_type );

		// Dynamic Data is empty
		if ( isset( $settings[ $image_type ]['useDynamicData']['name'] ) ) {

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
					'title'      => sprintf( $message, '"' . $settings[ $image_type ]['useDynamicData']['label'] . '"', $settings[ $image_type ]['useDynamicData']['group'] ),
				] );
			}
		} else {
			// Image id is empty or doesn't exist

			// No image
			if ( empty( $settings[ $image_type ]['id'] ) ) {
				return $this->render_element_placeholder( [
					'icon-class' => 'ti-image',
					'title'      => esc_html__( 'No image selected.', 'max-addons' ),
				] );
			}

			// Return if image ID does not exist
			if ( ! wp_get_attachment_image_src( $settings[ $image_type ]['id'] ) ) {
				return $this->render_element_placeholder( [
					'icon-class' => 'ti-image',
					'title'      => sprintf( esc_html__( 'Image ID (%s) no longer exist. Please select another image.', 'max-addons' ), $settings[ $image_type ]['id'] ),
				] );
			}
		}

		$image_atts = [];
		$image_atts['id'] = 'image-' . $settings[ $image_type ]['id'];

		$image_wrapper_classes = [ 'image-wrapper' ];
		$img_classes = [ 'post-thumbnail', 'css-filter' ];

		$img_classes[] = 'size-' . $settings[ $image_type ]['size'];
		$image_atts['class'] = join( ' ', $img_classes );

		if ( isset( $settings[ $image_type ]['id'] ) ) {
			echo wp_get_attachment_image( $settings[ $image_type ]['id'], $settings[ $image_type ]['size'], false, $image_atts );
		} elseif ( ! empty( $settings[ $image_type ]['url'] ) ) {
			echo '<img src="' . esc_url( $settings[ $image_type ]['url'] ) . '">';
		}
	}

	// Render element HTML
	public function render() {
		$settings = $this->settings;

		$no_before_image_message = $this->no_image_message( 'beforeImage' );
		$no_after_image_message  = $this->no_image_message( 'afterImage' );

		if ( $no_before_image_message ) {
			return $this->render_element_placeholder( [
				'icon-class' => 'ti-image',
				'title'      => $no_before_image_message,
			] );
		}

		if ( $no_after_image_message ) {
			return $this->render_element_placeholder( [
				'icon-class' => 'ti-image',
				'title'      => $no_after_image_message,
			] );
		}

		// Set element attributes
		$this->set_attribute( '_root', 'class', 'mab-image-comparison' );

		$before_label = isset( $settings['beforeLabel'] ) ? esc_attr( $settings['beforeLabel'] ) : '';
		$after_label  = isset( $settings['afterLabel'] ) ? esc_attr( $settings['afterLabel'] ) : '';

		$before_label_classes[] = 'max-ic-label max-ic-label-before keep';
		$after_label_classes[] = 'max-ic-label max-ic-label-after keep';

		if ( isset( $settings['orientation'] ) && 'vertical' === $settings['orientation'] ) {
			$before_label_classes[] = 'vertical';
			$after_label_classes[] = 'vertical';
		}

		$this->set_attribute( 'before-label', 'class', $before_label_classes );
		$this->set_attribute( 'after-label', 'class', $after_label_classes );

		$widget_options = [
			'startingPoint' => isset( $settings['startingPoint'] ) ? intval( $settings['startingPoint'] ) : 50,
			'verticalMode'  => ( isset( $settings['orientation'] ) && 'horizontal' === $settings['orientation'] ) ? false : true,
			'hoverStart'    => 'mouse_move' === $settings['moveSlider'] ? true : false,
			'showLabels'    => false,
			'addCircle'     => true,
			'addCircleBlur' => false,
		];
		?>
		<div <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?> data-settings='<?php echo wp_json_encode( $widget_options ); ?>'>
			<?php $this->render_image( 'beforeImage' ); ?>
			<?php
			if ( isset( $settings['showLabels'] ) ) {
				if ( isset( $settings['beforeLabel'] ) ) {
					echo '<span ' . wp_kses_post( $this->render_attributes( 'before-label' ) ) . '>';
					echo esc_html( $settings['beforeLabel'] );
					echo '</span>';
				}
				if ( isset( $settings['afterLabel'] ) ) {
					echo '<span ' . wp_kses_post( $this->render_attributes( 'after-label' ) ) . '>';
					echo esc_html( $settings['afterLabel'] );
					echo '</span>';
				}
			}
			?>
			<?php $this->render_image( 'afterImage' ); ?>
		</div>
		<?php
	}
}
