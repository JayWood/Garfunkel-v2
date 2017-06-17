<?php
/*
 * Template Name: Portfolio Template
 */

get_header();
?>
	<div class="wrapper">

		<div class="wrapper-inner section-inner thin">

			<div class="content">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

					<?php if ( has_post_thumbnail() ) : ?>

						<div class="featured-media">

							<?php the_post_thumbnail( 'post-image' ); ?>

							<?php if ( ! empty( get_post( get_post_thumbnail_id() )->post_excerpt ) ) : ?>

								<div class="media-caption-container">

									<p class="media-caption"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt; ?></p>

								</div>

							<?php endif; ?>

						</div> <!-- /featured-media -->

					<?php endif; ?>

					<div class="post-inner">

						<div class="post-header">

							<p class="post-date"><?php the_time( get_option( 'date_format' ) ); ?><?php edit_post_link( __( 'Edit', 'garfunkel' ), '<span class="sep">/</span>' ); ?></p>

							<h1 class="post-title"><?php the_title(); ?></h1>

						</div> <!-- /post-header -->

						<div class="post-content">

							<?php
							if ( in_array( $format, array( 'link', 'quote', 'video' ) ) ) {
								/** @var array $content_parts */
								echo apply_filters( 'the_content', $content_parts['extended'] );
							} else {
								the_content();
							}

							wp_link_pages();
							?>

							<div class="clear"></div>

						</div> <!-- /post-content -->

					</div> <!-- /post-inner -->

				</div> <!-- /post -->

			<?php endwhile; else : ?>

				<p><?php _e( "We couldn't find any posts that matched your query. Please try again.", 'garfunkel' ); ?></p>

			<?php endif; ?>

			<?php get_sidebar(); ?>

			</div> <!-- /content -->

			<div class="clear"></div>

		</div> <!-- /wrapper-inner -->

	</div> <!-- /wrapper -->

<?php get_footer();
