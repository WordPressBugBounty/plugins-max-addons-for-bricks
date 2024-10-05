<?php
namespace MaxAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Cta_Button_Element extends \Bricks\Element {
	// Element properties
	public $category = 'max-addons-elements'; // Use predefined element category 'general'
	public $name     = 'max-cta-button'; // Make sure to prefix your elements
	public $icon     = 'ti-layout-cta-btn-left max-element'; // Themify icon font class
	public $tag      = 'span';

	// Return localized element label
	public function get_label() {
		return esc_html__( 'CTA Button', 'max-addons' );
	}

	// Enqueue element styles and scripts
	public function enqueue_scripts() {
		wp_enqueue_style( 'mab-cta-button' );
	}

	// Set builder control groups
	public function set_control_groups() {
		$this->controls['text'] = [ // Unique group identifier (lowercase, no spaces)
			'title' => esc_html__( 'Text', 'max-addons' ), // Localized control group title
			'tab'   => 'content', // Set to either "content" or "style"
		];

		$this->control_groups['icon'] = [
			'title' => esc_html__( 'Icon', 'max-addons' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {

		// Set button width CSS selector
		$this->controls['_width']['css'][0]['selector'] = $this->css_selector;

		$this->controls['text'] = [
			'tab'            => 'content',
			'label'          => esc_html__( 'Text', 'max-addons' ),
			'type'           => 'text',
			'default'        => esc_html__( 'Sign up now!', 'max-addons' ),
			// 'hidden' => true,
			'hasDynamicData' => 'text',
		];

		$this->controls['description'] = [
			'tab'            => 'content',
			'label'          => esc_html__( 'Description', 'max-addons' ),
			'type'           => 'textarea',
			'rows'           => 3,
			'default'        => esc_html__( 'Free for first 30 days', 'max-addons' ),
			'hasDynamicData' => 'text',
		];

		$this->controls['tag'] = [
			'label'          => esc_html__( 'HTML tag', 'max-addons' ),
			'type'           => 'text',
			'hasDynamicData' => false,
			'inline'         => true,
			'placeholder'    => 'span',
			'required'       => [ 'link', '=', '' ],
		];

		$this->controls['size'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Size', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['buttonSizes'],
			'inline'      => true,
			'reset'       => true,
			'placeholder' => esc_html__( 'Medium', 'max-addons' ),
		];

		$this->controls['style'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Style', 'max-addons' ),
			'type'        => 'select',
			'options'     => $this->control_options['styles'],
			'inline'      => true,
			'reset'       => true,
			'default'     => 'primary',
			'placeholder' => esc_html__( 'None', 'max-addons' ),
		];

		$this->controls['circle'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Circle', 'max-addons' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['outline'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Outline', 'max-addons' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		unset( $this->controls['_typography'] );

		$this->controls['textTypography'] = [
			'tab'    => 'content',
			'group'  => '_typography',
			'label'  => esc_html__( 'Text Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-button-text',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		$this->controls['descriptionTypography'] = [
			'tab'    => 'content',
			'group'  => '_typography',
			'label'  => esc_html__( 'Description Typography', 'max-addons' ),
			'type'   => 'typography',
			'css'    => [
				[
					'property' => 'font',
					'selector' => '.mab-button-description',
				],
			],
			'inline' => true,
			'small'  => true,
		];

		// Link

		$this->controls['linkSeparator'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Link', 'max-addons' ),
			'type'  => 'separator',
		];

		$this->controls['link'] = [
			'tab'   => 'content',
			'label' => esc_html__( 'Link type', 'max-addons' ),
			'type'  => 'link',
		];

		// Icon Section

		$this->controls['icon_type'] = [
			'tab'         => 'content',
			'group'       => 'icon',
			'label'       => esc_html__( 'Icon Type', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'icon'  => esc_html__( 'Icon', 'max-addons' ),
				'image' => esc_html__( 'Image', 'max-addons' ),
			],
			'inline'      => true,
			'clearable'   => true,
			'pasteStyles' => false,
			'default'     => 'icon',
		];

		$this->controls['iconPosition'] = [
			'tab'         => 'content',
			'group'       => 'icon',
			'label'       => esc_html__( 'Position', 'max-addons' ),
			'type'        => 'select',
			'options'     => [
				'before-title' => esc_html__( 'Before Title', 'max-addons' ),
				'after-title'  => esc_html__( 'After Title', 'max-addons' ),
				'left'         => esc_html__( 'Before Title & Description', 'max-addons' ),
				'right'        => esc_html__( 'After Title & Description', 'max-addons' ),
			],
			'inline'      => true,
			'placeholder' => esc_html__( 'After Title & Description', 'max-addons' ),
			'default'     => 'right',
			'required'    => [ 'icon_type', '!=', '' ],
		];

		$this->controls['icon'] = [
			'tab'      => 'content',
			'group'    => 'icon',
			'label'    => esc_html__( 'Icon', 'max-addons' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'themify',
				'icon'    => 'ti-arrow-circle-right',
			],
			'css' 	=> [
				[
					'selector' => '.icon-svg',
				],
			],
			'required' => [ 'icon_type', '=', 'icon' ],
		];

		$this->controls['image'] = [
			'tab'      => 'content',
			'group'    => 'icon',
			'type'     => 'image',
			'label'    => esc_html__( 'Image', 'max-addons' ),
			'required' => [ 'icon_type', '=', 'image' ],
		];

		$this->controls['iconTypography'] = [
			'tab'      => 'content',
			'group'    => 'icon',
			'label'    => esc_html__( 'Typography', 'max-addons' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => 'i',
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
			'required' => [ 'icon_type', '=', 'icon' ],
		];

		$this->controls['iconSpacing'] = [
			'tab'      => 'content',
			'group'    => 'icon',
			'label'    => esc_html__( 'Gap', 'max-addons' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'margin-right',
					'selector' => '.icon-left',
				],
				[
					'property' => 'margin-left',
					'selector' => '.icon-right',
				],
			],
			'default'  => '10px',
			'required' => [ 'icon_type', '!=', '' ],
		];

		$this->controls['height'] = [
			'tab'      => 'content',
			'group'    => 'icon',
			'label'    => esc_html__( 'Height', 'max-addons' ),
			'type'     => 'number',
			'css'      => [
				[
					'property' => 'height',
					'selector' => 'img',
				],
			],
			'units'    => true,
			'required' => [ 'icon_type', '=', 'image' ],
		];

		$this->controls['width'] = [
			'tab'      => 'content',
			'group'    => 'icon',
			'label'    => esc_html__( 'Width', 'max-addons' ),
			'type'     => 'number',
			'css'      => [
				[
					'property' => 'width',
					'selector' => 'img',
				],
			],
			'units'    => true,
			'required' => [ 'icon_type', '=', 'image' ],
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
			$images = $this->render_dynamic_data_tag( $image['useDynamicData']['name'], $image_type );
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
					'title'      => sprintf(
						$message,
						$settings[ $image_type ]['useDynamicData']['label'],
						$settings[ $image_type ]['useDynamicData']['group']
					),
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

		$image_html = '';

		if ( isset( $settings[ $image_type ]['id'] ) ) {
			$image_html = wp_get_attachment_image( $settings[ $image_type ]['id'], $settings[ $image_type ]['size'], false, $image_atts );
		} elseif ( ! empty( $settings[ $image_type ]['url'] ) ) {
			$image_html = '<img src="' . esc_url( $settings[ $image_type ]['url'] ) . '">';
		}

		return $image_html;
	}

	public function render_button_icon() {
		$settings = $this->settings;

		$icon_type = isset( $settings['icon_type'] ) ? $settings['icon_type'] : '';
		$icon_position = isset( $settings['iconPosition'] ) ? $settings['iconPosition'] : 'right';

		if ( 'before-title' === $icon_position ) {
			$icon_position = 'left';
		} elseif ( 'after-title' === $icon_position ) {
			$icon_position = 'right';
		}

		if ( ! $icon_type ) {
			return;
		}

		if ( isset( $settings['icon']['icon'] ) ) {
			$this->set_attribute( 'icon', 'class', $settings['icon']['icon'] );
		}

		$icon_html = '<span class="mab-cta-button-icon icon-' . $icon_position . '">';

		if ( 'icon' === $icon_type ) {
			if ( isset( $settings['icon'] ) ) {
				$icon_html .= isset( $settings['icon'] ) ? self::render_icon( $settings['icon'] ) : false;
			}
		} elseif ( 'image' === $icon_type ) {
			$icon_html .= wp_kses_post( $this->render_image( 'image' ) );
		}

		$icon_html .= '</span>';

		echo $icon_html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function render_button_text() {
		$settings = $this->settings;

		$this->set_attribute( 'button-text', 'class', 'mab-button-text' );

		if ( isset( $settings['text'] ) ) { ?>
			<span <?php echo wp_kses_post( $this->render_attributes( 'button-text' ) ); ?>><?php echo trim( $settings['text'] ); ?> </span>
			<?php
		}
	}

	public function render_button_description() {
		$settings = $this->settings;

		$this->set_attribute( 'button-description', 'class', 'mab-button-description' );

		if ( isset( $settings['description'] ) ) { ?>
			<span <?php echo wp_kses_post( $this->render_attributes( 'button-description' ) ); ?>><?php echo wp_kses_post( $settings['description'] ); ?> </span>
			<?php
		}
	}

	public function render_layout_1( $icon_position ) {
		?>
		<span class="mab-cta-button-content">
			<span class="bricks-button-inner">
				<?php
				if ( 'before-title' === $icon_position ) {
					$this->render_button_icon();
				}

				$this->render_button_text();

				if ( 'after-title' === $icon_position ) {
					$this->render_button_icon();
				}
				?>

			</span>

			<?php $this->render_button_description(); ?>
		</span>
		<?php
	}

	public function render_layout_2( $icon_position ) {
		?>
		<span class="bricks-button-inner">
			<?php
			if ( 'left' === $icon_position ) {
				$this->render_button_icon();
			}
			?>
			<span class="mab-cta-button-content">
				<?php
				$this->render_button_text();

				$this->render_button_description();
				?>
			</span>
			<?php
			if ( 'right' === $icon_position ) {
				$this->render_button_icon();
			}
			?>
		</span>
		<?php
	}

	public function render() {
		$settings = $this->settings;

		$button_classes[] = 'bricks-button mab-cta-button';

		if ( isset( $settings['size'] ) ) {
			$button_classes[] = $settings['size'];
		}

		if ( isset( $settings['style'] ) ) {
			// Outline
			if ( isset( $settings['outline'] ) ) {
				$button_classes[] = 'outline';
				$button_classes[] = 'bricks-color-' . $settings['style'];
			} else {
				// Fill (default)
				$button_classes[] = 'bricks-background-' . $settings['style'];
			}
		}

		// Button circle
		if ( isset( $settings['circle'] ) ) {
			$button_classes[] = 'circle';
		}

		$icon_position = isset( $settings['iconPosition'] ) ? $settings['iconPosition'] : 'right';

		$button_classes[] = 'mab-cta-button-icon-align-' . $icon_position;

		$this->set_attribute( '_root', 'class', $button_classes );

		// Link
		if ( isset( $settings['link'] ) ) {
			$this->tag = 'a';

			$this->set_link_attributes( '_root', $settings['link'] );
		}

		// Render button ?>
		<<?php echo esc_attr( $this->tag ) . ' ' . wp_kses_post( $this->render_attributes( '_root' ) ); ?> >

			<?php
			if ( 'before-title' === $icon_position || 'after-title' === $icon_position ) {
				$this->render_layout_1( $icon_position );
			} else {
				$this->render_layout_2( $icon_position );
			}
			?>

		<?php echo '</' . esc_attr( $this->tag ) . '>';

	}

	public static function render_builder() { ?>
		<script type="text/x-template" id="tmpl-brxe-max-cta-button">
			<component
				:is="settings.link ? 'a' : settings.tag ? settings.tag : 'span'"
				:class="[
					'bricks-button mab-cta-button mab-cta-button-icon-align-' + settings.iconPosition,
					settings.size ? settings.size : null,
					settings.style ? settings.outline ? 'outline bricks-color-' + settings.style : 'bricks-background-' + settings.style : null,
					settings.circle ? 'circle' : null
				]">
				<span v-if="settings.iconPosition === 'before-title' || settings.iconPosition === 'after-title'" class="mab-cta-button-content">
					<span class="bricks-button-inner">
						<span v-if="settings.icon_type === 'icon' && settings.icon && settings.iconPosition === 'before-title'" class="mab-cta-button-icon icon-left">
							<icon-svg :iconSettings="settings.icon"/>
						</span>
						<span v-else-if="settings.icon_type === 'image' && settings.image && settings.image.url && settings.iconPosition === 'before-title'" class="mab-cta-button-icon icon-left">
							<img :src="settings.image.url" />
						</span>

						<contenteditable
						tag="span"
						class="mab-button-text"
						:name="name"
						controlKey="text"
						toolbar="style"
						:settings="settings"/>

						<span v-if="settings.icon_type === 'icon' && settings.icon && settings.iconPosition === 'after-title'" class="mab-cta-button-icon icon-right">
							<icon-svg :iconSettings="settings.icon"/>
						</span>
						<span v-else-if="settings.icon_type === 'image' && settings.image && settings.image.url && settings.iconPosition === 'after-title'" class="mab-cta-button-icon icon-right">
							<img :src="settings.image.url" />
						</span>
					</span>

					<contenteditable
					tag="span"
					class="mab-button-description"
					:name="name"
					controlKey="description"
					toolbar="style"
					:settings="settings"/>
				</span>

				<span v-if="settings.iconPosition === 'left' || settings.iconPosition === 'right'" class="bricks-button-inner">
					<span v-if="settings.icon_type === 'icon' && settings.icon && settings.iconPosition === 'left'" class="mab-cta-button-icon icon-left">
						<icon-svg :iconSettings="settings.icon"/>
					</span>
					<span v-else-if="settings.icon_type === 'image' && settings.image && settings.image.url && settings.iconPosition === 'left'" class="mab-cta-button-icon icon-left">
						<img :src="settings.image.url" />
					</span>

					<span class="mab-cta-button-content">
						<contenteditable
						tag="span"
						class="mab-button-text"
						:name="name"
						controlKey="text"
						toolbar="style"
						:settings="settings"/>
						<contenteditable
						tag="span"
						class="mab-button-description"
						:name="name"
						controlKey="description"
						toolbar="style"
						:settings="settings"/>
					</span>

					<span v-if="settings.icon_type === 'icon' && settings.icon && settings.iconPosition !== 'left'" class="mab-cta-button-icon icon-right">
						<icon-svg :iconSettings="settings.icon"/>
					</span>
					<span v-else-if="settings.icon_type === 'image' && settings.image && settings.image.url && settings.iconPosition !== 'left'" class="mab-cta-button-icon icon-right">
						<img :src="settings.image.url" />
					</span>
				</span>
			</component>
		</script>
		<?php
	}

}
