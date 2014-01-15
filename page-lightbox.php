<?php
/*
 Template Name: Lightbox
 *
 * @package Sell Photos
 * @since Sell Photos 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php
					
					$blogname = get_site_url();
					$blogname = str_replace( array(':','.','/','-'), '', $blogname);
					
					// Lightbox from cookie
					$cookie_name = '_sellphotos_lightbox_' . $blogname;
					if( isset($_COOKIE[$cookie_name]) && ! isset ( $_GET['sell_media_ids'] ) ) {
						// Get post IDs from the cookie
						$cookie=  $_COOKIE[$cookie_name];

						// Build Lightbox email link
						if( $_SERVER['QUERY_STRING'] != '' ) {
							$special_char = '%26';
						} else {
							$special_char = '%3F';
						}
						$lightbox_link = get_permalink()  . $special_char . 'sell_media_ids=' . $cookie;
						?>
						<a href="mailto:?body=<?php echo $lightbox_link; ?>" class="email-to-friend"><div class="genericon genericon-mail"></div> <?php _e(' Email to friend'); ?></a>
					<?php } ?>
				</header><!-- .entry-header -->

				<?php if ( sell_photos_sell_media_check() ) { ?>
					<div id="lightbox">
						<?php
					
						// Lightbox from email
						if ( isset ( $_GET['sell_media_ids'] ) ) {
							$sell_media_ids = $_GET['sell_media_ids'];
							$posts = explode(',', $sell_media_ids);
						
							// Query posts
							$args = array(
									'posts_per_page' => -1,
									'post_type' => 'sell_media_item',
									'post__in' => $posts
							        );
							$posts = New WP_Query( $args );

							?>
							<?php if ( $posts->posts ) : ?>

								<?php /* Start the Loop */ ?>
								<?php foreach( $posts->posts as $post ) {  ?>
									<div class="sell-media-grid third">
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
												<a id="like-<?php the_ID(); ?>" class="like-count icon-heart" href="#" <?php sell_photos_liked_class(); ?>>
													<?php sell_photos_post_liked_count(); ?>
												</a>
											</div>
										</div>
									</div>

								<?php } ?>

							<?php else : ?>

								<?php _e( 'Your lightbox is empty', 'sell_photos' ); ?>

							<?php endif; 
						
						} else {
						?>
							<?php
							$blogname = get_site_url();
							$blogname = str_replace( array(':','.','/','-'), '', $blogname);
							
							$cookie_name = '_sellphotos_lightbox_' . $blogname;
							// Lightbox from cookie
							if( isset($_COOKIE[$cookie_name]) ) {
								// Get post IDs from the cookie
								$cookie=  $_COOKIE[$cookie_name];
						        $posts=explode(',',$cookie);
								
								// Query posts
								$args = array(
										'posts_per_page' => -1,
										'post_type' => 'sell_media_item',
										'post__in' => $posts
								        );
								$posts = New WP_Query( $args );
								?>
								<?php if ( $posts->posts ) : ?>
									
									<?php /* Start the Loop */ ?>
									<?php foreach( $posts->posts as $post ) {  ?>
										<div class="sell-media-grid third">
											<a href="" title="<?php _e( 'Remove from lightbox', 'sell_photos' ); ?>" class="remove-lightbox" id="lightbox-<?php the_ID(); ?>"><div class="genericon genericon-close"></div></a>

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
													<a id="like-<?php the_ID(); ?>" class="like-count genericon genericon-small genericon-star" href="#" <?php sell_photos_liked_class(); ?>><?php sell_photos_post_liked_count(); ?>
													</a>
												</div>
											</div>
										</div>

									<?php } ?>

								<?php else : ?>

									<?php _e( 'Your lightbox is empty', 'sell_photos' ); ?>

								<?php endif; ?>
							<?php } else { ?>
								<?php _e( 'Your lightbox is empty', 'sell_photos' ); ?>
							<?php } ?>
						<?php } ?>
					</div><!-- #lightbox -->
				<?php } else { ?>
					<?php _e('Please activate Sell Media plugin to use this page.', 'sell_photos'); ?>
				<?php } ?>
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>