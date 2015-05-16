(function(window, document, $) {

	function refusebotSubmit (query) {

		$.ajax('http://hackathon.local/refuse-bot', {
			dataType: 'json',
			error: function(jqXhr, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			},
			success: function(data, textStatus, jqXhr) {
				var _responses = data.responses;

				_responses.map(function(answer, idx, responses) {
					return answer.noun == query;
				});

			}
		});
	}

	function refusebotKeydown ($submit) {
		$submit.removeAttr('disabled');
	}

	$(document).ready(function() {

		var $formRefusebotSubmit = $('#form-refusebot-submit'),
			$formRefusebotInput = $('#form-refusebot-query');

		$formRefusebotSubmit.on('click', function (event) {
			event.preventDefault();

			var _query = $formRefusebotInput.val();

			if (_query.length) {
				refusebotSubmit(_query);
			} else {

			}

		});

		$formRefusebotInput.on('keydown', function(event) {
			if (event.keyCode > 64 && event.keyCode < 81) {
				refusebotKeydown($formRefusebotSubmit);
			}
		});

	});

}(window, document, jQuery));