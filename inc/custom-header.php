<?php
/**
 * Setup the WordPress core custom header feature.
 *
 * @uses zoren_header_style()
 * @uses zoren_admin_header_style()
 * @uses zoren_admin_header_image()
 *
 * @package Zoren
 */
function zoren_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'zoren_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '414048',
		'width'                  => 1180,
		'height'                 => 250,
		'flex-height'            => true,
		'flex-width'             => true,
		'wp-head-callback'       => 'zoren_header_style',
		'admin-head-callback'    => 'zoren_admin_header_style',
		'admin-preview-callback' => 'zoren_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'zoren_custom_header_setup' );

if ( ! function_exists( 'zoren_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see zoren_custom_header_setup().
 */
function zoren_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
		.main-navigation {
			margin-left: 0;
			width: 940px;
		}
		@media only screen and (min-width: 1220px) {
			.main-navigation {
				width: 1180px;
			}
		}
		@media only screen and (min-width: 768px) and (max-width: 959px) {
			.main-navigation {
				width: 700px;
			}
		}
		@media only screen and (max-width: 767px) {
			.main-navigation {
				width: 100%;
			}
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // zoren_header_style

if ( ! function_exists( 'zoren_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see zoren_custom_header_setup().
 */
function zoren_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		.displaying-header-text {
			font-family: "Open sans", sans-serif;
		}
		#headimg h1 {
			width: 280px;
			font-size: 36px;
			line-height: 1.2;
			font-weight: 800;
			margin: 0;
			text-transform: uppercase;
		}
		#headimg h1 a {
			text-decoration: none;
		}
		#desc {
			font-size: 16px;
			line-height: 24px;
			font-weight: normal;
			margin: 5px 0 20px;
			padding-bottom: 20px;
			border-bottom: 10px solid #d0d0d0;
		}
		#desc div {
			width: 280px;
		}
		#headimg img {
			display: block;
			margin: 0 auto;
		}
	</style>
<?php
}
endif; // zoren_admin_header_style

if ( ! function_exists( 'zoren_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see zoren_custom_header_setup().
 */
function zoren_admin_header_image() {
	$style        = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_image = get_header_image();
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><div><?php bloginfo( 'description' ); ?></div></div>
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // zoren_admin_header_image