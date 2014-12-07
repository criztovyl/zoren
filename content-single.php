<?php
/**
 * @package Zoren
 */

$format = get_post_format();
$formats = get_theme_support( 'post-formats' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( 'post' == get_post_type() ) : ?>
	<div class="entry-meta clear">

		<?php if ( $format && in_array( $format, $formats[0] ) ): ?>
			<a class="entry-format-badge genericon genericon-<?php echo $format; ?>" href="<?php echo esc_url( get_post_format_link( $format ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'All %s posts', 'zoren' ), get_post_format_string( $format ) ) ); ?>"><span class="screen-reader-text"><?php echo get_post_format_string( $format ); ?></span></a>
		<?php else: ?>
			<span class="entry-format-badge genericon genericon-standard"><span class="screen-reader-text"><?php _e( 'Standard', 'zoren' ); ?></span></span>
		<?php endif; ?>

		<div class="author-meta ">
			<p><?php _e( 'Posted by', 'zoren' ); ?></p>
			<span><?php the_author_posts_link(); ?></span>
		</div>
		<div class="clock-meta">
			<p><?php _e( 'Posted on', 'zoren' ); ?></p>
			<span><a href="<?php echo get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ); ?>" rel="bookmark" title="<?php the_time(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
		</div>
		<div class="category-meta">
			<p><?php _e( 'Posted under', 'zoren' ); ?></p>
			<span> <?php the_category(', '); ?></span>
		</div>
		<div class="discussion-meta">
			<p><?php _e( 'Comments', 'zoren' ); ?></p>
			<span><?php comments_popup_link( __('Leave a Comment', 'zoren'), __('1 Comment', 'zoren'), __('% Comments', 'zoren') ); ?></span>
		</div>
	</div><!-- .entry-meta -->
	<?php endif; ?>

	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

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
		<?php
		if( get_the_tag_list() )
			echo get_the_tag_list( '<div class="taglist"><ul class="clear"><li>','</li><li>','</li></ul></div' );
		?>
		<?php edit_post_link( __( 'Edit', 'zoren' ), '<p class="edit-link">', '</p>' ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->