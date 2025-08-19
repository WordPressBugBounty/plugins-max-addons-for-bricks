<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lottie_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-lottie'; // Make sure to prefix your elements
	public $icon         = 'ti-pencil-alt max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = ['mabLottie']; // Script(s) run when element is rendered on frontend or updated in builder

	public function get_label() {
		return esc_html__( 'Lottie', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_script( 'lottie-player' );
		wp_enqueue_script( 'lottie-interactivity' );
		wp_enqueue_script( 'mab-lottie' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->control_groups['lottie'] = [
			'title' => esc_html__( 'Lottie', 'max-addons' ),
			'tab'   => 'content',
		];

		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {

		$this->controls['_background']['css'][0]['selector'] = '';
		$this->controls['_gradient']['css'][0]['selector'] = '';

		$this->set_lottie_controls();
		$this->set_settings_controls();
	}

	// Set Lottie controls
	public function set_lottie_controls() {

		$this->controls['sourceExternalUrl'] = [
			'tab'     => 'content',
			'group'   => 'lottie',
			'label'   => esc_html__( 'Lottie File URL', 'max-addons' ),
			'type'    => 'text',
			'default' => 'https://assets2.lottiefiles.com/private_files/lf30_kjpkr2oh.json'
		];

		$this->controls['link'] = [
			'tab'         => 'content',
			'group'       => 'lottie',
			'label'       => esc_html__( 'Link', 'max-addons' ),
			'type'        => 'link',
			'pasteStyles' => false,
			'exclude'     => [
				'internal',
				'lightboxImage',
				'lightboxVideo',
			],
		];
	}

	// Set lottie settings controls
	public function set_settings_controls() {
		$this->controls['trigger'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Trigger', 'max-addons' ),
			'type'    => 'select',
			'options' => [
				'auto'     => esc_html__( 'Automatic', 'max-addons' ),
				'click'    => esc_html__( 'Click', 'max-addons' ),
				'hover'    => esc_html__( 'Hover', 'max-addons' ),
				'cursor'   => esc_html__( 'Cursor Movement', 'max-addons' ),
				'scroll'   => esc_html__( 'Scroll', 'max-addons' ),
				'viewport' => esc_html__( 'Viewport', 'max-addons' ),
			],
			'inline'  => true,
			'default' => 'auto',
		];

		$this->controls['clickSelector'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Custom Element Selector', 'max-addons' ),
			'description' => esc_html__( 'By default clicking on the lottie element will trigger the animation. You can change this by adding your custom selector here.', 'max-addons' ),
			'type'        => 'text',
			'placeholder' => '#my-element or .my-element',
			'required'    => [ 'trigger', '=', 'click' ]
		];

		$this->controls['hoverSelector'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Custom Element Selector', 'max-addons' ),
			'description' => esc_html__( 'By default hovering over the lottie element will trigger the animation. You can change this by adding your custom selector here.', 'max-addons' ),
			'type'        => 'text',
			'placeholder' => '#my-element or .my-element',
			'required'    => [ 'trigger', '=', 'hover' ]
		];

		$this->controls['cursorSelector'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( 'Custom Element Selector', 'max-addons' ),
			'description' => esc_html__( 'By default moving cursor over the lottie element will trigger the animation. You can change this by adding your custom selector here.', 'max-addons' ),
			'type'        => 'text',
			'placeholder' => '#my-element or .my-element',
			'required'    => [ 'trigger', '=', 'cursor' ]
		];

		$this->controls['onAnotherClick'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'On another click', 'max-addons' ),
			'type'     => 'select',
			'options'  => [
				'no'     => esc_html__( 'Do nothing', 'max-addons' ),
				'replay' => esc_html__( 'Play again', 'max-addons' ),
			],
			'inline'   => true,
			'required' => [ 'trigger', '=', 'click' ]
		];

		$this->controls['viewportBottom'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Offset Bottom (%)', 'max-addons' ),
			'type'     => 'number',
			'default'  => 0,
			'min'      => 0,
			'max'      => 100,
			'inline'   => true,
			'small'    => true,
			'required' => [ 'trigger', '=', ['scroll', 'viewport'] ]
		];

		$this->controls['viewportTop'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Offset Top (%)', 'max-addons' ),
			'type'     => 'number',
			'default'  => 0,
			'min'      => 0,
			'max'      => 100,
			'inline'   => true,
			'small'    => true,
			'required' => [ 'trigger', '=', ['scroll', 'viewport'] ]
		];

		$this->controls['loop'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Loop', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'small'    => true,
			'required' => [ 'trigger', '=', ['auto', 'viewport'] ]
		];

		$this->controls['loopCount'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Loop Count', 'max-addons' ),
			'type'     => 'number',
			'default'  => 3,
			'units'    => false,
			'min'      => 1,
			'max'      => 100,
			'inline'   => true,
			'small'    => true,
			'required' => [ 'loop', '=', true ],
		];

		$this->controls['speed'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Play Speed', 'max-addons' ),
			'type'    => 'number',
			'units'   => false,
			'default' => 1,
			'min'     => 0.1,
			'max'     => 3,
			'inline'  => true,
			'small'   => true,
		];

		$this->controls['start'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Start Frame', 'max-addons' ),
			'type'    => 'number',
			'units'   => false,
			'default' => 0,
			'min'     => 0,
			'max'     => 1000,
			'inline'  => true,
			'small'   => true,
		];

		$this->controls['end'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'End Frame', 'max-addons' ),
			'type'    => 'number',
			'units'   => false,
			'default' => 300,
			'min'     => 1,
			'max'     => 1000,
			'inline'  => true,
			'small'   => true,
		];

		$this->controls['reverse'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Reverse', 'max-addons' ),
			'type'     => 'checkbox',
			'inline'   => true,
			'small'    => true,
			'required' => [ 'trigger', '!=', 'scroll' ],
		];

		$this->controls['renderer'] = [
			'tab'     => 'content',
			'group'   => 'settings',
			'label'   => esc_html__( 'Renderer', 'max-addons' ),
			'type'    => 'select',
			'options' => [
				'svg'    => esc_html__( 'SVG', 'max-addons' ),
				'canvas' => esc_html__( 'Canvas', 'max-addons' ),
			],
			'inline'  => true,
			'default' => 'svg',
		];
	}

	public function has_link() {
		return isset( $this->settings['link'] );
	}

	public function get_settings_attrs() {
		$settings  = $this->settings;
		$trigger   = isset( $settings['trigger'] ) ? $settings['trigger'] : 'none';
		$loop      = isset( $settings['loop'] ) && $settings['loop'] ? 'yes' : 'no';
		$speed     = isset( $settings['speed'] ) && $settings['speed'] ? $settings['speed'] : 1;
		$reverse   = isset( $settings['reverse'] ) && $settings['reverse'] ? 'yes' : 'no';
		$loopCount = isset( $settings['loopCount'] ) ? intval( $settings['loopCount'] ) : 3;


		$viewport = [
			'top' => 1,
			'bottom' => 0
		];

		if ( isset( $settings['viewportBottom'] ) ) {
			$viewport['bottom'] = $settings['viewportBottom'];
		}
		if ( isset( $settings['viewportTop'] ) ) {
			$viewport['top'] = $settings['viewportTop'];
		}

		$attrs = [
			'trigger'   => $trigger,
			'loop'      => $loop,
			'speed'     => $speed,
			'start'     => 0,
			'end'       => 0,
			'viewport'  => $viewport,
			'loopCount' => $loopCount,
		];

		if ( 'scroll' !== $trigger ) {
			$attrs['reverse'] = $reverse;
		}

		if ( isset( $settings['start'] ) && '' !== $settings['start'] ) {
			$attrs['start'] = $settings['start'];
		}
		if ( isset( $settings['end'] ) && '' !== $settings['end'] ) {
			$attrs['end'] = $settings['end'];
		}

		if ( 'click' === $trigger && isset( $settings['clickSelector'] ) && ! empty( $settings['clickSelector'] ) ) {
			$attrs['selector'] = $settings['clickSelector'];
		}
		if ( 'hover' === $trigger && isset( $settings['hoverSelector'] ) && ! empty( $settings['hoverSelector'] ) ) {
			$attrs['selector'] = $settings['hoverSelector'];
		}
		if ( 'cursor' === $trigger && isset( $settings['cursorSelector'] ) && ! empty( $settings['cursorSelector'] ) ) {
			$attrs['selector'] = $settings['cursorSelector'];
		}

		if ( 'click' === $trigger && isset( $settings['onAnotherClick'] ) ) {
			$attrs['onAnotherClick'] = $settings['onAnotherClick'];
		}

		return $attrs;
	}

	public function render() {
		$settings     = $this->settings;
		$external_url = isset( $settings['sourceExternalUrl'] ) ? $settings['sourceExternalUrl'] : '';
		$renderer     = isset( $settings['renderer'] ) ? $settings['renderer'] : 'svg';

		// Element placeholder
		if ( empty( $external_url ) ) {
			return $this->render_element_placeholder( [
				'icon-class' => $this->icon,
				'title'      => esc_html__( 'No Lottie file provided.', 'max-addons' ),
			] );
		}

		$attrs = $this->get_settings_attrs();

		$this->set_attribute( '_root', 'class', 'mab-lottie' );
		$this->set_attribute( '_root', 'data-element-id', $this->id );
		$this->set_attribute( '_root', 'data-settings', htmlspecialchars( wp_json_encode( $attrs ) ) );

		$this->set_attribute( 'player', 'id', 'lottie-player-' . $this->id );
		$this->set_attribute( 'player', 'src', esc_url( $external_url ) );
		$this->set_attribute( 'player', 'speed', $attrs['speed'] );
		$this->set_attribute( 'player', 'renderer', $renderer );

		if ( 'auto' === $attrs['trigger'] ) {
			$this->set_attribute( 'player', 'autoplay', '' );
		}

		if ( $this->has_link() ) {
			$this->set_link_attributes( 'link', $settings['link'] );
		}
		?>
		<div <?php echo $this->render_attributes( '_root', true ); ?>>
			<div class="mab-lottie-container">
				<?php if ( $this->has_link() ) { ?>
				<a class="mab-lottie-link" <?php echo $this->render_attributes( 'link' ); ?>>
				<?php } ?>
				<lottie-player <?php echo $this->render_attributes( 'player' ); ?>></lottie-player>
				<?php if ( $this->has_link() ) { ?>
				</a>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}
