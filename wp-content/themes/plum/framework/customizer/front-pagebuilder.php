<?php
/**
 * @param $wp_customize
 *
 * Front Page Builder
 */
function plum_customize_register_front_pagebuilder($wp_customize) {
    $wp_customize->add_panel('plum_fpage_builder',
        array(
            'title' => __('Front Page Builder', 'plum'),
            'priority' => 30,
        )
    );


    //Basic Settings
    $wp_customize->add_section('plum_basic_settings_section',
        array(
            'title' => __('Basic Settings', 'plum'),
            'priority' => 20,
            'panel' => 'plum_fpage_builder',
        )
    );

    //Basic Setting Info
    $wp_customize->add_setting(
			'plum_fpb',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new Plum_WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'plum_fpb',
	        array(
	            'label' => __('Note','plum'),
	            'description' => __('You need to set your homepage to a Static Front page in order to use any of these settings.','plum'),
	            'section' => 'plum_basic_settings_section',
	            'settings' => 'plum_fpb',			       
	        )
		)
	);
	
    $wp_customize->add_setting('plum_page_title',
        array(
                'sanitize_callback' => 'plum_sanitize_checkbox'
        ));
    $wp_customize->add_control('plum_page_title',
        array(
            'setting' => 'plum_page_title',
            'section' => 'plum_basic_settings_section',
            'label' => __('Disable Page Title', 'plum'),
            'description' => __('Default: Enabled. Check to Disable Page Title.', 'plum'),
            'type' => 'checkbox'
        )
    );

    $wp_customize->add_setting('plum_disable_comments',
        array(
            'sanitize_callback' => 'plum_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('plum_disable_comments',
        array(
            'setting' => 'plum_disable_comments',
            'section' => 'plum_basic_settings_section',
            'label' => __('Enable Comments Box', 'plum'),
            'description' => __('Comment Box will be enabled from your Static Page', 'plum'),
            'type' => 'checkbox',
            'default' => false,
        )
    );


    //font size
    $font_size = array(
        '14px' => 'Default',
        'initial' => 'Initial',
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large',
        'larger' => 'Larger',
        'x-large' => 'Extra Large',
    );

    $wp_customize->add_setting(
        'plum_content_font_size', array(
            'default' => '14px',
            'sanitize_callback' => 'plum_sanitize_fontsize'
        )
    );

    function plum_sanitize_fontsize( $input ) {
        if ( in_array($input, array('14px','initial','small','medium','large','larger','x-large') ) )
            return $input;
        else
            return '';
    }



    $wp_customize->add_control(
        'plum_content_font_size', array(
            'settings' => 'plum_content_font_size',
            'label' => __( 'Content Font Size','plum' ),
            'description' => __('Select Font Size. This is only for the content on Static Page area. Not for Blog Posts, Pages or Archives.', 'plum'),
            'section'  => 'plum_basic_settings_section',
            'type'     => 'select',
            'choices' => $font_size
        )
    );


    //HERO 1
    $wp_customize->add_section('plum_hero1_section',
        array(
            'title' => __('HERO (Above Content)', 'plum'),
            'priority' => 20,
            'panel' => 'plum_fpage_builder',
        )
    );

    $wp_customize->add_setting('plum_hero_enable',
        array(
                'sanitize_callback' => 'plum_sanitize_checkbox'
        ));
    $wp_customize->add_control('plum_hero_enable',
        array(
            'setting' => 'plum_hero_enable',
            'section' => 'plum_hero1_section',
            'label' => __('Enable HERO', 'plum'),
            'type' => 'checkbox',
            'default' => false,
        )
    );

    $wp_customize->add_setting('plum_hero_background_image',
        array(
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, 'plum_hero_background_image',
            array (
                'setting' => 'plum_hero_background_image',
                'section' => 'plum_hero1_section',
                'label' => __('Background Image', 'plum'),
                'description' => __('Upload an image to display in background of HERO', 'plum'),
                'active_callback' => 'plum_hero_active_callback'
            )
        )
    );

    $wp_customize->add_setting('plum_hero1_selectpage',
        array(
                'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control('plum_hero1_selectpage',
        array(
            'setting' => 'plum_hero1_selectpage',
            'section' => 'plum_hero1_section',
            'label' => __('Title', 'plum'),
            'description' => __('Select a Page to display Title', 'plum'),
            'type' => 'dropdown-pages',
            'active_callback' => 'plum_hero_active_callback'
        )
    );


    $wp_customize->add_setting('plum_hero1_full_content',
        array(
            'sanitize_callback' => 'plum_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('plum_hero1_full_content',
        array(
            'setting' => 'plum_hero1_full_content',
            'section' => 'plum_hero1_section',
            'label' => __('Show Full Content insted of excerpt', 'plum'),
            'type' => 'checkbox',
            'default' => false,
            'active_callback' => 'plum_hero_active_callback'
        )
    );

    $wp_customize->add_setting('plum_hero1_button',
        array(
                'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('plum_hero1_button',
        array(
            'setting' => 'plum_hero1_button',
            'section' => 'plum_hero1_section',
            'label' => __('Button Name', 'plum'),
            'description' => __('Leave blank to disable Button.', 'plum'),
            'type' => 'text',
            'active_callback' => 'plum_hero_active_callback'
        )
    );

    function plum_hero_active_callback( $control ) {
        $option = $control->manager->get_setting('plum_hero_enable');
        return $option->value() == true;
    }

    //HERO 2
    $wp_customize->add_section('plum_hero2_section',
        array(
            'title' => __('HERO (Below Content)', 'plum'),
            'priority' => 25,
            'panel' => 'plum_fpage_builder',
        )
    );

    $wp_customize->add_setting('plum_hero_eta_enable',
        array(
            'sanitize_callback' => 'plum_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('plum_hero_eta_enable',
        array(
            'setting' => 'plum_hero_eta_enable',
            'section' => 'plum_hero2_section',
            'label' => __('Enable HERO', 'plum'),
            'type' => 'checkbox',
            'default' => false
        )
    );

    $wp_customize->add_setting('plum_hero2_background_image',
        array(
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, 'plum_hero2_background_image',
            array (
                'setting' => 'plum_hero2_background_image',
                'section' => 'plum_hero2_section',
                'label' => __('Background Image', 'plum'),
                'description' => __('Upload an image to display in background of HERO', 'plum'),
                'active_callback' => 'plum_hero_eta_active_callback'
            )
        )
    );

    $wp_customize->add_setting('plum_hero2_selectpage',
        array(
            'sanitize_callback' => 'absint'
        )
    );
    
    $wp_customize->add_control('plum_hero2_selectpage',
        array(
            'setting' => 'plum_hero2_selectpage',
            'section' => 'plum_hero2_section',
            'label' => __('Title', 'plum'),
            'description' => __('Select a Page to display Title', 'plum'),
            'type' => 'dropdown-pages',
            'active_callback' => 'plum_hero_eta_active_callback'
        )
    );

    $wp_customize->add_setting('plum_hero2_full_content',
        array(
            'sanitize_callback' => 'plum_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('plum_hero2_full_content',
        array(
            'setting' => 'plum_hero2_full_content',
            'section' => 'plum_hero2_section',
            'label' => __('Show Full Content instead of excerpt', 'plum'),
            'type' => 'checkbox',
            'default' => false,
            'active_callback' => 'plum_hero_eta_active_callback'
        )
    );

    $wp_customize->add_setting('plum_hero2_button',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control('plum_hero2_button',
        array(
            'setting' => 'plum_hero2_button',
            'section' => 'plum_hero2_section',
            'label' => __('Button Name', 'plum'),
            'description' => __('Leave blank to disable Button.', 'plum'),
            'type' => 'text',
            'active_callback' => 'plum_hero_eta_active_callback'
        )
    );

    function plum_hero_eta_active_callback( $control ) {
        $option = $control->manager->get_setting('plum_hero_eta_enable');
        return $option->value() == true;
    }
}
add_action('customize_register', 'plum_customize_register_front_pagebuilder');