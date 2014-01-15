<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sell Photos
 * @since Sell Photos 1.0
 */

get_header(); ?>

		<section id="primary" class="content-area author-page">
			<div id="content" class="site-content" role="main">
				<?php $user = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>

				<?php
				$args = array(
					'post_status' => 'publish',
					'taxonomy' => 'collection',
					'post_type' => 'sell_media_item',
					'paged' => $paged,
					'author' => $user->ID,
					
					);

				$posts = New WP_Query( $args );
				?>
				<?php if ( $posts->posts ) { ?>
				<?php
				$i = 0;

				foreach( $posts->posts as $post ) : $i++; ?>

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
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="collection"><?php echo get_the_author(); ?></a>
							<a id="like-<?php the_ID(); ?>" class="like-count genericon genericon-small genericon-star" href="#" <?php sell_photos_liked_class(); ?>>
								<?php sell_photos_post_liked_count(); ?>
					        </a>
						</div>
					</div>

				<?php endforeach; ?>
				<?php sell_media_pagination_filter(); ?>
				<?php } else { ?>
					<?php _e('This author has no posts', 'sell_photos'); ?>
				<?php } ?>

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

		<section id="secondary">

			<?php
			$user_avatar = get_avatar($user->ID, 512);
			?>

			<div class="author-wrap">
				<a href="<?php echo esc_url( home_url( '/?post_type=sell_media_item&author=' ) ) . $user->ID; ?>" class="author-image"><?php echo $user_avatar; ?></a>
				<div class='author-info'>
					<ul class='author-details'>
						<li class='author-info-name'><h3><?php echo $user->display_name; ?></h3></li>
						<?php if ( ! empty($user->position)) { ?>
						<li class='author-info-position'><?php echo $user->position; ?></li>
						<?php } ?>
						<?php if ( ! empty($user->description)) { ?>
							<li class='author-info-bio'><?php echo $user->description; ?></li>
						<?php } ?>
						<?php if ( ! empty($user->user_url)) { ?>
							<li class="author-social">
								<a href='<?php echo $user->user_url; ?>' target='_blank'><div class="genericon genericon-small genericon-link"></div></a>
							</li>
						<?php } ?>
						<?php if ( ! empty($user->twitter)) { ?>
							<li class="author-social">
								<a href='<?php echo $user->twitter; ?>' target='_blank'><div class="genericon genericon-small genericon-twitter"></div></a>
							</li>
						<?php } ?>
						<?php if ( ! empty($user->facebook)) { ?>
							<li class="author-social">
								<a href='<?php echo $user->facebook; ?>' target='_blank'><div class="genericon genericon-small genericon-facebook"></div></a>
							</li>
						<?php } ?>
						<?php if ( ! empty($user->googleplus)) { ?>
							<li class="author-social">
								<a href='<?php echo $user->googleplus; ?>' target='_blank'><div class="genericon genericon-small genericon-googleplus"></div></a>
							</li>
						<?php } ?>
						<?php if ( ! empty($user->youtube)) { ?>
							<li class="author-social">
								<a href='<?php echo $user->youtube; ?>' target='_blank'><div class="genericon genericon-small genericon-youtube"></div></a>
							</li>
						<?php } ?>
						<?php if ( ! empty($user->vimeo)) { ?>
							<li class="author-social">
								<a href='<?php echo $user->vimeo; ?>' target='_blank'><div class="genericon genericon-small genericon-vimeo"></div></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</section>
<?php get_footer(); ?>