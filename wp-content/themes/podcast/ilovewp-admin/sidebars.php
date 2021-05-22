<?php 

/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)																			 */
/*-----------------------------------------------------------------------------------*/

function podcast_widgets_init() {

	register_sidebar(array(
		'name' => __('Sidebar','podcast'),
		'id' => 'sidebar',
		'before_widget' => '<div class="widget %2$s clearfix" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<p class="widget-title">',
		'after_title' => '</p>',
	));

	register_sidebar(array(
		'name' => __('Homepage: Welcome Widgets (Right)','podcast'),
		'id' => 'homepage-welcome-widgets-right',
		'description' => __('Recommended widgets: An image widget, social icons widget, subscribe banners, etc.','podcast'),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content-wrapper">',
		'after_widget'  => '</div><!-- .widget-content-wrapper --></div>',
		'before_title' => '<p class="widget-title">',
		'after_title' => '</p>',
	));

	register_sidebar(array(
		'name' => __('Homepage: Subscribe Bar','podcast'),
		'id' => 'homepage-subscribe',
		'description' => __('We recommend adding a single [Text Widget]. The widget\'s title will be wrapped in a <h1></h1> tag.','podcast'),
		'before_widget' => '<div class="widget widget-welcome %2$s clearfix" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="title-welcome widget-title"><span class="page-title-span">',
		'after_title' => '</span></h1>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer: Column 1', 'podcast' ),
		'id'            => 'footer-col-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content-wrapper">',
		'after_widget'  => '</div><!-- .widget-content-wrapper --></div>',
		'before_title'  => '<p class="widget-title"><span>',
		'after_title'   => '</span></p>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer: Column 2', 'podcast' ),
		'id'            => 'footer-col-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content-wrapper">',
		'after_widget'  => '</div><!-- .widget-content-wrapper --></div>',
		'before_title'  => '<p class="widget-title"><span>',
		'after_title'   => '</span></p>',
	) );

} 

add_action( 'widgets_init', 'podcast_widgets_init' );