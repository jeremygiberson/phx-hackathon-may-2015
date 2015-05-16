(function(window, document, $) {

	function errorHandler (jqXhr, textStatus, errorThrown) {
		console.log(textStatus, errorThrown);
	}

	if (!String.prototype.toTitleCase) {
		String.prototype.toTitleCase = function () {
			return this.replace(/\w\S*/g, function(txt){
				return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
			});
		};
	}

	function refusebotSubmit (query) {

		$.ajax('http://hackathon.local/refuse-bot', {
			data: {},
			dataType: 'json',
			error: errorHandler,
			success: successHandler
		});

		function successHandler (data, textStatus, jqXhr) {

			hide('#form-pickup-days');
			updateResultsDom(data);
			show('#results-pickup-days');
		}

		function updateResultsDom (data) {
			var _$results = $('#refusebot-message');

			_$results
		}

	}

	function hide (element) {
		var _$el = element;

		if (typeof element === 'string') {
			_$el = $(element);
		}

		_$el.addClass('hidden');
	}

	function show (element) {
		var _$el = element;

		if (typeof element === 'string') {
			_$el = $(element);
		}

		_$el.removeClass('hidden');
	}

	function pickupDaysSubmit (query) {

		$.ajax('http://hackathon.local/collection-days', {
			data: {
				"address": query
			},
			dataType: 'json',
			error: errorHandler,
			success: successHandler
		});

		function successHandler (data, textStatus, jqXhr) {

			hide('#form-pickup-days');
			updateResultsDom(data);

		}

		function updateResultsDom (data) {

			var _garbageDay = data.GARBAGE,
				_recycleDay = data.RECYCLE,
				_$results = $('#results-pickup-days'),
				html = [
					'<tr><td>Garbage:</td><td>', _garbageDay.toTitleCase(), '</td></tr>',
					'<tr><td>Recycling:</td><td>', _recycleDay.toTitleCase(), '</td></tr>'
				].join('');

			$('table', _$results).html(html);
			show(_$results);

		}

	}

	$(document).ready(function() {

		var $formRefusebotSubmit = $('#form-refusebot-submit'),
			$formRefusebotInput = $('#form-refusebot-query'),
			$formPickupDaySubmit = $('#form-pickup-days-submit'),
			$formPickupDayInput = $('#form-pickup-days-query');

		$formRefusebotSubmit.on('click', function (event) {
			event.preventDefault();
			refusebotSubmit();
		});

		$formPickupDaySubmit.on('click', function (event) {
			event.preventDefault();

			var query = $formPickupDayInput.val();

			pickupDaysSubmit(query);
		});

	});

}(window, document, jQuery));