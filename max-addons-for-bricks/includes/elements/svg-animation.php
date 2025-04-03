<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Svg_Animation_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-svg-animation'; // Make sure to prefix your elements
	public $icon         = 'ti-marker-alt max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = [ 'mabSvgAnimation' ]; // Script(s) run when element is rendered on frontend or updated in builder

	public function get_label() {
		return esc_html__( 'SVG Animation', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-svg-animation' );
		wp_enqueue_script( 'vivus' );
		wp_enqueue_script( 'mab-svg-animation' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['settings'] = [
			'title'    => esc_html__( 'Settings', 'max-addons' ),
			'tab'      => 'content',
			'required' => [ 'file', '!=', '' ],
		];
	}

	public function set_controls() {

		$this->set_content_controls();
		$this->set_svg_style_controls();
	}

	// Set content controls
	public function set_content_controls() {

		$this->controls['file'] = [
			'tab'   => 'content',
			'type'  => 'svg',
			'label' => esc_html__( 'Select SVG File', 'max-addons' ),
		];

		$this->controls['svgHeight'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Height', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'height',
					'selector' => '.mab-svg-animation .mab-svg-inner-block',
				],
				[
					'property' => 'height',
					'selector' => '.mab-svg-animation object',
				],
			],
			'required' => [ 'file', '!=', '' ],
		];

		$this->controls['svgWidth'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Width', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'width',
					'selector' => '.mab-svg-animation .mab-svg-inner-block',
				],
				[
					'property' => 'width',
					'selector' => '.mab-svg-animation object',
				],
			],
			'required' => [ 'file', '!=', '' ],
		];

		$this->controls['strokeColor'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Stroke Color', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'default'  => [
				'hex' => '#623DDC',
			],
			'required' => [ 'file', '!=', '' ],
		];

		$this->controls['svgFillColor'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Fill', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'required' => [ 'file', '!=', '' ],
		];
	}

	// Set svg style controls
	public function set_svg_style_controls() {

		$this->controls['drawOnHover'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Draw On Hover', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'required' => [ 'file', '!=', '' ],
		];

		$this->controls['animationType'] = [
			'tab'       => 'content',
			'group'     => 'settings',
			'label'     => esc_html__( 'Animation Type', 'max-addons' ),
			'type'      => 'select',
			'options'   => [
				'delayed'       => esc_html__( 'Delayed', 'max-addons' ),
				'sync'          => esc_html__( 'Sync', 'max-addons' ),
				'oneByOne'      => esc_html__( 'One By One', 'max-addons' ),
				'scenario-sync' => esc_html__( 'Scenario Sync', 'max-addons' ),
			],
			'inline'    => true,
			'clearable' => false,
			'default'   => 'delayed',
			'required'  => [ 'file', '!=', '' ],
		];

		$this->controls['duration'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Duration', 'max-addons' ),
			'type'     => 'number',
			'min'      => 0,
			'max'      => 1000,
			'step'     => 1,
			'inline'   => true,
			'default'  => 220,
			'required' => [ 'file', '!=', '' ],
		];
	}

	public function render() {
		$settings = $this->settings;

		$animated_class = '';
		$animation_attr = '';

		if ( ! isset( $this->settings['file']['url'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No SVG selected.', 'max-addons' ),
				]
			);
		}

		$svg_url = $settings['file']['url'];

		if ( isset( $settings['strokeColor'] ) ) {
			$border_stroke_color = $settings['strokeColor']['hex'];
		} else {
			$border_stroke_color = 'none';
		}

		$hover_draw = '';

		if ( isset( $settings['drawOnHover'] ) ) {
			$hover_draw = 'mab-hover-draw-svg';
		}

		if ( isset( $settings['svgFillColor']['hex'] ) ) {
			$svg_fill_color = $settings['svgFillColor']['hex'];
		} else {
			$svg_fill_color = 'none';
		}

		$this->set_attribute( '_root', 'class', 'mab-svg-animation-wrapper' );
		$this->set_attribute( 'svg-animation', 'class', [ 'mab-svg-animation', 'mab-svg-animation-' . $this->id, $hover_draw, $animated_class ] );
		$this->set_attribute( 'svg-animation', 'data-id', 'mab-svg-' . $this->id );
		$this->set_attribute( 'svg-animation', 'data-type', $settings['animationType'] );
		$this->set_attribute( 'svg-animation', 'data-duration', $settings['duration'] );
		$this->set_attribute( 'svg-animation', 'data-stroke', $border_stroke_color );
		$this->set_attribute( 'svg-animation', 'data-fill-color', $svg_fill_color );

		$this->set_attribute( 'object', 'id', 'mab-svg-' . $this->id );
		$this->set_attribute( 'object', 'type', 'image/svg+xml' );
		$this->set_attribute( 'object', 'data', $svg_url );

		$animate_svg = '<div ' . wp_kses_post( $this->render_attributes( '_root' ) ) . '>';
			$animate_svg .= '<div ' . wp_kses_post( $this->render_attributes( 'svg-animation' ) ) . $animation_attr . '>';
				$animate_svg .= '<div class="mab-svg-inner-block">';
					$animate_svg .= '<object ' . wp_kses_post( $this->render_attributes( 'object' ) ) . '></object>';
				$animate_svg .= '</div>';
			$animate_svg .= '</div>';
		$animate_svg .= '</div>';

		echo $animate_svg; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public static function render_builder() { ?>
		<script type="text/x-template" id="tmpl-brxe-svg-animation">
				<div
					class="mab-svg-animation"
					:data-id="'mab-svg-' + id"
					:data-type="settings.animationType"
					:data-duration="settings.duration"
					:data-stroke="settings.strokeColor.hex ? settings.strokeColor.hex : 'none'"
					:data-fill-color="settings.svgFillColor.hex ? settings.svgFillColor.hex : 'none'">
					<div class="mab-svg-inner-block">
						<object
							:id="'mab-svg-' + id"
							:type="image/svg+xml"
							:data="settings.file.url">
						</object>
					</div>
				</div>
			</div>
		</script>
		<?php
	}
}
