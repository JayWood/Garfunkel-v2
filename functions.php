<?php

// Add theme widgets
require_once 'includes/class-garfunkel-walker.php';
require_once get_template_directory() . '/widgets/dribbble-widget.php';
require_once get_template_directory() . '/widgets/flickr-widget.php';
require_once get_template_directory() . '/widgets/recent-comments.php';
require_once get_template_directory() . '/widgets/recent-posts.php';
require_once get_template_directory() . '/widgets/video-widget.php';
require_once get_template_directory() . '/widgets/search-form.php';
require_once 'includes/class-garfunkel-customize.php';

// Custom CPTs
require_once 'includes/class-cpt-portfolio.php';

// Theme setup
add_action( 'after_setup_theme', 'garfunkel_setup' );

function garfunkel_setup() {

	// Automatic feed
	add_theme_support( 'automatic-feed-links' );

	// Post thumbnails
	add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	add_image_size( 'post-image', 1140, 9999 );
	add_image_size( 'post-thumbnail', 552, 9999 );

	// Post formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'link', 'quote', 'video' ) );

	// Custom header
	$args = array(
		'width'         => 1440,
		'height'        => 960,
		'default-image' => get_template_directory_uri() . '/images/bg.jpg',
		'uploads'       => true,
		'header-text'   => false,

	);
	add_theme_support( 'custom-header', $args );

	// Jetpack infinite scroll
	add_theme_support( 'infinite-scroll', array(
		'type'      => 'scroll',
		'container' => 'posts',
		'footer'    => false,
	) );

	// Add support for title tag
	add_theme_support( 'title-tag' );

	// Add nav menu
	register_nav_menu( 'primary', __( 'Primary Menu', 'garfunkel' ) );
	register_nav_menu( 'social', __( 'Social Menu', 'garfunkel' ) );

	// Make the theme translation ready
	load_theme_textdomain( 'garfunkel', get_template_directory() . '/languages' );

	$locale      = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) ) {
		require_once( $locale_file );
	}

}

/**
 * Registers styles and scripts.
 *
 * @return void
 *
 * @author JayWood
 * @since  NEXT
 */
function garfunkel_register_scripts() {
	wp_register_script( 'garfunkel_imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.js', array( 'jquery' ), '', true );
	wp_register_script( 'garfunkel_flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'garfunkel_global', get_template_directory_uri() . '/js/global.js', array( 'jquery' ), '', true );

	wp_register_style( 'garfunkel_googleFonts', '//fonts.googleapis.com/css?family=Fira+Sans:400,500,700,400italic,700italic|Playfair+Display:400,900|Crimson+Text:700,400italic,700italic,400' );
	wp_register_style( 'garfunkel_genericons', get_template_directory_uri() . '/genericons/genericons.css' );
	wp_register_style( 'garfunkel_style', get_stylesheet_uri() );
}

add_action( 'init', 'garfunkel_register_scripts' );

/**
 * Loads styles and scripts.
 *
 * @return void
 *
 * @author JayWood
 * @since  NEXT
 */
function garfunkel_load_scripts() {

	if ( is_admin() ) {
		return;
	}

	wp_enqueue_script( 'garfunkel_imagesloaded' );
	wp_enqueue_script( 'masonry' );
	wp_enqueue_script( 'garfunkel_flexslider' );
	wp_enqueue_script( 'garfunkel_global' );

	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load styles now.
	wp_enqueue_style( 'garfunkel_googleFonts' );
	wp_enqueue_style( 'garfunkel_genericons' );
	wp_enqueue_style( 'garfunkel_style' );
}

add_action( 'wp_enqueue_scripts', 'garfunkel_load_scripts' );


// Add editor styles
function garfunkel_add_editor_styles() {
	add_editor_style( 'garfunkel-editor-style.css' );
	$font_url = '//fonts.googleapis.com/css?family=Roboto+Slab:400,700|Roboto:400,400italic,700,700italic,300';
	add_editor_style( str_replace( ',', '%2C', $font_url ) );
}

add_action( 'init', 'garfunkel_add_editor_styles' );


// Add footer widget areas
add_action( 'widgets_init', 'garfunkel_sidebar_reg' );

function garfunkel_sidebar_reg() {
	register_sidebar( array(
		'name'          => __( 'Footer A', 'garfunkel' ),
		'id'            => 'footer-a',
		'description'   => __( 'Widgets in this area will be shown in the left column in the footer of single posts and pages.', 'garfunkel' ),
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div><div class="clear"></div></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer B', 'garfunkel' ),
		'id'            => 'footer-b',
		'description'   => __( 'Widgets in this area will be shown in the middle column in the footer  of single posts and pages.', 'garfunkel' ),
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div><div class="clear"></div></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer C', 'garfunkel' ),
		'id'            => 'footer-c',
		'description'   => __( 'Widgets in this area will be shown in the right column in the footer  of single posts and pages.', 'garfunkel' ),
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div><div class="clear"></div></div>',
	) );
}

// Delist the WordPress widgets replaced by custom theme widgets
function garfunkel_unregister_default_widgets() {
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Search' );
}

add_action( 'widgets_init', 'garfunkel_unregister_default_widgets', 11 );


// Set content-width
if ( ! isset( $content_width ) ) {
	$content_width = 700;
}


// Check whether the browser supports javascript
function garfunkel_html_js_class() {
	echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>' . "\n";
}

add_action( 'wp_head', 'garfunkel_html_js_class', 1 );


// Add classes to next_posts_link and previous_posts_link
add_filter( 'next_posts_link_attributes', 'garfunkel_posts_link_attributes_1' );
add_filter( 'previous_posts_link_attributes', 'garfunkel_posts_link_attributes_2' );

function garfunkel_posts_link_attributes_1() {
	return 'class="post-nav-older fleft"';
}

function garfunkel_posts_link_attributes_2() {
	return 'class="post-nav-newer fright"';
}

// Add class to body if the post/page has a featured image
add_action( 'body_class', 'garfunkel_if_featured_image_class' );

function garfunkel_if_featured_image_class( $classes ) {
	global $post;
	if ( isset( $post ) && has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	} else {
		$classes[] = 'no-featured-image';
	}

	return $classes;
}

// Add class to body if on the first page of the home page
add_action( 'body_class', 'garfunkel_if_first_page_home_page' );

function garfunkel_if_first_page_home_page( $classes ) {

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	if ( is_home() && ( 1 == $paged ) ) {
		$classes[] = 'home_first_page';
	}

	return $classes;
}


// Add class to body if it's viewed on mobile
add_action( 'body_class', 'garfunkel_if_is_mobile' );

function garfunkel_if_is_mobile( $classes ) {
	if ( wp_is_mobile() ) {
		$classes[] = 'is_mobile';
	}

	return $classes;
}


// Add class to body if it's a single page
add_action( 'body_class', 'garfunkel_if_page_class' );

function garfunkel_if_page_class( $classes ) {
	if ( is_page() || is_404() || is_attachment() ) {
		$classes[] = 'single-post';
	}

	return $classes;
}


// Change the length of excerpts
function garfunkel_custom_excerpt_length() {
	return 20;
}

add_filter( 'excerpt_length', 'garfunkel_custom_excerpt_length', 999 );


// Add ellipsis to end of excerpt
function garfunkel_new_excerpt() {
	return ' &hellip;';
}

add_filter( 'excerpt_more', 'garfunkel_new_excerpt' );


// Add class to excerpts
add_filter( 'the_excerpt', 'garfunkel_add_class_to_excerpt' );
function garfunkel_add_class_to_excerpt( $excerpt ) {
	return str_replace( '<p', '<p class="post-excerpt"', $excerpt );
}


// Get comment excerpt length
function garfunkel_get_comment_excerpt( $comment_id = 0, $num_words = 20 ) {
	$comment      = get_comment( $comment_id );
	$comment_text = strip_tags( $comment->comment_content );
	$blah         = explode( ' ', $comment_text );
	if ( count( $blah ) > $num_words ) {
		$k             = $num_words;
		$use_dotdotdot = 1;
	} else {
		$k             = count( $blah );
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for ( $i = 0; $i < $k; $i ++ ) {
		$excerpt .= $blah[ $i ] . ' ';
	}
	$excerpt .= ( $use_dotdotdot ) ? '...' : '';

	return apply_filters( 'get_comment_excerpt', $excerpt );
}


// Style the admin area
function garfunkel_custom_colors() {
	?>
	<style type="text/css">
		#postimagediv #set-post-thumbnail img {max-width: 100%;height: auto;}
	</style>';
	<?php
}

add_action( 'admin_head', 'garfunkel_custom_colors' );

// Garfunkel meta function
function garfunkel_meta() {
	?>
	<div class="post-meta">
		<a class="post-meta-date" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<div class="genericon genericon-time"></div>
			<?php the_time( get_option( 'date_format' ) ); ?>
		</a>
		<?php if ( comments_open() ) : ?>
			<a class="post-meta-comments" href="<?php the_permalink(); ?>#comments" title="<?php comments_number( '0', '1', '%' ); ?> <?php _e( 'comments to', 'garfunkel' ); ?> <?php the_title_attribute(); ?>">
				<div class="genericon genericon-comment"></div>
				<?php comments_number( '0', '1', '%' ); ?>
			</a>
		<?php endif; ?>
		<div class="clear"></div>
	</div> <!-- /post-meta -->
	<?php
}


// Flexslider function for format-gallery
function garfunkel_flexslider( $size = 'thumbnail' ) {
	global $post;

	if ( is_page() ) {
		$attachment_parent = $post->ID;
	} else {
		$attachment_parent = get_the_ID();
	}

	$images = get_posts( array(
		'post_parent'    => $attachment_parent,
		'post_type'      => 'attachment',
		'numberposts'    => - 1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );

	if ( ! $images ) {
		return;
	}

	?>
	<div class="flexslider">
		<ul class="slides">
			<?php foreach ( $images as $image ) {
				$attimg = wp_get_attachment_image( $image->ID, $size ); ?>
				<li>
					<?php echo $attimg; ?>
					<?php if ( ! empty( $image->post_excerpt ) && is_single() ) : ?>
						<div class="media-caption-container">
							<p class="media-caption"><?php echo $image->post_excerpt ?></p>
						</div>
					<?php endif; ?>
				</li>
			<?php }; ?>
		</ul>
	</div>
	<?php
}


// Garfunkel comment function
if ( ! function_exists( 'garfunkel_comment' ) ) :
	function garfunkel_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>

				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

					<?php __( 'Pingback:', 'garfunkel' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'garfunkel' ), '<span class="edit-link">', '</span>' ); ?>

				</li>
				<?php
				break;
			default :
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

				<div id="comment-<?php comment_ID(); ?>" class="comment">

					<?php echo get_avatar( $comment, 80 ); ?>

					<div class="comment-inner">

						<div class="comment-header">

							<h4><?php comment_author_link(); ?></h4>

							<p>
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo get_comment_date() . '<span> &mdash; ' . get_comment_time() . '</span>'; ?></a>
							</p>

						</div> <!-- /comment-header -->

						<div class="comment-content post-content">

							<?php comment_text(); ?>

							<?php if ( '0' == $comment->comment_approved ) : ?>

								<p class="comment-awaiting-moderation"><?php _e( 'Awaiting moderation', 'garfunkel' ); ?></p>

							<?php endif; ?>

						</div><!-- /comment-content -->

						<div class="comment-actions">

							<?php edit_comment_link( __( 'Edit', 'garfunkel' ), '', '' ); ?>

							<?php comment_reply_link( array_merge( $args, array(
								'reply_text' => __( 'Reply', 'garfunkel' ),
								'depth'      => $depth,
								'max_depth'  => $args['max_depth'],
							) ) ); ?>

							<div class="clear"></div>

						</div> <!-- /comment-actions -->

					</div> <!-- /comment-inner -->

				</div><!-- /comment-## -->
				<?php
				break;
		endswitch;
	}
endif;
