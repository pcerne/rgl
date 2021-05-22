<?php

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_breadcrumbs' ) ) {
	function ilovewp_helper_display_breadcrumbs() {

		// CONDITIONAL FOR "Breadcrumb NavXT" plugin OR Yoast SEO Breadcrumbs
		// https://wordpress.org/plugins/breadcrumb-navxt/

		if ( function_exists('bcn_display') ) { ?>
		<div class="site-breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
			<p class="site-breadcrumbs-p"><?php bcn_display(); ?></p>
		</div><!-- .site-breadcrumbs--><?php }

		// CONDITIONAL FOR "Yoast SEO" plugin, Breadcrumbs feature
		// https://wordpress.org/plugins/wordpress-seo/
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<div class="site-breadcrumbs"><p class="site-breadcrumbs-p">','</p></div>');
		}

	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_title' ) ) {
	function ilovewp_helper_display_title($post) {

		if( ! is_object( $post ) ) return;
		the_title( '<h1 class="page-title">', '</h1>' );
	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_datetime' ) ) {
	function ilovewp_helper_display_datetime($post) {
		
		if( ! is_object( $post ) ) return;

		return '<p class="entry-descriptor"><span class="entry-descriptor-span"><time class="entry-date published" datetime="' . esc_attr(get_the_date('c')) . '">' . get_the_date() . '</time></span></p>';

	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_excerpt' ) ) {
	function ilovewp_helper_display_excerpt($post) {

		if( ! is_object( $post ) ) return;

		return '<p class="entry-excerpt">' . get_the_excerpt() . '</p>';

	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_comments' ) ) {
	function ilovewp_helper_display_comments($post) {

		if( ! is_object( $post ) ) return;

		if ( comments_open() || get_comments_number() ) :

			echo '<hr /><div id="ilovewp-comments"">';
			comments_template();
			echo '</div><!-- #ilovewp-comments -->';

		endif;

	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_content' ) ) {
	function ilovewp_helper_display_content($post) {

		if( ! is_object( $post ) ) return;

		echo '<div class="entry-content">';
			
			the_content();
			
			wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'podcast').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));

		echo '</div><!-- .entry-content -->';

	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_tags' ) ) {
	function ilovewp_helper_display_tags($post) {

		if( ! is_object( $post ) ) return;

		if ( get_post_type($post->ID) == 'post' ) { 
			the_tags( '<p class="post-meta post-tags"><strong>'.__('Tags', 'podcast').':</strong> ', ', ', '</p>');
		}

	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_postmeta' ) ) {
	function ilovewp_helper_display_postmeta($post) {

		if( ! is_object( $post ) ) return;

		if ( get_post_type($post->ID) == 'post' ) { 

			echo '<p class="entry-tagline">';
			echo '<span class="post-meta-span post-meta-span-time"><time datetime="' . esc_attr(get_the_time("Y-m-d")) . '" pubdate>' . esc_html(get_the_time(get_option('date_format'))) . '</time></span>';
			echo '<span class="post-meta-span post-meta-span-category">'; the_category(', '); echo '</span>';
			echo '</p><!-- .entry-tagline -->';

		}

	}
}

// Page/Post Title
if( ! function_exists( 'ilovewp_helper_display_page_sidebar_column' ) ) {
	function ilovewp_helper_display_page_sidebar_column() {

		?><div class="site-column site-column-aside">

			<div class="site-column-wrapper clearfix">

				<?php get_sidebar(); ?>

			</div><!-- .site-column-wrapper .clearfix -->

		</div><!-- .site-column .site-column-aside --><?php

	}
}

// Content Column Wrapper Start
if( ! function_exists( 'ilovewp_helper_display_page_content_wrapper_start' ) ) {
	function ilovewp_helper_display_page_content_wrapper_start() {

		?><div class="site-column site-column-content"><div class="site-column-wrapper clearfix"><!-- .site-column .site-column-1 .site-column-aside --><?php

	}
}

// Content Column Wrapper Start
if( ! function_exists( 'ilovewp_helper_display_page_content_wrapper_end' ) ) {
	function ilovewp_helper_display_page_content_wrapper_end() {

		?></div><!-- .site-column-wrapper .clearfix --></div><!-- .site-column .site-column-content --><?php

	}
}

// Get Sidebar Position for Current Page or Post
if( ! function_exists( 'ilovewp_helper_get_sidebar_position' ) ) {
	function ilovewp_helper_get_sidebar_position() {

		global $post;

		$themeoptions_sidebar_position = esc_attr(get_theme_mod( 'theme-sidebar-position', 'right' ));

		if ( $themeoptions_sidebar_position == 'left' ) {
			$default_position = 'page-sidebar-left';
		} else {
			$default_position = 'page-sidebar-right';
		}

		return $default_position;
	}
}

// Get Color Palette from Theme Options
if( ! function_exists( 'ilovewp_helper_get_color_palette' ) ) {
	function ilovewp_helper_get_color_palette() {

		global $post;

		$valid_palettes = array('black','blue','green','orange','purple','red','teal');
		$themeoptions_color_palette = esc_attr(get_theme_mod( 'theme-color-palette', 'teal' ));
		$class_string = 'theme-color-';

		if ( in_array($themeoptions_color_palette, $valid_palettes) ) {
			$class_string = $class_string . $themeoptions_color_palette;
		} else {
			$class_string = $class_string . 'teal';
		}

		return $class_string;
	}
}