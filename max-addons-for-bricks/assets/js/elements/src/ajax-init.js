/**
 * Set up Max elements in content Bricks adds over AJAX.
 *
 * Bricks re-runs its own element scripts after an AJAX popup, Load more /
 * infinite scroll, AJAX pagination, Query Filters result or AJAX page load,
 * but not ours, so element scripts register their init here as well.
 */
window.mabAjaxInit = window.mabAjaxInit || ( function () {
	'use strict';

	const EVENTS = [
		'bricks/ajax/popup/loaded',
		'bricks/ajax/query_result/displayed',
		'bricks/ajax/pagination/completed',
		'bricks/ajax/load_page/completed',
	];

	const callbacks   = [];
	const initialized = new WeakMap();

	EVENTS.forEach( function ( event ) {
		document.addEventListener( event, function () {
			if ( typeof bricksIsFrontend === 'undefined' || ! bricksIsFrontend ) {
				return;
			}

			// One element failing must not stop the others from being set up.
			callbacks.forEach( function ( callback ) {
				try {
					callback();
				} catch ( error ) {
					setTimeout( function () {
						throw error;
					} );
				}
			} );
		} );
	} );

	return {
		/**
		 * Run a callback each time Bricks adds content over AJAX. It is
		 * expected to scan the document and skip elements isNew() has seen.
		 */
		add: function ( callback ) {
			callbacks.push( callback );
		},

		/**
		 * Whether an element still needs setting up for the given script,
		 * marking it as set up if so.
		 *
		 * Tracked in a WeakMap rather than an attribute, so a node cloned
		 * after setup (e.g. a slider's loop duplicate) still counts as new.
		 */
		isNew: function ( element, key ) {
			let keys = initialized.get( element );

			if ( ! keys ) {
				keys = {};
				initialized.set( element, keys );
			}

			if ( keys[ key ] ) {
				return false;
			}

			keys[ key ] = true;

			return true;
		},
	};
}() );
