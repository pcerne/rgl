<?php 
		if ( is_active_sidebar('footer-col-1') || is_active_sidebar('footer-col-2') ) { ?>

		<footer id="site-footer" class="site-section site-section-footer">
			<div class="site-section-wrapper site-section-wrapper-footer">

				<div class="site-columns site-columns-footer site-columns-2 clearfix">

					<?php
					$i = 0;
					$max = 2;
					while ($i < $max) { 
						$i++; 
						?><div class="site-column site-column-<?php echo esc_attr($i); ?>">
						<div class="site-column-wrapper clearfix">
							<?php if (is_active_sidebar('footer-col-' . esc_attr($i) )) { ?>
								<?php dynamic_sidebar( 'footer-col-' . esc_attr($i) ); ?>
							<?php } ?>
						</div><!-- .site-column-wrapper .clearfix -->
					</div><!-- .site-column .site-column-1 --><?php } ?>

				</div><!-- .site-columns .site-columns-footer .site-columns-2 .clearfix -->

			</div><!-- .site-section-wrapper .site-section-wrapper-footer -->

		</footer><!-- #site-footer .site-section-footer --><?php 
		}
		?>

		<div id="site-footer-credit">
			<div class="site-section-wrapper site-section-wrapper-footer-credit">
				<?php $copyright_default = __('Copyright &copy; ','podcast') . date("Y", time()) . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved. ', 'podcast'); ?>
				<p class="site-credit"><?php echo esc_html(get_theme_mod( 'footer-text', $copyright_default )); ?> <span class="theme-credit"><?php esc_html_e('Theme by', 'podcast'); ?> <a href="https://www.ilovewp.com/" rel="external nofollow designer noopener" target="_blank" title="Podcast WordPress Themes">ILoveWP.com</a></span></p>
			</div><!-- .site-section-wrapper .site-section-wrapper-footer-credit -->
		</div><!-- #site-footer-credit -->

	</div><!-- .site-wrapper-all .site-wrapper-boxed -->

</div><!-- #container -->

<?php 
wp_footer(); 
?>
</body>
</html>