<?php
// Function to add prism.css and prism.js to the site
function add_prism() {

    // Register prism.css file
    wp_register_style(
        'prismCSS', // handle name for the style
        get_stylesheet_directory_uri() . '/lib/prism.css' // location of the prism.css file
    );

    // Register prism.js file
    wp_register_script(
        'prismJS', // handle name for the script
        get_stylesheet_directory_uri() . '/lib/prism.js' // location of the prism.js file
    );

    // Enqueue the registered style and script files
    wp_enqueue_style('prismCSS');
    wp_enqueue_script('prismJS');
}

function add_custom() {
    // Register custom.js file
    wp_register_script(
        'customJs', // handle name for the script
        get_stylesheet_directory_uri() . '/assets/js/custom.js', // location of the custom.js file
        array('jquery')
    );

    // Enqueue the registered style and script files
    wp_enqueue_script('customJs');
}

function get_cookie_panel() {
    if (!array_key_exists('wp-settings-alexsim-panel', $_COOKIE)) {
        return "panel-1";
    }
    return $_COOKIE["wp-settings-alexsim-panel"];
}

// Add Prism logic
add_action('wp_enqueue_scripts', 'add_prism');
// Add custom css and js logic
add_action('wp_enqueue_scripts', 'add_custom');
// Add php function to get cookie for panel
add_action('wp_head', 'get_cookie_panel');