class MabScrollImage {
	constructor(element) {
		this.element        = element;
		this.container      = element.querySelector('.max-scroll-image-container');
		this.settings       = JSON.parse(this.container.getAttribute('data-settings'));
		this.direction      = this.getDirection();
		this.scrollOverlay  = element.querySelector('.max-image-scroll-overlay');
		this.verticalScroll = element.querySelector('.max-image-scroll-vertical');
		this.imageScroll    = element.querySelector('.max-scroll-image-container img');

		this.init();
		this.handleTrigger();
	}

	init() {
		const { trigger } = this.settings;
		const reverse = this.checkReverse();

		if (trigger === 'scroll') {
			if (this.direction === 'vertical') {
				this.verticalScroll.classList.add('max-image-scroll-ver');
			} else {
				this.adjustOverlaySize();
			}
		} else {
			if (reverse) {
				this.element.classList.add('max-container-scroll-instant');
				this.setTransform();
				this.startTransform();
			}
			if (this.direction === 'vertical') {
				this.verticalScroll.classList.remove('max-image-scroll-ver');
			}
		}
	}

	handleTrigger() {
		const { trigger } = this.settings;
		const reverse = this.checkReverse();

		const interactionHandler = event => {
			const isElement = event.target === this.element || this.element.contains(event.target);

			if (trigger === 'click' && isElement || trigger !== 'click') {
				this.element.classList.remove('max-container-scroll-instant');
				this.setTransform();
				this.toggleTransform(reverse);
			} else {
				this.toggleTransform(!reverse);
			}
		};

		if (trigger === 'click' || trigger === 'hover') {
			const eventTarget = trigger === 'click' ? document.body : this.element;
			eventTarget.addEventListener(trigger === 'click' ? 'click' : 'mouseenter', interactionHandler);

			if (trigger === 'click') {
				document.body.addEventListener('click', interactionHandler);
			} else {
				this.element.addEventListener('mouseleave', () => this.toggleTransform(!reverse));
			}
		} else if (trigger === 'viewport') {
			const observer = new IntersectionObserver(entries => {
				entries.forEach(entry => {
					this.toggleBasedOnViewport(entry, reverse);
				});
			}, { threshold: 0.5 });

			observer.observe(this.element);
		}
	}

	toggleBasedOnViewport(entry, reverse) {
		this.element.classList.toggle('max-container-scroll-instant', !entry.isIntersecting);
		this.setTransform();
		this.toggleTransform(entry.isIntersecting ? reverse : !reverse);
	}

	adjustOverlaySize() {
		if (this.scrollOverlay) {
			this.scrollOverlay.style.width = `${this.element.offsetWidth}px`;
			this.scrollOverlay.style.height = `${this.element.offsetHeight}px`;
		}
	}

	getDirection() {
		const { direction } = this.settings;
		return ['top', 'bottom'].includes(direction) ? 'vertical' : 'horizontal';
	}

	checkReverse() {
		const { direction } = this.settings;
		return ['bottom', 'right'].includes(direction);
	}

	startTransform() {
		this.applyTransform(`-${this.settings.transformOffset}px`);
	}

	endTransform() {
		this.applyTransform('0px');
	}

	setTransform() {
		this.settings.transformOffset = this.direction === 'vertical' ? this.imageScroll.offsetHeight - this.container.offsetHeight : this.imageScroll.offsetWidth - this.container.offsetWidth;
	}

	applyTransform(offset) {
		this.imageScroll.style.transform = `${this.direction === 'vertical' ? 'translateY' : 'translateX'}(${offset})`;
	}

	toggleTransform(reverse) {
		if (reverse) {
			this.endTransform();
		} else {
			this.startTransform();
		}
	}
}

document.addEventListener('DOMContentLoaded', () => {
	if (window.bricksIsFrontend) {
		document.querySelectorAll('.brxe-max-scroll-image').forEach(element => {
			new MabScrollImage(element);
		});
	}
});
