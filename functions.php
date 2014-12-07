<?php
/**
 * Zoren functions and definitions
 *
 * @package Zoren
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 800; /* pixels */

/**
 * Adjust the content width for Full Width page template.
 */
function zoren_set_content_width() {
	global $content_width;

	if ( is_page_template( 'full-width.php' ) )
		$content_width = 1100;
}
add_action( 'template_redirect', 'zoren_set_content_width' );

/*
 * Load Jetpack compatibility file.
 */
if ( file_exists( get_template_directory() . '/inc/jetpack.php' ) )
	require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'zoren_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function zoren_setup() {

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
	 * If you're building a theme based on zoren, use a find and replace
	 * to change 'zoren' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'zoren', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured-thumbnail', 880, 400, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'zoren' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'audio', 'gallery' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'zoren_custom_background_args', array(
		'default-color' => 'eeeeee',
		'default-image' => get_template_directory_uri() . '/images/body.png',
	) ) );

}
endif; // zoren_setup
add_action( 'after_setup_theme', 'zoren_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function zoren_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'zoren' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'zoren_widgets_init' );

/**
 * Register Google fonts for Zoren
 */
function zoren_fonts() {
	/* translators: If there are characters in your language that are not supported
	   by Bitter, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Bitter font: on or off', 'zoren' ) ) {

		$protocol = is_ssl() ? 'https' : 'http';

		wp_register_style( 'zoren-bitter', "$protocol://fonts.googleapis.com/css?family=Bitter:400,700,400italic", array(), null );
	}

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'zoren' ) ) {

		$protocol = is_ssl() ? 'https' : 'http';

		wp_register_style( 'zoren-open-sans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800", array(), null );
	}
}
add_action( 'init', 'zoren_fonts' );

/**
 * Enqueue scripts and styles
 */
function zoren_scripts() {
	wp_enqueue_style( 'zoren-style', get_stylesheet_uri() );

	wp_enqueue_style( 'zoren-bitter' );

	wp_enqueue_style( 'zoren-open-sans' );

	wp_enqueue_script( 'zoren-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'zoren-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'zoren-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	wp_enqueue_script( 'zoren', get_template_directory_uri() . '/js/zoren.js', array( 'jquery' ), '20130319', true );
}
add_action( 'wp_enqueue_scripts', 'zoren_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 */
function zoren_admin_fonts( $hook_suffix ) {
	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'zoren-open-sans' );

}
add_action( 'admin_enqueue_scripts', 'zoren_admin_fonts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

// updater for WordPress.com themes
if ( is_admin() )
	include dirname( __FILE__ ) . '/inc/updater.php';
