<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sell Media
 * @since 0.1
 */
get_header(); global $wp_query; ?>

	<?php if ( sell_media_get_term_meta( $wp_query->queried_object_id, 'collection_hidden', true ) == "on" ) : ?>
		<div id="sell-media-archive" class="sell-media">
			<div id="content" role="main">
			<?php _e( 'This collection is hidden.', 'sell_photos' ); ?>
			</div>
		</div>
	<?php else : ?>

	<div id="sell-media-archive" class="sell-media">
		<div id="content" role="main">

			<header class="page-header">
				<h1 class="page-title">
					<a href="<?php print get_post_type_archive_link( 'sell_media_item' ); ?>"><?php $obj = get_post_type_object( 'sell_media_item' ); echo $obj->rewrite['slug']; ?></a> <span class="sep">&raquo;</span> <span><?php _e( 'Keyword Archives', 'sell_photos' ); ?></span> <span class="sep">&raquo;</span> <?php echo single_cat_title( '', false ); ?>
				</h1>
			</header><!-- .page-header -->

			<div class="sell-media-grid-container">
			<?php if ( have_posts() ) : ?>
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
								<a id="like-<?php the_ID(); ?>" class="like-count genericon genericon-small genericon-star"  href="#" <?php sell_photos_liked_class(); ?>>
						            <?php sell_photos_post_liked_count(); ?>
						        </a>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
    			<?php sell_media_pagination_filter(); ?>
			<?php else : ?>
				<p><?php _e( 'Nothing Found', 'sell_photos' ); ?></p>
			<?php endif; $i = 0; ?>
			</div><!-- .sell-media-grid-container -->
		</div><!-- #content -->
	</div><!-- #sell_media-single .sell_media -->
<?php endif; ?>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>