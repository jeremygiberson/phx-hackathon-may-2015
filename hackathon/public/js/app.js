(function(window, document, $) {

	function errorHandler (jqXhr, textStatus, errorThrown) {
		console.log(textStatus, errorThrown);

		var response = jqXhr.responseJSON,
			selector,
			url;

		url = this.url.replace(/\?.*/, '');

		switch (url.substring(23)) {
			case 'refuse-bot':
				selector = '#form-refusebot';
				break;
			case 'collection-days':
				console.log('collection-days');
				break;
			case 'remind-me':
				console.log('remind-me');
				break;
			default:
				return false;
		}

		$(selector).append(['<div class="alert alert-danger alert-dismissible" role="alert">',
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close">',
									'<span aria-hidden="true">&times;</span>',
								'</button>',
								'<p><strong>' + response.title + '</strong><br>' + response.detail + '</p>',
							'</div>'].join(''));


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

			hide('#form-refusebot');
			updateResultsDom(data);

		}

		function updateResultsDom (data) {
			var _$results = $('#refusebot-message'),
				message = [];

			for (var i = data.responses.length - 1; i >= 0; i--) {

				var row = [];

				if (i == data.responses.length - 1) {
					message.push(' Lastly, for a <strong>' + data.responses[i].noun + '</strong> you can ' + data.responses[i].instructions + '.');
				} else if (i === 0) {
					message.push('For a <strong>' + data.responses[i].noun + '</strong>, you can ' + data.responses[i].instructions + '.');
					message.reverse();
				} else {
					message.push(' For a <strong>' + data.responses[i].noun + '</strong>, you can ' + data.responses[i].instructions + '.');
				}

			}

			_$results.html(message);

			$('#refusebot').addClass('open');
			show(_$results);
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

	function emailSubmit (query) {

		$.ajax('http://hackathon.local/remind-me', {
			data: query,
			success: successHandler
		});

		function successHandler (data, textStatus, jqXhr) {

			hide('#form-email');
			updateResultsDom(data);

		}

		function updateResultsDom (data) {

			var _$message = $('#results-email-message'),
				_$streetAddress = $('#results-email-street-address'),
				_$emailAddress = $('#results-email-email-address'),
				_$alerts = $('#results-email-alerts'),
				rows = [];

			_$message.html('<strong>Awesome!</strong> ' + data.message + ' They\'ll be sent to ' + data.email);
			_$streetAddress.html(data.address);
			_$emailAddress.html(data.email);

			for (var i = data.reminders.length - 1; i >= 0; i--) {

				rows.push([
					'<tr>',
						'<td>' + data.reminders[i].container.toTitleCase() + ': </td>',
						'<td>' + data.reminders[i].day.toTitleCase() + '</td>',
					'</tr>'
				].join(''));

			}

			$('table', '#results-pickup-days').empty();
			hide('#results-pickup-days');

			$('#results-email-reminders').append(rows);

			show('#results-email');

		}
	}

	$(document).ready(function() {

		var $formRefusebotSubmit = $('#form-refusebot-submit'),
			$formRefusebotInput = $('#form-refusebot-query'),
			$formPickupDaySubmit = $('#form-pickup-days-submit'),
			$formPickupDayInput = $('#form-pickup-days-query'),
			$formEmailSubmit = $('#form-email-submit'),
			$formEmailInput = $('#form-email-input');

		$formRefusebotSubmit.on('click', function (event) {
			event.preventDefault();
			var query = $formRefusebotInput.val();

			if (!query.length) {
				alert('enter data, nerd.');
			} else {
				refusebotSubmit(query);
			}

		});

		$formPickupDaySubmit.on('click', function (event) {
			event.preventDefault();

			var query = $formPickupDayInput.val();

			if (!query.length) {
				alert('enter data, nerd.');
			} else {
				pickupDaysSubmit(query);
			}

		});

		$formEmailSubmit.on('click', function (event) {
			event.preventDefault();

			var query = {
				email: $formEmailInput.val(),
				address: $formPickupDayInput.val(),
			};

			if (!query.email.length) {
				alert('enter data, nerd.');
			} else {
				emailSubmit(query);
			}

		});

	});

}(window, document, jQuery));