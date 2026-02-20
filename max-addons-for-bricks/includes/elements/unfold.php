<?php
namespace MaxAddons\Elements;

use MaxAddons\Base\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Unfold_Element extends Element_Base {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-unfold'; // Make sure to prefix your elements
	public $icon         = 'ti-folder max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = [ 'mabUnfold' ]; // Script(s) run when element is rendered on frontend or updated in builder
	public $nestable     = true;

	public function get_label() {
		return esc_html__( 'Unfold', 'max-addons-for-bricks' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-unfold' );
		wp_enqueue_script( 'mab-unfold' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['contentSettings'] = [
			'title' => esc_html__( 'Content', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['separator'] = [
			'title' => esc_html__( 'Separator', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['button'] = [
			'title' => esc_html__( 'Button', 'max-addons-for-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'max-addons-for-bricks' ),
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
			'label'     => esc_html__( 'Content Type', 'max-addons-for-bricks' ),
			'type'      => 'select',
			'default'   => 'editor',
			'options'   => [
				'editor' => esc_html__( 'Text Editor', 'max-addons-for-bricks' ),
				'nested' => esc_html__( 'Nested Elements', 'max-addons-for-bricks' ),
			],
			'inline'    => true,
			'clearable' => false,
		];

		$this->controls['content'] = [
			'tab'      => 'content',
			'group'    => 'contentSettings',
			'label'    => esc_html__( 'Content', 'max-addons-for-bricks' ),
			'type'     => 'editor',
			'default'  => '<p>Nam condimentum et quam in dignissim. Integer in ante diam. Nunc leo sem, dignissim in finibus at, pretium sit amet neque. Nunc sed turpis volutpat, molestie tortor eu, pretium nisl. Quisque vitae leo augue. Aliquam venenatis sagittis magna nec ullamcorper. Aenean sollicitudin fermentum felis, eget vulputate risus. Sed sit amet sem ac ipsum ornare lacinia. In mi felis, egestas at fringilla non, posuere vitae tortor.</p>',
			'required' => [ 'contentType', '!=', 'nested' ],
		];

		$this->controls['contentTypography'] = [
			'tab'    => 'content',
			'group'  => 'contentSettings',
			'type'   => 'typography',
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
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
			'label'  => esc_html__( 'Background Color', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Padding', 'max-addons-for-bricks' ),
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
			'label'   => esc_html__( 'Show separator', 'max-addons-for-bricks' ),
			'type'    => 'checkbox',
			'default' => true, // Default: false
		];

		$this->controls['separatorHeight'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Height', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'units'    => true,
			'default'  => '50px',
			'css'      => [
				[
					'property' => 'height',
					'selector' => '.mab-unfold-separator',
				],
			],
			'required' => [ 'separator', '!=', '' ],
		];

		$this->controls['separatorBackground'] = [
			'tab'      => 'content',
			'group'    => 'separator',
			'label'    => esc_html__( 'Background', 'max-addons-for-bricks' ),
			'type'     => 'gradient',
			'css'      => [
				[
					'property' => 'background-image',
					'selector' => '.mab-unfold-separator',
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
			'label'   => esc_html__( 'Alignment', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Unfold', 'max-addons-for-bricks' ),
			'type'  => 'separator',
		];

		$this->controls['buttonTextOpen'] = [
			'tab'            => 'content',
			'group'          => 'button',
			'type'           => 'text',
			'label'          => esc_html__( 'Text', 'max-addons-for-bricks' ),
			'default'        => esc_html__( 'Read More', 'max-addons-for-bricks' ),
			'placeholder'    => esc_html__( 'Read More', 'max-addons-for-bricks' ),
			'hasDynamicData' => 'text',
			'inline'         => true,
		];

		$this->controls['buttonIconOpen'] = [
			'tab'     => 'content',
			'group'   => 'button',
			'label'   => esc_html__( 'Icon', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Fold', 'max-addons-for-bricks' ),
			'type'  => 'separator',
		];

		$this->controls['buttonTextClosed'] = [
			'tab'            => 'content',
			'group'          => 'button',
			'type'           => 'text',
			'label'          => esc_html__( 'Text', 'max-addons-for-bricks' ),
			'default'        => esc_html__( 'Read Less', 'max-addons-for-bricks' ),
			'placeholder'    => esc_html__( 'Read Less', 'max-addons-for-bricks' ),
			'hasDynamicData' => 'text',
			'inline'         => true,
		];

		$this->controls['buttonIconClosed'] = [
			'tab'     => 'content',
			'group'   => 'button',
			'label'   => esc_html__( 'Icon', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Button Style', 'max-addons-for-bricks' ),
			'type'  => 'separator',
		];

		$this->controls['buttonIconTypography'] = [
			'tab'     => 'content',
			'group'   => 'button',
			'label'   => esc_html__( 'Icon Typography', 'max-addons-for-bricks' ),
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
			'label'       => esc_html__( 'Icon Position', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => $this->control_options['iconPosition'],
			'inline'      => true,
			'placeholder' => esc_html__( 'Right', 'max-addons-for-bricks' ),
		];

		$this->controls['buttonSize'] = [
			'tab'         => 'content',
			'group'       => 'button',
			'label'       => esc_html__( 'Size', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => $this->control_options['buttonSizes'],
			'inline'      => true,
			'reset'       => true,
			'placeholder' => esc_html__( 'Medium', 'max-addons-for-bricks' ),
		];

		$this->controls['buttonStyle'] = [
			'tab'         => 'content',
			'group'       => 'button',
			'label'       => esc_html__( 'Style', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => $this->control_options['styles'],
			'inline'      => true,
			'reset'       => true,
			'default'     => 'primary',
			'placeholder' => esc_html__( 'None', 'max-addons-for-bricks' ),
		];

		$this->controls['buttonCircle'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Circle', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['buttonOutline'] = [
			'tab'   => 'content',
			'group' => 'button',
			'label' => esc_html__( 'Outline', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['buttonBorder'] = [
			'tab'    => 'content',
			'group'  => 'button',
			'type'   => 'border',
			'label'  => esc_html__( 'Border', 'max-addons-for-bricks' ),
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
			'label'  => esc_html__( 'Box Shadow', 'max-addons-for-bricks' ),
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
			'label'  => esc_html__( 'Typography', 'max-addons-for-bricks' ),
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
			'label'  => esc_html__( 'Background', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Padding', 'max-addons-for-bricks' ),
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
			'label' => esc_html__( 'Spacing', 'max-addons-for-bricks' ),
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
			'label'   => esc_html__( 'Transition Speed in Seconds', 'max-addons-for-bricks' ),
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
			'label'     => esc_html__( 'Content Visibility By', 'max-addons-for-bricks' ),
			'type'      => 'select',
			'default'   => 'pixels',
			'options'   => [
				'lines'  => esc_html__( 'Lines', 'max-addons-for-bricks' ),
				'pixels' => esc_html__( 'Pixels', 'max-addons-for-bricks' ),
			],
			'inline'    => true,
			'clearable' => false,
		];

		$this->controls['visibleAmount'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Visible Amount in Px', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Visible Amount in Lines', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'min'      => 1,
			'max'      => 20,
			'step'     => '1',
			'inline'   => true,
			'default'  => 2,
			'required' => [ 'visibleType', '=', 'lines' ],
		];
	}

	private function render_button( string $text, array $icon_settings, string $icon_position ) : string {
		$output    = '';
		$icon_html = ! empty( $icon_settings ) ? self::render_icon( $icon_settings ) : '';

		if ( $icon_html && 'left' === $icon_position ) {
			$output .= $icon_html;
		}

		if ( '' !== $text ) {
			$output .= sprintf(
				'<span class="mab-unfold-button-text">%s</span>',
				esc_html( trim( $text ) )
			);
		}

		if ( $icon_html && 'right' === $icon_position ) {
			$output .= $icon_html;
		}

		return $output;
	}

	private function render_content( array $settings, string $content_type ) {
		if ( 'nested' === $content_type ) {
			if ( method_exists( '\Bricks\Frontend', 'render_children' ) ) {
				echo \Bricks\Frontend::render_children( $this ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			return;
		}

		if ( empty( $settings['content'] ) ) {
			return;
		}

		$content = $this->render_dynamic_data( $settings['content'] );

		if ( method_exists( '\Bricks\Helpers', 'parse_editor_content' ) ) {
			$content = \Bricks\Helpers::parse_editor_content( $content );
		} else {
			$content = shortcode_unautop( $content );
			$content = do_shortcode( $content );
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Content already processed via Bricks/editor.
		echo $content;
	}

	public function render() {
		$settings = $this->settings;

		$content_type   = $settings['contentType'] ?? 'editor';
		$visibility     = ( 'editor' === $content_type ) ? ( $settings['visibleType'] ?? 'pixels' ) : 'pixels';
		$visible_amount = $settings['visibleAmount'] ?? '50';
		$visible_lines  = $settings['visibleLines'] ?? '2';

		if ( 'nested' !== $content_type && empty( $settings['content'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No content added.', 'max-addons-for-bricks' ),
				]
			);
		}

		$unfold_options = [
			'content_type' => $content_type,
			'speed'        => $settings['speedUnreveal'] ?? '',
			'visibility'   => $visibility,
		];

		if ( 'pixels' === $visibility ) {
			$unfold_options['content_height'] = absint( $visible_amount );
		}

		if ( 'lines' === $visibility ) {
			$unfold_options['lines'] = absint( $visible_lines );
		}

		$this->set_attribute( '_root', 'data-unfold', wp_json_encode( $unfold_options ) );
		$this->set_attribute( 'wrapper', 'class', 'mab-unfold-content-wrapper' );
		$this->set_attribute( 'buttonInner', 'class', 'mab-unfold-button-inner' );

		$button_classes = [ 'bricks-button', 'mab-unfold-button' ];

		if ( ! empty( $settings['buttonSize'] ) ) {
			$button_classes[] = sanitize_html_class( $settings['buttonSize'] );
		}

		if ( ! empty( $settings['buttonStyle'] ) ) {
			$style = sanitize_html_class( $settings['buttonStyle'] );

			if ( ! empty( $settings['buttonOutline'] ) ) {
				$button_classes[] = 'buttonOutline';
				$button_classes[] = 'outline';
				$button_classes[] = 'bricks-color-' . $style;
			} else {
				$button_classes[] = 'bricks-background-' . $style;
			}
		}

		if ( ! empty( $settings['buttonCircle'] ) ) {
			$button_classes[] = 'buttonCircle';
			$button_classes[] = 'circle';
		}

		if ( ! empty( $settings['block'] ) ) {
			$button_classes[] = 'block';
		}

		$icon_position = $settings['buttonIconPosition'] ?? 'right';

		$has_open_icon   = ! empty( $settings['buttonIconOpen'] );
		$has_closed_icon = ! empty( $settings['buttonIconClosed'] );

		if ( $has_open_icon || $has_closed_icon ) {
			$this->set_attribute( 'buttonInner', 'class', 'icon-' . esc_attr( $icon_position ) );
		}

		$this->set_attribute( 'buttonOpen', 'class', array_merge( $button_classes, [ 'mab-unfold-button-open' ] ) );
		$this->set_attribute( 'buttonClosed', 'class', array_merge( $button_classes, [ 'mab-unfold-button-closed' ] ) );
		?>
		<div <?php $this->print_render_attributes( '_root' ); ?>>
			<div <?php $this->print_render_attributes( 'wrapper' ); ?>>
				<div class="mab-unfold-content">
					<?php $this->render_content( $settings, $content_type ); ?>
				</div>

				<?php if ( ! empty( $settings['separator'] ) ) : ?>
					<div class="mab-unfold-separator"></div>
				<?php endif; ?>
			</div>

			<div class="mab-unfold-buttons-wrapper">
				<div <?php $this->print_render_attributes( 'buttonInner' ); ?>>

					<div <?php $this->print_render_attributes( 'buttonOpen' ); ?>>
						<?php
						$button_text_open = $settings['buttonTextOpen'] ?? '';
						$button_icon_open = $settings['buttonIconOpen'] ?? [];

						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped inside render_button().
						echo $this->render_button( $button_text_open, $button_icon_open, $icon_position );
						?>
					</div>

					<div <?php $this->print_render_attributes( 'buttonClosed' ); ?>>
						<?php
						$button_text_closed = $settings['buttonTextClosed'] ?? '';
						$button_icon_closed = $settings['buttonIconClosed'] ?? [];

						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped inside render_button().
						echo $this->render_button( $button_text_closed, $button_icon_closed, $icon_position );
						?>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
}
