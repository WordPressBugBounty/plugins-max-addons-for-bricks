function mabSvgAnimation() {
	bricksQuerySelectorAll(document, '.brxe-max-svg-animation').forEach(function (e) {
		var element = e.querySelector('.mab-svg-animation');

		if ( element === '' || element === null ) {
			return;
		}

		var svgId     = element.getAttribute('data-id'),
			duration  = element.getAttribute('data-duration'),
			type      = element.getAttribute('data-type'),
			stroke    = element.getAttribute('data-stroke'),
			fillColor = element.getAttribute('data-fill-color');

		var drawSvg = new Vivus( svgId,
			{
				type: type,
				duration: duration,
				forceRender: false,
				start: 'inViewport',
				onReady: function (myVivus) {
					var items  = myVivus.el.childNodes,
						showId = document.getElementById(svgId);

					if ( fillColor !== 'none' ) {
						myVivus.el.style.fillOpacity = '0';
						myVivus.el.style.transition = 'fill-opacity 0s';
					}

					showId.style.opacity = '1';
					if ( stroke !== '' ) {
						for ( var i = 0; i < items.length; i++ ) {
							if ( items[i].children !== undefined ) {
								items[i].style.fill = fillColor;
								items[i].style.stroke = stroke;
							}

							var child     = items[i],
								pchildern = child.children;

							if ( pchildern !== undefined ) {
								for ( var j=0; j < pchildern.length; j++ ) {
									pchildern[j].style.fill = fillColor;
									pchildern[j].style.stroke = stroke;
								}
							}
						}
					}
				}
			}, function (myVivus) {
				if ( myVivus.getStatus() === 'end' && fillColor !== 'none' ) {
					myVivus.el.style.fillOpacity = '1';
					myVivus.el.style.transition = 'fill-opacity 1s';
				}
			} );

		if ( element.classList.contains('mab-hover-draw-svg') ) {
			e.querySelector('.mab-hover-draw-svg .mab-svg-inner-block').onmouseover = function() {
				drawSvg.reset().play();
			};
			e.querySelector('.mab-hover-draw-svg .mab-svg-inner-block').onmouseout = function() {
				drawSvg.finish();
			};
		}
	} );
}

document.addEventListener('DOMContentLoaded', function (e) {
	if (bricksIsFrontend) {
		mabSvgAnimation();
	}
});