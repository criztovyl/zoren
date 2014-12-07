<?php
/**
 * The template for displaying image attachments.
 *
 * @package Zoren
 */

get_header();
?>

	<div id="primary" class="content-area image-attachment format-image">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="entry-meta clear">
					<span class="entry-format-badge genericon genericon-image"><span class="screen-reader-text"><?php _e( 'Image', 'zoren' ); ?></span></span>
					<div class="author-meta">
						<p><?php _e( 'Posted by', 'zoren' ); ?></p>
						<span><?php the_author_posts_link(); ?></span>
					</div>
					<div class="clock-meta">
						<p><?php _e( 'Posted on', 'zoren' ); ?></p>
						<?php if ( ! is_single() ) { ?>
						<span><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_time(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
						<?php } else { ?>
						<span><?php the_time( get_option( 'date_format' ) ); ?></span>
						<?php } ?>
					</div>
					<div class="category-meta">
						<p><?php _e( 'Posted in', 'zoren' ); ?></p>
						<span><a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" title="Return to <?php echo esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ); ?>" rel="gallery"><?php echo get_the_title( $post->post_parent ); ?></a></span>
					</div>
					<div class="discussion-meta">
						<p><?php _e( 'Comments', 'zoren' ); ?></p>
						<span><?php comments_popup_link( __('Leave a Comment', 'zoren'), __('1 Comment', 'zoren'), __('% Comments', 'zoren') ); ?></span>
					</div>
				</div><!-- .entry-meta -->

				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

				<div class="entry-content">

					<div class="entry-attachment">
						<div class="attachment">
							<?php
								/**
								 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
								 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
								 */
								$attachments = array_values( get_children( array(
									'post_parent'    => $post->post_parent,
									'post_status'    => 'inherit',
									'post_type'      => 'attachment',
									'post_mime_type' => 'image',
									'order'          => 'ASC',
									'orderby'        => 'menu_order ID'
								) ) );
								foreach ( $attachments as $k => $attachment ) {
									if ( $attachment->ID == $post->ID )
										break;
								}
								$k++;
								// If there is more than 1 attachment in a gallery
								if ( count( $attachments ) > 1 ) {
									if ( isset( $attachments[ $k ] ) )
										// get the URL of the next image attachment
										$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
									else
										// or get the URL of the first image attachment
										$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
								} else {
									// or, if there's only 1 image, get the URL of the image
									$next_attachment_url = wp_get_attachment_url();
								}
							?>

							<a href="<?php echo $next_attachment_url; ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'zoren_attachment_size', array( 1200, 1200 ) ); // Filterable image size.
								echo wp_get_attachment_image( $post->ID, $attachment_size );
							?></a>
						</div><!-- .attachment -->

						<?php if ( ! empty( $post->post_excerpt ) ) : ?>
						<div class="wp-caption-text">
							<?php the_excerpt(); ?>
						</div><!-- .entry-caption -->
						<?php endif; ?>
					</div><!-- .entry-attachment -->

					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'zoren' ), 'after' => '</div>' ) ); ?>

					<p><?php $metadata = wp_get_attachment_metadata(); printf( __( 'Size: <a href="%1$s" title="Link to full-size image">%2$s &times; %3$s</a>', 'zoren' ), wp_get_attachment_url(), $metadata['width'], $metadata['height'] ); ?></p>

					<?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open ?>
						<p><?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'zoren' ), get_trackback_url() ); ?></p>
					<?php elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open ?>
						<p><?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'zoren' ), get_trackback_url() ); ?></p>
					<?php elseif ( comments_open() && ! pings_open() ) : // Only comments open ?>
						<p><?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'zoren' ); ?></p>
					<?php elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed ?>
						<p><?php _e( 'Both comments and trackbacks are currently closed.', 'zoren' ); ?></p>
					<?php endif; ?>
					<?php edit_post_link( __( 'Edit', 'zoren' ), '<p class="edit-link">', '</p>' ); ?>

				</div><!-- .entry-content -->

			</article><!-- #post-<?php the_ID(); ?> -->

			<nav role="navigation" id="image-navigation" class="navigation-image">
				<div class="previous"><?php previous_image_link( false, __( '<span class="meta-nav">&larr;</span> Previous', 'zoren' ) ); ?></div>
				<div class="next"><?php next_image_link( false, __( 'Next <span class="meta-nav">&rarr;</span>', 'zoren' ) ); ?></div>
			</nav><!-- #image-navigation -->

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>