<?php
/**
 * Template Name: Plugin SPID/CIE
 * Pagina di presentazione del plugin Auth SPID CIE.
 */
get_header();

$img   = get_stylesheet_directory_uri() . '/assets/img/';
$demo  = function_exists( 'hub_demo_url' ) && hub_demo_url( 'asl' ) ? hub_demo_url( 'asl' ) . '?authspidcie=choose' : '';

$features = array(
	array( 'SPID e CIE, un solo plugin', 'Service Provider SAML 2.0 per entrambi: richieste firmate, metadata per enti pubblici e privati.' ),
	array( 'Nessun account da gestire', 'Il cittadino si identifica e il sito riceve solo gli attributi necessari, in una sessione protetta.' ),
	array( 'Pulsanti pronti', 'Shortcode e pagina di accesso con l\'elenco dei gestori in ordine casuale, come da linee guida.' ),
	array( 'Integrato col tema', 'Il pulsante «Area personale» porta al login e mostra il nome del cittadino. Colori ereditati dal tema.' ),
	array( 'Certificati dal pannello', 'Generazione conforme all\'Avviso SPID n.29 o import di quelli già registrati.' ),
	array( 'Metadata sotto controllo', 'Salvi quello registrato e il plugin ti avvisa se cambia, prima che rompa l\'adesione.' ),
	array( 'Controlla il server', 'Verifica pratica di OpenSSL all\'attivazione: se l\'hosting non basta, blocca e spiega perché.' ),
	array( 'Zero dipendenze', 'Niente Composer né librerie esterne. Solo PHP 8 con le estensioni openssl, dom, libxml e mbstring.' ),
);
$steps = array(
	array( 'Il cittadino sceglie', 'SPID o CIE dalla pagina di accesso del sito.' ),
	array( 'Il sito chiede', 'Invia all\'identity provider una richiesta firmata.' ),
	array( 'Il gestore autentica', 'Il cittadino si identifica con le sue credenziali.' ),
	array( 'Il sito verifica', 'Controlla firma e contenuto della risposta, la usa una sola volta e apre la sessione.' ),
);
$security = array(
	array( 'Firma verificata sull\'elemento giusto', 'Contro il signature wrapping, ID duplicati, SHA-1, DOCTYPE ed entità esterne. Gli attributi si leggono solo dall\'Assertion firmata.' ),
	array( 'Anti-replay', 'Richiesta e asserzione si consumano una volta sola. Destination, Recipient, Audience, livello e tempi sono controllati.' ),
	array( 'Chiave privata protetta', 'Permessi 0600, file con guard PHP, .htaccess e index.php. Il pannello non la mostra mai.' ),
	array( 'I dati sopravvivono agli aggiornamenti', 'Aggiornare o reinstallare il plugin non cancella chiavi e metadata registrato. Provato con una reinstallazione vera.' ),
);
?>
<main id="contenuto">

	<section class="hub-hero hub-hero--plugin">
		<div class="hub-container">
			<p class="hub-eyebrow">Auth SPID CIE &middot; v0.1.0 in sviluppo</p>
			<h1>Accesso con SPID e CIE<br>per WordPress.</h1>
			<p class="hub-lead">Un plugin autonomo che porta SPID e CIE sul tuo sito istituzionale. Il cittadino si identifica con la sua identità digitale; tu ricevi solo i dati che servono, senza gestire account.</p>
			<div class="hub-cta">
				<?php if ( $demo ) : ?><a class="hub-btn hub-btn--solid" href="<?php echo esc_url( $demo ); ?>">Vedi la pagina di accesso</a><?php endif; ?>
				<a class="hub-btn hub-btn--ghost" href="#come">Come funziona</a>
			</div>
		</div>
		<div class="hub-hero__shapes" aria-hidden="true"><span></span><span></span><span></span></div>
	</section>

	<section id="cosa" class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Cosa offre</h2>
			<ul class="hub-features">
				<?php foreach ( $features as [ $t, $x ] ) : ?>
					<li><h3><?php echo esc_html( $t ); ?></h3><p><?php echo esc_html( $x ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section id="come" class="hub-section hub-section--alt">
		<div class="hub-container">
			<h2 class="hub-title">Come funziona</h2>
			<ol class="hub-steps">
				<?php foreach ( $steps as $i => [ $t, $x ] ) : ?>
					<li><span class="hub-steps__n" aria-hidden="true"><?php echo (int) $i + 1; ?></span><h3><?php echo esc_html( $t ); ?></h3><p><?php echo esc_html( $x ); ?></p></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="hub-section">
		<div class="hub-container hub-split">
			<div>
				<h2 class="hub-title hub-title--left">Integrato con il tema ASL</h2>
				<p class="hub-text">Con il tema WP Digital Italia (e i suoi child ASL, Comuni e Scuole) l'integrazione è automatica: il pulsante <strong>Area personale</strong> dell'header porta alla pagina di accesso e, da collegato, mostra il nome del cittadino.</p>
				<ul class="hub-list">
					<li>Colori ereditati dal tema, senza configurare nulla.</li>
					<li>Pagina di accesso dentro l'header, il footer e il breadcrumb del sito.</li>
					<li>Elenco dei gestori in ordine casuale e link «Non hai SPID? / Serve aiuto?».</li>
					<li>Markup accessibile (<code>details/summary</code>), senza JavaScript.</li>
				</ul>
			</div>
			<figure class="hub-shot hub-shot--tall"><img src="<?php echo esc_url( $img . 'spid-login-box.png' ); ?>" alt="Pagina di accesso con SPID e CIE nel sito dell'ASL: pulsante «Entra con SPID» con l'elenco dei gestori e pulsante «Entra con CIE»" loading="lazy"><figcaption>La pagina di accesso nel sito ASL.</figcaption></figure>
		</div>
	</section>

	<section class="hub-section hub-section--alt">
		<div class="hub-container hub-split hub-split--rev">
			<figure class="hub-shot"><img src="<?php echo esc_url( $img . 'spid-admin-stato.png' ); ?>" alt="Pannello Impostazioni → SPID/CIE: stato del server, dei certificati e del metadata registrato" loading="lazy"><figcaption>Il pannello di controllo: server, certificati e metadata registrato.</figcaption></figure>
			<div>
				<h2 class="hub-title hub-title--left">Tutto sotto controllo</h2>
				<p class="hub-text">Dal pannello compili i dati dell'ente, generi o importi i certificati e scarichi il metadata da registrare presso AgID e CIE.</p>
				<ul class="hub-list">
					<li>Stato di OpenSSL e della cartella dei dati.</li>
					<li>Scadenza dei certificati e link ai metadata SPID e CIE.</li>
					<li>«Salva come registrato»: se il metadata cambia, ti avvisa.</li>
					<li>Avviso chiaro su cosa si perde eliminando il plugin.</li>
				</ul>
			</div>
		</div>
	</section>

	<section class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Sicurezza</h2>
			<ul class="hub-features hub-features--2">
				<?php foreach ( $security as [ $t, $x ] ) : ?>
					<li><h3><?php echo esc_html( $t ); ?></h3><p><?php echo esc_html( $x ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="hub-section hub-section--alt">
		<div class="hub-container hub-split">
			<div>
				<h2 class="hub-title hub-title--left">Per chi sviluppa</h2>
				<p class="hub-text">Shortcode per i pulsanti, funzioni PHP per leggere gli attributi e hook per reagire al login.</p>
			</div>
			<pre class="hub-code" aria-label="Esempio di codice"><code>[authspidcie_login]
[spid_button return="/area-riservata/"]
[cie_button]

if ( authspidcie_is_authenticated() ) {
    $cf = authspidcie_get_attribute( 'fiscalNumber' );
}

do_action( 'authspidcie_authenticated', $attrs );</code></pre>
		</div>
	</section>

	<section class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Stato del progetto</h2>
			<div class="hub-note">
				<p><strong>Versione 0.1.0, in sviluppo.</strong> Il plugin è stato verificato in locale, non ancora in produzione.</p>
				<ul class="hub-list">
					<li><strong>Verificato:</strong> 31 + 138 test automatici su PHP 8.0, 8.2, 8.3 e 8.5; metadata validati con gli strumenti AgID (SPID 110 controlli, CIE 85, nessun errore); reinstallazione vera su WordPress senza perdita di dati.</li>
					<li><strong>Da fare:</strong> collaudo con gestori d'identità reali, con il validator e la demo AgID online e con la pre-produzione CIE; poi l'adesione.</li>
					<li><strong>Aperti:</strong> alcuni controlli segnalati dagli strumenti AgID sulle richieste e sulle risposte, in corso di analisi.</li>
					<li><strong>Fuori scopo:</strong> eIDAS, creazione automatica di utenti WordPress, asserzioni cifrate.</li>
				</ul>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
