/* Home Musei: avviso chiudibile (ricordato per sessione) e conferma della newsletter. */
(function () {
	'use strict';

	var alertBox = document.querySelector('[data-mu-alert]');
	if (alertBox) {
		var key = 'mu-alert-' + alertBox.getAttribute('data-mu-alert');
		try {
			if (window.sessionStorage.getItem(key)) { alertBox.hidden = true; }
		} catch (e) { /* storage non disponibile */ }
		var close = alertBox.querySelector('.mu-alert__close');
		if (close) {
			close.addEventListener('click', function () {
				alertBox.hidden = true;
				try { window.sessionStorage.setItem(key, '1'); } catch (e) { /* ignora */ }
			});
		}
	}

	document.querySelectorAll('[data-mu-newsletter]').forEach(function (form) {
		if (form.getAttribute('action') !== '#') { return; }
		form.addEventListener('submit', function (ev) {
			ev.preventDefault();
			var ok = form.querySelector('.mu-newsletter__ok');
			if (ok) { ok.hidden = false; }
			form.reset();
		});
	});
})();
