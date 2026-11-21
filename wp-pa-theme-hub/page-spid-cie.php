<?php
/**
 * Template Name: Plugin SPID/CIE
 * Pagina di presentazione del plugin Auth SPID CIE.
 */
get_header();

$img      = get_stylesheet_directory_uri() . '/assets/img/';
$github   = 'https://github.com/ttensrl/auth-spid-cie';
$demo     = home_url( '/?authspidcie=choose' );
$demo_asl = function_exists( 'hub_demo_url' ) && hub_demo_url( 'asl' ) ? hub_demo_url( 'asl' ) . '?authspidcie=choose' : '';

$flow = array(
	array( 'Il cittadino sceglie', 'Preme «Entra con SPID» o «Entra con CIE» e, per SPID, sceglie il suo gestore.' ),
	array( 'Il sito chiede', 'Invia al gestore una richiesta di accesso (AuthnRequest) firmata con il certificato dell\'ente.' ),
	array( 'Il gestore autentica', 'Il cittadino si identifica sul sito del gestore: il sito non vede mai le sue credenziali.' ),
	array( 'Il sito verifica', 'Riceve la risposta firmata (all\'indirizzo ACS), ne controlla firma e contenuto e la accetta una sola volta.' ),
	array( 'Si apre la sessione', 'Gli attributi (nome, codice fiscale, …) restano disponibili al tema e ad altri plugin finché dura la sessione.' ),
);
$gets  = array( 'Gli attributi che chiedi: sempre il codice fiscale; a scelta nome, cognome, data di nascita, email, ecc.', 'Il gestore con cui ha fatto l\'accesso e il livello di sicurezza (SpidL1, L2, L3).', 'Una sessione con scadenza assoluta (2 ore, modificabile).' );
$never = array( 'Non crea utenti WordPress e non assegna ruoli: i cittadini non entrano in bacheca.', 'Non salva le credenziali: non le vede mai.', 'Non conserva i dati del cittadino: restano nella sessione e spariscono alla scadenza o al logout.' );

$features = array(
	array( 'SPID e CIE, un solo plugin', 'Service Provider SAML 2.0 per entrambi, con metadata per enti pubblici e privati (ContactPerson ed estensioni spid:, fpa:, cie:).' ),
	array( 'Richieste firmate', 'AuthnRequest firmate (Redirect e POST) con RelayState, livello di autenticazione SpidL1-L3 e Destination verso l\'endpoint del gestore.' ),
	array( 'Risposte verificate', 'Firma sull\'elemento giusto, Issuer, Destination, InResponseTo, Audience, tempi e anti-replay: richiesta e asserzione si usano una sola volta.' ),
	array( 'Pulsanti con i loghi dei gestori', 'I loghi dei gestori SPID sono inclusi nel plugin: nessuna richiesta a CDN esterni. Elenco in ordine casuale, come da linee guida.' ),
	array( 'Pagina di accesso e shortcode', '<code>[spid_button]</code>, <code>[cie_button]</code> e <code>[authspidcie_login]</code>, oppure la pagina pronta <code>/?authspidcie=choose</code> dentro header e footer del tema.' ),
	array( 'Integrato col tema', 'Con WP Digital Italia il pulsante «Area personale» porta al login e, da collegati, mostra il nome del cittadino (filtro <code>dci_area_personale</code>).' ),
	array( 'Certificati dal pannello', 'Generazione con il soggetto previsto dall\'Avviso SPID n.29 oppure import di chiave e certificato già registrati.' ),
	array( 'Chiave cifrabile', 'La chiave privata sta nel database; con la costante <code>AUTHSPIDCIE_SECRET</code> viene cifrata con libsodium. Il pannello non la mostra mai.' ),
	array( 'Dati che sopravvivono', 'Certificati, chiave e metadata registrato sono nel database, non in file: aggiornare o reinstallare il plugin non li perde.' ),
	array( 'Multisite', 'Certificato condiviso da tutta la rete, impostazioni (entityID, dati dell\'ente) per ogni sito. Il pannello dice quale sito stai configurando.' ),
	array( 'Controlla il server', 'All\'attivazione prova davvero a generare chiavi e certificati: se l\'hosting non basta, il plugin si ferma e spiega perché.' ),
	array( 'In italiano, senza dipendenze', 'Traduzione it_IT completa inclusa. Niente Composer né librerie esterne: serve solo PHP 8 con alcune estensioni standard.' ),
);

$ready = array(
	'<strong>Codice IPA</strong> dell\'ente (per i privati, partita IVA o codice fiscale) e i suoi dati: nome, indirizzo, sede.',
	'<strong>Referente</strong> per AgID: email e telefono di contatto che finiranno nel metadata.',
	'<strong>Un sito in HTTPS</strong> con indirizzo stabile: sarà l\'entityID e non deve più cambiare dopo la registrazione.',
	'<strong>Accesso all\'hosting</strong> per aggiungere, se vuoi, la costante <code>AUTHSPIDCIE_SECRET</code> a <code>wp-config.php</code>.',
);
$install = array(
	array( 'Controlla il server', 'PHP 8.0 o superiore con le estensioni <code>openssl</code>, <code>dom</code>, <code>libxml</code> e <code>mbstring</code> (<code>sodium</code> serve solo se vuoi cifrare la chiave). WordPress 6.0+. All\'attivazione il plugin verifica anche che OpenSSL generi davvero i certificati.' ),
	array( 'Installa e attiva', 'Carica la cartella <code>auth-spid-cie</code> in <code>wp-content/plugins</code> (o lo zip da Plugin → Aggiungi nuovo) e attivala. Il pannello è in <em>Impostazioni → SPID / CIE</em>; in multisite apri quello del sito che ti interessa.' ),
	array( 'Compila i dati dell\'ente', 'Come entityID usa l\'indirizzo del sito (<code>https://tuosito.it/</code>, senza parametri: se lo lasci vuoto lo usa il plugin). Aggiungi nome, codice IPA, località e referente. Il pannello ti dice cosa manca.' ),
	array( 'Genera il certificato', 'Dal punto 7 del pannello genera il certificato SPID (e CIE). Se hai già registrato un Service Provider, <em>importa</em> chiave e certificato esistenti invece di crearne di nuovi, altrimenti dovrai ripetere la registrazione.' ),
	array( 'Scarica e registra il metadata', 'Dal pannello scarichi il metadata di SPID e CIE. Per le prove lo carichi sul validator di <strong>demo.spid.gov.it</strong>; per la produzione si aderisce presso <strong>AgID</strong>, mentre per la CIE si passa dalla <strong>pre-produzione del Ministero dell\'Interno</strong>.' ),
	array( 'Prova l\'accesso', 'Dalla pagina di accesso scegli «SPID Demo» e usa un utente di prova di demo.spid.gov.it. Se funziona, hai la prova che richiesta, firma e ritorno sono a posto.' ),
	array( 'Passa in produzione', 'Dopo l\'adesione attiva «Ambiente di produzione» (spegne gli IdP di test) e salva una copia del metadata registrato: da quel momento il plugin ti avvisa se una modifica obbliga a ripetere la registrazione.' ),
);
$security = array(
	array( 'Firma e risposta verificate', 'La firma si controlla sull\'elemento giusto, contro signature wrapping, ID duplicati, SHA-1, DOCTYPE ed entità esterne. Gli attributi si leggono solo dall\'Assertion firmata.' ),
	array( 'Anti-replay', 'Richiesta e asserzione si consumano una volta sola. Destination, Recipient, Audience, livello e tempi sono controllati prima di aprire la sessione.' ),
	array( 'Sessione senza sessioni PHP', 'Un cookie casuale a 256 bit (<code>HttpOnly</code>, <code>SameSite=Lax</code>, <code>Secure</code> in HTTPS) punta a dati conservati sul server sotto il suo hash. Nuovo identificativo a ogni login, scadenza e logout lato server, nessun cookie ai visitatori anonimi.' ),
	array( 'Chiave privata nel database', 'Mai in file raggiungibili dal web e mai mostrata nel pannello. Con <code>AUTHSPIDCIE_SECRET</code> viene cifrata (libsodium); se la costante sparisce o cambia, il plugin lo segnala e blocca l\'uso della chiave invece di usarne una corrotta.' ),
);

$dev_code = <<<'PHP'
// Shortcode (anche con return= e level=)
[authspidcie_login]
[spid_button return="/area-riservata/" level="2"]
[cie_button]

// Funzioni
if ( authspidcie_is_authenticated() ) {
    $cf    = authspidcie_get_attribute( 'fiscalNumber' );
    $tutti = authspidcie_get_attributes();
    $esci  = authspidcie_logout_url( home_url( '/' ) );
}
$url = authspidcie_login_url( 'https://demo.spid.gov.it', 2 );

// Dopo un accesso riuscito
add_action( 'authspidcie_authenticated', function ( $attributi, $user, $idp ) {
    // $attributi: attributi SAML; $idp: entityID del gestore
}, 10, 3 );

// Filtri
add_filter( 'authspidcie_session_lifetime', fn() => HOUR_IN_SECONDS );
add_filter( 'authspidcie_logo_url', fn( $url, $servizio ) => $url, 10, 2 );
PHP;

$faq = array(
	array( 'Crea utenti WordPress?', 'No, per scelta. Il cittadino ha una sessione con i suoi attributi, che il tema o un altro plugin possono leggere con <code>authspidcie_get_attributes()</code>. Se ti serve un account vero, puoi crearlo tu nell\'azione <code>authspidcie_authenticated</code>.' ),
	array( 'Serve per forza un certificato?', 'Sì: richieste e metadata devono essere firmati. Il plugin lo genera dal pannello oppure importa quello che hai già registrato.' ),
	array( 'Dove si trova la chiave privata?', 'Nel database di WordPress (opzioni), mai in file. Senza <code>AUTHSPIDCIE_SECRET</code> è in chiaro, quindi i backup del database la contengono: trattali come segreti o cifra la chiave.' ),
	array( 'E se cambio l\'entityID o i dati dell\'ente?', 'Cambia il metadata: se il sito è già registrato, la registrazione va ripetuta. Per questo il plugin ti fa salvare una copia di quello registrato e ti avvisa quando differisce.' ),
	array( 'Funziona con più siti (multisite)?', 'Sì. Il certificato è unico per la rete; le impostazioni, e quindi entityID e metadata, sono per sito.' ),
	array( 'Posso usarlo come soggetto privato?', 'Sì, con i dati di fatturazione e i codici richiesti dal profilo privato. Va però provato con il tuo caso: finora le prove sono state fatte come ente pubblico.' ),
	array( 'La CIE funziona?', 'Il metadata CIE supera i controlli dello strumento AgID (85 su 85), ma non è stata provata la pre-produzione del Ministero dell\'Interno: per la CIE non puoi ancora considerarlo collaudato.' ),
	array( 'Licenza e costi?', 'Gratuito, licenza GPL-3.0-or-later. Il codice è su GitHub e puoi usarlo e modificarlo liberamente.' ),
);
$badges = array( 'PHP 8.0+', 'GPL-3.0', 'Nessuna dipendenza', 'SAML 2.0' );
?>
<main id="contenuto">

	<section class="hub-hero hub-hero--plugin">
		<div class="hub-container">
			<p class="hub-eyebrow">Auth SPID CIE &middot; v0.1.0 in sviluppo</p>
			<h1>Accesso con SPID e CIE per WordPress.</h1>
			<p class="hub-lead">Un plugin autonomo che porta SPID e CIE sul sito istituzionale di Comuni, ASL, scuole e musei. Il cittadino si identifica con la sua identità digitale; il sito riceve solo i dati che servono, senza gestire account.</p>
			<div class="hub-cta">
				<a class="hub-btn hub-btn--solid" href="<?php echo esc_url( $demo ); ?>">Prova la demo</a>
				<a class="hub-btn hub-btn--ghost" href="<?php echo esc_url( $github ); ?>">Codice su GitHub</a>
			</div>
			<ul class="hub-badges" aria-label="Caratteristiche principali">
				<?php foreach ( $badges as $b ) : ?><li><?php echo esc_html( $b ); ?></li><?php endforeach; ?>
			</ul>
		</div>
		<div class="hub-hero__shapes" aria-hidden="true"><span></span><span></span><span></span></div>
	</section>

	<nav class="hub-subnav" aria-label="In questa pagina">
		<div class="hub-container">
			<ul>
				<li><a href="#come">Come funziona</a></li>
				<li><a href="#funzioni">Funzioni</a></li>
				<li><a href="#installazione">Installazione</a></li>
				<li><a href="#sicurezza">Sicurezza</a></li>
				<li><a href="#sviluppatori">Sviluppatori</a></li>
				<li><a href="#qualita">Prove e stato</a></li>
				<li><a href="#faq">Domande</a></li>
			</ul>
		</div>
	</nav>

	<section id="come" class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Come funziona</h2>
			<p class="hub-sub">Cinque passaggi, dal clic del cittadino alla sessione sul tuo sito.</p>
			<ol class="hub-flow">
				<?php foreach ( $flow as $i => [ $t, $x ] ) : ?>
					<li><span class="hub-flow__n" aria-hidden="true"><?php echo (int) $i + 1; ?></span><h3><?php echo esc_html( $t ); ?></h3><p><?php echo esc_html( $x ); ?></p></li>
				<?php endforeach; ?>
			</ol>
			<div class="hub-two">
				<div class="hub-panel hub-panel--yes">
					<h3>Cosa riceve il sito</h3>
					<ul class="hub-list"><?php foreach ( $gets as $g ) : ?><li><?php echo esc_html( $g ); ?></li><?php endforeach; ?></ul>
				</div>
				<div class="hub-panel hub-panel--no">
					<h3>Cosa non fa</h3>
					<ul class="hub-list"><?php foreach ( $never as $g ) : ?><li><?php echo esc_html( $g ); ?></li><?php endforeach; ?></ul>
				</div>
			</div>
		</div>
	</section>

	<section class="hub-section hub-section--alt">
		<div class="hub-container hub-split">
			<div>
				<h2 class="hub-title hub-title--left">Una pagina di accesso pronta</h2>
				<p class="hub-text">Il pulsante «Entra con SPID» apre l'elenco dei gestori, ognuno con il proprio logo; sotto c'è «Entra con CIE». I gestori compaiono in ordine casuale, come chiedono le linee guida, e i link «Non hai SPID?» e «Serve aiuto?» sono già al loro posto.</p>
				<ul class="hub-list">
					<li>Dentro header, footer e breadcrumb del sito, con i colori del tema.</li>
					<li>Markup accessibile (<code>details/summary</code>), senza JavaScript.</li>
					<li>Con gli IdP di prova visibili finché non sei in produzione.</li>
				</ul>
				<p class="hub-actions">
					<a class="hub-link" href="<?php echo esc_url( $demo ); ?>">Aprila qui</a>
					<?php if ( $demo_asl ) : ?><a class="hub-link" href="<?php echo esc_url( $demo_asl ); ?>">Nel tema ASL</a><?php endif; ?>
				</p>
			</div>
			<figure class="hub-shot hub-shot--tall"><img src="<?php echo esc_url( $img . 'spid-login-box.png' ); ?>" alt="Pagina di accesso con SPID e CIE: pulsante «Entra con SPID» con l'elenco dei gestori, ognuno con il suo logo, e pulsante «Entra con CIE»" loading="lazy"><figcaption>La pagina di accesso con i loghi dei gestori SPID.</figcaption></figure>
		</div>
	</section>

	<section id="funzioni" class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Cosa include</h2>
			<ul class="hub-features hub-features--3">
				<?php foreach ( $features as [ $t, $x ] ) : ?>
					<li><h3><?php echo esc_html( $t ); ?></h3><p><?php echo wp_kses( $x, array( 'code' => array() ) ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section id="installazione" class="hub-section hub-section--alt">
		<div class="hub-container">
			<h2 class="hub-title">Installazione e configurazione</h2>
			<p class="hub-sub">Sette passi, dal server alla produzione. I tempi dipendono soprattutto dalla registrazione presso AgID.</p>
			<div class="hub-panel hub-panel--ready">
				<h3>Cosa devi avere pronto</h3>
				<ul class="hub-list"><?php foreach ( $ready as $r ) : ?><li><?php echo wp_kses( $r, array( 'strong' => array(), 'code' => array() ) ); ?></li><?php endforeach; ?></ul>
			</div>
			<ol class="hub-guide">
				<?php foreach ( $install as $i => [ $t, $x ] ) : ?>
					<li><span class="hub-guide__n" aria-hidden="true"><?php echo (int) $i + 1; ?></span><div><h3><?php echo esc_html( $t ); ?></h3><p><?php echo wp_kses( $x, array( 'strong' => array(), 'code' => array(), 'em' => array() ) ); ?></p></div></li>
				<?php endforeach; ?>
			</ol>
			<figure class="hub-shot hub-shot--wide" style="margin-top:2rem"><img src="<?php echo esc_url( $img . 'spid-admin-stato.png' ); ?>" alt="Pannello di configurazione del plugin: checklist «Per attivare SPID/CIE» con il prossimo passo evidenziato e stato di SPID e CIE" loading="lazy"><figcaption>Il pannello di configurazione: una checklist guida dai dati dell'ente fino al passaggio in produzione.</figcaption></figure>
		</div>
	</section>

	<section id="sicurezza" class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Sicurezza</h2>
			<ul class="hub-features hub-features--2">
				<?php foreach ( $security as [ $t, $x ] ) : ?>
					<li><h3><?php echo esc_html( $t ); ?></h3><p><?php echo wp_kses( $x, array( 'code' => array() ) ); ?></p></li>
				<?php endforeach; ?>
			</ul>
			<div class="hub-note hub-note--wide">
				<p><strong>Cosa il plugin non è.</strong> Non è certificato da AgID e non sostituisce un'analisi di sicurezza del tuo sito. Senza <code>AUTHSPIDCIE_SECRET</code> la chiave privata è in chiaro nel database, e quindi in ogni suo backup.</p>
			</div>
		</div>
	</section>

	<section id="sviluppatori" class="hub-section hub-section--alt">
		<div class="hub-container hub-split hub-split--top">
			<div>
				<h2 class="hub-title hub-title--left">Per chi sviluppa</h2>
				<p class="hub-text">Shortcode per i pulsanti, funzioni PHP per leggere gli attributi e hook per reagire al login. Le funzioni <code>authspidcie_*</code> sono l'API pubblica del plugin.</p>
				<ul class="hub-list">
					<li>Gli attributi arrivano con i nomi SAML (<code>fiscalNumber</code>, <code>name</code>, <code>familyName</code>, …).</li>
					<li>Il logo CIE non è incluso (manca una licenza): lo fornisce il tema con il filtro <code>authspidcie_logo_url</code>.</li>
					<li>Documentazione e struttura del codice nel <a href="<?php echo esc_url( $github ); ?>">README su GitHub</a>.</li>
				</ul>
			</div>
			<pre class="hub-code" tabindex="0" aria-label="Esempi di codice"><code><?php echo esc_html( $dev_code ); ?></code></pre>
		</div>
	</section>

	<section id="qualita" class="hub-section">
		<div class="hub-container">
			<h2 class="hub-title">Prove e stato del progetto</h2>
			<ul class="hub-stats">
				<li><strong>189</strong><span>test automatici (31 + 158) su PHP 8.0, 8.3 e 8.5</span></li>
				<li><strong>110/110</strong><span>controlli sul metadata SPID con lo strumento AgID <em>spid-sp-test</em></span></li>
				<li><strong>85/85</strong><span>controlli sul metadata CIE</span></li>
				<li><strong>0</strong><span>errori in Plugin Check sul pacchetto di rilascio</span></li>
			</ul>
			<div class="hub-note hub-note--wide">
				<p><strong>Versione 0.1.0, in sviluppo.</strong> Onestamente, a che punto siamo:</p>
				<ul class="hub-list">
					<li><strong>Provato:</strong> accesso completo con l'IdP di prova SPID Demo (demo.spid.gov.it), controllo di metadata e richieste con gli strumenti AgID, aggiornamenti e reinstallazione senza perdere i dati.</li>
					<li><strong>Da fare:</strong> collaudo con gestori d'identità reali, adesione presso AgID e prova della pre-produzione CIE.</li>
					<li><strong>Non è:</strong> certificato. Non gestisce eIDAS, asserzioni cifrate o la creazione automatica di utenti WordPress.</li>
				</ul>
			</div>
			<p class="hub-actions hub-actions--center">
				<a class="hub-link" href="<?php echo esc_url( $github ); ?>">Codice e README</a>
				<a class="hub-link" href="<?php echo esc_url( $github . '/blob/main/docs/STORAGE.md' ); ?>">Dove stanno i dati (STORAGE)</a>
			</p>
		</div>
	</section>

	<section id="faq" class="hub-section hub-section--alt">
		<div class="hub-container hub-narrow">
			<h2 class="hub-title">Domande frequenti</h2>
			<div class="hub-faq">
				<?php foreach ( $faq as [ $q, $a ] ) : ?>
					<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo wp_kses( $a, array( 'code' => array() ) ); ?></p></details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="hub-section hub-cta-band">
		<div class="hub-container">
			<h2>Vuoi provarlo?</h2>
			<p>La demo usa l'IdP di prova SPID Demo, con utenti fittizi: non serve alcuna credenziale vera.</p>
			<div class="hub-cta hub-cta--center">
				<a class="hub-btn hub-btn--solid" href="<?php echo esc_url( $demo ); ?>">Prova la demo</a>
				<a class="hub-btn hub-btn--ghost" href="<?php echo esc_url( $github ); ?>">Codice su GitHub</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
