<?php if ( has_post_thumbnail() ) : ?>
<div class="featured-media">
	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
		<?php
		the_post_thumbnail( 'post-image' );
		$thumb_excerpt = get_post( get_post_thumbnail_id() )->post_excerpt;
		?>
		<?php if ( $thumb_excerpt ) : ?>
			<div class="media-caption-container">
				<p class="media-caption"><?php echo esc_html( $thumb_excerpt ); ?></p>
			</div>
		<?php endif; ?>
	</a>
</div> <!-- /featured-media -->
<?php endif; ?>