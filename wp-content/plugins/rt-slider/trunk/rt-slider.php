<?php

/*
Plugin Name: RT Slider
Description: A Very Simple & Easy Slider Plugin, which helps you create sliders from Customizer, if your Theme Supports it. Originally Designed to Work with Rohitink.com & Inkhive.com Themes. 
Version: 1.0.7
Author: Rohit Tripathi
Author URI: http://rohitink.com
License: GPLv3


++ Note For Developers/Users ++
--------------------------------
All This Plugin Does Create Sections in themes for users to create and set up their sliders.
What Kind of Slider to be used, or its styling, will be completely done by the themes which support this plugin.

This ensures that Users do not loose their slider data once, they switch themes.

Naming of Variables:
All instances of rtslider, which are for plugin use only, are named rtslider. 
All Those to be referenced by themes are named rt_slider. (with Underscrore).
*/

if(!defined('RTSLIDER_URL')){
	define('RTSLIDER_URL', plugin_dir_url(__FILE__) );
}


//LOAD TEXTDOMAIN
add_action( 'plugins_loaded', 'rtslider_textdomain' );
function rtslider_textdomain() {
  load_plugin_textdomain( 'rt-slider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

//The Purpose of creating a class here, is also to help theme check if plugin is installed by
// calling a class_exists() functions.
class rt_slider {
	public function __construct() {
	    add_action( 'admin_notices', array($this, 'rtslider_admin_notice__error' ) );
	    add_action( 'customize_register', array($this, 'rtslider_customize_register') );
	    
    }   
    
    //Admin Notice - If theme does not support the plugin
	public function rtslider_admin_notice__error() {
		if (!get_theme_support('rt-slider')) :
	    ?>
	    <div class="notice notice-error is-dismissible">
	        <p><?php _e( 'Your Theme Does not Support this RT Slider Plugin. ', 'rt-slider' ); ?></p>
	    </div>
	    <?php
		endif; 
	}
	
	
	//The Part which Renders the Slider in Customizer
	public function rtslider_customize_register( $wp_customize ) {
	
		$max_count = 10;
		$page_support = false;
		$config_support = false;
		$front_page_only = false;
		$effects_array = array();
		$config_options = array();
		
		$is_supported = get_theme_support('rt-slider');
				
		//print_r($is_supported[0]['config']);
		
		if ( is_array( $is_supported ) ) :
			$max_count = $is_supported[0][0];
			
			if ( in_array( 'pages', $is_supported[0] ) )
				$page_support = true;
				
			if ( in_array( 'front-page-only', $is_supported[0] ) )
				$front_page_only = true;
				
			if ( in_array( 'config', $is_supported[0] ))
				$config_support = true;	
				
			if (array_key_exists('config', $is_supported[0] ))	:
				
				$config_support = true;	
				
				//Put all Available options into the array
				if (array_key_exists('options', $is_supported[0]['config']))
					$config_options = $is_supported[0]['config']['options'];
						
				//Put All Available Effects into its array
				if (array_key_exists('effects', $is_supported[0]['config']))
					$effects_array = $is_supported[0]['config']['effects'];
			
			endif; //options exist
			
		endif;	
		
		if ( $is_supported ) :
		
			// SLIDER PANEL
			$wp_customize->add_panel( 'rtslider_panel', array(
			    'priority'       => 35,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			    'title'          => __('Main Slider (RT Slider)','rt-slider'),
			) );
		
			$wp_customize->add_section(
			    'rtslider_sec_slider_options',
			    array(
			        'title'     => __('Enable/Disable','rt-slider'),
			        'priority'  => 0,
			        'panel'     => 'rtslider_panel'
			    )
			);
						
			$wp_customize->add_setting(
				'rtslider_enable_front',
				array( 'sanitize_callback' => 'rtslider_sanitize_checkbox' )
			);
			
			$wp_customize->add_control(
					'rtslider_enable_front', array(
				    'settings' => 'rtslider_enable_front',
				    'label'    => __( 'Enable Slider on Static Front Page.', 'rt-slider' ),
				    'section'  => 'rtslider_sec_slider_options',
				    'type'     => 'checkbox',
				)
			);
			
			//var_dump($front_page_only);
			
			if ( !$front_page_only ) :
			
				$wp_customize->add_setting(
					'rtslider_enable',
					array( 'sanitize_callback' => 'rtslider_sanitize_checkbox' )
				);
				
				$wp_customize->add_control(
						'rtslider_enable', array(
					    'settings' => 'rtslider_enable',
					    'label'    => __( 'Enable Slider on Blog/Home.', 'rt-slider' ),
					    'section'  => 'rtslider_sec_slider_options',
					    'type'     => 'checkbox',
					)
				);
				
				$wp_customize->add_setting(
					'rtslider_enable_posts',
					array( 'sanitize_callback' => 'rtslider_sanitize_checkbox' )
				);
				
				$wp_customize->add_control(
						'rtslider_enable_posts', array(
					    'settings' => 'rtslider_enable_posts',
					    'label'    => __( 'Enable Slider on All Posts.', 'rt-slider' ),
					    'section'  => 'rtslider_sec_slider_options',
					    'type'     => 'checkbox',
					)
				);
				
				$wp_customize->add_setting(
					'rtslider_enable_pages',
					array( 'sanitize_callback' => 'rtslider_sanitize_checkbox' )
				);
				
				$wp_customize->add_control(
						'rtslider_enable_pages', array(
					    'settings' => 'rtslider_enable_pages',
					    'label'    => __( 'Enable Slider on All Pages.', 'rt-slider' ),
					    'section'  => 'rtslider_sec_slider_options',
					    'type'     => 'checkbox',
					)
				);
				
			endif; //front_page_only	
			
			
			if ( $page_support ) :
			
				$wp_customize->add_setting('rtslider_enable_page1', array(
					'capability' => 'edit_theme_options',
					//'type' => 'option',
				));
			
				$wp_customize->add_control('rtslider_enable_page1', array(
					'label' => __('Enable Slider on Upto 2 Individual Pages.', 'rt-slider'),
					'description' => __('Page 1.', 'rt-slider'),
					'section' => 'rtslider_sec_slider_options',
					'type' => 'dropdown-pages',
					'settings' => 'rtslider_enable_page1',
				)); 
				
				$wp_customize->add_setting('rtslider_enable_page2', array(
					'capability' => 'edit_theme_options',
					//'type' => 'option',
				));
			
				$wp_customize->add_control('rtslider_enable_page2', array(
					'description' => __('Page 2.', 'rt-slider'),
					'section' => 'rtslider_sec_slider_options',
					'type' => 'dropdown-pages',
					'settings' => 'rtslider_enable_page2',
				)); 
				
			endif;	
			
			
			if( $config_support ) :
			
				//Slider Config
				$wp_customize->add_section(
				    'rtslider_config',
				    array(
				        'title'     => __('Configure Slider','rt-slider'),
				        'priority'  => 0,
				        'panel'     => 'rtslider_panel'
				    )
				);
				
				if ( in_array('duration', $config_options) ) :
				
					$wp_customize->add_setting(
						'rtslider_duration',
							array(
								'default' => 5000,
								'sanitize_callback' => 'rtslider_sanitize_positive_number'
							)
					);
					
					$wp_customize->add_control(
							'rtslider_duration', array(
						    'settings' => 'rtslider_duration',
						    'label'    => __( 'Time Between Each Slide.' ,'rt-slider'),
						    'section'  => 'rtslider_config',
						    'type'     => 'number',
						    'description' => __('Duration for which each slide must be shown. Value in Milliseconds. Default: 5000.','rt-slider'),
						    
						)
					);
					
				endif;	
				
				
				if ( in_array('speed', $config_options) ) :
				
					$wp_customize->add_setting(
						'rtslider_speed',
							array(
								'default' => 500,
								'sanitize_callback' => 'rtslider_sanitize_positive_number'
							)
					);
					
					$wp_customize->add_control(
							'rtslider_speed', array(
						    'settings' => 'rtslider_speed',
						    'label'    => __( 'Animation Speed.' ,'rt-slider'),
						    'section'  => 'rtslider_config',
						    'type'     => 'number',
						    'description' => __('The Speed at which Slide Animates from one slide to another. Value in Milliseconds. Default: 500.','rt-slider'),
						    
						)
					);
				
				endif;
				
				
				if ( in_array('duration', $config_options) ) :
				
					$wp_customize->add_setting(
						'rtslider_random',
							array(
								'default' => false,
								'sanitize_callback' => 'rtslider_sanitize_checkbox'
							)
					);
					
					$wp_customize->add_control(
							'rtslider_random', array(
						    'settings' => 'rtslider_random',
						    'label'    => __( 'Start Slider from Random Slide.' ,'rt-slider'),
						    'section'  => 'rtslider_config',
						    'type'     => 'checkbox',		    
						)
					);
				
				endif;
					
				if ( in_array('pager', $config_options) ) :
					
					$wp_customize->add_setting(
						'rtslider_pager',
							array(
								'default' => true,
								'sanitize_callback' => 'rtslider_sanitize_checkbox'
							)
					);
					
					$wp_customize->add_control(
							'rtslider_pager', array(
						    'settings' => 'rtslider_pager',
						    'label'    => __( 'Enable Pager.' ,'rt-slider'),
						    'section'  => 'rtslider_config',
						    'type'     => 'checkbox',
						    'description' => __('Pager is the Small buttons at the bottom, which represent current slide.','rt-slider'),		    
						)
					);
					
				endif;	
				
				if ( in_array('duration', $config_options) ) :
				
				$wp_customize->add_setting(
						'rtslider_autoplay',
							array(
								'default' => true, //Because, in nivo its Force Manual Transitions.
								'sanitize_callback' => 'rtslider_sanitize_checkbox'
							)
					);
					
					$wp_customize->add_control(
							'rtslider_autoplay', array(
						    'settings' => 'rtslider_autoplay',
						    'label'    => __( 'Enable Autoplay.' ,'rt-slider'),
						    'section'  => 'rtslider_config',
						    'type'     => 'checkbox',
						)
					);
				
				endif;
				
				if ( !empty($effects_array ) ):	
				
					$wp_customize->add_setting(
						'rtslider_effect',
							array(
								'default' => 'random',
								'sanitize_callback' => 'rtslider_sanitize_text'
							)
					);
					
					$earray= $effects_array;
					$earray = array_combine($earray, $earray);
					
					$wp_customize->add_control(
							'rtslider_effect', array(
						    'settings' => 'rtslider_effect',
						    'label'    => __( 'Slider Animation Effect.' ,'rt-slider'),
						    'section'  => 'rtslider_config',
						    'type'     => 'select',
						    'choices' => $earray,
					) );
					
				endif;	
			
			endif;	
			
			
			$wp_customize->add_setting(
				'rtslider_count',
					array(
						'default' => 0,
						'sanitize_callback' => 'rtslider_sanitize_positive_number'
					)
			);
			
			//Select How Many Slides the User wants, and Reload the Page.
			$wp_customize->add_control(
					'rtslider_count', array(
				    'settings' => 'rtslider_count',
				    'label'    => __( 'No. of Slides(Min:0, Max: '.$max_count.')' ,'rt-slider'),
				    'section'  => 'rtslider_sec_slider_options',
				    'type'     => 'number',
				    'description' => __('Set the No. of Slides you want, and go then <strong style="color:green;">reload this page</strong> screen to configure the slides.','rt-slider'),
				    
				)
			);						
			
			for ( $i = 1 ; $i <= get_theme_mod('rtslider_count',0) ; $i++ ) :
				
				//Create the settings Once, and Loop through it.	
				$wp_customize->add_section(
				    'rtslider_slide_sec'.$i,
				    array(
				        'title'     => 'Slide '.$i,
				        'priority'  => $i,
				        'panel'     => 'rtslider_panel',
				        
				    )
				);	
				
				
				$wp_customize->add_setting(
					'rtslider_slide_img'.$i,
					array( 'sanitize_callback' => 'esc_url_raw' )
				);
				
				$wp_customize->add_control(
				    new WP_Customize_Image_Control(
				        $wp_customize,
				        'rtslider_slide_img'.$i,
				        array(
				            'label' => '',
				            'section' => 'rtslider_slide_sec'.$i,
				            'settings' => 'rtslider_slide_img'.$i,			       
				        )
					)
				);
				
				$wp_customize->add_setting(
					'rtslider_slide_title'.$i,
					array( 'sanitize_callback' => 'sanitize_text_field' )
				);
				
				$wp_customize->add_control(
						'rtslider_slide_title'.$i, array(
					    'settings' => 'rtslider_slide_title'.$i,
					    'label'    => __( 'Slide Title','rt-slider' ),
					    'section'  => 'rtslider_slide_sec'.$i,
					    'type'     => 'text',
					)
				);
				
				$wp_customize->add_setting(
					'rtslider_slide_desc'.$i,
					array( 'sanitize_callback' => 'sanitize_text_field' )
				);
				
				$wp_customize->add_control(
						'rtslider_slide_desc'.$i, array(
					    'settings' => 'rtslider_slide_desc'.$i,
					    'label'    => __( 'Slide Description','rt-slider' ),
					    'section'  => 'rtslider_slide_sec'.$i,
					    'type'     => 'text',
					)
				);
				
				
				
				$wp_customize->add_setting(
					'rtslider_slide_cta_button'.$i,
					array( 'sanitize_callback' => 'sanitize_text_field' )
				);
				
				$wp_customize->add_control(
						'rtslider_slide_cta_button'.$i, array(
					    'settings' => 'rtslider_slide_cta_button'.$i,
					    'label'    => __( 'Custom Call to Action Button Text(Optional)','rt-slider' ),
					    'section'  => 'rtslider_slide_sec'.$i,
					    'type'     => 'text',
					)
				);
				
				$wp_customize->add_setting(
					'rtslider_slide_url'.$i,
					array( 'sanitize_callback' => 'esc_url_raw' )
				);
				
				$wp_customize->add_control(
						'rtslider_slide_url'.$i, array(
					    'settings' => 'rtslider_slide_url'.$i,
					    'label'    => __( 'Target URL','rt-slider' ),
					    'section'  => 'rtslider_slide_sec'.$i,
					    'type'     => 'url',
					)
				);
				
			endfor;
			
		endif;	 //end get theme support
			
			function rtslider_sanitize_positive_number( $input ) {
				if ( ($input >= 0) && is_numeric($input) )
					return $input;
				else
					return '';	
			}
			
			function rtslider_sanitize_checkbox( $input ) {
			    if ( $input == 1 ) {
			        return 1;
			    } else {
			        return '';
			    }
			}
		
	}
	
	public function is_rtslider_enabled() {
		if ( ( get_theme_mod('rtslider_enable') && is_home() )
			|| ( get_theme_mod('rtslider_enable_front') && is_front_page() )
			|| ( get_theme_mod('rtslider_enable_posts') && is_single() ) 
			|| ( get_theme_mod('rtslider_enable_pages') && is_page() )
			|| ( is_page(get_theme_mod('rtslider_enable_page1', 0)) && is_page() && get_theme_mod('rtslider_enable_page1') != "0" )
			|| ( is_page(get_theme_mod('rtslider_enable_page2', 0)) && is_page() && get_theme_mod('rtslider_enable_page2') != "0") //Extra check by is_page() added on purpose.		
		)
		return true;
	}
	
	//The Function which is to be called by themes.
	public static function render($param1, $param2 = null) {
		global $rtslider_inst; //Global Variable of the Instance
		if ( $rtslider_inst->is_rtslider_enabled() )
			get_template_part( $param1, $param2 );
			
	}
	
	//The Function to Fetch Various Slider Settings and Values
	public static function fetch( $param, $slide_number = null ) {
		
		$return_value = null;
		
		if ($slide_number == null) {		
			$return_value = get_theme_mod('rtslider_'.$param);
		} elseif ($slide_number > 0) {
			$return_value = get_theme_mod('rtslider_slide_'.$param.$slide_number);
		}
		
		return $return_value;
		
	}

} //END CLASS

//Initialize and Instance of the Slider.
$rtslider_inst = new rt_slider();