<?php
/**
 * Template Name: Home
 * Home del profilo Scuola, modellata su federicocaffe.edu.it: in evidenza + "Avvisi e Notizie",
 * "In primo piano", "Accesso rapido", "Collegamenti utili", "Trasparenza" e "Procedure attive".
 *
 * @package digital-italia
 */
get_header();

$posts    = dci_latest_posts( 9 )->posts;
$feat     = $posts ? array_shift( $posts ) : null;
$notices  = array_slice( $posts, 0, 5 );
$cards    = array_slice( $posts, 0, 4 );
$news_url = get_permalink( (int) get_option( 'page_for_posts' ) );
$bandi    = dci_latest_bandi( 5 );
$servizi  = get_posts( array( 'post_type' => 'servizio', 'numberposts' => 6, 'orderby' => 'title', 'order' => 'ASC' ) );
$icons    = array( 'files', 'calendar', 'folder', 'bookmark', 'clip', 'note' );
$privacy  = get_page_by_path( 'privacy' );
$access   = get_page_by_path( 'accessibilita' );
$transp   = get_theme_mod( 'site_contact_administration_transparent' ) ?: get_post_type_archive_link( 'bando' );
$tiles    = array(
	array( __( 'Amministrazione Trasparente', 'wp-digital-italia' ), 'pa', $transp, '#0a5fd0' ),
	array( __( 'Albo Online', 'wp-digital-italia' ), 'files', get_post_type_archive_link( 'bando' ), '#0a4aa6' ),
	array( __( 'Sicurezza', 'wp-digital-italia' ), 'info-circle', $access ? get_permalink( $access ) : '#', '#2b7be0' ),
	array( __( 'Privacy', 'wp-digital-italia' ), 'bookmark', $privacy ? get_permalink( $privacy ) : '#', '#0a2a63' ),
);
$links = array(
	array( 'PNRR', 'https://pnrr.istruzione.it/' ),
	array( 'Pago in Rete', 'https://www.istruzione.it/pagoinrete/' ),
	array( 'Erasmus+', 'https://erasmus-plus.ec.europa.eu/it' ),
	array( 'Scuola in Chiaro', 'https://cercalatuascuola.istruzione.it/' ),
	array( 'Ministero', 'https://www.mim.gov.it/' ),
);
?>
<main id="primary">

	<section class="dci-block" aria-labelledby="evidenza">
		<div class="dci-wrap dci-two">
			<div>
				<div class="dci-block__head"><h2 id="evidenza" class="dci-block__title"><?php esc_html_e( 'In evidenza', 'wp-digital-italia' ); ?></h2></div>
				<?php if ( $feat ) : $img = dci_post_image_url( $feat ); ?>
					<a class="dci-herosplit__media<?php echo $img ? '' : ' dci-ph dci-ph--v1'; ?>" style="display:block;margin-bottom:.9rem" href="<?php echo esc_url( get_permalink( $feat ) ); ?>" tabindex="-1" aria-hidden="true"><?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt=""><?php endif; ?></a>
					<h3 class="dci-newscard__title"><a href="<?php echo esc_url( get_permalink( $feat ) ); ?>"><?php echo esc_html( get_the_title( $feat ) ); ?></a></h3>
					<p class="dci-newscard__text"><?php echo esc_html( wp_trim_words( get_the_excerpt( $feat ), 28 ) ); ?></p>
				<?php endif; ?>
			</div>
			<div>
				<div class="dci-block__head"><h2 class="dci-block__title"><?php esc_html_e( 'Avvisi e Notizie', 'wp-digital-italia' ); ?></h2><?php if ( $news_url ) : ?><a class="dci-more" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Leggi tutto', 'wp-digital-italia' ); ?></a><?php endif; ?></div>
				<ul class="dci-notices">
					<?php foreach ( $notices as $p ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a><time datetime="<?php echo esc_attr( get_the_date( 'c', $p ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y', $p ) ); ?></time></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

	<?php if ( $cards ) : ?>
		<section class="dci-block dci-block--grey" aria-labelledby="primo-piano">
			<div class="dci-wrap">
				<div class="dci-block__head"><h2 id="primo-piano" class="dci-block__title dci-block__title--caps"><?php esc_html_e( 'In primo piano', 'wp-digital-italia' ); ?></h2><?php if ( $news_url ) : ?><a class="dci-more" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Leggi tutto', 'wp-digital-italia' ); ?></a><?php endif; ?></div>
				<div class="dci-newsgrid dci-newsgrid--4">
					<?php foreach ( $cards as $i => $p ) :
						global $post;
						$post = $p;
						setup_postdata( $post );
						get_template_part( 'template-parts/home/news-card', null, array( 'variant' => $i ) );
					endforeach;
					wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $servizi ) : ?>
		<section class="dci-block" aria-labelledby="accesso-rapido">
			<div class="dci-wrap">
				<div class="dci-block__head"><h2 id="accesso-rapido" class="dci-block__title dci-block__title--caps"><?php esc_html_e( 'Accesso rapido', 'wp-digital-italia' ); ?></h2></div>
				<ul class="dci-icontiles">
					<?php foreach ( $servizi as $i => $s ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><span class="dci-icontiles__ico"><?php echo dci_icon( $icons[ $i % count( $icons ) ], 'icon' ); ?></span><?php echo esc_html( get_the_title( $s ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<section class="dci-block" aria-labelledby="collegamenti" style="padding-top:0">
		<div class="dci-wrap">
			<div class="dci-block__head"><h2 id="collegamenti" class="dci-block__title dci-block__title--caps"><?php esc_html_e( 'Collegamenti utili', 'wp-digital-italia' ); ?></h2></div>
			<ul class="dci-logotiles">
				<?php foreach ( $links as [ $label, $url ] ) : ?>
					<li><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><span><?php echo esc_html( $label ); ?></span><span class="visually-hidden"> (<?php esc_html_e( 'si apre in una nuova scheda', 'wp-digital-italia' ); ?>)</span></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="dci-block dci-block--grey" aria-labelledby="trasparenza">
		<div class="dci-wrap dci-two">
			<div>
				<div class="dci-block__head"><h2 id="trasparenza" class="dci-block__title dci-block__title--caps"><?php esc_html_e( 'Trasparenza', 'wp-digital-italia' ); ?></h2></div>
				<div class="dci-colortiles">
					<?php foreach ( $tiles as [ $label, $icon, $url, $color ] ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" style="--t: <?php echo esc_attr( $color ); ?>"><span><?php echo dci_icon( $icon, 'icon' ); ?></span><span><?php echo esc_html( $label ); ?></span></a>
					<?php endforeach; ?>
				</div>
			</div>
			<div>
				<div class="dci-block__head"><h2 class="dci-block__title dci-block__title--caps"><?php esc_html_e( 'Procedure attive', 'wp-digital-italia' ); ?></h2></div>
				<ul class="dci-proc">
					<?php while ( $bandi->have_posts() ) : $bandi->the_post();
						$pub = get_post_meta( get_the_ID(), '_dci_bando_data_publish', true );
						$sca = get_post_meta( get_the_ID(), '_dci_bando_data_scadenza', true ); ?>
						<li>
							<span class="dci-proc__dates"><span><?php esc_html_e( 'Data di pubblicazione:', 'wp-digital-italia' ); ?> <?php echo $pub ? esc_html( date_i18n( 'j M Y', strtotime( $pub ) ) ) : ''; ?></span><?php if ( $sca ) : ?><span><?php esc_html_e( 'Data di scadenza:', 'wp-digital-italia' ); ?> <?php echo esc_html( date_i18n( 'j M Y', strtotime( $sca ) ) ); ?></span><?php endif; ?></span>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
				<p class="dci-block__foot"><a class="dci-more" href="<?php echo esc_url( get_post_type_archive_link( 'bando' ) ); ?>"><?php esc_html_e( 'Leggi tutto', 'wp-digital-italia' ); ?></a></p>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
