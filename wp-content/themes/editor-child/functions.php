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

function my_mail_from( $email ) {
    return "system@alexandchelsea.co.uk";
}

add_action('wp_enqueue_scripts', 'add_prism');
add_filter( 'wp_mail_from', 'my_mail_from' );
