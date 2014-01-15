<?php
	global $theme_options;

	if ( sell_photos_sell_media_check() ) {
		$settings = sell_media_get_plugin_options();
		$price = $settings->default_price;
	} else {
		$price = "0.00";
	}

?>

	<div id="main-collections" class="sell-media-grid-container">
		<?php

		$taxonomy = 'collection';
		$term_ids = array();
		foreach( get_terms( $taxonomy ) as $term_obj ){
		    $password = sell_media_get_term_meta( $term_obj->term_id, 'collection_password', true );
		    if ( $password ) $term_ids[] = $term_obj->term_id;
		}

		$args = array(
		    'orderby' => 'name',
			'hide_empty' => true,
			'number' => get_option('posts_per_page '),
			'parent' => 0,
			'exclude' => $term_ids
		);

		$terms = get_terms( $taxonomy, $args );

		// Randomize Taxonomies
		shuffle( $terms );

		if ( empty( $terms ) )
			return;

		$count = count( $terms );

		foreach( $terms as $term ) :
			$args = array(
					'post_status' => 'publish',
					'taxonomy' => 'collection',
					'field' => 'slug',
					'term' => $term->slug,
					'tax_query' => array(
						array(
                            'taxonomy' => 'collection',
                            'field' => 'id',
                            'terms' => $term_ids,
                            'operator' => 'NOT IN'
                            )
						)
			        );
			$posts = New WP_Query( $args );
			$post_count = $posts->found_posts;

			if ( $post_count != 0 ) : ?>
				<div class="sell-media-grid third">
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
							<?php

							$collection_attachment_id = sell_media_get_term_meta( $term->term_id, 'collection_icon_id', true );

							if ( ! empty ( $collection_attachment_id ) ) {
								$attached_image = wp_get_attachment_image( $collection_attachment_id, 'sell_media_item' );
								if ( empty( $attached_image ) ) $attached_image = '<img src="' . get_template_directory_uri() . '/images/no-image-thumbnail.png" class="wp-post-image" alt="' . __( 'Set a Featured Image', 'sell_photos') . '" />';
								echo $attached_image;
							} else {
								sell_media_item_icon( $attachment_id, 'sell_media_item' );
							} ?>
							<div class="sell-media-item-details sell-media-item-details-collection">
								<?php echo $term->name; ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
	    <?php endforeach; ?>
	</div><!-- .sell-media-grid-container -->