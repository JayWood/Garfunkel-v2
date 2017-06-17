<?php

require_once 'CPT_Core/CPT_Core.php';


class Garfunkel_CPT_Portfolio extends CPT_Core {

	public static $class = null;

	public static function init() {
		if ( null === self::$class ) {
			self::$class = new self();
		}

		return self::$class;
	}

	public function __construct() {

		error_log( print_r( get_theme_support( 'post-thumbnails' ), 1 ) );

		parent::__construct( array(
			__( 'Portfolio Item', 'garfunkel' ),
			__( 'Portfolio Items', 'garfunkel' ),
			'portfolio',
		), array(
			'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail' ),
		) );

		add_action( 'admin_head', array( $this, 'admin_styles' ) );
	}

	public function admin_styles() {
		?>
		<style type="text/css">
			.garfunkel-thumbnail img{ border: 4px solid #ccc }
			th.column-garfunkel-thumbnail { width: 130px; }
		</style>
		<?php
	}

	public function columns( $columns ) {
		$out = [];
		foreach( $columns as $k => $column ) {
			$out[ $k ] = $column;

			if ( 'cb' == $k ) {
				$out['garfunkel-thumbnail'] = __( 'Screenshot', 'garfunkel' );
			}
		}

		return $out;
	}

	public function columns_display( $col, $post_id ) {
		if ( 'garfunkel-thumbnail' == $col ) {
			?>
			<div>
				<?php the_post_thumbnail( array( 128, 9999) ); ?>
			</div>
			<?php
		}
	}
}

// Garfunkel_CPT_Portfolio::init();
add_action( 'after_setup_theme', array( 'Garfunkel_CPT_Portfolio', 'init' ), 9 );