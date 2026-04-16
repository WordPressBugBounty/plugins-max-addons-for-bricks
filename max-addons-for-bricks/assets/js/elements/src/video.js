MabVideo = function ( element ) {
	this.element = element;
	this.window  = window;

	this.init();
	this.initSticky();
};

MabVideo.prototype = {
	init: function () {
		var videoPlay = this.element.querySelector( '.mab-video-play' ),
			action    = videoPlay.dataset.action,
			autoplay  = videoPlay.dataset.autoplay,
			self      = this;

		if ( action === 'inline' ) {
			videoPlay.addEventListener( 'click', function(e) {
				e.preventDefault();
				const player = e.currentTarget.querySelector('.mab-video-player');
				const wrap = (self.isStickyEnabled()) ? self.element.querySelector('.mab-video-wrap') : null;
				self.playVideoInline(player, wrap);
			});
		}

		if (action === 'inline' && autoplay === '1') {

			const player = this.element.querySelector('.mab-video-player');
			const playerWrap = this.element.querySelector('.mab-video-wrap');

			this.playVideoInline(player, playerWrap);
		}
	},

	playVideoInline: function(player, wrap) {
		if (player.querySelector('iframe')) {
			return;
		}

		const vidSrc = player.dataset.src;
		const iframe = document.createElement('iframe');

		iframe.setAttribute('src', vidSrc);
		iframe.setAttribute('frameborder', '0');
		iframe.setAttribute('allowfullscreen', '1');
		iframe.setAttribute('allow', 'autoplay; encrypted-media; picture-in-picture');

		// Remove thumb + icon
		player.innerHTML = '';

		player.appendChild(iframe);

		// Remove click overlay so video is clickable
		if (wrap && wrap.classList) {
			wrap.classList.add('mab-video-playing');
		}
	},

	isStickyEnabled: function() {
		return ( this.element.hasAttribute( 'data-sticky-video' ) );
	},

	stickyCheckBreakpoint: function() {
		var breakpoints    = this.element.dataset.stickyVideo,
			breakpointsArr = breakpoints ? breakpoints.split(',') : [];

		if ( !breakpointsArr.length ) {
			return false;
		}

		if (
			breakpointsArr.length &&
			!breakpointsArr.some(function (e) {
				var width = _slicedToArray(
						e.split('-').map(function (e) {
							var width = Number(e);
							return isNaN(width) ? (console.error( 'Invalid width value: '.concat(e)), 0) : width;
						}),
						2
					),
					minWidth = width[0],
					maxWidth = width[1];

				return window.innerWidth >= minWidth && window.innerWidth <= maxWidth;
			})
		) {
			return false;
		} else {
			return true;
		}
	},

	initSticky: function() {
		if (this.isStickyEnabled()) {
			const observerOptions = {
				root: null,
				rootMargin: '0px',
				threshold: 0.5
			};

			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						this.element.classList.remove('mab-sticky-video');
					} else {
						this.element.classList.add('mab-sticky-video');
					}
				});
			}, observerOptions);

			this.doSticky(observer);

			const closeButton = this.element.querySelector('.mab-sticky-close');
			if (closeButton) {
				closeButton.addEventListener('click', () => {
					this.disableSticky(observer);
				});
			}

			const handleResize = () => {
				this.doSticky(observer);
			};

			window.addEventListener('resize', handleResize);
		}
	},

	doSticky: function(observer) {
		if (this.stickyCheckBreakpoint()) {
			this.disableSticky(observer);
		} else {
			observer.observe(this.element);
		}
	},

	disableSticky: function(observer) {
		observer.unobserve(this.element);
		this.element.classList.remove('mab-sticky-video');
	}
};

function mabVideo() {
	bricksQuerySelectorAll(document, '.brxe-max-video').forEach(function (e) {
		new MabVideo(e);
	});
}

document.addEventListener( 'DOMContentLoaded', function (e) {
	if ( bricksIsFrontend ) {
		mabVideo();
	}
});
