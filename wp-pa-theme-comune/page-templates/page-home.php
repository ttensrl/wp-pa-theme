<?php
/**
 * Template Name: Home
 * Home del profilo Comune, modellata su comune.sandonatomilanese.mi.it:
 * notizia in evidenza (testo + immagine), "In primo piano" a card, avvisi/bandi e servizi.
 *
 * @package digital-italia
 */
get_header();

$posts   = dci_latest_posts( 7 )->posts;
$feat    = $posts ? array_shift( $posts ) : null;
$news_url = get_permalink( (int) get_option( 'page_for_posts' ) );
$bandi   = dci_latest_bandi( 4 );
$tiles   = dci_quick_links();
?>
<main id="primary">

	<?php if ( $feat ) :
		$img = dci_post_image_url( $feat );
		$cat = array_values( array_filter( get_the_category( $feat->ID ), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
		?>
		<section class="dci-herosplit" aria-label="<?php esc_attr_e( 'Notizia in evidenza', 'wp-digital-italia' ); ?>">
			<div class="dci-wrap dci-herosplit__grid">
				<div>
					<p class="dci-herosplit__meta"><?php echo dci_icon( 'file', 'icon icon-sm' ); ?> <?php esc_html_e( 'Notizia', 'wp-digital-italia' ); ?> &mdash; <time datetime="<?php echo esc_attr( get_the_date( 'c', $feat ) ); ?>"><?php echo esc_html( dci_short_date( $feat ) ); ?></time></p>
					<h1 class="dci-herosplit__title"><a href="<?php echo esc_url( get_permalink( $feat ) ); ?>"><?php echo esc_html( get_the_title( $feat ) ); ?></a></h1>
					<p class="dci-herosplit__text"><?php echo esc_html( wp_trim_words( get_the_excerpt( $feat ), 36 ) ); ?></p>
					<?php if ( $cat ) : ?><span class="dci-pill"><?php echo esc_html( $cat[0]->name ); ?></span><br><?php endif; ?>
					<?php if ( $news_url ) : ?><a class="dci-cta" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Scopri le ultime novità', 'wp-digital-italia' ); ?> <?php echo dci_icon( 'arrow-right', 'icon icon-sm' ); ?></a><?php endif; ?>
				</div>
				<a class="dci-herosplit__media<?php echo $img ? '' : ' dci-ph dci-ph--v0'; ?>" href="<?php echo esc_url( get_permalink( $feat ) ); ?>" tabindex="-1" aria-hidden="true">
					<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt=""><?php endif; ?>
				</a>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $posts ) : ?>
		<section class="dci-block" aria-labelledby="primo-piano">
			<div class="dci-wrap">
				<div class="dci-block__head"><h2 id="primo-piano" class="dci-block__title"><?php esc_html_e( 'In primo piano', 'wp-digital-italia' ); ?></h2></div>
				<div class="dci-newsgrid">
					<?php foreach ( $posts as $i => $p ) :
						global $post;
						$post = $p;
						setup_postdata( $post );
						get_template_part( 'template-parts/home/news-card', null, array( 'variant' => $i ) );
					endforeach;
					wp_reset_postdata(); ?>
				</div>
				<?php if ( $news_url ) : ?><div class="dci-block__foot"><a class="dci-btn" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Tutte le novità', 'wp-digital-italia' ); ?></a></div><?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<section class="dci-block dci-block--grey" aria-labelledby="servizi-bandi">
		<div class="dci-wrap dci-two">
			<div>
				<div class="dci-block__head"><h2 id="servizi-bandi" class="dci-block__title"><?php esc_html_e( 'Cosa cerchi?', 'wp-digital-italia' ); ?></h2></div>
				<ul class="dci-icontiles">
					<?php foreach ( $tiles as [ $label, $icon, $url ] ) : ?>
						<li><a href="<?php echo esc_url( $url ); ?>"><span class="dci-icontiles__ico"><?php echo dci_icon( $icon, 'icon' ); ?></span><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div>
				<div class="dci-block__head"><h2 class="dci-block__title"><?php esc_html_e( 'Bandi e avvisi', 'wp-digital-italia' ); ?></h2><a class="dci-more" href="<?php echo esc_url( get_post_type_archive_link( 'bando' ) ); ?>"><?php esc_html_e( 'Leggi tutto', 'wp-digital-italia' ); ?></a></div>
				<ul class="dci-proc">
					<?php while ( $bandi->have_posts() ) : $bandi->the_post();
						$pub = get_post_meta( get_the_ID(), '_dci_bando_data_publish', true );
						$sca = get_post_meta( get_the_ID(), '_dci_bando_data_scadenza', true ); ?>
						<li>
							<span class="dci-proc__dates"><span><?php esc_html_e( 'Pubblicato il', 'wp-digital-italia' ); ?> <?php echo $pub ? esc_html( date_i18n( 'j M Y', strtotime( $pub ) ) ) : ''; ?></span><?php if ( $sca ) : ?><span><?php esc_html_e( 'Scadenza', 'wp-digital-italia' ); ?> <?php echo esc_html( date_i18n( 'j M Y', strtotime( $sca ) ) ); ?></span><?php endif; ?></span>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
