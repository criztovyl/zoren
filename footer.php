<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Zoren
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'zoren_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'zoren' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'zoren' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<a href="http://www.fabthemes.com/" rel="designer"><?php printf( __( 'Theme: %1$s by %2$s.', 'zoren' ), 'Zoren', 'FabThemes' ); ?></a><br>
			<a href="/blog/changelog">Some modifications by me, see Changelog</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
