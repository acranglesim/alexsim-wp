<?php
function plum_customize_regster_menu_alignement($wp_customize) {
    $menu_alignment = array (
        'default' => __('Default', 'plum'),
        'center' => __('Center', 'plum'),
        'right' =>  __('Right', 'plum')
    );

    $wp_customize->add_section('plum_menu_alignment_section', array(
            'title' => __('Menu Alignment', 'plum'),
            'priority' => 10,
            'panel' => 'nav_menus',
        )
    );

    $wp_customize->add_setting('plum_menu_alignment_set', array(
            'default' => 'default',
            'sanitize_callback' => 'plum_sanitize_menu_alignment',
        )
    );

    $wp_customize->add_control('plum_menu_alignment_set', array(
            'setting' => 'plum_menu_alignment_set',
            'section' => 'plum_menu_alignment_section',
            'label' => __('Select An Option', 'plum'),
            'description' => __('Default Aligned: Left', 'plum'),
            'type' => 'select',
            'choices' => $menu_alignment,
        )
    );

    function plum_sanitize_menu_alignment($input) {
        $menu_alignment = array(
            'default',
            'center',
            'right',
        );
        if ( in_array($input, $menu_alignment))
            return $input;
        else
            return '';
    }
}
add_action('customize_register', 'plum_customize_regster_menu_alignement');