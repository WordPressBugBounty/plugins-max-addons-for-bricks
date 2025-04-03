<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Unfold_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-unfold'; // Make sure to prefix your elements
	public $icon         = 'ti-folder max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = [ 'mabUnfold' ]; // Script(s) run when element is rendered on frontend or updated in builder
	public $nestable     = true;

	public function get_label() {
		return esc_html__( 'Unfold', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-unfold' );
		wp_enqueue_script( 'mab-unfold' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['contentSettings'] = [
			'title' => esc_html__( 'Content', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['separator'] = [
			'title' => esc_html__( 'Separator', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['button'] = [
			'title' => esc_html__( 'Button', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'max-addons' ),
			'tab'   => 'content',
		];

		unset( $this->control_groups['_typography'] );
	}

	public function set_controls() {

		$this->controls['_background']['css'][0]['selector'] = '';
		$this->controls['_gradient']['css'][0]['selector'] = '';

		$this->set_content_controls();
		$this->set_separator_controls();
		$this->set_button_controls();
		$this->set_settings_controls();
	}

	// Set content controls
	public function set_content_controls() {

		$this->controls['contentType'] = [
			'tab'       => 'content',
			'group'     => 'contentSettings',
			'label'     => esc_html__( 'Content Type', 'max-addons' ),
			'type'      => 'select',
			'default'   => 'editor',
			'options'   => [
				'editor' => esc_html__( 'Text Editor', 'max-addons' ),
				'nested' => esc_html__( 'Nested Elements', 'max-addons' ),
			],
			'inline'    => true,
			'clearable' => false,
		];

		$this->controls['content'] = [
			'tab'      => 'content',
			'group'    => 'contentSettings',
			'label'    => esc_html__( 'Content', 'max-addons' ),
			'type'     => 'editor',
			'default'  => '<p>Nam condimentum et quam in dignissim. Integer in ante diam. Nunc leo sem, dignissim in finibus at, pretium sit amet neque. Nunc sed turpis volutpat, molestie tortor eu, pretium nisl. Quisque vitae leo augue. Aliquam venenatis sagittis magna nec ullamcorper. Aenean sollicitudin fermentum felis, eget vulputate risus. Sed sit amet sem ac ipsum ornare lacinia. In mi felis, egestas at fringilla non, posuere vitae tortor.</p>',
			'required' => [ 'contentType', '!=', 'nested' ],
		];

		$this->controls['contentTypography'] = [
			'tab'    => 'content',
			'group'  => 'contentSettings',
			'type'   => 'typography',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-unfold-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentBackgroundColor'] = [
			'tab'    => 'content',
			'group'  => 'contentSettings',
			'type'   => 'color',
			'label'  => esc_html__( 'Background Color', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.mab-unfold-content',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['contentPadding'] = [
			'tab'   => 'content',
			'group' => 'contentSettings',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-unfold-content',
				],
			],
		];
	}

	// Set background text controls
	public function set_separator_controls() {

		$this->controls['separator'] = [
			'tab'     => 'content',
			'group'   => 'separator',
			'label'   => esc_html__( 'Show separator', 'max-addons' ),
			'type'    => 'checkbox',
			'default' => true, // Default: false
		];

		$this->controls['separatorHeight'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Height', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'default'  => '50px',
			'css'      => [
				[
					'property' => 'height',
					'selector' => '.mab-unfold-saparator',
				],
			],
			'required' => [ 'separator', '!=', '' ],
		];

		$this->controls['separatorBackground'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Background', 'max-addons' ),
			'type'     => 'gradient',
			'css'      => [
				[
					'property' => 'background-image',
					'selector' => '.mab-unfold-saparator',
				],
			],
			'required' => [ 'separator', '!=', '' ],
		];
	}

	// Set background text controls
	public function set_button_controls() {

		$this->controls['buttonAlign'] = [
			'tab'     => 'content',
			'group'   => 'button',
			'label'   => esc_html__( 'Alignment', 'max-addons' ),
			'type'    => 'justify-content',
			'css'     => [
				[
					'property' => 'justify-content',
					'selector' => '.mab-unfold-buttons-wrapper',
				],
			],
			'inline'  => true,
			'default' => 'center',
			'exclude' => [
				'space',
			],
		];

		// Content Unfold
		$this->controls['contentUnfoldSeparator'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Unfold', 'max-addons' ),
			'type'  => 'separator',
		];

		$this->controls['buttonTextOpen'] = [
			'tab'            => 'content',
			'group'          => 'button',
			'type'           => 'text',
			'label'          => esc_html__( 'Text', 'max-addons' ),
			'default'        => esc_html__( 'Read More', 'max-addons' ),
			'placeholder'    => esc_html__( 'Read More', 'max-addons' ),
			'hasDynamicData' => 'text',
			'inline'         => true,
		];

		$this->controls['buttonIconOpen'] = [
			'tab'     => 'content',
			'group'   => 'button',
			'label'   => esc_html__( 'Icon', 'max-addons' ),
			'type'    => 'icon',
			'default' => [
				'library' => 'themify',
				'icon'    => 'ti-angle-down',
			],
			'css'     => [
				[
					'selector' => '.icon-svg',
				],
			],
		];

		// Content Fold
		$this->controls['contentFoldSeparator'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Fold', 'max-addons' ),
			'type'  => 'separator',
		];

		$this->controls['buttonTextClosed'] = [
			'tab'            => 'content',
			'group'          => 'button',
			'type'           => 'text',
			'label'          => esc_html__( 'Text', 'max-addons' ),
			'default'        => esc_html__( 'Read Less', 'max-addons' ),
			'placeholder'    => esc_html__( 'Read Less', 'max-addons' ),
			'hasDynamicData' => 'text',
			'inline'         => true,
		];

		$this->controls['buttonIconClosed'] = [
			'tab'     => 'content',
			'group'   => 'button',
			'label'   => esc_html__( 'Icon', 'max-addons' ),
			'type'    => 'icon',
			'default' => [
				'library' => 'themify',
				'icon'    => 'ti-angle-up',
			],
			'css'     => [
				[
					'selector' => '.icon-svg',
				],
			],
		];

		// Content Reveal
		$this->controls['buttonSettingSeparator'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Button Style', 'max-addons' ),
			'type'  => 'separator',
		];

		$this->controls['buttonIconTypography'] = [
			'tab'     => 'content',
			'group'   => 'button',
			'label'   => esc_html__( 'Icon Typography', 'max-addons' ),
			'type'    => 'typography',
			'css'     => [
				[
					'property' => 'font',
					'selector' => '.mab-unfold-button i',
				],
			],
			'exclude' => [
				'font-family',
				'font-weight',
				'font-style',
				'text-align',
				'text-decoration',
				'text-transform',
				'line-height',
				'letter-spacing',
			],
			'inline'  => true,
			'small'   => true,
		];

		$this->controls['buttonIconPosition'] = [
			'tab'         => 'content',
			'group'       => 'button',
			'label'       => esc_html__( 'Icon Position', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['iconPosition'],
			'inline'      => true,
			'placeholder' => esc_html__( 'Right', 'max-addons' ),
		];

		$this->controls['buttonSize'] = [
			'tab'         => 'content',
			'group'       => 'button',
			'label'       => esc_html__( 'Size', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['buttonSizes'],
			'inline'      => true,
			'reset'       => true,
			'placeholder' => esc_html__( 'Medium', 'max-addons' ),
		];

		$this->controls['buttonStyle'] = [
			'tab'         => 'content',
			'group'       => 'button',
			'label'       => esc_html__( 'Style', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['styles'],
			'inline'      => true,
			'reset'       => true,
			'default'     => 'primary',
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['buttonCircle'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Circle', 'max-addons' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['buttonOutline'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Outline', 'max-addons' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['buttonBorder'] = [
			'tab'    => 'content',
			'group'  => 'button',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons' ),
			'css'    => [
				[
					'property' => 'border',
					'selector' => '.mab-unfold-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonBoxShadow'] = [
			'tab'    => 'content',
			'group'  => 'button',
			'label'  => esc_html__( 'Box Shadow', 'max-addons' ),
			'type'   => 'box-shadow',
			'css'    => [
				[
					'property' => 'box-shadow',
					'selector' => '.mab-unfold-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonTypography'] = [
			'tab'    => 'content',
			'group'  => 'button',
			'type'   => 'typography',
			'label'  => esc_html__( 'Typography', 'max-addons' ),
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-unfold-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonBackground'] = [
			'tab'    => 'content',
			'group'  => 'button',
			'type'   => 'color',
			'label'  => esc_html__( 'Background', 'max-addons' ),
			'css'    => [
				[
					'property' => 'background-color',
					'selector' => '.mab-unfold-button',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['buttonPadding'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Padding', 'max-addons' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.mab-unfold-button',
				],
			],
		];

		$this->controls['spacing'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Spacing', 'max-addons' ),
			'type'  => 'number',
			'units' => true,
			'css'   => [
				[
					'property' => 'margin-top',
					'selector' => '.mab-unfold-buttons-wrapper',
				],
			],
		];
	}

	// Set settings controls
	public function set_settings_controls() {

		$this->controls['speedUnreveal'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Transition Speed in Seconds', 'max-addons' ),
			'type'    => 'number',
			'min'     => 0.1,
			'min'     => 2,
			'step'    => 0.1,
			'default' => 0.5,
			'inline'  => true,
			'small'   => true,
		];

		$this->controls['visibleType'] = [
			'tab'       => 'content',
			'group'     => 'settings',
			'label'     => esc_html__( 'Content Visibility By', 'max-addons' ),
			'type'      => 'select',
			'default'   => 'pixels',
			'options'   => [
				'lines'  => esc_html__( 'Lines', 'max-addons' ),
				'pixels' => esc_html__( 'Pixels', 'max-addons' ),
			],
			'inline'    => true,
			'clearable' => false,
		];

		$this->controls['visibleAmount'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Visible Amount in Px', 'max-addons' ),
			'type'     => 'number',
			'min'      => 10,
			'max'      => 200,
			'step'     => '1',
			'inline'   => true,
			'default'  => 50,
			'required' => [ 'visibleType', '=', 'pixels' ],
		];

		$this->controls['visibleLines'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Visible Amount in Lines', 'max-addons' ),
			'type'     => 'number',
			'min'      => 1,
			'max'      => 20,
			'step'     => '1',
			'inline'   => true,
			'default'  => 2,
			'required' => [ 'visibleType', '=', 'lines' ],
		];
	}

	public function render() {
		$settings = $this->settings;

		$content_type   = isset( $settings['contentType'] ) ? $settings['contentType'] : 'editor';
		$visibility     = ( 'editor' === $content_type ) ? ( isset( $settings['visibleType'] ) ? $settings['visibleType'] : 'pixels' ) : 'pixels';
		$visible_amount = isset( $settings['visibleAmount'] ) ? $settings['visibleAmount'] : '50';
		$visible_lines  = isset( $settings['visibleLines'] ) ? $settings['visibleLines'] : '2';

		// Element placeholder
		if ( 'nested' !== $content_type ) {
			if ( ! isset( $settings['content'] ) || empty( $settings['content'] ) ) {
				return $this->render_element_placeholder( [ 'title' => esc_html__( 'No content added.', 'max-addons' ) ] );
			}
		}

		$mab_unfold_options = array(
			'content_type' => $content_type,
			'speed'        => isset( $settings['speedUnreveal'] ) ? $settings['speedUnreveal'] : '',
			'visibility'   => $visibility,
		);

		if ( 'pixels' === $visibility ) {
			$mab_unfold_options['content_height'] = $visible_amount;
		}

		if ( 'lines' === $visibility ) {
			$mab_unfold_options['lines'] = $visible_lines;
		}

		$this->set_attribute( '_root', 'data-unfold', wp_json_encode( $mab_unfold_options ) );

		$this->set_attribute( 'wrapper', 'class', 'mab-unfold-content-wrapper' );

		$button_classes[] = 'bricks-button mab-unfold-button';

		if ( isset( $settings['buttonSize'] ) ) {
			$button_classes[] = $settings['buttonSize'];
		}

		if ( isset( $settings['buttonStyle'] ) ) {
			// Outline
			if ( isset( $settings['buttonOutline'] ) ) {
				$button_classes[] = 'buttonOutline outline';
				$button_classes[] = 'bricks-color-' . $settings['buttonStyle'];
			} else {
				// Fill (default)
				$button_classes[] = 'bricks-background-' . $settings['buttonStyle'];
			}
		}

		// Button circle
		if ( isset( $settings['buttonCircle'] ) ) {
			$button_classes[] = 'buttonCircle circle';
		}

		if ( isset( $settings['block'] ) ) {
			$button_classes[] = 'block';
		}

		$this->set_attribute( 'buttonInner', 'class', 'mab-unfold-button-inner' );

		$icon_position = isset( $settings['buttonIconPosition'] ) ? $settings['buttonIconPosition'] : 'right';

		if ( isset( $settings['buttonIconOpen']['icon'] ) ) {
			$this->set_attribute( 'icon-open', 'class', $settings['buttonIconOpen']['icon'] );
		}

		if ( isset( $settings['buttonIconClosed']['icon'] ) ) {
			$this->set_attribute( 'icon-closed', 'class', $settings['buttonIconClosed']['icon'] );
		}

		if ( isset( $settings['buttonIconOpen']['icon'] ) || isset( $settings['buttonIconOpen']['svg'] ) || isset( $settings['buttonIconClosed']['icon'] ) || isset( $settings['buttonIconClosed']['svg'] ) ) {
			$this->set_attribute( 'buttonInner', 'class', "icon-$icon_position" );
		}

		$this->set_attribute( 'buttonOpen', 'class', $button_classes );
		$this->set_attribute( 'buttonOpen', 'class', 'mab-unfold-button-open' );
		$this->set_attribute( 'buttonClosed', 'class', $button_classes );
		$this->set_attribute( 'buttonClosed', 'class', 'mab-unfold-button-closed' );
		?>
		<div <?php echo $this->render_attributes( '_root' ); ?>>
			<div <?php echo wp_kses_post( $this->render_attributes( 'wrapper' ) ); ?>>
				<div class="mab-unfold-content">
					<?php
					if ( 'nested' === $content_type ) {
						if ( method_exists( '\Bricks\Frontend', 'render_children' ) ) {
							echo \Bricks\Frontend::render_children( $this );
						}
					} else {
						$content = ! empty( $settings['content'] ) ? $settings['content'] : false;

						if ( $content ) {
							$content = $this->render_dynamic_data( $content );

							if ( method_exists( '\Bricks\Helpers', 'parse_editor_content' ) ) {
								$content = \Bricks\Helpers::parse_editor_content( $content );
							} else {
								$content = shortcode_unautop( $content );
								$content = do_shortcode( $content );
							}

							echo $content;
						}
					}
					?>
				</div>
				<?php if ( isset( $settings['separator'] ) ) { ?>
					<div class="mab-unfold-saparator"></div>
				<?php } ?>
			</div>
			<div class="mab-unfold-buttons-wrapper">
				<div <?php echo wp_kses_post( $this->render_attributes( 'buttonInner' ) ); ?>>
					<div <?php echo wp_kses_post( $this->render_attributes( 'buttonOpen' ) ); ?>>
						<?php
						// Render button
						$button_html = '';

						// Get icon HTML ('i' or 'svg')
						$icon_html = isset( $settings['buttonIconOpen'] ) ? self::render_icon( $settings['buttonIconOpen'] ) : false;

						if ( $icon_html && 'left' === $icon_position ) {
							$button_html .= $icon_html;
						}

						if ( isset( $settings['buttonTextOpen'] ) ) {
							$button_html .= '<span class="mab-unfold-button-text">' . trim( $settings['buttonTextOpen'] ) . '</span>';
						}

						if ( $icon_html && 'right' === $icon_position ) {
							$button_html .= $icon_html;
						}

						echo $button_html;
						?>
					</div>
					<div <?php echo wp_kses_post( $this->render_attributes( 'buttonClosed' ) ); ?>>
						<?php
						// Render button
						$button_html = '';

						// Get icon HTML ('i' or 'svg')
						$icon_html = isset( $settings['buttonIconClosed'] ) ? self::render_icon( $settings['buttonIconClosed'] ) : false;

						if ( $icon_html && 'left' === $icon_position ) {
							$button_html .= $icon_html;
						}

						if ( isset( $settings['buttonTextClosed'] ) ) {
							$button_html .= '<span class="mab-unfold-button-text">' . trim( $settings['buttonTextClosed'] ) . '</span>';
						}

						if ( $icon_html && 'right' === $icon_position ) {
							$button_html .= $icon_html;
						}

						echo $button_html;
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
