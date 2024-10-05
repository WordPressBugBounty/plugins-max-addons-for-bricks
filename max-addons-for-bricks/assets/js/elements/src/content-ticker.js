MabTicker = function( element ) {
	this.element  = element;
	this.sliders  = {};

	this.init();
};

MabTicker.prototype = {
	id      : '',
	element : '',

	init: function() {
		var ticker        = this.element.querySelector('.mab-ticker'),
			nextButton    = this.element.querySelector('.bricks-swiper-button-next'),
			prevButton    = this.element.querySelector('.bricks-swiper-button-prev'),
			slidesContent = this.element.querySelectorAll('.mab-ticker-content'),
			sliderOptions = JSON.parse( this.element.dataset.sliderOptions );

		if ( sliderOptions.arrows ) {
			sliderOptions.navigation = {
				'prevEl': prevButton,
				'nextEl': nextButton
			};
		}

		sliderOptions.on = {
			init: (swiper) => {
				var contentheight = 0;

				slidesContent.forEach(function (slide) {
					if ( slide.offsetHeight > contentheight ) {
						contentheight = slide.offsetHeight;
					}
				});

				swiper.slides.forEach(function (slide) {
					slide.style.maxHeight = contentheight + 'px';
				});
			},
		};

		this.sliders.main = new Swiper( ticker, sliderOptions );
	}
};

function mabTicker() {
	bricksQuerySelectorAll(document, '.brxe-max-content-ticker').forEach(function (e) {
		new MabTicker( e );
	});
}

document.addEventListener( 'DOMContentLoaded', function (e) {
	if ( bricksIsFrontend ) {
		mabTicker();
	}
});