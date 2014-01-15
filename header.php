<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Sell Photos
 * @since Sell Photos 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php global $theme_options; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if ( ! empty( $theme_options['favicon'] ) ) { ?>
	<link rel="shortcut icon" href="<?php echo esc_url( $theme_options['favicon'] ); ?>" />
<?php } ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div id="header-inner" >
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			    	<?php if ( ! empty( $theme_options['logo'] ) ) : ?>
			    	<img class="sitetitle" src="<?php echo esc_url( $theme_options['logo'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			    	<?php else : ?>
			    		<?php bloginfo( 'name' ); ?>
			    	<?php endif; ?>
		    	</a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>

			<!-- <?php
			if ( class_exists( 'SellMedia' ) && function_exists( 'sell_media_advanced_search' ) ) {
				echo '<div id="header-smas" style="display:none">';
				echo do_shortcode( '[sell_media_searchform_advanced]' );
				echo '</div>';
			} else {
				get_search_form();
			} ?> -->
		</div>
		<div id="main-nav-wrapper" class="site-nav">
			<nav id="site-navigation" role="navigation" class="site-navigation-main main-navigation">
				<h1 class="menu-toggle"><span class="genericon genericon-menu"></span> <?php _e( 'Menu', 'sell_photos' ); ?></h1>
				<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'sell_photos' ); ?>"><?php _e( 'Skip to content', 'sell_photos' ); ?></a></div>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .site-navigation .main-navigation -->
		</div><!-- #main-nav-wrapper -->
		<div id="nav-wrapper">
			<nav role="navigation" class="top-navigation">
				<h1 class="assistive-text"><span class="genericon genericon-menu"></span> <?php _e( 'Top Menu', 'sell_photos' ); ?></h1>
				<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'sell_photos' ); ?>"><?php _e( 'Skip to content', 'sell_photos' ); ?></a></div>
				<?php wp_nav_menu( array( 'theme_location' => 'top' ) ); ?>

				<?php if ( sell_photos_sell_media_check() ) { ?>
					<span class='lightbox-counter' style="display:none;">
						<?php
						$blogname = get_site_url();
						$blogname = str_replace( array(':','.','/','-'), '', $blogname);
						
						$cookie_name = '_sellphotos_lightbox_' . $blogname;
						if ( isset($_COOKIE[$cookie_name]) ) {
							$cookie=  $_COOKIE[$cookie_name];
							$cookie=explode(',', $cookie);
							$count = count($cookie);
							echo $count;
						} else {
							echo "0";
						}
						?>
					</span>
				<?php } ?>
				
				<?php if ( sell_photos_sell_media_check() ) { ?>
					<span class="menu-cart-info" style="display:none;">
						&#40;<span class='menu-cart-items'></span>&#41;
						<span class="menu-cart-total-wrap">
							<span class='menu-cart-total'></span>
							<span class="menu-cart-currency">
								<?php echo sell_media_get_currency_symbol(); ?>
							</span>
						</span>
					</span>
				<?php } ?>

			</nav><!-- .top-navigation -->
		</div><!-- #nav-wrapper -->
	</header><!-- #masthead .site-header -->

	<div id="main" class="site-main">
		<div id="custom-header"<?php sell_photos_header_image(); ?>></div>