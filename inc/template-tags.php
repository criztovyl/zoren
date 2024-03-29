<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Zoren
 */

if ( ! function_exists( 'zoren_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function zoren_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?> clear">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'zoren' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php next_post_link( '<div class="next">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Next post link', 'zoren' ) . '</span> %title' ); ?>
		<?php previous_post_link( '<div class="previous">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Previous post link', 'zoren' ) . '</span>'  ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>


		<?php if ( get_previous_posts_link() ) : ?>
    	<div class="next"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Newer Posts', 'zoren' ) ); ?></div>
		<?php endif; ?>

        <?php if ( get_next_posts_link() ) : ?>
		<div class="previous"><?php next_posts_link( __( 'Older Posts <span class="meta-nav">&rarr;</span>', 'zoren' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // zoren_content_nav

if ( ! function_exists( 'zoren_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function zoren_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<?php _e( 'Pingback:', 'zoren' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'zoren' ), ' | <span class="edit-link">', '<span>' ); ?>
	<?php
			break;
		default :
	?>
	<li <?php comment_class( 'clear' ); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'zoren' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'zoren' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'zoren' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'zoren' ), '<span class="edit-link">', '<span>' ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>
			<?php
			comment_reply_link( array_merge( $args, array(
				'depth'		=> $depth,
				'max_depth'	=> $args['max_depth'],
				'before'	=> '<div class="reply">',
				'after'		=> '</div>',
			) ) );
			?>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for zoren_comment()

/**
 * Returns true if a blog has more than 1 category
 */
function zoren_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so zoren_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so zoren_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in zoren_categorized_blog
 */
function zoren_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'zoren_category_transient_flusher' );
add_action( 'save_post', 'zoren_category_transient_flusher' );
