<?php
/**
 * Homepage template file.
 *
 *
 * @package Sell Photos
 * @since Sell Photos 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<?php if ( is_active_sidebar( 'homepage-top' ) ) : ?>
			<section id="homewidgets-top" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'homepage-top' ); ?>
			</section><!-- #homewidgets-top .widget-area -->
		<?php endif; ?>
		
		<?php
		// Homepage Slideshow
		if ( '' <> $theme_options['slide_show'] && isset($theme_options['slideshow_enabled']) && $theme_options['slideshow_enabled'] == 'yes' ) { ?>

			<?php
			// Get Slides 
			$slides = $theme_options['slide_show'];
			$images = explode( ',', $slides );
			?>

			<div id="home-slider">
				<div class="flexslider home-slider">
			        <ul class="slides">

						<?php 
						foreach( $images as $id ) {

							$attachment_caption = get_post_field('post_excerpt', $id);
							$attachment_title = get_post_field('post_title', $id);
							$attachment_button = get_post_meta( $id, "_gpp_custom_url", true );
							?>
						<li>
							<div class="slide <?php if ( empty( $attachment_title ) ) echo "slide-no-title" ?>">
								<?php if ( ! empty ( $attachment_button ) ) { ?>
										<a href="<?php echo $attachment_button; ?>" title="<?php echo $attachment_title ?>" class="slide-link">
											<?php echo wp_get_attachment_image( $id, "large", 0 ); ?>
										</a>
								<?php } else { ?>

										<?php echo wp_get_attachment_image( $id, "large", 0 ); ?>
								<?php } ?>
								<?php if ( ! empty ( $attachment_caption ) || ! empty ( $attachment_title )  ) {

				                    echo '<div class="flex-caption">';
									if ( ! empty ( $attachment_title ) ) { ?>
										<h2 class="home-slide-title">
											<?php echo $attachment_title; ?>
										</h2>
									<?php }
									if ( ! empty ( $attachment_caption ) ) { ?>
										<?php echo '<span class="slide-caption">'.$attachment_caption.'</span>'; ?>
									<?php }
									echo '</div>';
				                } ?>
							</div>
						</li>
					<?php } ?>
				</ul> <!-- .slides -->	
			</div> <!-- .flexslider -->
		</div> <!-- #home-slider -->
	<?php } 
	// End Homepage Slideshow
	?>



		
			<div class="products-wrap">
				<!-- <h2 class="widget-title center"><?php _e( 'Collections', 'sell_photos' ); ?></h2> -->
						<div class="sell-media-grid-container">


						<?php query_posts('post_type=sell_media_item&showposts=100'); ?>
								<?php while ( have_posts() ) : the_post(); ?>
								<?php
														//Get Post Attachment ID
														$sell_media_attachment_id = get_post_meta( $post->ID, '_sell_media_attachment_id', true );
														if ( $sell_media_attachment_id ){
															$attachment_id = $sell_media_attachment_id;
														} else {
															$attachment_id = get_post_thumbnail_id( $post->ID );
														}
														?>

								<div class="sell-media-grid third<?php echo $end; ?>">
								<?php sell_media_item_buy_button( $post->ID, 'text', 'Buy' ); ?>
								<?php
								//Get Post Attachment ID
								$sell_media_attachment_id = get_post_meta( $post->ID, '_sell_media_attachment_id', true );
								if ( $sell_media_attachment_id ){
									$attachment_id = $sell_media_attachment_id;
								} else {
									$attachment_id = get_post_thumbnail_id( $post->ID );
								}
								?>
								<a href="<?php the_permalink(); ?>"><?php sell_media_item_icon( $attachment_id, 'sell_media_item' ); ?></a>

								<div class="sell-media-item-details">
									<div class="sell-media-item-details-inner">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<a id="like-<?php the_ID(); ?>" class="like-count genericon genericon-small genericon-star" href="#" <?php sell_photos_liked_class(); ?>>
											<?php sell_photos_post_liked_count(); ?>
										</a>
									</div>
								</div>
							</div><!-- .sell-media-grid -->
					

								<?php endwhile; ?>
			<section id="homewidgets-bottom" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'homepage-bottom' ); ?>
			</section><!-- #homewidgets-bottom .widget-area -->


	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>