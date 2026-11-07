<?php
/** Landing di presentazione del progetto. */
get_header();

$demos = hub_demos();
$features = array(
	array( 'Bootstrap Italia', 'Componenti e tipografia (Titillium Web) conformi alle linee guida AgID.' ),
	array( 'Accessibilità', 'Landmark, skip link, focus visibile, slider con pausa e riduzione del movimento.' ),
	array( 'Boxed o full width', 'Il layout si sceglie dal Personalizza, con default boxed come i portali sanitari.' ),
	array( 'Hero con le news', 'Slider delle ultime notizie con immagini placeholder di default.' ),
	array( 'Organigramma e strutture', 'Persone, ruoli e unità collegate organizzati in accordion e schede.' ),
	array( 'Bandi e concorsi', 'Elenco con filtro per anno, stato In corso/Scaduto, allegati e aggiudicatari.' ),
	array( 'Sidebar a box', 'Navigazione di sezione, contatti, accesso rapido e guide, sempre a sinistra.' ),
	array( 'Prenotazioni e cookie', 'Appuntamenti online con slot e consenso cookie GDPR granulare.' ),
);
?>
<main id="contenuto">

	<section class="hub-hero">
		<div class="hub-container">
			<p class="hub-eyebrow">WP Digital Italia</p>
			<h1>Un unico tema,<br>tanti enti pubblici.</h1>
			<p class="hub-lead">Comuni, ASL e scuole sullo stesso tema WordPress: un parent accessibile basato su Bootstrap Italia e un child theme per ogni ente. Scegli una demo e naviga come un cittadino.</p>
			<div class="hub-cta">
				<a class="hub-btn hub-btn--solid" href="#demo">Esplora le demo</a>
				<a class="hub-btn hub-btn--ghost" href="#architettura">Come funziona</a>
			</div>
		</div>
		<div class="hub-hero__shapes" aria-hidden="true"><span></span><span></span><span></span></div>
	</section>

	<section id="demo" class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Scegli una demo</h2>
			<p class="hub-sub">Tre siti reali nella stessa installazione, ognuno con il proprio tema, i propri contenuti e il proprio profilo grafico.</p>
			<div class="hub-cards">
				<?php foreach ( $demos as $slug => $d ) :
					$url = hub_demo_url( $slug );
					?>
					<article class="hub-card" style="--c: <?php echo esc_attr( $d['color'] ); ?>">
						<span class="hub-card__tag"><?php echo esc_html( $d['tag'] ); ?></span>
						<h3><?php echo esc_html( $d['title'] ); ?></h3>
						<p><?php echo esc_html( $d['text'] ); ?></p>
						<ul>
							<?php foreach ( $d['items'] as $i ) : ?><li><?php echo esc_html( $i ); ?></li><?php endforeach; ?>
						</ul>
						<?php if ( $url ) : ?>
							<a class="hub-card__go" href="<?php echo esc_url( $url ); ?>">Entra nella demo <span aria-hidden="true">&rarr;</span><span class="visually-hidden"> <?php echo esc_html( $d['title'] ); ?></span></a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="funzioni" class="hub-section hub-section--alt">
		<div class="hub-container">
			<h2 class="hub-title">Cosa include</h2>
			<ul class="hub-features">
				<?php foreach ( $features as [ $t, $x ] ) : ?>
					<li><h3><?php echo esc_html( $t ); ?></h3><p><?php echo esc_html( $x ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section id="architettura" class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Come è fatto</h2>
			<p class="hub-sub">Un parent con tutto il lavoro pesante, un child sottilissimo per ogni ente, una rete multisite per la demo.</p>
			<div class="hub-arch" role="img" aria-label="Il tema parent WP Digital Italia è esteso dai child Comuni, ASL e Scuole, ognuno su un sito della rete multisite">
				<div class="hub-arch__parent">wp-pa-theme<small>parent &middot; Bootstrap Italia &middot; layout, CPT, accessibilità</small></div>
				<div class="hub-arch__lines" aria-hidden="true"></div>
				<div class="hub-arch__children">
					<div style="--c:#00796b">wp-pa-theme-comune<small>/comuni/</small></div>
					<div style="--c:#0066cc">wp-pa-theme-asl<small>/asl/</small></div>
					<div style="--c:#6a3fa0">wp-pa-theme-scuola<small>/scuole/</small></div>
				</div>
			</div>
			<p class="hub-sub hub-sub--small">I siti stanno su percorsi virtuali (<code>/comuni/</code>, <code>/asl/</code>, <code>/scuole/</code>) della stessa installazione WordPress multisite; gli asset compilati sono già nel repository.</p>
		</div>
	</section>
</main>
<?php
get_footer();
