MabImageAccordion = function( element ) {
	this.element  = element;
	this.items    = this.element.querySelectorAll( '.mab-image-accordion-item' );
	this.action   = this.element.dataset.action;
	this.window  = window;

	if ( 'undefined' !== typeof this.element.dataset.settings ) {
		this.settings = JSON.parse( this.element.dataset.settings );
	}

	this.action        = this.settings.action;
	this.onmouseout    = this.settings.onmouseout;
	this.defaultActive = this.settings.default;
	this.stackOn       = this.settings.stackOn;

	this.init();
};

MabImageAccordion.prototype = {
	id            : '',
	element       : '',
	action        : 'on-hover',
	onmouseout    : 'close-all',
	defaultActive : '',
	window        : '',

	init: function() {
		if ( 'on-hover' === this.action ) {
			this.items.forEach( function( item ) {
				item.addEventListener( 'mouseover', this.onEnter.bind( this, item ) );
				if ( 'last-active' !== this.onmouseout ) {
					item.addEventListener( 'mouseout', this.onOut.bind( this, item ) );
				}
			}.bind( this ) );
		}
		if ( 'on-click' === this.action ) {
			this.items.forEach( function( item ) {
				item.addEventListener( 'click', this.onEnter.bind( this, item ), true );
			}.bind( this ) );

			document.body.addEventListener( 'click', this.resetAll.bind( this ) );
		}

		if ( undefined !== this.stackOn ) {
			this.stackIt();

			this.window.addEventListener( 'resize', function() {
				this.stackIt();
			}.bind( this ) );
		}
	},

	onEnter: function(item, e) {
		if ( 'on-click' === this.action ) {
			e.stopPropagation();
		}

		this.resetAll();

		this.activeItem(item);
	},

	onOut: function(item, e) {
		item.style.flex = '1';
		item.classList.remove( 'mab-image-accordion-active' );

		if ( 'first-item' === this.onmouseout ) {
			item = this.items[0];
		} else if ( 'default-active' === this.onmouseout ) {
			item = ( 'undefined' !== typeof this.defaultActive ) ? this.items[this.defaultActive] : this.items[0];
		}

		if ( 'first-item' === this.onmouseout || 'default-active' === this.onmouseout ) {
			this.activeItem(item);
		}
	},

	activeItem: function(item) {
		item.classList.add( 'mab-image-accordion-active' );
		item.style.flex = '3';
	},

	stackIt: function() {
		if ( window.innerWidth <= this.stackOn ) {
			this.element.classList.remove( 'mab-image-accordion-vertical' );
			this.element.classList.add( 'mab-image-accordion-horizontal' );
		} else {
			this.element.classList.remove( 'mab-image-accordion-horizontal' );
			this.element.classList.add( 'mab-image-accordion-vertical' );
		}
	},

	resetAll: function() {
		this.items.forEach( function( item ) {
			item.style.flex = '1';
			item.classList.remove( 'mab-image-accordion-active' );
		} );
	}
};

function mabImageAccordion() {
	bricksQuerySelectorAll(document, '.brxe-max-image-accordion').forEach(function (e) {
		new MabImageAccordion( e );
	});
}

document.addEventListener( 'DOMContentLoaded', function (e) {
	if ( bricksIsFrontend ) {
		mabImageAccordion();
	}
});