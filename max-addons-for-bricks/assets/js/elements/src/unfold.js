MabUnfold = function( element ) {
	this.element       = element;
	this.id            = this.element.getAttribute( 'data-element-id' );

	if ( 'undefined' !== typeof this.element.dataset.unfold ) {
		this.settings = JSON.parse( this.element.dataset.unfold );

		this.contentWrapper       = this.element.querySelector('.mab-unfold-content-wrapper');
		this.content              = this.element.querySelector('.mab-unfold-content');
		this.contentOuterHeight   = this.content.offsetHeight;
		this.contentWrapperHeight = '';
		this.button               = this.element.querySelector('.mab-unfold-button-inner');
		this.saparator            = this.element.querySelector('.mab-unfold-saparator');

		this.init();
	}
};

MabUnfold.prototype = {
	init: function () {
		var contentP             = this.content.querySelector('p'),
			contentType          = this.settings.content_type,
			contentVisibility    = this.settings.visibility,
			contentHeightCustom  = this.settings.content_height,
			speedUnreveal        = this.settings.speed,
			contentHeightLines   = this.settings.lines;

		if ( contentType === 'editor' ) {
			allStyle            = getComputedStyle(contentP),
			contentPaddingStyle = getComputedStyle(this.content),
			contentLineHeight   = allStyle.lineHeight,
			contentPaddingTop   = contentPaddingStyle.paddingTop;
		}

        if ( contentVisibility === 'lines' ) {
            if ( contentHeightLines === '0' ) {
                this.contentWrapperHeight = this.contentWrapper.outerHeight();
            } else {
                this.contentWrapperHeight = (parseInt(contentLineHeight, 10) * contentHeightLines) + parseInt(contentPaddingTop, 10);

				this.contentWrapper.style.height = this.contentWrapperHeight + 'px';
            }
        } else {
			this.contentWrapper.style.height = contentHeightCustom + 'px';
            this.contentWrapperHeight = contentHeightCustom;
        }

		this.contentWrapper.style.transitionDuration = speedUnreveal + 's';

		this.button.addEventListener('click', this.unfoldToggle.bind(this), true );
	},

	unfoldToggle: function() {
		this.saparator.classList.toggle('hide');
		this.button.classList.toggle('mab-unfolded');
		this.button.classList.toggle('hide');

		if ( this.button.classList.contains('mab-unfolded') ) {
			this.contentWrapper.style.height = this.contentOuterHeight + 'px';

			this.element.dispatchEvent(new Event('max_unfold:expand'));
		} else {
			this.contentWrapper.style.height = this.contentWrapperHeight + 'px';

			this.element.dispatchEvent(new Event('max_unfold:collapse'));
		}
	}
};

function mabUnfold() {
	bricksQuerySelectorAll(document, '.brxe-max-unfold').forEach(function (e) {
		new MabUnfold( e );
	});
}

document.addEventListener( 'DOMContentLoaded', function (e) {
	if ( bricksIsFrontend ) {
		mabUnfold();
	}
});
