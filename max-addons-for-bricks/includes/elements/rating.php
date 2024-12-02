<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Star_Rating_Element extends \Bricks\Element {
	// Element properties
	public $category     = 'max-addons-elements'; // Use predefined element category 'general'
	public $name         = 'max-rating'; // Make sure to prefix your elements
	public $icon         = 'ti-star max-element'; // Themify icon font class
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Rating', 'max-addons' );
	}

	public function get_keywords() {
		return [ 'rating', 'stars', 'review' ];
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-rating' );
	}

	public function set_controls() {

		$this->set_rating_controls();
	}

	// Set primary controls
	public function set_rating_controls() {
		$this->controls['ratingScale'] = [
			'tab'            => 'content',
			'label'          => esc_html__( 'Rating Scale', 'max-addons' ),
			'type'           => 'number',
			'hasDynamicData' => true,
			'min'            => 1,
			'max'            => 10,
			'default'        => 5,
		];

		$this->controls['rating'] = [
			'tab'            => 'content',
			'label'          => esc_html__( 'Rating', 'max-addons' ),
			'type'           => 'number',
			'hasDynamicData' => true,
			'default'        => 5,
		];

		$this->controls['ratingIcon'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Icon', 'max-addons' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-star',
			],
			'css' 	=> [
				[
					'selector' => '.icon-svg',
				],
			],
		];

		$this->controls['iconColor'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Marked Icon color', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'default'  => array(
				'hex' => '#ffc107',
			),
			'css'      => [
				[
					'property' => 'color',
					'selector' => '.mab-icon-marked',
				],
				[
					'property' => 'fill',
					'selector' => '.mab-icon-marked svg',
				],
			],
		];

		$this->controls['iconUnmarkedColor'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Unmarked Icon color', 'max-addons' ),
			'type'     => 'color',
			'inline'   => true,
			'default'  => array(
				'hex' => '#e0e0e0',
			),
			'css'      => [
				[
					'property' => 'color',
					'selector' => '.mab-icon-unmarked',
				],
				[
					'property' => 'fill',
					'selector' => '.mab-icon-unmarked svg',
				],
			],
		];

		$this->controls['iconSize'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Icon Size', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'font-size',
					'selector' => '.mab-icon',
				],
			],
		];

		$this->controls['iconGap'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Icon Spacing', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'margin-inline-end',
					'selector' => '.mab-icon',
				],
			],
		];

	}

	public function get_rating_scale(): int {
		$settings = $this->settings;

		$rating_scale = isset( $settings['ratingScale'] ) ? $settings['ratingScale'] : 5;
		if ( is_string( $rating_scale ) && strpos( $rating_scale, '{' ) !== false && strpos( $rating_scale, '}' ) !== false ) {
			$rating_scale = intval( $this->render_dynamic_data( $rating_scale ) );
		}

		if ( ! is_numeric( $rating_scale ) || $rating_scale < 1 ) {
			$rating_scale = 5;
		}

		return intval( $rating_scale );
	}

	public function get_rating_value(): float {
		$settings      = $this->settings;
		$initial_value = $this->get_rating_scale();
		$rating_value  = $settings['rating'];

		if ( is_string( $rating_value ) && strpos( $rating_value, '{' ) !== false && strpos( $rating_value, '}' ) !== false ) {
			$rating_value = floatval( $this->render_dynamic_data( $rating_value ) );
		}

		if ( '' === $rating_value ) {
			$rating_value = $initial_value;
		}

		$rating_value = floatval( $rating_value );

		// If rating is less than 0, default to 0 and if it's higher than max rating, default to max rating
		$rating_value = max( 0, min( $rating_value, $initial_value ) );

		return round( $rating_value, 2 );
	}

	public function get_icon_marked_width( $icon_index ): string {
		$rating_value = $this->get_rating_value();

		$width = '0%';

		if ( $rating_value >= $icon_index ) {
			$width = '100%';
		} elseif ( intval( ceil( $rating_value ) ) === $icon_index ) {
			$width = ( $rating_value - ( $icon_index - 1 ) ) * 100 . '%';
		}

		return $width;
	}

	public function get_icon_markup(): string {
		$settings = $this->settings;
		$icon = $settings['ratingIcon'];
		$rating_scale = $this->get_rating_scale();

		ob_start();

		for ( $index = 1; $index <= $rating_scale; $index++ ) {
			$this->set_attribute( 'icon_marked_' . $index, 'class', 'mab-icon-marked' );

			$icon_marked_width = $this->get_icon_marked_width( $index );

			if ( '100%' !== $icon_marked_width ) {
				$this->set_attribute( 'icon_marked_' . $index, 'style', '--mab-rating-icon-marked-width: ' . $icon_marked_width . ';' );
			}
			?>
			<div class="mab-icon">
				<div <?php echo wp_kses_post( $this->render_attributes( 'icon_marked_' . $index ) ); ?>>
					<?php echo self::render_icon( $icon, [ 'aria-hidden' => 'true' ] );; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div class="mab-icon-unmarked">
					<?php echo self::render_icon( $icon, [ 'aria-hidden' => 'true' ] );; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
			<?php
		}

		return ob_get_clean();
	}

	public function render() {
		$settings = $this->settings;

		$this->set_attribute( '_root', 'class', 'mab-rating' );
		$this->set_attribute( '_root', 'itemtype', 'http://schema.org/Rating' );
		$this->set_attribute( '_root', 'itemscope', '' );
		$this->set_attribute( '_root', 'itemprop', 'reviewRating' );

		$this->set_attribute( 'widget_wrapper', 'class', 'mab-rating-wrapper' );
		$this->set_attribute( 'widget_wrapper', 'itemprop', 'reviewRating' );
		$this->set_attribute( 'widget_wrapper', 'content', $this->get_rating_value() );
		$this->set_attribute( 'widget_wrapper', 'role', 'img' );
		$this->set_attribute( 'widget_wrapper', 'aria-label',  sprintf( esc_html__( 'Rated %1$s out of %2$s', 'max-addons' ),
			$this->get_rating_value(),
			$this->get_rating_scale()
		) );

		// Render button ?>
		<div <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?>>
			<meta itemprop="worstRating" content="0">
			<meta itemprop="bestRating" content="<?php echo $this->get_rating_scale(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
			<div <?php echo wp_kses_post( $this->render_attributes( 'widget_wrapper' ) ); ?>>
				<?php echo $this->get_icon_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
		<?php
	}
}
