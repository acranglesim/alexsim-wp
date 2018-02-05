<?php 
function plum_customize_register_static_page($wp_customize) {
    //Static Page
    $wp_customize->add_panel('plum_custom_page_panel',
        array(
            'title' => __('Custom Pages', 'plum'),
            'priority' => 100,
        )
    );
    
    $wp_customize->add_section('plum_custom_page_section',
        array(
            'title' => __('Contact Us', 'plum'),
            'panel' => 'plum_custom_page_panel',
        )
    );
    
    //Info on how to use this
    $wp_customize->add_setting(
			'plum_cpw',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new Plum_WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'plum_cpw',
	        array(
	            'label' => __('How to Create a Beautiful Contact us Page?','plum'),
	            'description' => __('To do so, go to your Dashboard - Pages - Add New. <br/> 
	            In the Add New Page, Give the Page a title and add some content to it if you want to. And then Set the template of the page to <strong>Contact Us</strong> from "Default Template". <br/><br/>
	            Once you have done so, open the contact us page in your browser and click on Customize from the Admin Bar. Once you are in the Customizer you can Comeback to this section and finish designing your custom page.','plum'),
	            'section' => 'plum_custom_page_section',
	            'settings' => 'plum_cpw',			       
	        )
		)
	);
	
	

    //Page Title Enable/Disable
    $wp_customize->add_setting('plum_contact_page_title',
        array(
            'sanitize_callback' => 'plum_sanitize_checkbox'
        ));
    $wp_customize->add_control('plum_contact_page_title',
        array(
            'setting' => 'plum_contact_page_title',
            'section' => 'plum_custom_page_section',
            'label' => __('Disable Page Title', 'plum'),
            'description' => __('Default: Enabled. Check to Disable Page Title.', 'plum'),
            'type' => 'checkbox'
        )
    );

    //From Shortcode
    $wp_customize->add_setting('plum_form_shortcode_set',
        array(
            'sanitize_callback' => 'sanitize_textarea_field'
        )
    );

    $wp_customize->add_control('plum_form_shortcode_set',
        array(
            'setting' => 'plum_form_shortcode_set',
            'section' => 'plum_custom_page_section',
            'label' => __('Shortccode', 'plum'),
            'description' => __('Paste form shortcode here to display form.', 'plum'),
            'type' => 'textarea',
        )
    );

    //Contact Us Details
    $wp_customize->add_setting('plum_select_contact_page',
        array(
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control('plum_select_contact_page',
        array(
            'setting' => 'plum_select_contact_page',
            'section' => 'plum_custom_page_section',
            'label' => __('Contact Page', 'plum'),
            'description' => __('Select a Page to display Address Details', 'plum'),
            'type' => 'dropdown-pages',
        )
    );

    //Page Text
    $wp_customize->add_setting('plum_static_selectpage',
        array(
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control('plum_static_selectpage',
        array(
            'setting' => 'plum_static_selectpage',
            'section' => 'plum_custom_page_section',
            'label' => __('More Details Box', 'plum'),
            'description' => __('Fetch more details from following page', 'plum'),
            'type' => 'dropdown-pages',
        )
    );

    //Page Button Text
    $wp_customize->add_setting('plum_static_button',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('plum_static_button',
        array(
            'setting' => 'plum_static_button',
            'section' => 'plum_custom_page_section',
            'label' => __('Button Name', 'plum'),
            'type' => 'text',
        )
    );


    //Map Image
    $wp_customize->add_setting('plum_map_set',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, 'plum_map_set',
            array (
                'setting' => 'plum_map_set',
                'section' => 'plum_custom_page_section',
                'label' => __('Map Location Image', 'plum'),
                'description' => __('Upload an image to display location in MAP. Image should be 788 X 414', 'plum'),
            )
        )
    );

    //Button Text
    $wp_customize->add_setting('plum_button_text',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('plum_button_text',
        array(
            'setting' => 'plum_button_text',
            'section' => 'plum_custom_page_section',
            'label' => __('Button ', 'plum'),
            'description' => __('Enter button name', 'plum'),
            'type' => 'text',
        )
    );

    //Button Url
    $wp_customize->add_setting('plum_button_url',
        array(
            'sanitize_callback' => 'esc_url'
        )
    );

    $wp_customize->add_control('plum_button_url',
        array(
            'setting' => 'plum_button_url',
            'section' => 'plum_custom_page_section',
            'label' => __('Button URL', 'plum'),
            'description' => __('Enter button URL with: http://', 'plum'),
            'type' => 'url',
        )
    );
}
add_action('customize_register', 'plum_customize_register_static_page');