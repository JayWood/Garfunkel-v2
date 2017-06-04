<?php

// Garfunkel theme options
class Garfunkel_Customize {

	/**
	 * Registers the cusgomizer options.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 *
	 * @author JayWood
	 * @since  NEXT
	 */
	public static function register( $wp_customize ) {

		//1. Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'garfunkel_options',
			array(
				'title'       => __( 'Garfunkel Options', 'garfunkel' ),
				//Visible title of section
				'priority'    => 35,
				//Determines what order this appears in
				'capability'  => 'edit_theme_options',
				//Capability needed to tweak
				'description' => __( 'Allows you to customize settings for Garfunkel.', 'garfunkel' ),
				//Descriptive tooltip
			)
		);

		$wp_customize->add_section( 'garfunkel_logo_section', array(
			'title'       => __( 'Logo', 'garfunkel' ),
			'priority'    => 40,
			'description' => 'Upload a logo to replace the default site name and description in the header',
		) );

		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'accent_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			array(
				'default'           => '#ca2017',
				//Default setting/value to save
				'type'              => 'theme_mod',
				//Is this an 'option' or a 'theme_mod'?
				'capability'        => 'edit_theme_options',
				//Optional. Special permissions for accessing this setting.
				'transport'         => 'postMessage',
				//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		// Add logo setting and sanitize it
		$wp_customize->add_setting( 'garfunkel_logo',
			array(
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
			$wp_customize, //Pass the $wp_customize object (required)
			'garfunkel_accent_color', //Set a unique ID for the control
			array(
				'label'    => __( 'Accent Color', 'garfunkel' ),
				//Admin-visible name of the control
				'section'  => 'colors',
				//ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'accent_color',
				//Which setting to load and manipulate (serialized is okay)
				'priority' => 10,
				//Determines the order this control appears in for the specified section
			)
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'garfunkel_logo', array(
			'label'    => __( 'Logo', 'garfunkel' ),
			'section'  => 'garfunkel_logo_section',
			'settings' => 'garfunkel_logo',
		) ) );

		//4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}

	public static function header_output() {
		?>

		<!--Customizer CSS-->

		<style type="text/css">
			<?php
			self::generate_css( 'body a', 'color', 'accent_color' );
			self::generate_css( 'body a:hover', 'color', 'accent_color' );
			self::generate_css( '.blog-title a:hover', 'color', 'accent_color' );
			self::generate_css( '.menu-social a:hover', 'background-color', 'accent_color' );
			self::generate_css( '.sticky.post .is-sticky', 'background-color', 'accent_color' );
			self::generate_css( '.sticky.post .is-sticky:before', 'border-top-color', 'accent_color' );
			self::generate_css( '.sticky.post .is-sticky:before', 'border-left-color', 'accent_color' );
			self::generate_css( '.sticky.post .is-sticky:after', 'border-top-color', 'accent_color' );
			self::generate_css( '.sticky.post .is-sticky:after', 'border-right-color', 'accent_color' );
			self::generate_css( '.post-title a:hover', 'color', 'accent_color' );
			self::generate_css( '.post-quote', 'background', 'accent_color' );
			self::generate_css( '.post-link', 'background', 'accent_color' );
			self::generate_css( '.post-content a', 'color', 'accent_color' );
			self::generate_css( '.post-content a:hover', 'color', 'accent_color' );
			self::generate_css( '.post-content fieldset legend', 'background', 'accent_color' );
			self::generate_css( '.post-content input[type="button"]:hover', 'background', 'accent_color' );
			self::generate_css( '.post-content input[type="reset"]:hover', 'background', 'accent_color' );
			self::generate_css( '.post-content input[type="submit"]:hover', 'background', 'accent_color' );
			self::generate_css( '.post-nav-fixed a:hover', 'background', 'accent_color' );
			self::generate_css( '.tab-post-meta .post-nav a:hover h4', 'color', 'accent_color' );
			self::generate_css( '.post-info-items a:hover', 'color', 'accent_color' );
			self::generate_css( '.page-links a', 'color', 'accent_color' );
			self::generate_css( '.page-links a:hover', 'background', 'accent_color' );
			self::generate_css( '.author-name a:hover', 'color', 'accent_color' );
			self::generate_css( '.content-by', 'color', 'accent_color' );
			self::generate_css( '.author-content a:hover .title', 'color', 'accent_color' );
			self::generate_css( '.author-content a:hover .post-icon', 'background', 'accent_color' );
			self::generate_css( '.comment-notes a', 'color', 'accent_color' );
			self::generate_css( '.comment-notes a:hover', 'color', 'accent_color' );
			self::generate_css( '.content #respond input[type="submit"]', 'background-color', 'accent_color' );
			self::generate_css( '.comment-header h4 a', 'color', 'accent_color' );
			self::generate_css( '.bypostauthor > .comment:before', 'background', 'accent_color' );
			self::generate_css( '.comment-actions a:hover', 'color', 'accent_color' );
			self::generate_css( '#cancel-comment-reply-link', 'color', 'accent_color' );
			self::generate_css( '#cancel-comment-reply-link:hover', 'color', 'accent_color' );
			self::generate_css( '.comments-nav a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget-title a', 'color', 'accent_color' );
			self::generate_css( '.widget-title a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_text a', 'color', 'accent_color' );
			self::generate_css( '.widget_text a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_rss li a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_archive li a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_meta li a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_pages li a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_links li a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_categories li a:hover', 'color', 'accent_color' );
			self::generate_css( '.widget_rss .widget-content ul a.rsswidget:hover', 'color', 'accent_color' );
			self::generate_css( '#wp-calendar a', 'color', 'accent_color' );
			self::generate_css( '#wp-calendar a:hover', 'color', 'accent_color' );
			self::generate_css( '#wp-calendar thead', 'color', 'accent_color' );
			self::generate_css( '#wp-calendar tfoot a:hover', 'color', 'accent_color' );
			self::generate_css( '.tagcloud a:hover', 'background', 'accent_color' );
			self::generate_css( '.widget_garfunkel_recent_posts a:hover .title', 'color', 'accent_color' );
			self::generate_css( '.widget_garfunkel_recent_posts a:hover .post-icon', 'background', 'accent_color' );
			self::generate_css( '.widget_garfunkel_recent_comments a:hover .title', 'color', 'accent_color' );
			self::generate_css( '.widget_garfunkel_recent_comments a:hover .post-icon', 'background', 'accent_color' );
			self::generate_css( '.mobile-menu a:hover', 'background', 'accent_color' );
			self::generate_css( '.mobile-menu-container .menu-social a:hover', 'background', 'accent_color' );
			self::generate_css( 'body#tinymce.wp-editor a', 'color', 'accent_color' );
			self::generate_css( 'body#tinymce.wp-editor fieldset legend', 'background', 'accent_color' );
			self::generate_css( 'body#tinymce.wp-editor input[type="submit"]:hover', 'background', 'accent_color' );
			self::generate_css( 'body#tinymce.wp-editor input[type="reset"]:hover', 'background', 'accent_color' );
			self::generate_css( 'body#tinymce.wp-editor input[type="button"]:hover', 'background', 'accent_color' );
			?>
		</style>

		<!--/Customizer CSS-->

		<?php
	}

	public static function live_preview() {
		wp_enqueue_script(
			'garfunkel-themecustomizer', // Give the script a unique ID
			get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
			array( 'jquery', 'customize-preview' ), // Define dependencies
			'', // Define a version (optional)
			true // Specify whether to put in footer (leave this true)
		);
	}

	public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
		$return = '';
		$mod    = get_theme_mod( $mod_name );
		if ( ! empty( $mod ) ) {
			$return = sprintf( '%s { %s:%s; }',
				$selector,
				$style,
				$prefix . $mod . $postfix
			);
			if ( $echo ) {
				echo $return;
			}
		}

		return $return;
	}
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register', array( 'Garfunkel_Customize', 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head', array( 'Garfunkel_Customize', 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', array( 'Garfunkel_Customize', 'live_preview' ) );
