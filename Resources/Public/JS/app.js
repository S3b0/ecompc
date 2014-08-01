/*
* ecom Configurator :: app.js
* */

// Equalize height of checkbox and package selection on resize.
(function($) {
	function equalizeHeight() {
		$('#tx-ecompc-canvas .ecom-configurator-package-select').each(function() {
			$(this).siblings('.ecom-configurator-package-state').height($(this).outerHeight());
		});
	}equalizeHeight();
	$(window).resize(function() {
		equalizeHeight();
	});
})(jQuery);


// Package-OptionList => Popover for hint text
(function($) {
	var triggerHint = '#tx-ecompc-canvas .ecom-configurator-select-package-option-info',
		hintBoxSelector = '#tx-ecompc-canvas .ecom-configurator-select-package-option-info-hint-box',
		windowHeight,
		popupHeight,
		scrollPosition,
		currentHintBox;

	// Hide the Box Function
	function hideHintBox(hintBox) {
		$(hintBox).fadeOut('fast', function() {
			$(this).css({'display': 'none', 'opacity': 0, 'top': 0});
		}).stop(true, true);
	}
	// Popup on click
	$(triggerHint).on('click', function() {
		// First hide every active hint box
		hideHintBox(hintBoxSelector);

		// Setting new vars
		windowHeight = $(window).height();
		currentHintBox = $(this).parents('.ecom-configurator-select-package-option-wrap').next('.ecom-configurator-select-package-option-info-hint-box');

		// Calculate position of the hint-box
		popupHeight = $(currentHintBox).outerHeight();
		scrollPosition = (windowHeight - popupHeight) / 2;
		// Show Popup
		currentHintBox.css('display', 'block').animate({'top': scrollPosition, 'opacity': 1}, 'fast');

		// Prevent Option-a-tag from executing
		return false;
	});
	// Hide hint-box on click and ESC key
	$('#tx-ecompc-canvas .ecom-configurator-select-package-option-info-hint-box .close-popover-x, #tx-ecompc-canvas .ecom-configurator-select-package-option-info-hint-box, body').on('click keyup', function(e) {
		// If the keyup event is triggered
		if (e.type == 'keyup') {
			if (e.keyCode == 27) {
				hideHintBox(hintBoxSelector);
			}
		// If click event is triggered
		} else {
			hideHintBox(hintBoxSelector);
		}
	});
})(jQuery);