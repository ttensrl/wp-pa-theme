/* Pagine di dettaglio ASL: pulsante "Condividi" e indice della pagina attivo. */
(function () {
	'use strict';

	document.querySelectorAll('[data-asl-share]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var data = { title: document.title, url: window.location.href };
			if (navigator.share) {
				navigator.share(data).catch(function () {});
			} else if (navigator.clipboard) {
				navigator.clipboard.writeText(data.url).then(function () {
					var label = btn.querySelector('span');
					if (label) {
						var old = label.textContent;
						label.textContent = btn.getAttribute('data-copied') || 'Link copiato';
						setTimeout(function () { label.textContent = old; }, 2000);
					}
				});
			}
		});
	});

	var index = document.querySelector('[data-asl-index="anchors"]');
	if (!index || !('IntersectionObserver' in window)) { return; }
	var links = Array.prototype.slice.call(index.querySelectorAll('a[href^="#"]'));
	var map = {};
	links.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });
	var visible = {};
	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) { visible[e.target.id] = e.isIntersecting; });
		var first = Object.keys(map).find(function (id) { return visible[id]; });
		if (first) {
			links.forEach(function (a) {
				var on = a === map[first];
				a.parentNode.classList.toggle('is-current', on);
				if (on) { a.setAttribute('aria-current', 'location'); } else { a.removeAttribute('aria-current'); }
			});
		}
	}, { rootMargin: '0px 0px -60% 0px' });
	Object.keys(map).forEach(function (id) {
		var el = document.getElementById(id);
		if (el) { io.observe(el); }
	});
})();
