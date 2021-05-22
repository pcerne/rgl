<?php
get_header();
?>

<main id="site-main">

	<?php if ( is_front_page() && !is_paged() ) { ?>
	<div class="page-intro-header">
		<div class="site-section-wrapper site-section-page-header-wrapper clearfix">

			<div id="site-home-welcome">

				<div class="site-columns site-columns-2 clearfix">
					<div class="site-column site-column-1">
						<div class="site-column-wrapper clearfix">

							<?php if ( 1 == get_theme_mod( 'podcast-display-latest-episode', 1 ) ) { 
								get_template_part( 'template-parts/content-home-post', 'home-featured' );
							} ?>

						</div><!-- .site-column-wrapper .clearfix -->
					</div><!-- .site-column .site-column-1 --><?php if ( is_active_sidebar('homepage-welcome-widgets-right') ) { ?><!-- ws fix
					--><div class="site-column site-column-2">
						<div class="site-column-wrapper clearfix">

							<?php dynamic_sidebar( 'homepage-welcome-widgets-right' ); ?>

						</div><!-- .site-column-wrapper .clearfix -->
					</div><!-- .site-column .site-column-2 --><?php } ?>
				</div><!-- .site-columns .site-columns-2 .clearfix -->

			</div><!-- #site-home-welcome .site-section -->

		</div><!-- .site-section-wrapper .site-section-page-header-wrapper .clearfix -->
	</div><!-- .page-intro-header -->
	<?php } ?>

	<?php if ( ( is_front_page() || is_home() ) && !is_paged() ) { ?>
	
	<?php if ( is_active_sidebar('homepage-subscribe') ) { ?>
	<div class="page-intro-subscribe">
		<div class="site-section-wrapper site-section-page-subscribe-wrapper clearfix">
			<?php dynamic_sidebar( 'homepage-subscribe' ); ?>
		</div><!-- .site-section-wrapper .site-section-page-subscribe-wrapper .clearfix -->
	</div><!-- .page-intro-subscribe -->
	<?php } // if subscribe bar has any widgets in it ?>

	<?php if ( 1 == get_theme_mod( 'podcast-display-pages', 1 ) ) {
		get_template_part( 'template-parts/content', 'home-featured' );
	} // if featured pages are activated

	} ?>

	<div class="site-page-content">
		<div class="site-section-wrapper site-section-wrapper-main clearfix">

			<?php

			// Function to display the START of the content column markup
			ilovewp_helper_display_page_content_wrapper_start(); ?>

			<?php 
			if ( have_posts() ) { 
				$i = 0; 
			
				if ( is_home() && ! is_front_page() ) { ?>
				<h1 class="page-title archives-title"><?php single_post_title(); ?></h1>
				<?php } ?>

				<?php if ( is_home() ) { ?><p class="page-title archives-title"><span class="page-title-span"><?php esc_html_e('Recent Posts','podcast'); ?></span></p><?php } ?>

				<?php get_template_part('loop');

			}

			// Function to display the END of the content column markup
			ilovewp_helper_display_page_content_wrapper_end();

			// Function to display the SIDEBAR (if not hidden)
			ilovewp_helper_display_page_sidebar_column();

			?>

		</div><!-- .site-section-wrapper .site-section-wrapper-main -->
	</div><!-- .site-page-content -->

</main><!-- #site-main -->

<?php
get_footer();
?>