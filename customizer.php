<?php
/**
 * bcdl-usbs-01 Theme Customizer
 *
 * @package bcdl-usbs-01
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function bcdl_usbs_01_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'bcdl_usbs_01_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'bcdl_usbs_01_customize_partial_blogdescription',
			)
		);
	};

	//bcdl add section for selecting exhibitions
	$bcdl_exargs = array(
		'post_type' => 'post',
		'orderby' => 'date',
		'order' => 'DESC',
		'tax_query' => array(
			'0' => array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => array('exhibitions'),
				'operator' => 'IN',
			),
		),
	);

	$bcdl_exhposts_list = array();
	$bcdl_exhposts = get_posts( $bcdl_exargs );
	foreach( $bcdl_exhposts as $bcdl_exhpost ) {
    $bcdl_exhposts_list[ $bcdl_exhpost->ID ] = $bcdl_exhpost->post_title;
	};
	//Exhibitions section:
	$wp_customize->add_section( 'bcdl-exhibitions' , 
		array(
	    'title'      => __( 'Exhibitions', 'bcdl-usbs-01' ),
	    'description' => __( 'Select exhibitions featured posts', 'bcdl-usbs-01' ),
	    'priority'   => 220,
		) 
	);

	$wp_customize->add_setting( 'bcdl-excoming-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Control( 
		$wp_customize, 'bcdl-excoming', 
			array( 
				'label' => __( 'Coming exhibitions', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-exhibitions', 
				'type' => 'select',
				'settings' => 'bcdl-excoming-set',
				'choices' =>  $bcdl_exhposts_list 
			) 
		) 
	);

	$wp_customize->add_setting( 'bcdl-exnow-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Control( 
		$wp_customize, 'bcdl-exnow', 
			array( 
				'label' => __( 'Present exhibitions', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-exhibitions', 
				'type' => 'select',
				'settings' => 'bcdl-exnow-set',
				'choices' =>  $bcdl_exhposts_list 
			) 
		) 
	);

	$wp_customize->add_setting( 'bcdl-expast-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Control( 
		$wp_customize, 'bcdl-expast', 
			array( 
				'label' => __( 'Past exhibitions', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-exhibitions', 
				'type' => 'select',
				'settings' => 'bcdl-expast-set',
				'choices' =>  $bcdl_exhposts_list 
			) 
		) 
	);
	//Fund section:
	$wp_customize->add_section( 'bcdl-funds' , 
		array(
	    'title'      => __( 'Funds', 'bcdl-usbs-01' ),
	    'description' => __( 'Select images for fund cards', 'bcdl-usbs-01' ),
	    'priority'   => 240,
		) 
	);

	$wp_customize->add_setting( 'bcdl-painting-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Media_Control( 
		$wp_customize, 'bcdl-painting', 
			array( 
				'label' => __( 'Select Painting image', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-funds', 
				'settings' => 'bcdl-painting-set',
			) 
		) 
	);

	$wp_customize->add_setting( 'bcdl-graphics-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Media_Control( 
		$wp_customize, 'bcdl-graphics', 
			array( 
				'label' => __( 'Select Graphics image', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-funds', 
				'settings' => 'bcdl-graphics-set',
			) 
		) 
	);

	$wp_customize->add_setting( 'bcdl-sculpture-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Media_Control( 
		$wp_customize, 'bcdl-sculpture', 
			array( 
				'label' => __( 'Select Graphics image', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-funds', 
				'settings' => 'bcdl-sculpture-set',
			) 
		) 
	);

	$wp_customize->add_setting( 'bcdl-icons-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Media_Control( 
		$wp_customize, 'bcdl-icons', 
			array( 
				'label' => __( 'Select Graphics image', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-funds', 
				'settings' => 'bcdl-icons-set',
			) 
		) 
	);

	//Header section
	$wp_customize->add_section( 'bcdl-header' , 
		array(
	    'title'      => __( 'Frontpage Header', 'bcdl-usbs-01' ),
	    'description' => __( 'Select image for the header. Must be 1200x400 pixels.', 'bcdl-usbs-01' ),
	    'priority'   => 260,
		) 
	);

	$wp_customize->add_setting( 'bcdl-header-set', 
		array( 
			'type' => 'theme_mod',
			'default' => '',
			'transport' => 'refresh',
      'sanitize_callback' => 'absint'
		) 
	);

	$wp_customize->add_control( new WP_Customize_Media_Control( 
		$wp_customize, 'bcdl-headerctrl', 
			array( 
				'label' => __( 'Select Header image', 'bcdl-usbs-01' ), //check the .pot file
				'section' => 'bcdl-header', 
				'settings' => 'bcdl-header-set',
			) 
		) 
	);

	//end of bcdl code

}

add_action( 'customize_register', 'bcdl_usbs_01_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function bcdl_usbs_01_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function bcdl_usbs_01_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bcdl_usbs_01_customize_preview_js() {
	wp_enqueue_script( 'bcdl-usbs-01-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'bcdl_usbs_01_customize_preview_js' );
