<?php

function plum_customize_register_misc( $wp_customize ) {
	//Upgrade to Pro
	$wp_customize->add_section(
	    'plum_sec_pro',
	    array(
	        'title'     => __('Important Links','plum'),
	        'priority'  => 10,
	    )
	);
	
	$wp_customize->add_setting(
			'plum_pro',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new Plum_WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'plum_pro',
	        array(
                'description'	=> '<a class="plum-important-links" href="https://inkhive.com/contact-us/" target="_blank">'.__('InkHive Support Forum', 'plum').'</a>
                                    <a class="plum-important-links" href="http://demo.inkhive.com/plum-plus/" target="_blank">'.__('Plum Plus Live Demo', 'plum').'</a>
                                    <a class="plum-important-links" href="https://www.facebook.com/inkhivethemes/" target="_blank">'.__('We Love Our Facebook Fans', 'plum').'</a>
                                    <a class="plum-important-links" href="https://wordpress.org/support/theme/plum/reviews" target="_blank">'.__('Review Plum on WordPress', 'plum').'</a>
                                    <a class="plum-important-links" href="https://inkhive.com/documentation/plum" target="_blank">'.__('Plum Documentation', 'plum').'</a>',
	            'section' => 'plum_sec_pro',
	            'settings' => 'plum_pro',			       
	        )
		)
	);
}
add_action('customize_register', 'plum_customize_register_misc');