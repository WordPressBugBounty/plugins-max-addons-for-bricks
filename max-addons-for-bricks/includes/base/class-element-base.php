<?php
namespace MaxAddons\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base Element Class for Max Addons.
 *
 * Extends Bricks\Element and provides shared helper
 * methods for all custom elements.
 */
abstract class Element_Base extends \Bricks\Element {

	/**
	 * Element category
	 */
	public $category = 'max-addons-elements';

	/**
	 * Prints escaped HTML attributes for a given render context.
	 *
	 * Used to output rendered attributes for an element. This is a wrapper around
	 * Bricks' render_attributes() method. The render_attributes() method returns
	 * a pre-escaped attribute string,but PHPCS cannot detect this automatically.
	 * Therefore, output escaping is intentionally bypassed here.
	 *
 	 * @since 1.6.7
	 * @param string $context The render attributes context key.
	 * @return void
	 */
	public function print_render_attributes( $context ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- render_attributes() returns escaped attributes.
		echo $this->render_attributes( $context );
	}
}
