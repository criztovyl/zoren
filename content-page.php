<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Zoren
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content clear">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'zoren' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>'
			) );
		?>
		<?php edit_post_link( __( 'Edit', 'zoren' ), '<p class="edit-link">', '</p>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->