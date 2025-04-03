MabLottie = function( element ) {
	this.element       = element;
	this.id            = this.element.getAttribute( 'data-element-id' );
	this.player        = this.element.querySelector( '#lottie-player-' + this.id );
	this.jsonSrc       = this.player.src;
	this.lottie        = this.player.getLottie();
	this.firstFrame    = this.lottie.firstFrame;
	this.totalFrames   = this.lottie.totalFrames;
	this.newCycle      = true;
	this.playDirection = 'forward';
	this.observer      = null;

	this.settings = this.element.getAttribute('data-settings');
	this.settings = JSON.parse( this.settings );

	if ( this.element.classList.contains( 'mab-backend' ) ) {
		this.init();
	}

	this.lottie.addEventListener( 'DOMLoaded', this.init.bind( this ) );
	this.lottie.addEventListener( 'complete', this.complete.bind( this ) );
};

MabLottie.prototype = {
	id      : '',
	element : '',
	settings: {},

	init: function() {
		this.firstFrame  = this.lottie.firstFrame;
		this.totalFrames = this.lottie.totalFrames;

		var offset = this.getOffset();
		var frames = this.getFrameRange();

		var selector  = this.settings.selector && '' !== this.settings.selector ? this.settings.selector : '#lottie-player-' + this.id;
		var elements  = null;
		var lottie    = null;
		var trigger   = this.settings.trigger;
		var isReverse = 'yes' === this.settings.reverse;

		this.removeObserver();

		if ( 'scroll' === trigger ) {
			LottieInteractivity.create({
				player: '#lottie-player-' + this.id,
				container: '#lottie-player-' + this.id,
				mode: 'scroll',
				actions: [
					{
						visibility: [0, offset.bottom],
						type: 'stop',
						frames: [frames.start],
					},
					{
						visibility: [offset.bottom, offset.top],
						type: 'seek',
						frames: [frames.start, frames.end],
					},
					{
						visibility: [offset.top, 1],
						type: 'stop',
						frames: [frames.end],
					},
				]
			});
		}

		if ( 'hover' === trigger ) {
			elements = bricksQuerySelectorAll( document, selector );

			if ( elements.length === 0 ) {
				return;
			}

			lottie = this.player.getLottie();

			lottie.goToAndStop( frames.start, true );

			elements.forEach( function( element ) {
				element.addEventListener( 'mouseenter', function() {
					lottie.setDirection(1);
					if ( isReverse ) {
						lottie.playSegments( [ frames.end, frames.start ], true );
					} else {
						lottie.playSegments( [ frames.start, frames.end ], true );
					}
				} );

				element.addEventListener( 'mouseleave', function() {
					lottie.setDirection(-1);
					lottie.play();
				} );
			} );
		}

		if ( 'click' === trigger ) {
			elements = mabFrontend.domHelpers.querySelectorAll( selector );

			if ( elements.length === 0 ) {
				return;
			}

			this.player.seek( frames.start );

			var replay = this.settings.onAnotherClick && 'replay' === this.settings.onAnotherClick;

			lottie = this.player.getLottie();

			elements.forEach( function( element ) {
				element.addEventListener( 'click', function() {
					replay && lottie.stop();
					if ( isReverse ) {
						lottie.playSegments( [ frames.end, frames.start ], true );
					} else {
						lottie.playSegments( [ frames.start, frames.end ], true );
					}
				} );
			} );
		}

		if ( 'cursor' === trigger ) {
			LottieInteractivity.create({
				player: '#lottie-player-' + this.id,
				container: selector,
				mode: 'cursor',
				actions: [
					{
						position: {
							x: [0, 1],
							y: [0, 1]
						},
						type: 'seek',
						frames: [frames.start, frames.end],
					}
				]
			});
		}

		if ( 'viewport' === trigger ) {
			lottie = this.player.getLottie();

			lottie.setDirection(1);

			var viewportTop = 100 - ((1 + offset.top) * 100),
				viewportBottom = offset.bottom * 100,
				isInViewport = false;

			this.player.seek( frames.start );

			if ( 'undefined' === typeof IntersectionObserver ) {
				window.addEventListener( 'scroll', function() {
					this.lottie = this.player.getLottie();

					if ( mabFrontend.domHelpers.isInViewport( this.player ) ) {
						isInViewport = true;
						this.playLottie();
					} else {
						isInViewport = false;
						lottie.pause();
					}
				}.bind(this) );
			} else {
				this.observer = mabFrontend.domHelpers.scrollObserver( {
					offset: -(viewportBottom) + '% 0% ' + (viewportTop) + '%',
					callback: function(e) {
						if (e.isInViewport) {
							isInViewport = true;
							this.playLottie();
						} else {
							isInViewport = false;
							lottie.pause();
						}
					}.bind( this )
				} );

				this.observer.observe( this.player );
			}
		}
	},

	complete: function() {
		this.newCycle = true;

		this.element.dispatchEvent(new Event('max_lottie:complete'));

		if ( 'viewport' !== this.settings.trigger ) {
			return;
		}

		if ( 'yes' === this.settings.loop && 'yes' !== this.settings.reverse ) {
			this.playLottie();
		}
		if ( 'yes' === this.settings.loop && 'yes' === this.settings.reverse ) {
			this.playDirection = 'forward' === this.playDirection ? 'backward' : 'forward';
			this.playLottie();
		}
		if ( 'yes' !== this.settings.loop && 'yes' === this.settings.reverse ) {
			this.playDirection = 'backward';
		}
	},

	getOffset: function() {
		var viewport = this.settings.viewport;

		if ( 'undefined' === typeof viewport ) {
			viewport = {
				top: 1,
				bottom: 0
			};
		}

		var top = 'undefined' === typeof viewport.top ? 1 : parseInt( viewport.top );
		var bottom = 'undefined' === typeof viewport.bottom ? 0 : parseInt( viewport.bottom );

		return {
			top: 1 - top / 100,
			bottom: bottom / 100
		};
	},

	getFrames: function() {
		var frameRange = this.getFrameRange();

		var currentFrame = 0 === this.lottie.firstFrame ? this.lottie.currentFrame : this.lottie.firstFrame + this.lottie.currentFrame;

		var firstFrame = this.firstFrame,
			lastFrame = 0 === this.firstFrame ? this.totalFrames : this.firstFrame + this.totalFrames;

		if ( frameRange.start && frameRange.start > firstFrame ) {
			firstFrame = frameRange.start;
		}
		if ( frameRange.end && frameRange.end < lastFrame ) {
			lastFrame = frameRange.end;
		}

		if ( ! this.newCycle && 'scroll' !== this.settings.trigger ) {
			firstFrame = frameRange.start && frameRange.start > currentFrame ? frameRange.start : currentFrame;
		}

		// Reverse.
		if ( 'backward' === this.playDirection && 'yes' === this.settings.reverse ) {
			firstFrame = currentFrame;
			lastFrame = frameRange.start && frameRange.start > this.firstFrame ? frameRange.start : this.firstFrame;
		}

		return {
			first: firstFrame,
			last: lastFrame,
			current: currentFrame,
			total: this.totalFrames
		};
	},

	getFrameRange: function() {
		var start = parseInt( this.settings.start ) || 0;
		var end = parseInt( this.settings.end ) || 0;

		//start = Math.min(100, Math.max(0, start));
		//end = Math.min(100, Math.max(0, end));
		
		return {
			start: start,
			end: end
		};
	},

	playLottie: function() {
		var frames = this.getFrames();

		this.lottie.stop();
		this.lottie.playSegments( [frames.first, frames.last], true );

		this.newCycle = false;
	},

	removeObserver: function() {
		if ( this.observer ) {
			this.observer.unobserve( this.player );
		}
	},

	start: function() {
		var directionMenu,
			trigger = this.settings.trigger;

		if ( 'click' === trigger ) {
			directionMenu = 'yes' === this.settings.reverse ? -1 : 1;
			var state = 'play';
			this.animation.addEventListener('click', (e) => {
				this.lottie.setDirection(directionMenu);
				this.lottie.stop();
				if ( 'play' === state ) {
					this.lottie.play();
					state = 'pause';
				} else {
					this.lottie.pause();
					state = 'play';
				}
				directionMenu = 'yes' === this.settings.reverse ? 1 : -1;
			});
		}

		if ( 'hover' === trigger ) {
			directionMenu = 'yes' === this.settings.reverse ? -1 : 1;
			this.animation.addEventListener('mouseenter', (e) => {
				this.lottie.setDirection(directionMenu);
				this.lottie.play();
				directionMenu = 'yes' === this.settings.reverse ? 1 : -1;
			});
	  
			this.animation.addEventListener('mouseleave', (e) => {
				this.lottie.setDirection(directionMenu);
				this.lottie.play();
			});
		}

		var viewport = this.settings.viewport;

		if ( 'undefined' === typeof viewport ) {
			viewport = {
				top: 100,
				bottom: 0
			};
		}

		viewport.top = 'undefined' === typeof viewport.top ? 100 : parseInt( viewport.top );
		viewport.bottom = 'undefined' === typeof viewport.bottom ? 0 : parseInt( viewport.bottom );

		if ( 'viewport' === trigger ) {
			this.lottie.setDirection(1);

			this.observer = this.scrollObserver( {
				offset: viewport.bottom + '% 0% ' + viewport.top + '%',
				callback: function(e) {
					if (e.isInViewport) {
						this.isInViewport = true;
						this.lottie.play();
					} else {
						this.isInViewport = false;
						this.lottie.pause();
					}
				}.bind( this )
			} );

			this.observer.observe( this.animation );
		}

		if ( 'scroll' === trigger ) {
			this.lottie.setDirection(1);

			this.observer = this.scrollObserver( {
				offset: viewport.bottom + '% 0% ' + viewport.top + '%',
				callback: function(e) {
					if (e.isInViewport) {
						this.isInViewport = true;

						var percent = this.getElementViewportPercentage( this.animation, viewport );
						percent = Math.min(100, Math.max(0, percent));

						this.lottie.goToAndStop(percent);
					} else {
						this.isInViewport = false;
						//this.lottie.pause();
					}
				}.bind( this )
			} );

			this.observer.observe( this.player );

			
		}

	},
};

function mabLottie() {
	bricksQuerySelectorAll(document, '.brxe-max-lottie').forEach(function (e) {
		new MabLottie(e);
	});
}

document.addEventListener( 'DOMContentLoaded', function (e) {
	if ( bricksIsFrontend ) {
		mabLottie();
	}
});