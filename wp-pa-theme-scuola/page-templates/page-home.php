<?php
/**
 * Template Name: Home
 * Home del profilo Scuola (modello Design Scuole): hero della scuola, notizie e circolari,
 * servizi, didattica con offerta formativa e risorse.
 *
 * @package digital-italia
 */

get_header();

$news_page = (int) get_option( 'page_for_posts' );
$news_url  = $news_page ? get_permalink( $news_page ) : home_url( '/' );
$cat_circ  = get_category_by_slug( 'circolari' );

/* Notizie: tutto tranne le circolari. Circolari: categoria omonima o, in mancanza, gli ultimi bandi. */
$news_args = array( 'posts_per_page' => 1, 'post_status' => 'publish', 'ignore_sticky_posts' => true );
if ( $cat_circ ) {
	$news_args['category__not_in'] = array( (int) $cat_circ->term_id );
}
$news = get_posts( $news_args );
$notice_posts = array();
$notice_label = __( 'Circolari', 'wp-digital-italia' );
$notice_more  = $cat_circ ? get_category_link( $cat_circ ) : $news_url;
if ( $cat_circ ) {
	$notice_posts = get_posts( array( 'posts_per_page' => 1, 'category' => (int) $cat_circ->term_id, 'post_status' => 'publish' ) );
}
if ( ! $notice_posts ) {
	$notice_posts = get_posts( array( 'post_type' => 'bandi', 'posts_per_page' => 1, 'post_status' => 'publish' ) );
	$notice_label = __( 'Avvisi e bandi', 'wp-digital-italia' );
	$notice_more  = dci_bandi_url();
}

$servizi = get_posts( array( 'post_type' => 'servizio', 'numberposts' => 6, 'orderby' => 'title', 'order' => 'ASC' ) );
$serv_archive = get_post_type_archive_link( 'servizio' );
$plessi  = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => 0, 'numberposts' => 6, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
$parts   = dci_brand_parts();
$hero_img = $news ? dci_post_image_url( $news[0], 'large' ) : '';
$about   = scuola_page_url( 'chi-siamo' );
$school  = trim( ( $parts['prefix'] ? $parts['prefix'] . ' ' : '' ) . $parts['name'] );
$hero_title = (string) get_theme_mod( 'scuola_hero_title', $parts['name'] );
$hero_label = (string) get_theme_mod( 'scuola_hero_label', $parts['prefix'] );
?>
<main id="main-container" class="sc-home">

	<!-- Hero -->
	<section class="sc-hero" aria-labelledby="sc-hero-title">
		<div class="sc-hero__text">
			<div class="sc-hero__in">
				<?php if ( $hero_label ) : ?><p class="sc-hero__label"><?php echo esc_html( $hero_label ); ?></p><?php endif; ?>
				<h1 id="sc-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
				<a class="sc-btn sc-btn--outline" href="<?php echo esc_url( $about ); ?>"><?php esc_html_e( 'Vai alla scuola', 'wp-digital-italia' ); ?></a>
			</div>
		</div>
		<div class="sc-hero__media<?php echo $hero_img ? '' : ' is-placeholder'; ?>">
			<?php if ( $hero_img ) : ?><img src="<?php echo esc_url( $hero_img ); ?>" alt=""><?php endif; ?>
		</div>
	</section>

	<!-- Notizie e circolari -->
	<section class="sc-section sc-news-section" aria-label="<?php esc_attr_e( 'Notizie e circolari', 'wp-digital-italia' ); ?>">
		<div class="container">
			<div class="row g-4">
				<div class="col-lg-4">
					<h2 class="sc-h2"><?php esc_html_e( 'Notizie', 'wp-digital-italia' ); ?></h2>
					<?php foreach ( $news as $p ) : $img = dci_post_image_url( $p ); ?>
						<article class="sc-card sc-card--news">
							<div class="sc-card__body">
								<h3><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $p ), 24 ) ); ?></p>
								<p class="sc-card__by"><span class="sc-avatar" aria-hidden="true"></span><span><?php esc_html_e( 'da', 'wp-digital-italia' ); ?> <u><?php echo esc_html( get_the_author_meta( 'display_name', (int) $p->post_author ) ?: $school ); ?></u><br><small><time datetime="<?php echo esc_attr( get_the_date( 'c', $p ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y', $p ) ); ?></time></small></span></p>
							</div>
							<span class="sc-card__thumb<?php echo $img ? '' : ' is-placeholder'; ?>"><?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt=""><?php endif; ?></span>
						</article>
					<?php endforeach; ?>
					<p class="sc-more"><a href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Leggi tutte', 'wp-digital-italia' ); ?></a></p>
				</div>
				<div class="col-lg-4">
					<h2 class="sc-h2"><?php echo esc_html( $notice_label ); ?></h2>
					<?php foreach ( $notice_posts as $p ) : ?>
						<article class="sc-card sc-card--notice">
							<div class="sc-card__body">
								<h3><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></h3>
								<p class="sc-card__kind"><?php echo esc_html( get_post_type( $p ) === 'bandi' ? __( 'Bando', 'wp-digital-italia' ) : __( 'Circolare', 'wp-digital-italia' ) ); ?></p>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $p ), 30 ) ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
					<?php if ( $notice_more ) : ?><p class="sc-more"><a href="<?php echo esc_url( $notice_more ); ?>"><?php esc_html_e( 'Leggi tutte', 'wp-digital-italia' ); ?></a></p><?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- Servizi -->
	<?php if ( $servizi ) : ?>
		<section id="servizi" class="sc-services" aria-labelledby="sc-services-title">
			<div class="sc-services__band">
				<div class="container">
					<h2 id="sc-services-title"><?php esc_html_e( 'Servizi', 'wp-digital-italia' ); ?></h2>
					<p><?php echo esc_html( sprintf( /* translators: %s: nome dell'istituto */ __( 'I servizi offerti da %s dedicati a tutti i genitori, studenti, personale ATA e docenti', 'wp-digital-italia' ), $school ) ); ?></p>
				</div>
			</div>
			<div class="container sc-services__cards">
				<div class="row g-4">
					<?php foreach ( $servizi as $s ) : ?>
						<div class="col-md-6 col-lg-4">
							<a class="sc-service" href="<?php echo esc_url( get_permalink( $s ) ); ?>">
								<strong><?php echo esc_html( get_the_title( $s ) ); ?></strong>
								<span><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $s->post_content ), 10 ) ); ?></span>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if ( $serv_archive ) : ?><p class="sc-more sc-more--center"><a href="<?php echo esc_url( $serv_archive ); ?>"><?php esc_html_e( 'Vedi tutti i servizi', 'wp-digital-italia' ); ?></a></p><?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Didattica -->
	<?php if ( $plessi ) : ?>
		<section id="didattica" class="sc-didattica" aria-labelledby="sc-did-title">
			<div class="sc-didattica__side">
				<div class="sc-didattica__side-in">
					<p class="sc-didattica__kicker"><?php esc_html_e( 'La scuola', 'wp-digital-italia' ); ?></p>
					<p class="sc-didattica__year"><?php echo esc_html( scuola_school_year() ); ?></p>
					<p class="sc-didattica__tab"><?php echo esc_html( $school ); ?></p>
				</div>
			</div>
			<div class="sc-didattica__main">
				<div class="sc-didattica__main-in">
					<h2 id="sc-did-title"><?php esc_html_e( 'La didattica', 'wp-digital-italia' ); ?></h2>
					<p class="sc-didattica__sub"><?php esc_html_e( 'la nostra offerta formativa', 'wp-digital-italia' ); ?></p>
					<div class="sc-accordion" id="sc-offerta">
						<?php foreach ( $plessi as $i => $d ) : ?>
							<div class="sc-accordion__item">
								<h3>
									<button class="sc-accordion__btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sc-off-<?php echo (int) $i; ?>" aria-expanded="false" aria-controls="sc-off-<?php echo (int) $i; ?>">
										<span class="sc-accordion__plus" aria-hidden="true"></span><?php echo esc_html( get_the_title( $d ) ); ?>
									</button>
								</h3>
								<div id="sc-off-<?php echo (int) $i; ?>" class="collapse" data-bs-parent="#sc-offerta">
									<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $d->post_content ), 40 ) ); ?> <a href="<?php echo esc_url( get_permalink( $d ) ); ?>"><?php esc_html_e( 'Scopri di più', 'wp-digital-italia' ); ?></a></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<a class="sc-btn sc-btn--red" href="<?php echo esc_url( $about ); ?>"><?php esc_html_e( 'Vai alla presentazione della scuola', 'wp-digital-italia' ); ?></a>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Risorse didattiche -->
	<section class="sc-resources" aria-labelledby="sc-res-title">
		<div class="container">
			<div class="row g-4 align-items-start">
				<div class="col-lg-4">
					<p class="sc-resources__kicker"><?php esc_html_e( 'Didattica', 'wp-digital-italia' ); ?></p>
					<h2 id="sc-res-title"><?php echo esc_html__( 'Esplora le risorse didattiche dell\'Istituto', 'wp-digital-italia' ); ?></h2>
					<a class="sc-btn sc-btn--blue-outline" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Vai alla didattica', 'wp-digital-italia' ); ?></a>
				</div>
				<div class="col-lg-8">
					<div class="row g-4">
						<?php
						$res = apply_filters( 'scuola_resources', array(
							array( __( 'Progetti', 'wp-digital-italia' ), $news_url, 'book' ),
							array( __( 'Schede didattiche', 'wp-digital-italia' ), $news_url, 'grid' ),
						) );
						foreach ( $res as [ $label, $url, $icon ] ) :
							?>
							<div class="col-md-6">
								<a class="sc-resource" href="<?php echo esc_url( $url ); ?>">
									<?php if ( 'book' === $icon ) : ?>
										<svg viewBox="0 0 40 40" width="40" height="40" aria-hidden="true"><rect x="7" y="4" width="26" height="32" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M13 12h14M13 18h14M13 24h8" stroke="currentColor" stroke-width="2"/></svg>
									<?php else : ?>
										<svg viewBox="0 0 40 40" width="40" height="40" aria-hidden="true"><rect x="4" y="6" width="32" height="28" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M4 14h32M4 22h32M13 6v28M22 6v28M31 6v28" stroke="currentColor" stroke-width="2"/></svg>
									<?php endif; ?>
									<span><?php echo esc_html( $label ); ?></span>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			if ( trim( get_the_content() ) ) :
				?>
				<section class="sc-section"><div class="container entry-content"><?php the_content(); ?></div></section>
				<?php
			endif;
		endwhile;
	endif;
	?>
</main>
<?php
get_footer();
