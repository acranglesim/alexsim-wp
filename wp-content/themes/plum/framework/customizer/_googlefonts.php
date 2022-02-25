<?php
	function plum_customize_register_fonts( $wp_customize ) {
	//Fonts
	$wp_customize->add_section(
	    'plum_typo_options',
	    array(
	        'title'     => __('Google Web Fonts','plum'),
	        'priority'  => 41,
	        'description' => __('Defaults: Arvo, Ubuntu.','plum'),
	        'panel' => 'plum_design_panel'
	    )
	);

	$font_array = array('Arvo','Ubuntu','Source Sans Pro','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo 13px','Lora');
	$fonts = array_combine($font_array, $font_array);
	
	$wp_customize->add_setting(
		'plum_title_font',
		array(
			'default'=> 'Arvo',
			'sanitize_callback' => 'plum_sanitize_gfont' 
			)
	);
	
	function plum_sanitize_gfont( $input ) {
		if ( in_array($input, array('Arvo','Ubuntu','Source Sans Pro','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo 13px','Lora',) ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
		'plum_title_font',array(
				'label' => __('Title','plum'),
				'settings' => 'plum_title_font',
				'section'  => 'plum_typo_options',
				'type' => 'select',
				'choices' => $fonts,
			)
	);
	
	$wp_customize->add_setting(
		'plum_body_font',
			array(	'default'=> 'Ubuntu',
					'sanitize_callback' => 'plum_sanitize_gfont' )
	);
	
	$wp_customize->add_control(
		'plum_body_font',array(
				'label' => __('Body','plum'),
				'settings' => 'plum_body_font',
				'section'  => 'plum_typo_options',
				'type' => 'select',
				'choices' => $fonts
			)
	);
}
add_action('customize_register', 'plum_customize_register_fonts');