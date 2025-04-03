MabHotspots = function( args ) {
	this.id       = args.id;
	this.element  = args.element;
	this.hotspots = [];

	this.init();
};

MabHotspots.prototype = {
	id      : '',
	element : '',

	init: function() {
		var tooltipOptions = this.element.getAttribute( 'data-tooltip-options' );

		if ( 'undefined' === typeof tooltipOptions || '' === tooltipOptions ) {
			return;
		}

		tooltipOptions = JSON.parse( tooltipOptions );

		var trigger  = tooltipOptions.trigger,
			position = tooltipOptions.position,
			arrow    = tooltipOptions.arrow,
			width    = tooltipOptions.width,
			distance = tooltipOptions.distance;

		this.element.querySelectorAll( '.mab-hotspot-wrap' ).forEach( function( hotspot ) {
			if ( hotspot.classList.contains( 'mab-hotspot-tooptip' ) ) {

				var instance = tippy( hotspot.querySelector('.mab-hotspot'), {
					content    : hotspot.querySelector('.mab-tooltip-content'),
					allowHTML  : true,
					interactive: true,
					placement  : position,
					arrow      : arrow,
					trigger    : trigger,
					appendTo   : hotspot.querySelector('.mab-tooltip'),
					offset     : [0, parseInt( distance )],
					maxWidth   : width ? parseInt( width ) : 'none',
				} );

				this.hotspots.push( instance );
			}
		}.bind( this ) );
	}
};

function mabHotspots() {
	bricksQuerySelectorAll(document, '.brxe-max-hotspots').forEach(function (e) {
		new MabHotspots(e);
	});
}

document.addEventListener( 'DOMContentLoaded', function (e) {
	if ( bricksIsFrontend ) {
		mabHotspots();
	}
});