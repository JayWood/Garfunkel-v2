<?php

if ( ! class_exists( 'CPT_Core' ) ) {
	require_once 'CPT_Core/CPT_Core.php';
}

class Garfunkel_CPT_Portfolio extends CPT_Core {

	public static $class = null;

	public static function init() {
		if ( null === self::$class ) {
			self::$class = new self();
		}

		return self::$class;
	}

	public function __construct() {

		parent::__construct( array(
			__( 'Portfolio Item', 'garfunkel' ),
			__( 'Portfolio Items', 'garfunkel' ),
			'portfolio',
		), array(
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		) );
	}

	public function columns( $columns ) {
		$out = [];
		foreach( $columns as $k => $column ) {
			$out[ $k ] = $column;

			if ( 'cb' == $k ) {
				$out['thumbnail'] = __( 'Screenshot', 'garfunkel' );
			}
		}

		return $out;
	}

	public function columns_display( $col, $post_id ) {
		if ( 'thumbnail' == $col ) {
			the_post_thumbnail();
		}
	}
}

Garfunkel_CPT_Portfolio::init();