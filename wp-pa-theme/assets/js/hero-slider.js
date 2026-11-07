/* Hero slider accessibile: frecce, pallini, pausa, pausa su hover/focus, rispetto di prefers-reduced-motion. */
(function () {
	document.querySelectorAll('.dci-hero-slider').forEach(function (root) {
		var slides = root.querySelectorAll('.dci-hero-slide');
		var dots = root.querySelectorAll('[data-go]');
		var pauseBtn = root.querySelector('.dci-hero-slider__pause');
		var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var interval = parseInt(root.dataset.interval, 10) || 6000;
		var current = 0, timer = null, userPaused = reduce, hoverPaused = false;
		var autoplay = root.dataset.autoplay === '1' && slides.length > 1;

		function show(n) {
			current = (n + slides.length) % slides.length;
			slides.forEach(function (s, i) {
				var on = i === current;
				s.hidden = !on;
				s.classList.toggle('is-active', on);
			});
			dots.forEach(function (d, i) {
				if (i === current) { d.setAttribute('aria-current', 'true'); } else { d.removeAttribute('aria-current'); }
			});
		}
		function stop() { if (timer) { clearInterval(timer); timer = null; } }
		function start() {
			stop();
			if (autoplay && !userPaused && !hoverPaused) { timer = setInterval(function () { show(current + 1); }, interval); }
		}
		function setPaused(p) {
			userPaused = p;
			if (pauseBtn) {
				pauseBtn.setAttribute('aria-pressed', p ? 'true' : 'false');
				var label = p ? pauseBtn.dataset.labelPlay : pauseBtn.dataset.labelPause;
				pauseBtn.setAttribute('aria-label', label);
				pauseBtn.firstElementChild.textContent = p ? '▶' : '❚❚';
			}
			root.querySelector('.dci-hero-slider__track').setAttribute('aria-live', p ? 'polite' : 'off');
			start();
		}

		root.querySelectorAll('[data-dir]').forEach(function (b) {
			b.addEventListener('click', function () { show(current + parseInt(b.dataset.dir, 10)); start(); });
		});
		dots.forEach(function (d) {
			d.addEventListener('click', function () { show(parseInt(d.dataset.go, 10)); start(); });
		});
		if (pauseBtn) { pauseBtn.addEventListener('click', function () { setPaused(!userPaused); }); }
		root.addEventListener('mouseenter', function () { hoverPaused = true; stop(); });
		root.addEventListener('mouseleave', function () { hoverPaused = false; start(); });
		root.addEventListener('focusin', function () { hoverPaused = true; stop(); });
		root.addEventListener('focusout', function () { hoverPaused = false; start(); });
		root.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft') { show(current - 1); start(); }
			if (e.key === 'ArrowRight') { show(current + 1); start(); }
		});

		if (reduce && pauseBtn) { setPaused(true); }
		start();
	});
})();
