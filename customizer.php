<?php
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

	//end of bcdl code

}

add_action( 'customize_register', 'bcdl_usbs_01_customize_register' );
