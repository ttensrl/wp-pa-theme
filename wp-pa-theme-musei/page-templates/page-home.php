<?php
/**
 * Template Name: Home
 * Home del profilo Musei (prototipo AGID "Musei civici"): hero con le sedi,
 * orari e dove siamo, in evidenza, opere, notizie, newsletter, social e sostegno.
 *
 * @package digital-italia
 */

get_header();

$arrow = '<svg class="mu-arrow" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M3 12h17M14 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>';
$today = wp_date( 'Y-m-d' );

$sedi = get_posts( array( 'post_type' => 'sede', 'numberposts' => 6, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );

/* Mostre ed eventi in corso o futuri, dalla piu' vicina; in mancanza si prendono le ultime. */
$eventi = get_posts( array(
	'post_type'   => 'mostra',
	'numberposts' => 3,
	'meta_key'    => '_mu_mostra_dal',
	'orderby'     => 'meta_value',
	'order'       => 'ASC',
	'meta_query'  => array(
		'relation' => 'OR',
		array( 'key' => '_mu_mostra_al', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
		array( 'key' => '_mu_mostra_dal', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
	),
) );
if ( count( $eventi ) < 3 ) {
	$eventi = get_posts( array( 'post_type' => 'mostra', 'numberposts' => 3, 'meta_key' => '_mu_mostra_dal', 'orderby' => 'meta_value', 'order' => 'DESC' ) );
}

$opere  = get_posts( array( 'post_type' => 'opera', 'numberposts' => 6, 'orderby' => 'menu_order date', 'order' => 'DESC' ) );
$news   = dci_latest_posts( 3 );
$social = dci_social_links();
$posts_page = (int) get_option( 'page_for_posts' );
$tickets    = (string) get_theme_mod( 'musei_tickets_url', '#biglietti' );
$hero_title = (string) get_theme_mod( 'musei_hero_title', __( 'Arte, storia e cultura tutte in unico Museo.', 'wp-digital-italia-musei' ) );
$hero_sub   = (string) get_theme_mod( 'musei_hero_text', __( 'Scopri l\'offerta dei Musei civici', 'wp-digital-italia-musei' ) );
?>
<main id="primary" class="mu-home">

	<!-- Hero con le sedi -->
	<section class="mu-hero" aria-labelledby="mu-hero-title" style="--mu-hero: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/hero.jpg' ); ?>')">
		<div class="container">
			<div class="mu-hero__top">
				<div class="mu-hero__head">
					<h1 id="mu-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
					<p class="mu-hero__sub"><?php echo esc_html( $hero_sub ); ?></p>
				</div>
				<div class="mu-hero__ctas">
					<a class="mu-btn mu-btn--white" href="<?php echo esc_url( get_post_type_archive_link( 'mostra' ) ); ?>"><?php esc_html_e( 'Scopri le mostre e gli eventi', 'wp-digital-italia-musei' ); ?></a>
					<a class="mu-btn mu-btn--outline" href="#orari"><?php esc_html_e( 'Organizza la visita', 'wp-digital-italia-musei' ); ?></a>
				</div>
			</div>

			<?php if ( $sedi ) : ?>
				<ul class="mu-places">
					<?php foreach ( $sedi as $s ) : ?>
						<li>
							<a class="mu-place" href="<?php echo esc_url( get_permalink( $s ) ); ?>">
								<span class="mu-place__img<?php echo has_post_thumbnail( $s ) ? '' : ' is-placeholder'; ?>">
									<?php echo has_post_thumbnail( $s ) ? get_the_post_thumbnail( $s, 'medium', array( 'alt' => '', 'loading' => 'lazy' ) ) : musei_placeholder_icon( 22 ); // phpcs:ignore ?>
								</span>
								<span class="mu-place__name"><?php echo esc_html( get_the_title( $s ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
				<p class="mu-hero__more"><a href="<?php echo esc_url( get_post_type_archive_link( 'sede' ) ); ?>"><?php esc_html_e( 'Esplora il museo', 'wp-digital-italia-musei' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Orari e dove siamo -->
	<?php if ( $sedi ) : ?>
		<section id="orari" class="mu-info" aria-label="<?php esc_attr_e( 'Orari e indirizzi', 'wp-digital-italia-musei' ); ?>">
			<div class="container">
				<div class="row g-4">
					<div class="col-lg-6">
						<div class="mu-panel">
							<h2><?php esc_html_e( 'Orari', 'wp-digital-italia-musei' ); ?></h2>
							<ul>
								<?php foreach ( $sedi as $s ) : ?>
									<?php
									$apre   = get_post_meta( $s->ID, '_mu_sede_apre', true );
									$chiude = get_post_meta( $s->ID, '_mu_sede_chiude', true );
									?>
									<li>
										<a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a>
										<?php if ( $apre && $chiude ) : ?>
											<span><?php echo esc_html( sprintf( /* translators: 1: ora di apertura, 2: ora di chiusura */ __( 'Aperto oggi dalle %1$s alle %2$s', 'wp-digital-italia-musei' ), $apre, $chiude ) ); ?></span>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
							<p class="mu-panel__more"><a href="<?php echo esc_url( get_post_type_archive_link( 'sede' ) ); ?>"><?php esc_html_e( 'Tutti gli orari', 'wp-digital-italia-musei' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mu-panel">
							<h2><?php esc_html_e( 'Dove siamo', 'wp-digital-italia-musei' ); ?></h2>
							<ul>
								<?php foreach ( $sedi as $s ) : ?>
									<li>
										<a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a>
										<span><?php echo esc_html( get_post_meta( $s->ID, '_mu_sede_indirizzo', true ) ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
							<p class="mu-panel__more"><a href="<?php echo esc_url( get_post_type_archive_link( 'sede' ) ); ?>"><?php esc_html_e( 'Dove siamo', 'wp-digital-italia-musei' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- In evidenza -->
	<?php if ( $eventi ) : ?>
		<section class="mu-section" aria-labelledby="mu-feat-title">
			<div class="container">
				<h2 id="mu-feat-title" class="mu-section__title"><?php esc_html_e( 'In evidenza', 'wp-digital-italia-musei' ); ?></h2>
				<div class="mu-featured-list">
					<?php foreach ( $eventi as $e ) : ?>
						<?php $tipo = get_post_meta( $e->ID, '_mu_mostra_tipo', true ) ?: 'mostra'; ?>
						<article class="mu-featured">
							<a class="mu-featured__media<?php echo has_post_thumbnail( $e ) ? '' : ' is-placeholder'; ?>" href="<?php echo esc_url( get_permalink( $e ) ); ?>" tabindex="-1" aria-hidden="true">
								<?php echo has_post_thumbnail( $e ) ? get_the_post_thumbnail( $e, 'large', array( 'alt' => '', 'loading' => 'lazy' ) ) : musei_placeholder_icon( 56 ); // phpcs:ignore ?>
							</a>
							<div class="mu-featured__body">
								<div>
									<h3><a href="<?php echo esc_url( get_permalink( $e ) ); ?>"><?php echo esc_html( get_the_title( $e ) ); ?></a></h3>
									<p class="mu-featured__date"><?php echo esc_html( musei_date_range( $e->ID ) ); ?></p>
									<p class="mu-featured__text"><?php echo esc_html( wp_trim_words( get_the_excerpt( $e ), 40 ) ); ?></p>
								</div>
								<span class="mu-badge"><?php echo 'evento' === $tipo ? esc_html__( 'Evento', 'wp-digital-italia-musei' ) : esc_html__( 'Mostra', 'wp-digital-italia-musei' ); ?></span>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<p class="mu-more"><a href="<?php echo esc_url( get_post_type_archive_link( 'mostra' ) ); ?>"><?php esc_html_e( 'Tutte le mostre e gli eventi', 'wp-digital-italia-musei' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
			</div>
		</section>
	<?php endif; ?>

	<!-- Immergiti nel museo -->
	<?php if ( $opere ) : ?>
		<section class="mu-section" aria-labelledby="mu-opere-title">
			<div class="container">
				<h2 id="mu-opere-title" class="mu-section__title"><?php esc_html_e( 'Immergiti nel museo', 'wp-digital-italia-musei' ); ?></h2>
				<ul class="mu-works">
					<?php foreach ( $opere as $o ) : ?>
						<li>
							<a class="mu-work" href="<?php echo esc_url( get_permalink( $o ) ); ?>">
								<span class="mu-work__img<?php echo has_post_thumbnail( $o ) ? '' : ' is-placeholder'; ?>">
									<?php echo has_post_thumbnail( $o ) ? get_the_post_thumbnail( $o, 'large', array( 'alt' => '', 'loading' => 'lazy' ) ) : musei_placeholder_icon( 56 ); // phpcs:ignore ?>
								</span>
								<span class="mu-work__title"><?php echo esc_html( get_the_title( $o ) ); ?></span>
								<span class="mu-work__artist"><?php echo esc_html( get_post_meta( $o->ID, '_mu_opera_artista', true ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
				<p class="mu-more"><a href="<?php echo esc_url( get_post_type_archive_link( 'opera' ) ); ?>"><?php esc_html_e( 'Tutte le opere', 'wp-digital-italia-musei' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
			</div>
		</section>
	<?php endif; ?>

	<!-- Ultime notizie -->
	<?php if ( $news->have_posts() ) : ?>
		<section class="mu-section" aria-labelledby="mu-news-title">
			<div class="container">
				<h2 id="mu-news-title" class="mu-section__title"><?php esc_html_e( 'Le ultime notizie del museo', 'wp-digital-italia-musei' ); ?></h2>
				<div class="row g-4">
					<?php while ( $news->have_posts() ) : $news->the_post(); ?>
						<div class="col-md-4">
							<article class="mu-news">
								<a class="mu-news__media<?php echo has_post_thumbnail() ? '' : ' is-placeholder'; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
									<?php echo has_post_thumbnail() ? get_the_post_thumbnail( null, 'large', array( 'alt' => '', 'loading' => 'lazy' ) ) : musei_placeholder_icon( 40 ); // phpcs:ignore ?>
								</a>
								<div class="mu-news__body">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 30 ) ); ?></p>
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( musei_format_date( get_the_time( 'U' ) ) ); ?></time>
								</div>
							</article>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<?php if ( $posts_page ) : ?>
					<p class="mu-more"><a href="<?php echo esc_url( get_permalink( $posts_page ) ); ?>"><?php esc_html_e( 'Tutte le notizie', 'wp-digital-italia-musei' ); ?> <?php echo $arrow; // phpcs:ignore ?></a></p>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Newsletter -->
	<section class="mu-newsletter" aria-labelledby="mu-nl-title">
		<div class="container">
			<h2 id="mu-nl-title"><?php esc_html_e( 'Iscriviti alla nostra newsletter', 'wp-digital-italia-musei' ); ?></h2>
			<p><?php esc_html_e( 'Iscriviti per ricevere la nostra newsletter con tutte le novità del Museo', 'wp-digital-italia-musei' ); ?></p>
			<form class="mu-newsletter__form" action="<?php echo esc_url( (string) apply_filters( 'musei_newsletter_action', '#' ) ); ?>" method="post" data-mu-newsletter>
				<label for="mu-nl-email"><?php esc_html_e( 'Email', 'wp-digital-italia-musei' ); ?></label>
				<input id="mu-nl-email" name="email" type="email" required autocomplete="email">
				<button type="submit" class="mu-btn mu-btn--lg"><?php esc_html_e( 'Iscriviti', 'wp-digital-italia-musei' ); ?></button>
				<p class="mu-newsletter__ok" role="status" hidden><?php esc_html_e( 'Grazie! Ti abbiamo registrato (demo: nessun dato viene inviato).', 'wp-digital-italia-musei' ); ?></p>
			</form>
		</div>
	</section>

	<!-- Social -->
	<?php if ( $social ) : ?>
		<section class="mu-social" aria-labelledby="mu-social-title">
			<div class="container">
				<h2 id="mu-social-title"><?php esc_html_e( 'Dai nostri social', 'wp-digital-italia-musei' ); ?></h2>
				<ul>
					<?php foreach ( $social as $l ) : ?>
						<li><a href="<?php echo esc_url( $l['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo dci_icon( str_replace( 'it-', '', $l['icon'] ), 'icon icon-sm' ); ?> <span><?php echo esc_html( $l['label'] ); ?></span></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- Supporta il museo -->
	<section id="supporta" class="mu-support" aria-labelledby="mu-support-title">
		<div class="container">
			<h2 id="mu-support-title"><?php esc_html_e( 'Vuoi supportare il museo?', 'wp-digital-italia-musei' ); ?></h2>
			<p><?php esc_html_e( 'Fai una donazione e diventa nostro membro', 'wp-digital-italia-musei' ); ?></p>
			<a class="mu-btn mu-btn--white mu-btn--lg" href="<?php echo esc_url( (string) apply_filters( 'musei_support_url', '#' ) ); ?>"><?php esc_html_e( 'Supporta il museo', 'wp-digital-italia-musei' ); ?></a>
		</div>
	</section>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			if ( trim( get_the_content() ) ) :
				?>
				<section class="mu-section"><div class="container entry-content"><?php the_content(); ?></div></section>
				<?php
			endif;
		endwhile;
	endif;
	?>
</main>
<?php
get_footer();
