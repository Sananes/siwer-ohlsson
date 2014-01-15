<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sell Photos
 * @since Sell Photos 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<header class="page-header">
				<h1 class="page-title">
					<?php $obj = get_post_type_object( 'sell_media_item' ); echo $obj->rewrite['slug']; ?>
				</h1>
			</header><!-- .page-header -->

			<?php if ( have_posts() ) : ?>

				<div class="sell-media-grid-container">

				<?php rewind_posts(); ?>
				<?php $i = 0; ?>
				<?php while ( have_posts() ) : the_post(); $i++; ?>
					<?php
						if ( $i %3 == 0)
							$end = ' end';
						else
							$end = null;
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
				</div><!-- .sell-media-grid-container -->
    			<?php sell_media_pagination_filter(); ?>
			<?php else : ?>
				<p><?php _e( 'Nothing Found', 'sell_media' ); ?></p>
			<?php endif; $i = 0; ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>