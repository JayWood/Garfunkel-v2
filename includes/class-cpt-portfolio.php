<?php

require_once 'CPT_Core/CPT_Core.php';
require_once 'CMB2-2.2.4/init.php';


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
			'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail' ),
			'has_archive' => true,
		) );

		add_action( 'admin_head', array( $this, 'admin_styles' ) );
		add_action( 'cmb2_admin_init', array( $this, 'cmb' ) );
	}

	public static function get_meta_prefix() {
		return 'garfunkel_portfolio_';
	}

	public static function get_company_logo( $post_id = 0 ) {
		$post_id = (int) $post_id ?: get_the_ID();

		if ( empty( $post_id ) ) {
			return;
		}

		$image_id = get_post_meta( $post_id, self::get_meta_prefix() . 'logo_id', true );
		if ( empty( $image_id ) ) {
			return;
		}

		return wp_get_attachment_image( $image_id, array( 512, 512 ) );
	}

	public static function get_company_name( $post_id = 0 ) {
		$post_id = (int) $post_id ?: get_the_ID();

		if ( empty( $post_id ) ) {
			return;
		}

		$company_name = get_post_meta( $post_id, self::get_meta_prefix() . 'company_name', true );
		if ( empty( $company_name ) ) {
			return;
		}

		return esc_attr( $company_name );
	}

	public function cmb() {

		$cmb = new_cmb2_box( array(
			'id'           => self::get_meta_prefix() . 'metabox',
			'title'        => esc_html__( 'Portfolio Options', 'garfunkel' ),
			'object_types' => [ $this->post_type() ],
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Logo', 'garfunkel' ),
			'desc'    => esc_html__( 'Provide a transparent .png logo to overlay the featured image.', 'garfunkel' ),
			'id'      => self::get_meta_prefix() . 'logo',
			'type'    => 'file',
			'options' => array(
				'url' => false,
			),
			'text'    => array(
				'add_upload_file_text' => esc_html__( 'Upload a Logo', 'garfunkel' ),
			),
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'Company Name', 'garfunkel' ),
			'type' => 'text',
			'id' => self::get_meta_prefix() . 'company_name',
		) );
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