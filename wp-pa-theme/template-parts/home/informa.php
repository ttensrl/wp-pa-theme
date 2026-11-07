<?php
/** Blocco "informa": tab accessibili Notizie / Bandi in corso. */
$news  = new WP_Query( array( 'posts_per_page' => 5, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
$bandi = new WP_Query( array(
	'post_type' => 'bando', 'posts_per_page' => 5, 'post_status' => 'publish',
	'meta_key'  => '_dci_bando_data_publish', 'orderby' => 'meta_value', 'order' => 'DESC',
) );
$news_url  = get_permalink( (int) get_option( 'page_for_posts' ) );
$bandi_url = get_post_type_archive_link( 'bando' );
?>
<section class="dci-section dci-section--alt" aria-labelledby="informa-title">
	<div class="container-fluid">
		<h2 id="informa-title" class="dci-section__title"><?php esc_html_e( 'Informa', 'wp-digital-italia' ); ?></h2>
		<ul class="nav nav-tabs justify-content-center" role="tablist">
			<li class="nav-item" role="presentation"><button class="nav-link active" id="tab-news" data-bs-toggle="tab" data-bs-target="#pane-news" type="button" role="tab" aria-controls="pane-news" aria-selected="true"><?php esc_html_e( 'Notizie', 'wp-digital-italia' ); ?></button></li>
			<li class="nav-item" role="presentation"><button class="nav-link" id="tab-bandi" data-bs-toggle="tab" data-bs-target="#pane-bandi" type="button" role="tab" aria-controls="pane-bandi" aria-selected="false"><?php esc_html_e( 'Bandi e concorsi', 'wp-digital-italia' ); ?></button></li>
		</ul>
		<div class="tab-content bg-white p-3 p-md-4">
			<div class="tab-pane fade show active" id="pane-news" role="tabpanel" aria-labelledby="tab-news" tabindex="0">
				<ul class="dci-list">
					<?php while ( $news->have_posts() ) : $news->the_post(); ?>
						<li class="dci-list__item">
							<h3 class="dci-list__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<span class="dci-list__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>
						</li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
				<?php if ( $news_url ) : ?><a class="dci-section__more d-block text-center mt-3" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Leggi tutte le notizie', 'wp-digital-italia' ); ?> <?php echo dci_icon( 'arrow-right' ); ?></a><?php endif; ?>
			</div>
			<div class="tab-pane fade" id="pane-bandi" role="tabpanel" aria-labelledby="tab-bandi" tabindex="0">
				<ul class="dci-list">
					<?php while ( $bandi->have_posts() ) : $bandi->the_post(); $st = dci_bando_stato( get_the_ID() ); ?>
						<li class="dci-list__item">
							<h3 class="dci-list__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if ( $st ) : ?><span class="dci-badge dci-badge--<?php echo esc_attr( $st ); ?>"><?php echo $st === 'attivo' ? esc_html__( 'In corso', 'wp-digital-italia' ) : esc_html__( 'Scaduto', 'wp-digital-italia' ); ?></span><?php endif; ?>
						</li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
				<?php if ( $bandi_url ) : ?><a class="dci-section__more d-block text-center mt-3" href="<?php echo esc_url( $bandi_url ); ?>"><?php esc_html_e( 'Tutti i bandi', 'wp-digital-italia' ); ?> <?php echo dci_icon( 'arrow-right' ); ?></a><?php endif; ?>
			</div>
		</div>
	</div>
</section>
