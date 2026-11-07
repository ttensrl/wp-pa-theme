<?php
/** Hero: slider accessibile delle ultime news (senza dipendenze JS esterne). */
if ( ! get_theme_mod( 'dci_hero_enabled', true ) ) {
	return;
}
$args_q = array(
	'posts_per_page'      => (int) get_theme_mod( 'dci_hero_count', 5 ),
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
);
if ( $cat = (int) get_theme_mod( 'dci_hero_category', 0 ) ) {
	$args_q['cat'] = $cat;
}
$q = new WP_Query( $args_q );
if ( ! $q->have_posts() ) {
	return;
}
$autoplay = get_theme_mod( 'dci_hero_autoplay', true ) && $q->post_count > 1;
$total    = $q->post_count;
?>
<section class="dci-hero-slider" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Ultime notizie', 'wp-digital-italia' ); ?>" data-autoplay="<?php echo $autoplay ? '1' : '0'; ?>" data-interval="6000">
	<div class="dci-hero-slider__track" aria-live="off">
		<?php
		$i = 0;
		while ( $q->have_posts() ) :
			$q->the_post();
			$img = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : '';
			$cat = array_values( array_filter( get_the_category(), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
			?>
			<article class="dci-hero-slide dci-hero-slide--v<?php echo (int) ( $i % 3 ); ?><?php echo $img ? '' : ' is-placeholder'; ?><?php echo 0 === $i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( sprintf( __( '%1$d di %2$d', 'wp-digital-italia' ), $i + 1, $total ) ); ?>"<?php echo $i ? ' hidden' : ''; ?>>
				<?php if ( $img ) : ?><img class="dci-hero-slide__img" src="<?php echo esc_url( $img ); ?>" alt="" loading="<?php echo $i ? 'lazy' : 'eager'; ?>"><?php endif; ?>
				<div class="dci-hero-slide__caption">
					<?php if ( $cat ) : ?><span class="dci-hero-slide__cat"><?php echo esc_html( $cat[0]->name ); ?></span><?php endif; ?>
					<h2 class="dci-hero-slide__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p class="dci-hero-slide__date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
					<p class="dci-hero-slide__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
				</div>
			</article>
			<?php
			$i++;
		endwhile;
		wp_reset_postdata();
		?>
	</div>
	<?php if ( $total > 1 ) : ?>
		<div class="dci-hero-slider__controls">
			<button type="button" class="dci-hero-slider__btn" data-dir="-1" aria-label="<?php esc_attr_e( 'Notizia precedente', 'wp-digital-italia' ); ?>"><?php echo dci_icon( 'chevron-left', 'icon icon-white' ); ?></button>
			<ul class="dci-hero-slider__dots">
				<?php for ( $d = 0; $d < $total; $d++ ) : ?>
					<li><button type="button" data-go="<?php echo (int) $d; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Vai alla notizia %d', 'wp-digital-italia' ), $d + 1 ) ); ?>"<?php echo 0 === $d ? ' aria-current="true"' : ''; ?>></button></li>
				<?php endfor; ?>
			</ul>
			<button type="button" class="dci-hero-slider__btn" data-dir="1" aria-label="<?php esc_attr_e( 'Notizia successiva', 'wp-digital-italia' ); ?>"><?php echo dci_icon( 'chevron-right', 'icon icon-white' ); ?></button>
			<?php if ( $autoplay ) : ?>
				<button type="button" class="dci-hero-slider__btn dci-hero-slider__pause" aria-pressed="false" data-label-pause="<?php esc_attr_e( 'Metti in pausa lo scorrimento', 'wp-digital-italia' ); ?>" data-label-play="<?php esc_attr_e( 'Riavvia lo scorrimento', 'wp-digital-italia' ); ?>" aria-label="<?php esc_attr_e( 'Metti in pausa lo scorrimento', 'wp-digital-italia' ); ?>"><span aria-hidden="true">❚❚</span></button>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if ( $news_url = get_permalink( (int) get_option( 'page_for_posts' ) ) ) : ?>
		<a class="dci-hero-slider__all" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Vedi tutte le news', 'wp-digital-italia' ); ?></a>
	<?php endif; ?>
</section>
