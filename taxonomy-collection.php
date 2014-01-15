<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sell Photos
 * @since 1.0
 */
get_header();
global $wp_query;
global $theme_options;

if ( sell_photos_sell_media_check() ) {
	$settings = sell_media_get_plugin_options();
	$price = $settings->default_price;
} else {
	$price = "0.00";
}

?>

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
					<a href="<?php print get_post_type_archive_link( 'sell_media_item' ); ?>"><?php $obj = get_post_type_object( 'sell_media_item' ); echo $obj->rewrite['slug']; ?></a>
					<?php
						$term = get_term_by( 'slug', get_query_var( 'siwer-ohlsson' ), get_query_var( 'taxonomy' ) );
						$parent = get_term($term->parent, get_query_var( 'taxonomy' ) );
						if ( !empty ( $parent->name ) )
						echo '<span class="sep">&raquo;</span> <a href="' . site_url( 'collection/' . $parent->slug ) . '">' . $parent->name . '</a>';
					?>
					<span class="sep">&raquo;</span>
					<?php echo single_cat_title( '', false ); ?>
				</h1>
			</header><!-- .page-header -->

				<?php
				// check if this term has child terms, if so, show terms
				$children = get_term_children( $wp_query->queried_object_id, 'collection' );
				if ( $children ) : ?>

				<div id="main-collections" class="sell-media-grid-container">

				<?php
					$taxonomy = 'collection';

					$args = array(
					    'orderby' => 'name',
						'hide_empty' => true,
						'number' => get_option('posts_per_page '),
						'parent' => $wp_query->queried_object_id
					);

					$terms = get_terms( $taxonomy, $args );

					if ( empty( $terms ) )
						return;

					$count = count( $terms );
					$x = 0;
					$i = 0;

					foreach( $terms as $term ) : $i++;

						if ( $i %3 == 0)
							$end = ' end';
						else
							$end = null;

						?>
						<div class="sell-media-grid third<?php echo $end; ?>">
							<?php
							$args = array(
									'post_status' => 'publish',
									'taxonomy' => 'collection',
									'field' => 'slug',
									'term' => $term->slug
							        );
							$posts = New WP_Query( $args );
							$post_count = 0;
							$post_count = $posts->found_posts;
							?>

							<div class="collection-details">
								<span class="collection-count">
									<?php echo '<span class="count">' . $post_count . '</span>' .  __( ' images in ', 'sell_photos' ) . '<span class="collection">' . $term->name . '</span>' . __(' collection', 'sell_photos'); ?>
								</span>
								<span class="collection-price">
									<?php echo __( 'Starting at ', 'sell_photos' ) . '<span class="price">' . sell_media_get_currency_symbol() . $price . '</span>' ?>
								</span>
							</div>
							<?php
							$args = array(
									'posts_per_page' => 1,
									'taxonomy' => 'collection',
									'field' => 'slug',
									'term' => $term->slug
									);

							$posts = New WP_Query( $args );
							?>

							<?php foreach( $posts->posts as $post ) : ?>

								<?php
								//Get Post Attachment ID
								$sell_media_attachment_id = get_post_meta( $post->ID, '_sell_media_attachment_id', true );
								if ( $sell_media_attachment_id ){
									$attachment_id = $sell_media_attachment_id;
								} else {
									$attachment_id = get_post_thumbnail_id( $post->ID );
								}
								?>
								<a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>" class="collection">
									<?php sell_media_item_icon( $attachment_id, 'sell_media_item' ); ?>
									<div class="sell-media-item-details sell-media-item-details-collection" style="display:block">
										<?php echo $term->name; ?>
									</div>
								</a>
							<?php endforeach; ?>
						</div>

					<?php endforeach; ?>

					</div><!-- .sell-media-grid-container -->

				<?php else : // term has no child terms, so show items ?>

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
										<a id="like-<?php the_ID(); ?>" class="like-count genericon genericon-small genericon-star" href="#" <?php sell_photos_liked_class(); ?>>
											<?php sell_photos_post_liked_count(); ?>
										</a>
									</div>
								</div>
							</div><!-- .sell-media-grid -->
						<?php endwhile; ?>
		    			<?php sell_media_pagination_filter(); ?>
					<?php else : ?>
						<p><?php _e( 'Nothing Found', 'sell_photos' ); ?></p>
					<?php endif; $i = 0; ?>

					</div><!-- .sell-media-grid-container -->

				<?php endif; ?><!-- end check for parent/child terms -->

		</div><!-- #content -->
	</div><!-- #sell_media-single .sell_media -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>