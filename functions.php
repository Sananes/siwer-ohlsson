<?php
/**
 *Sell Photos functions and definitions
 *
 * @package Sell Photos
 * @since Sell Photos 1.0
 */

/**
 * Set the theme option variable for use throughout theme.
 *
 * @since full_frame 1.0
 */
if ( ! isset( $theme_options ) )
	$theme_options = get_option( 'sell_photos_options' );
global $theme_options;

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Sell Photos 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 1000; /* pixels */

if ( ! function_exists( 'sell_photos_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Sell Photos 1.0
 */
function sell_photos_setup() {
	/**
	 * Actions for this theme.
	 */
	require( get_template_directory() . '/inc/actions.php' );
	/**
	 * Filters for this theme.
	 */
	require( get_template_directory() . '/inc/filters.php' );
	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );


	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Sell Photos, use a find and replace
	 * to change 'sell_photos' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sell_photos', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Add custom background support
	 */
	$args = array(
		'default-color' => 'ffffff'
	);

	add_theme_support( 'custom-background', $args );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	/**
	 * Set Image sizes
	 */
	set_post_thumbnail_size( 50, 50, true ); // default thumbnail
	update_option( 'thumbnail_size_w', 50, true );
	update_option( 'thumbnail_size_h', 50, true );
	add_image_size( 'sell_media_item', 420, 420, true ); // entry images

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sell_photos' ),
		'top' => __( 'Secondary Menu', 'sell_photos' )
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'image', 'video', 'gallery' ) );

	/**
	 * Remove Admin Bar
	 */
	$current_user = wp_get_current_user();
	if ( is_array( $current_user->roles ) && ! in_array( 'administrator', $current_user->roles ) ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}
}
endif; // sell_photos_setup
add_action( 'after_setup_theme', 'sell_photos_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Sell Photos 1.0
 */
function sell_photos_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'sell_photos' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	// check if sell media plugin is active
	if ( sell_photos_sell_media_check() ) {
		register_sidebar( array(
			'name' => __( 'Sidebar (Sell Media Single Items)', 'sell_photos' ),
			'id' => 'sell-media-sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		) );
	}

	register_sidebar( array(
		'name' => __( 'Homepage Top', 'sell_photos' ),
		'id' => 'homepage-top',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Homepage Bottom', 'sell_photos' ),
		'id' => 'homepage-bottom',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	$widgets = array( '1', '2', '3' );
	foreach ( $widgets as $i ) {
		register_sidebar(array(
			'name' => __( 'Footer Widget ', 'sell_photos' ) .$i,
			'id' => 'footer-widget-'.$i,
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		) );
	} // end foreach
}
add_action( 'widgets_init', 'sell_photos_widgets_init' );


/**
 * Count the number of footer widgets to enable dynamic classes for the footer
 *
 * @since Sell Photos 1.0
 */
function sell_photos_footer_widget_class() {
    $count = 0;

    if ( is_active_sidebar( 'footer-widget-1' ) )
        $count++;

    if ( is_active_sidebar( 'footer-widget-2' ) )
        $count++;

    if ( is_active_sidebar( 'footer-widget-3' ) )
        $count++;

    $class = '';

    switch ( $count ) {
        case '1':
            $class = 'one';
            break;
        case '2':
            $class = 'two';
            break;
        case '3':
            $class = 'three';
            break;
    }

    if ( $class )
        echo 'class="' . $class . '"';
}

/**
 * Enqueue scripts and styles
 */
function sell_photos_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() , '', '1.0.1' );
	wp_enqueue_style( 'sell_photos-flexslider', get_template_directory_uri() . '/js/flexslider/flexslider.css' );

	wp_enqueue_script( 'sell_photos-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'sell_photos-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1.0.1', true );

	wp_enqueue_script( 'jcookie' );

	wp_enqueue_script( 'sell_photos-sharrre', get_template_directory_uri() . '/js/jquery.sharrre-1.3.4.min.js', array( 'jquery' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'sell_photos-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	// AJAX url variable
	wp_localize_script( 'sell_photos-scripts', 'sellphotos',
		array(
			'ajaxurl'=>admin_url('admin-ajax.php'),
			'ajaxnonce' => wp_create_nonce('ajax-nonce')
			)
		);

	wp_enqueue_script( 'sell_photos-flexslider', get_template_directory_uri() .'/js/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '1.0' );
	wp_enqueue_script( 'sell_photos-flexslider-custom', get_template_directory_uri() .'/js/flexslider/flex_js.js', array( 'jquery' ), '1.0' );

}
add_action( 'wp_enqueue_scripts', 'sell_photos_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Implement Like feature
 */
require_once( get_template_directory() . '/inc/likes.php' );

/**
 * Implement Lightbox feature
 */
require_once( get_template_directory() . '/inc/lightbox.php' );

/**
 * Register Widgets
 */
require_once ( get_template_directory() . '/inc/widgets/sell-media-author.php'); // author media widget
require_once ( get_template_directory() . '/inc/widgets/sell-media-popular.php'); // popular media widget
require_once ( get_template_directory() . '/inc/widgets/sell-media-share.php'); // share media widget
require_once ( get_template_directory() . '/inc/widgets/sell-media-exif.php'); // exif widget
require_once ( get_template_directory() . '/inc/widgets/sell-media-author-info.php'); // exif widget

/**
 * Theme options
 */
if ( file_exists( get_template_directory() . '/options/options.php' ) )
	require( get_template_directory() . '/options/options.php' );
if ( file_exists( get_template_directory() . '/options/options.php' ) && file_exists( get_template_directory() . '/theme-options.php' ) )
	require( get_template_directory() . '/theme-options.php' );