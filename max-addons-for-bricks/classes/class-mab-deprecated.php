<?php
/**
 * Deprecated hooks handler.
 *
 * @package MaxAddonsForBricks
 * @since 1.6.7
 */

namespace MaxAddons\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MAB_Deprecated {

	/**
	 * Apply filter with optional deprecated fallback.
	 *
	 * @param string $new_hook  New hook name.
	 * @param mixed  $value     Value to filter.
	 * @param string $old_hook  Old hook name.
	 * @param string $version   Version deprecated.
	 *
	 * @return mixed
	 */
	public static function filter( $new_hook, $value, $old_hook = '', $version = '' ) {

		// Apply new hook.
		$value = apply_filters( $new_hook, $value );

		// Apply deprecated hook if provided.
		if ( ! empty( $old_hook ) ) {
			$value = apply_filters_deprecated(
				$old_hook,
				array( $value ),
				$version,
				$new_hook
			);
		}

		return $value;
	}

	/**
	 * Run action with optional deprecated fallback.
	 *
	 * @param string $new_hook  New hook name.
	 * @param array  $args      Arguments to pass.
	 * @param string $old_hook  Old hook name.
	 * @param string $version   Version deprecated.
	 *
	 * @return void
	 */
	public static function action( $new_hook, $args = array(), $old_hook = '', $version = '' ) {

		$args = (array) $args;

		// Run new action.
		do_action_ref_array( $new_hook, $args );

		// Run deprecated action if provided.
		if ( ! empty( $old_hook ) ) {
			do_action_deprecated(
				$old_hook,
				$args,
				$version,
				$new_hook
			);
		}
	}
}
