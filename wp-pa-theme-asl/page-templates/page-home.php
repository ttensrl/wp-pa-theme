<?php
/**
 * Template Name: Home
 * Home del profilo ASL, modellata sul prototipo AGID:
 * ricerca, in evidenza, servizi e prestazioni, FSE, come fare per,
 * tutto per, ASL comunica, bandi di gara.
 *
 * @package digital-italia
 */

get_header();

/** Freccia "vai a" usata nei link di fine sezione. */
$arrow = '<svg class="asl-arrow" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M3 12h17M14 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>';

$news_url  = get_permalink( (int) get_option( 'page_for_posts' ) );
$bandi_url = get_post_type_archive_link( 'bando' );
$serv_url  = get_post_type_archive_link( 'servizio' );

/* Ricerca rapida: modificabile dai child/plugin con il filtro. */
$quick = apply_filters( 'asl_quick_searches', array(
	'Screening per la prevenzione',
	'Emergenza e urgenza',
	'Covid-19',
	'Reparti e unità operative sanitarie',
	'Orientamento e contatti',
	'Asma',
) );

/* Destinatari ("Tutto per"): ognuno e' un tag che elenca tutti i contenuti collegati. */
$targets = asl_targets();

$user_icon = '<svg class="asl-card-icon" viewBox="0 0 24 24" width="32" height="32" aria-hidden="true"><circle cx="12" cy="8" r="4.5" fill="none" stroke="currentColor" stroke-width="1.2"/><path d="M3.5 22c.6-4.6 4.2-7.5 8.5-7.5s7.9 2.9 8.5 7.5" fill="none" stroke="currentColor" stroke-width="1.2"/></svg>';
$book_icon = '<svg class="asl-card-icon" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M2.5 4.5h7a2.5 2.5 0 0 1 2.5 2.5v13a2 2 0 0 0-2-2h-7.5zM21.5 4.5h-7A2.5 2.5 0 0 0 12 7v13a2 2 0 0 1 2-2h7.5z" fill="none" stroke="currentColor" stroke-width="1.2"/></svg>';
?>
<main id="primary" class="asl-home">

	<!-- Ricerca -->
	<section class="asl-search" aria-labelledby="asl-search-title">
		<div class="container">
			<h2 id="asl-search-title" class="asl-search__title"><?php esc_html_e( 'Cerca nel sito', 'wp-digital-italia-asl' ); ?></h2>
			<form class="asl-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label for="home-search" class="visually-hidden"><?php esc_html_e( 'Cerca nel sito', 'wp-digital-italia-asl' ); ?></label>
				<span class="asl-search__field">
					<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><circle cx="10" cy="10" r="6.5" fill="none" stroke="currentColor" stroke-width="1.3"/><path d="M15 15l6 6" stroke="currentColor" stroke-width="1.3"/></svg>
					<input id="home-search" type="search" name="s" aria-describedby="home-search-hint">
				</span>
				<button type="submit" class="asl-btn"><?php esc_html_e( 'Cerca', 'wp-digital-italia-asl' ); ?></button>
			</form>
			<p id="home-search-hint" class="asl-search__hint"><?php esc_html_e( '*Inserisci parole chiave, ad esempio "Vaccinazioni"', 'wp-digital-italia-asl' ); ?></p>
			<?php if ( $quick ) : ?>
				<h3 class="asl-search__quick-title"><?php esc_html_e( 'Ricerca rapida', 'wp-digital-italia-asl' ); ?></h3>
				<ul class="asl-search__quick">
					<?php foreach ( $quick as $q ) : ?>
						<li><a href="<?php echo esc_url( add_query_arg( 's', rawurlencode( $q ), home_url( '/' ) ) ); ?>"><?php echo esc_html( $q ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>

	<!-- In evidenza -->
	<?php
	$featured = new WP_Query( array( 'posts_per_page' => 1, 'post_status' => 'publish', 'ignore_sticky_posts' => false ) );
	if ( $featured->have_posts() ) :
		$featured->the_post();
		$img = dci_post_image_url( null, 'large' );
		$cat = array_values( array_filter( get_the_category(), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
		?>
		<section class="asl-section asl-section--white" aria-labelledby="asl-featured-title">
			<div class="container">
				<h2 id="asl-featured-title" class="asl-section__title"><?php esc_html_e( 'In evidenza', 'wp-digital-italia-asl' ); ?></h2>
				<article class="asl-featured">
					<div class="asl-featured__body">
						<h3 class="asl-featured__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="asl-featured__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
						<span class="asl-tag"><?php echo $cat ? esc_html( $cat[0]->name ) : esc_html__( 'Notizia', 'wp-digital-italia-asl' ); ?></span>
					</div>
					<div class="asl-featured__media<?php echo $img ? '' : ' is-placeholder'; ?>">
						<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt=""><?php endif; ?>
					</div>
				</article>
			</div>
		</section>
		<?php
	endif;
	wp_reset_postdata();
	?>

	<!-- Servizi e prestazioni -->
	<?php
	$servizi = get_posts( array( 'post_type' => 'servizio', 'numberposts' => 3, 'orderby' => 'title', 'order' => 'ASC' ) );
	if ( $servizi ) :
		?>
		<section class="asl-section" aria-labelledby="asl-servizi-title">
			<div class="container">
				<h2 id="asl-servizi-title" class="asl-section__title"><?php esc_html_e( 'Servizi e prestazioni', 'wp-digital-italia-asl' ); ?></h2>
				<p class="asl-section__lead"><?php esc_html_e( "Scopri e accedi ai servizi dell'ASL come visite specialistiche, esami, percorsi di cura, referti e certificati", 'wp-digital-italia-asl' ); ?></p>
				<div class="row g-4 asl-links">
					<?php foreach ( $servizi as $s ) : ?>
						<div class="col-md-4">
							<article class="asl-link-item">
								<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?><svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M9 4l8 8-8 8" fill="none" stroke="currentColor" stroke-width="1.5"/></svg></a></h3>
								<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $s->post_content ), 16 ) ); ?></p>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if ( $serv_url ) : ?>
					<p class="asl-more"><a href="<?php echo esc_url( $serv_url ); ?>"><?php esc_html_e( 'Tutti i servizi', 'wp-digital-italia-asl' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Fascicolo Sanitario Elettronico -->
	<section class="asl-fse" aria-labelledby="asl-fse-title">
		<div class="container">
			<h2 id="asl-fse-title"><?php esc_html_e( 'Fascicolo Sanitario Elettronico (FSE)', 'wp-digital-italia-asl' ); ?></h2>
			<p><?php esc_html_e( 'Paga online, prenota visite e ritira referti direttamente sul tuo Fascicolo Sanitario Elettronico', 'wp-digital-italia-asl' ); ?></p>
			<a class="asl-btn asl-btn--light" href="<?php echo esc_url( apply_filters( 'asl_fse_url', 'https://www.fascicolosanitario.gov.it/' ) ); ?>"><?php esc_html_e( 'Vai al servizio', 'wp-digital-italia-asl' ); ?></a>
		</div>
	</section>

	<!-- Come fare per -->
	<?php
	$guide = get_posts( array( 'post_type' => 'servizio', 'numberposts' => 4, 'offset' => 3, 'orderby' => 'title', 'order' => 'ASC' ) );
	if ( $guide ) :
		?>
		<section class="asl-section" aria-labelledby="asl-come-title">
			<div class="container">
				<h2 id="asl-come-title" class="asl-section__title"><?php esc_html_e( 'Come fare per', 'wp-digital-italia-asl' ); ?></h2>
				<p class="asl-section__lead"><?php esc_html_e( "Scopri e approfondisci tutte le procedure offerte dall'ASL", 'wp-digital-italia-asl' ); ?></p>
				<div class="row g-4">
					<?php foreach ( $guide as $g ) : ?>
						<div class="col-md-6">
							<a class="asl-card asl-card--row" href="<?php echo esc_url( get_permalink( $g ) ); ?>">
								<span><?php echo esc_html( get_the_title( $g ) ); ?></span><?php echo $book_icon; // phpcs:ignore ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if ( $serv_url ) : ?>
					<p class="asl-more"><a href="<?php echo esc_url( $serv_url ); ?>"><?php esc_html_e( 'Tutti i come fare per', 'wp-digital-italia-asl' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Tutto per -->
	<section class="asl-section asl-section--white" aria-labelledby="asl-tutto-title">
		<div class="container">
			<h2 id="asl-tutto-title" class="asl-section__title"><?php esc_html_e( 'Tutto per', 'wp-digital-italia-asl' ); ?></h2>
			<p class="asl-section__lead"><?php esc_html_e( 'Scopri i servizi, le strutture e le novità per tipologia di utente', 'wp-digital-italia-asl' ); ?></p>
			<div class="row g-4">
				<?php foreach ( $targets as $t ) : ?>
					<div class="col-6 col-lg-3">
						<a class="asl-card asl-card--target" href="<?php echo esc_url( asl_target_url( $t ) ); ?>">
							<span><?php echo esc_html( $t ); ?></span><?php echo $user_icon; // phpcs:ignore ?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ASL comunica -->
	<?php
	$news = dci_latest_posts( 3, 1 );
	if ( $news->have_posts() ) :
		?>
		<section class="asl-section" aria-labelledby="asl-comunica-title">
			<div class="container">
				<h2 id="asl-comunica-title" class="asl-section__title"><?php esc_html_e( 'ASL comunica', 'wp-digital-italia-asl' ); ?></h2>
				<p class="asl-section__lead"><?php esc_html_e( "Tutte le notizie, i comunicati stampa e gli eventi dell'ASL", 'wp-digital-italia-asl' ); ?></p>
				<div class="row g-4">
					<?php
					$i = 0;
					while ( $news->have_posts() ) :
						$news->the_post();
						$img = dci_post_image_url();
						$cat = array_values( array_filter( get_the_category(), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
						?>
						<div class="col-md-4">
							<article class="asl-news">
								<div class="asl-news__media<?php echo $img ? '' : ' is-placeholder is-v' . ( $i % 3 ); ?>">
									<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy"><?php endif; ?>
								</div>
								<div class="asl-news__body">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
									<div class="asl-news__meta">
										<span class="asl-tag"><?php echo $cat ? esc_html( $cat[0]->name ) : esc_html__( 'Notizia', 'wp-digital-italia-asl' ); ?></span>
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
									</div>
								</div>
							</article>
						</div>
						<?php
						$i++;
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php if ( $news_url ) : ?>
					<p class="asl-more"><a href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Tutte le novità', 'wp-digital-italia-asl' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Bandi di gara -->
	<?php
	$bandi = new WP_Query( array(
		'post_type' => 'bando', 'posts_per_page' => 4, 'post_status' => 'publish',
		'meta_key'  => '_dci_bando_data_publish', 'orderby' => 'meta_value', 'order' => 'DESC',
	) );
	if ( $bandi->have_posts() ) :
		?>
		<section class="asl-section" aria-labelledby="asl-bandi-title">
			<div class="container">
				<h2 id="asl-bandi-title" class="asl-section__title"><?php esc_html_e( 'Bandi di gara', 'wp-digital-italia-asl' ); ?></h2>
				<p class="asl-section__lead"><?php esc_html_e( "Gli ultimi bandi e concorsi attivi presso l'ASL", 'wp-digital-italia-asl' ); ?></p>
				<div class="row g-4">
					<?php
					while ( $bandi->have_posts() ) :
						$bandi->the_post();
						$pub = get_post_meta( get_the_ID(), '_dci_bando_data_publish', true );
						$ts  = $pub ? strtotime( $pub ) : get_the_time( 'U' );
						?>
						<div class="col-md-6">
							<article class="asl-card asl-card--bando">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="asl-news__meta">
									<span class="asl-tag"><?php esc_html_e( 'Bando', 'wp-digital-italia-asl' ); ?></span>
									<time datetime="<?php echo esc_attr( wp_date( 'c', $ts ) ); ?>"><?php echo esc_html( wp_date( 'j F Y', $ts ) ); ?></time>
								</div>
							</article>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php if ( $bandi_url ) : ?>
					<p class="asl-more"><a href="<?php echo esc_url( $bandi_url ); ?>"><?php esc_html_e( 'Tutti i bandi', 'wp-digital-italia-asl' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			if ( trim( get_the_content() ) ) :
				?>
				<section class="asl-section"><div class="container entry-content"><?php the_content(); ?></div></section>
				<?php
			endif;
		endwhile;
	endif;
	?>
</main>
<?php
get_footer();
