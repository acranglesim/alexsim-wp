<?php
	function plum_customize_register_social( $wp_customize ) {
		// Social Icons
	$wp_customize->add_section('plum_social_section', array(
			'title' => __('Social Icons','plum'),
			'priority' => 44 ,
			'panel' => 'plum_header_panel'
	));
	
	$social_networks = array( //Redefinied in Sanitization Function.
					'none' => __('-','plum'),
					'facebook-f' => __('Facebook','plum'),
					'twitter' => __('Twitter','plum'),
					'google-plus-g' => __('Google Plus','plum'),
					'instagram' => __('Instagram','plum'),
					'linkedin-in' => __('Linked In','plum'),
					'vimeo-v' => __('Vimeo','plum'),
					'youtube' => __('Youtube','plum'),
					'flickr' => __('Flickr','plum'),
					'pinterest-p'	=> __('Pinterest', 'plum'),
				);

	$social_icon_styles = array(
	        'none' => __('Default', 'plum'),
            'style1' => __('Style 1', 'plum'),
            'style2' => __('Style 2', 'plum'),
            'style3' => __('Style 3', 'plum')
        );

	$wp_customize->add_setting('plum_social_icon_style', array(
	    'default' => 'none',
        'sanitize_callback' => 'plum_sanitize_social_style',
        'transport'	=> 'postMessage'
    ) );

	function plum_sanitize_social_style($input) {
	    $social_icon_styles = array(
	        'none',
            'style1',
            'style2',
            'style3',
        );
	    if ( in_array($input, $social_icon_styles))
	        return $input;
	    else
	        return '';
    }

    $wp_customize->add_control('plum_social_icon_style', array(
         'setting' => 'plum_social_icon_style',
         'section' => 'plum_social_section',
         'label' => __('Social Icon Effects', 'plum'),
         'type' => 'select',
         'choices' => $social_icon_styles,
       )
    );

	$social_count = count($social_networks);
				
	for ($x = 1 ; $x <= ($social_count - 4) ; $x++) :
			
		$wp_customize->add_setting(
			'plum_social_'.$x, array(
				'sanitize_callback' => 'plum_sanitize_social',
				'default' => 'none',
				'transport'	=> 'postMessage'
			));

		$wp_customize->add_control( 'plum_social_'.$x, array(
					'settings' => 'plum_social_'.$x,
					'label' => __('Icon ','plum').$x,
					'section' => 'plum_social_section',
					'type' => 'select',
					'choices' => $social_networks,			
		));
		
		$wp_customize->add_setting(
			'plum_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'plum_social_url'.$x, array(
					'settings' => 'plum_social_url'.$x,
					'description' => __('Icon ','plum').$x.__(' Url','plum'),
					'section' => 'plum_social_section',
					'type' => 'url',
					'choices' => $social_networks,			
		));
		
	endfor;
	
	function plum_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook-f',
					'twitter',
					'google-plus-g',
					'instagram',
					'linkedin-in',
					'vimeo-v',
					'youtube',
					'flickr',
					'pinterest-p',
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';	
	}	
}
add_action('customize_register', 'plum_customize_register_social');