jQuery(function () {
	jQuery('#screen-meta').append(
		jQuery('#aps-wrap')
	);
	jQuery('#screen-meta-links').append(
		jQuery('#aps-link-wrap')
	);
	screenMeta.toggles.unbind('click');
	screenMeta.init();
	jQuery('[data-date-format]').each(function () {
		var $this = jQuery(this);
		$this.datepicker({
			dateFormat: $this.data('date-format')
		});
	});
	// compare selection
	jQuery('.input-prepend[data-options]').each(function () {
		var $input = jQuery(this), $ct = $input.parent(),
			$dd = jQuery('<ul />', { class: 'options-dropdown' });
		$dd.html(jQuery.map($input.data('options').split(','), function (value, idx) {
			var escape = jQuery('<div />').text(value);
			return ['<li>',
				'<a href="#" data-option="' + value + '">',
					escape.html(),
				'</a>',
			'</li>'].join('');
		})).on('click', 'a[data-option]', function (evt) {
			var $this = jQuery(this), $ct = $this.closest('.aps-filter');
			$ct.find('.input-prepend').val($this.data('option'));
			$ct.find('.options-dropdown').fadeOut(200);
			evt.preventDefault();
			return false;
		});
		$ct.append($dd);
		$input.click(function (evt) {
			var $dropdown = jQuery(this).parent().find('.options-dropdown').fadeIn(200);
			jQuery('.options-dropdown').not($dropdown).fadeOut(200);
			evt.preventDefault();
			return false;
		}).focus(function (evt) {
			jQuery(this).blur();
		});
	});
	jQuery('body').click(function (evt) {
		jQuery('.options-dropdown').fadeOut(200);
	});
});
