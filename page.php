<?php get_header(); ?>

	<div class="wrapper">

		<div class="wrapper-inner section-inner thin">

			<div class="content">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="post">
						<?php get_template_part( 'template-parts/featured-thumbnail', get_post_format() ); ?>

						<div class="post-inner">
							<div class="post-header">
								<h2 class="post-title"><?php the_title(); ?></h2>
							</div> <!-- /post-header -->

							<div class="post-content">
								<?php the_content(); ?>
								<?php edit_post_link( __( 'Edit', 'garfunkel' ) . ' &rarr;', '<div class="clear"></div>' ); ?>
							</div> <!-- /post-content -->

							<div class="clear"></div>
						</div> <!-- /post-inner -->

						<?php if ( comments_open() ) : ?>
							<div class="comments-page-container">
								<div class="comments-page-container-inner">
									<?php comments_template( '', true ); ?>
								</div> <!-- /comments-page-container-inner -->
							</div> <!-- /comments-page-container -->
						<?php endif; ?>

						<?php get_sidebar(); ?>
					</div> <!-- /post -->

				<?php endwhile; else: ?>

					<p><?php _e( "We couldn't find any posts that matched your query. Please try again.", "garfunkel" ); ?></p>
				<?php endif; ?>
				<div class="clear"></div>

			</div> <!-- /content -->

		</div> <!-- /section-inner -->

	</div> <!-- /wrapper -->
<?php get_footer();
