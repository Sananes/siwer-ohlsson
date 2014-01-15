<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Sell Photos
 * @since Sell Photos 1.0
 */
?>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div id="footer-inner">

				 <?php if ( is_active_sidebar( 'footer-widget-1' ) || is_active_sidebar( 'footer-widget-2' ) || is_active_sidebar( 'footer-widget-3' ) ) : ?>
			            <div id="footer-widgets" <?php sell_photos_footer_widget_class(); ?>>
			                <?php if ( is_active_sidebar( 'footer-widget-1' ) ) : ?>
			                    <aside id="widget-1" class="widget-1">
			                        <?php dynamic_sidebar( 'footer-widget-1' ); ?>
			                    </aside>
			                <?php endif; ?>
			                <?php if ( is_active_sidebar( 'footer-widget-2' ) ) : ?>
			                    <aside id="widget-2" class="widget-2">
			                        <?php dynamic_sidebar( 'footer-widget-2' ); ?>
			                    </aside>
			                <?php endif; ?>
			                <?php if ( is_active_sidebar( 'footer-widget-3' ) ) : ?>
			                    <aside id="widget-3" class="widget-3">
			                        <?php dynamic_sidebar( 'footer-widget-3' ); ?>
			                    </aside>
			                <?php endif; ?>
			            </div><!-- end #footer-widgets -->
			        <?php endif; // end check if any footer widgets are active ?>

			</div><!-- #footer-inner -->
			<div id="site-info-wrap">
				<div class="site-info">
					<?php do_action( 'sell_photos_credits' ); ?>
					<?php printf( __( '%1$s by %2$s.', 'sell_photos' ), '<a href="http://www.siwerohlsson.com">SiwerOhlsson</a>', '<a href="http://www.amego.co">AmegoBrands</a>' ); ?>
				</div><!-- .site-info -->
			</div>
		</footer><!-- #colophon .site-footer -->
	</div><!-- #main .site-main -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>