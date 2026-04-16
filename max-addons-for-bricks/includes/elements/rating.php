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
	public $tag          = 'div';
	public $css_selector = ''; // Default CSS selector
	public $scripts      = []; // Script(s) run when element is rendered on frontend or updated in builder

	// Return localized element label
	public function get_label() {
		return esc_html__( 'Rating', 'max-addons-for-bricks' );
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
			'label'          => esc_html__( 'Rating Scale', 'max-addons-for-bricks' ),
			'type'           => 'number',
			'hasDynamicData' => true,
			'min'            => 1,
			'max'            => 10,
			'default'        => 5,
		];

		$this->controls['rating'] = [
			'tab'            => 'content',
			'label'          => esc_html__( 'Rating', 'max-addons-for-bricks' ),
			'type'           => 'number',
			'hasDynamicData' => true,
			'default'        => 5,
		];

		$this->controls['ratingIcon'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Icon', 'max-addons-for-bricks' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-star',
			],
			'css'      => [
				[
					'selector' => '.icon-svg',
				],
			],
		];

		$this->controls['iconColor'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Marked Icon color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'inline'   => true,
			'default'  => [
				'hex' => '#ffc107',
			],
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
			'label'    => esc_html__( 'Unmarked Icon color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'inline'   => true,
			'default'  => [
				'hex' => '#e0e0e0',
			],
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
			'label'    => esc_html__( 'Icon Size', 'max-addons-for-bricks' ),
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
			'label'    => esc_html__( 'Icon Spacing', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'margin-inline-end',
					'selector' => '.mab-icon',
				],
			],
		];

		// Label controls
		$this->controls['labelSeparator'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Label', 'max-addons-for-bricks' ),
			'type'  => 'separator',
		];

		$this->controls['showLabel'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Show Label', 'max-addons-for-bricks' ),
			'type'  => 'checkbox',
		];

		$this->controls['labelFormat'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Format', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => [
				'value_scale' => esc_html__( 'Value / Scale (e.g. 4.5 / 5)', 'max-addons-for-bricks' ),
				'value_only'  => esc_html__( 'Value only (e.g. 4.5)', 'max-addons-for-bricks' ),
			],
			'placeholder' => esc_html__( 'Value / Scale (e.g. 4.5 / 5)', 'max-addons-for-bricks' ),
			'required'    => [ 'showLabel', '=', true ],
		];

		$this->controls['labelPrefix'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Prefix', 'max-addons-for-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. Rated', 'max-addons-for-bricks' ),
			'required'    => [ 'showLabel', '=', true ],
		];

		$this->controls['labelSuffix'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Suffix', 'max-addons-for-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. stars', 'max-addons-for-bricks' ),
			'required'    => [ 'showLabel', '=', true ],
		];

		$this->controls['labelPosition'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Position', 'max-addons-for-bricks' ),
			'type'        => 'select',
			'options'     => [
				'after'  => esc_html__( 'After stars', 'max-addons-for-bricks' ),
				'before' => esc_html__( 'Before stars', 'max-addons-for-bricks' ),
			],
			'placeholder' => esc_html__( 'After stars', 'max-addons-for-bricks' ),
			'required'    => [ 'showLabel', '=', true ],
		];

		$this->controls['labelGap'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Spacing', 'max-addons-for-bricks' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'gap',
					'selector' => '&',
				],
			],
			'required' => [ 'showLabel', '=', true ],
		];

		$this->controls['labelColor'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Color', 'max-addons-for-bricks' ),
			'type'     => 'color',
			'inline'   => true,
			'css'      => [
				[
					'property' => 'color',
					'selector' => '.mab-rating-label',
				],
			],
			'required' => [ 'showLabel', '=', true ],
		];

		$this->controls['labelTypography'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Typography', 'max-addons-for-bricks' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.mab-rating-label',
				],
			],
			'required' => [ 'showLabel', '=', true ],
		];

		// Link controls
		$this->controls['linkSeparator'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Link', 'max-addons-for-bricks' ),
			'type'  => 'separator',
		];

		$this->controls['link'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Link', 'max-addons-for-bricks' ),
			'type'  => 'link',
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

		return max( 1, min( intval( $rating_scale ), 10 ) );
	}

	public function get_rating_value(): float {
		$settings      = $this->settings;
		$initial_value = $this->get_rating_scale();
		$rating_value  = isset( $settings['rating'] ) ? $settings['rating'] : '';

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
		$settings     = $this->settings;
		$icon         = isset( $settings['ratingIcon'] ) ? $settings['ratingIcon'] : [];
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
					<?php echo self::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div class="mab-icon-unmarked">
					<?php echo self::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
			<?php
		}

		return ob_get_clean();
	}

	public function get_label_markup(): string {
		$settings = $this->settings;

		if ( empty( $settings['showLabel'] ) ) {
			return '';
		}

		$format = isset( $settings['labelFormat'] ) ? $settings['labelFormat'] : 'value_scale';
		$prefix = isset( $settings['labelPrefix'] ) ? trim( $settings['labelPrefix'] ) : '';
		$suffix = isset( $settings['labelSuffix'] ) ? trim( $settings['labelSuffix'] ) : '';

		if ( 'value_only' === $format ) {
			$value_text = (string) $this->get_rating_value();
		} else {
			$value_text = sprintf(
				/* translators: 1: rating value, 2: rating scale */
				_x( '%1$s / %2$s', 'rating label value/scale format', 'max-addons-for-bricks' ),
				$this->get_rating_value(),
				$this->get_rating_scale()
			);
		}

		$parts = array_filter( [ $prefix, $value_text, $suffix ] );
		$label = implode( ' ', $parts );

		return '<span class="mab-rating-label" aria-hidden="true">' . esc_html( $label ) . '</span>';
	}

	public function render() {
		$settings = $this->settings;

		$this->set_attribute( '_root', 'class', 'mab-rating' );
		$this->set_attribute( '_root', 'itemtype', 'https://schema.org/Rating' );
		$this->set_attribute( '_root', 'itemscope', '' );

		$this->set_attribute( 'widget_wrapper', 'class', 'mab-rating-wrapper' );
		$this->set_attribute( 'widget_wrapper', 'itemprop', 'reviewRating' );
		$this->set_attribute( 'widget_wrapper', 'content', $this->get_rating_value() );
		$this->set_attribute( 'widget_wrapper', 'role', 'img' );
		$this->set_attribute( 'widget_wrapper', 'aria-label', sprintf(
			/* translators: 1: rating value, 2: rating scale */
			esc_html__( 'Rated %1$s out of %2$s', 'max-addons-for-bricks' ),
			$this->get_rating_value(),
			$this->get_rating_scale()
		) );

		if ( ! empty( $settings['link'] ) ) {
			$this->tag = 'a';
			$this->set_link_attributes( '_root', $settings['link'] );
		}

		$label_position = isset( $settings['labelPosition'] ) ? $settings['labelPosition'] : 'after';
		$label_markup   = $this->get_label_markup();
		?>
		<<?php echo esc_attr( $this->tag ); ?> <?php echo wp_kses_post( $this->render_attributes( '_root' ) ); ?>>
			<meta itemprop="worstRating" content="0">
			<meta itemprop="bestRating" content="<?php echo esc_attr( $this->get_rating_scale() ); ?>">
			<?php if ( $label_markup && 'before' === $label_position ) : ?>
				<?php echo $label_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
			<div <?php echo wp_kses_post( $this->render_attributes( 'widget_wrapper' ) ); ?>>
				<?php echo $this->get_icon_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<?php if ( $label_markup && 'before' !== $label_position ) : ?>
				<?php echo $label_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
		</<?php echo esc_attr( $this->tag ); ?>>
		<?php
	}
}
