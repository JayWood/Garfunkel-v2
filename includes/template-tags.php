<?php

/**
 * Display company name of a post.
 *
 * @param int $post_id The post id.
 *
 * @return void
 *
 * @author JayWood
 * @since  NEXT
 */
function garfunkel_do_company_name( $post_id = 0 ) {
	$name = Garfunkel_CPT_Portfolio::get_company_name( $post_id );
	if ( empty( $name ) ) {
		if ( 'portfolio' == get_post_type() ) {
			$name = get_the_title( $post_id );
		} else {
			return;
		}
	}
	?>
	<span class="project-name">
		<?php echo $name; ?>
	</span>
	<?php
}