<?php
/**
 * The template used for displaying the latest podcast episode on the Front Page.
 *
 * @package Podcast
 */
?>

<?php

	$featured_category = get_theme_mod( 'podcast-episodes-category' , 1 );
	$featured_label = get_theme_mod( 'podcast-episodes-label' , esc_html__( 'Newest Episode', 'podcast' ) );
	
	$custom_loop = new WP_Query( array(
		'post_type'      => 'post',
		'posts_per_page' => 1,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'cat' 		 	 => absint($featured_category)
	) );

	?>

	<?php if ( $custom_loop->have_posts() ) : ?>
				
		<?php while ( $custom_loop->have_posts() ) : $custom_loop->the_post(); ?>

			<?php $classes = array('ilovewp-featured-post', 'clearfix'); ?>
			
			<div <?php post_class($classes); ?>>
				<p class="entry-tagline"><span class="post-meta-span post-meta-span-headline"><?php echo esc_html($featured_label); ?></span><span class="post-meta-span"><time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo get_the_date(); ?></time></span></p>
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<p class="entry-excerpt"><?php echo get_the_excerpt(); ?></p>
			</div><!-- .ilvoewp-featured-post .clearfix -->
		
		<?php endwhile; ?>
	
		<?php wp_reset_postdata(); ?>
	
	<?php endif; 