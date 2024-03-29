<?php
/**
 * @package Sell Photos
 * @since Sell Photos 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( '' != get_the_post_thumbnail() &&  ! is_single() ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'sell_photos' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark" class="archive-thumbnail">
				<?php the_post_thumbnail('sell_media_item'); ?>
			</a>
		<?php } ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'sell_photos' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php sell_photos_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">

		<?php if ( is_single() ) {
			if ( '' != get_the_post_thumbnail() ) {

				$thumbid = get_post_thumbnail_id( $post->ID );
				$img = wp_get_attachment_image_src( $thumbid, 'large' );
				$img[ 'title' ] = get_the_title( $thumbid ); ?>
				<a href="<?php echo $img[0]; ?>" title="<?php echo $img[ 'title' ]; ?>" class="single-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</a>

			<?php }
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'sell_photos' ) );
		} else {
			the_excerpt();
		} ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'sell_photos' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	<?php if ( is_single() ) { ?>
		<footer class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'sell_photos' ) );
					if ( $categories_list && sell_photos_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php printf( __( 'Posted in %1$s', 'sell_photos' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'sell_photos' ) );
					if ( $tags_list ) :
				?>
				<span class="sep"> | </span>
				<span class="tags-links">
					<?php printf( __( 'Tagged %1$s', 'sell_photos' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="sep"> | </span>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'sell_photos' ), __( '1 Comment', 'sell_photos' ), __( '% Comments', 'sell_photos' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'sell_photos' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	<?php } ?>
</article><!-- #post-<?php the_ID(); ?> -->
