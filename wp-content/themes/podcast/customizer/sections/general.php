<?php

function ilovewp_customizer_define_general_sections( $sections ) {
    $panel           = 'ilovewp' . '_general';
    $general_sections = array();

    $theme_sidebar_positions = array(
        'left'      => esc_html__('Left', 'podcast'),
        'right'     => esc_html__('Right', 'podcast')
    );

    $theme_color_palettes = array(
        'black'         => esc_html__('Black', 'podcast'),
        'blue'          => esc_html__('Blue', 'podcast'),
        'green'         => esc_html__('Green', 'podcast'),
        'orange'        => esc_html__('Orange', 'podcast'),
        'purple'        => esc_html__('Purple', 'podcast'),
        'red'           => esc_html__('Red', 'podcast'),
        'teal'          => esc_html__('Teal', 'podcast')
    );

    $general_sections['general'] = array(
        'title'     => esc_html__( 'Theme Settings', 'podcast' ),
        'priority'  => 4900,
        'options'   => array(

            'theme-color-palette'    => array(
                'setting'               => array(
                    'default'           => 'black',
                    'sanitize_callback' => 'ilovewp_sanitize_text'
                ),
                'control'           => array(
                    'label'         => esc_html__( 'Theme Color Palette', 'podcast' ),
                    'type'          => 'select',
                    'choices'       => $theme_color_palettes
                ),
            ),

            'theme-sidebar-position'    => array(
                'setting'               => array(
                    'default'           => 'right',
                    'sanitize_callback' => 'ilovewp_sanitize_text'
                ),
                'control'           => array(
                    'label'         => esc_html__( 'Default Sidebar Position', 'podcast' ),
                    'type'          => 'select',
                    'choices'       => $theme_sidebar_positions
                ),
            ),

            'podcast-display-latest-episode' => array(
                'setting'               => array(
                    'sanitize_callback' => 'absint',
                    'default'           => 0
                ),
                'control'               => array(
                    'label'             => __( 'Display Newest Episode Block on Homepage', 'podcast' ),
                    'type'              => 'checkbox'
                )
            ),

            'podcast-episodes-category'  => array(
                'setting'               => array(
                    'default'           => '1',
                    'sanitize_callback' => 'podcast_sanitize_categories'
                ),
                'control'               => array(
                    'label'             => esc_html__( 'Category containing Episodes', 'podcast' ),
                    'description'       => /* translators: link to categories */ sprintf( wp_kses( __( 'This list is populated with <a href="%1$s">Categories</a>.', 'podcast' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit-tags.php?taxonomy=category' ) ) ),
                    'type'              => 'select',
                    'choices'           => podcast_get_categories()
                ),
            ),

            'podcast-episodes-label' => array(
                'setting'               => array(
                    'sanitize_callback' => 'ilovewp_sanitize_text',
                    'default'           => esc_html__( 'Newest Episode', 'podcast' ),
                ),
                'control'               => array(
                    'label'             => __( 'Post Block Heading', 'podcast' ),
                    'type'              => 'text'
                )
            ),

            'podcast-display-pages'    => array(
                'setting'               => array(
                    'sanitize_callback' => 'absint',
                    'default'           => 0
                ),
                'control'               => array(
                    'label'             => __( 'Display Featured Pages on Homepage', 'podcast' ),
                    'type'              => 'checkbox'
                )
            ),

            'podcast-featured-page-1'  => array(
                'setting'               => array(
                    'default'           => 'none',
                    'sanitize_callback' => 'podcast_sanitize_pages'
                ),
                'control'               => array(
                    'label'             => esc_html__( 'Featured Page #1', 'podcast' ),
                    'description'       => /* translators: link to pages */ sprintf( wp_kses( __( 'This list is populated with <a href="%1$s">Pages</a>.', 'podcast' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=page' ) ) ),
                    'type'              => 'dropdown-pages',
                    'choices'           => podcast_get_pages()
                ),
            ),

            'podcast-featured-page-2'  => array(
                'setting'               => array(
                    'default'           => 'none',
                    'sanitize_callback' => 'podcast_sanitize_pages'
                ),
                'control'               => array(
                    'label'             => esc_html__( 'Featured Page #2', 'podcast' ),
                    'type'              => 'dropdown-pages',
                    'choices'           => podcast_get_pages()
                ),
            ),

            'podcast-featured-page-3'  => array(
                'setting'               => array(
                    'default'           => 'none',
                    'sanitize_callback' => 'podcast_sanitize_pages'
                ),
                'control'               => array(
                    'label'             => esc_html__( 'Featured Page #3', 'podcast' ),
                    'type'              => 'dropdown-pages',
                    'choices'           => podcast_get_pages()
                ),
            ),

        ),
    );

    return array_merge( $sections, $general_sections );
}

add_filter( 'ilovewp_customizer_sections', 'ilovewp_customizer_define_general_sections' );
