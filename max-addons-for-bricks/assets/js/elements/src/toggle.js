MabToggle = function( element ) {
	this.element  = element;
	this.buttons  = '';
	this.contents = '';

	this.init();
};

MabToggle.prototype = {
	id      : '',
	settings: {},

	init: function() {
		var designType = this.element.getAttribute('data-design-type');

		if ( 'button' === designType ) {
			this.initButtons();
		} else {
			this.initSwitch();
		}
	},

	initButtons: function() {
		this.buttons  = this.element.querySelectorAll('.mab-toggle-button'),
		this.contents = this.element.querySelectorAll('.mab-toggle-content');

		this.buttons.forEach( function( button ) {
			button.addEventListener( 'click', this.onButtonClick.bind( this, button ) );
		}.bind( this ) );
	},

	initSwitch: function() {
		var toggleSwitch      = this.element.querySelector('.mab-toggle-switch.mab-input-label'),
			input             = this.element.querySelector('input.mab-toggle-toggle-switch'),
			primarySwitcher   = this.element.querySelector('.mab-toggle-switch.primary'),
			secondarySwitcher = this.element.querySelector('.mab-toggle-switch.secondary'),
			primaryContent    = this.element.querySelector('.mab-toggle-content.primary'),
			secondaryContent  = this.element.querySelector('.mab-toggle-content.secondary');

		toggleSwitch.addEventListener('click', function(e){

			if ( input.checked ) {
				primarySwitcher.classList.remove('active');
				primaryContent.classList.remove('active');
				secondarySwitcher.classList.add('active');
				secondaryContent.classList.add('active');
			} else {
				secondarySwitcher.classList.remove('active');
				secondaryContent.classList.remove('active');
				primarySwitcher.classList.add('active');
				primaryContent.classList.add('active');
			}
		});
	},

	onButtonClick: function(button, e) {
		e.preventDefault();

		if ( button.classList.contains( 'active' ) ) {
			return;
		} else {
			this.resetButtons();

			button.classList.add( 'active' );

			var contentId = button.getAttribute( 'data-content-id' );

			document.getElementById( contentId ).classList.add( 'active' );
		}
	},

	resetButtons: function() {
		this.buttons.forEach( function( button ) {
			button.classList.remove( 'active' );
		} );

		this.contents.forEach( function( content ) {
			content.classList.remove( 'active' );
		} );
	}
};

function mabToggle() {
	bricksQuerySelectorAll(document, '.brxe-max-content-toggle').forEach(function (e) {
		new MabToggle(e);
	});
}

document.addEventListener( 'DOMContentLoaded', function (e) {
	if ( bricksIsFrontend ) {
		mabToggle();
	}
});
