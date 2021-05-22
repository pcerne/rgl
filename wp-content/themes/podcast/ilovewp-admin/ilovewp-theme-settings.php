<?php
/**
 * Define Constants
 */
if( ! defined( 'ILOVEWP_SHORTNAME' ) ) {
	define( 'ILOVEWP_SHORTNAME', 'podcast' );
}
if( ! defined( 'ILOVEWP_PAGE_BASENAME' ) ) {
	define( 'ILOVEWP_PAGE_BASENAME', 'podcast-doc' );
}
if( ! defined( 'ILOVEWP_THEME_DETAILS' ) ) {
	define( 'ILOVEWP_THEME_DETAILS', 'https://www.ilovewp.com/themes/podcast/?utm_source=dashboard&utm_medium=doc-page&utm_campaign=podcast&utm_content=theme-details-link' );
}
if( ! defined( 'ILOVEWP_THEME_DEMO' ) ) {
	define( 'ILOVEWP_THEME_DEMO', 'https://demo.ilovewp.com/?theme=podcast&utm_source=dashboard&utm_medium=doc-page&utm_campaign=podcast&utm_content=demo-link' );
}
if( ! defined( 'ILOVEWP_THEME_VIDEO_GUIDE' ) ) {
	define( 'ILOVEWP_THEME_VIDEO_GUIDE', 'https://youtu.be/-vHV7_FpFLY');
}
if( ! defined( 'ILOVEWP_THEME_VIDEO_COMPARISON' ) ) {
	define( 'ILOVEWP_THEME_VIDEO_COMPARISON', 'https://youtu.be/nqlX_ZfMkfA');
}
if( ! defined( 'ILOVEWP_THEME_DOCUMENTATION_URL' ) ) {
	define( 'ILOVEWP_THEME_DOCUMENTATION_URL', 'https://www.ilovewp.com/documentation/podcast/?utm_source=dashboard&utm_medium=doc-page&utm_campaign=podcast&utm_content=documentation-link' );
}
if( ! defined( 'ILOVEWP_THEME_SUPPORT_FORUM_URL' ) ) {
	define( 'ILOVEWP_THEME_SUPPORT_FORUM_URL', 'https://wordpress.org/support/theme/podcast/' );
}
if( ! defined( 'ILOVEWP_THEME_REVIEW_URL' ) ) {
	define( 'ILOVEWP_THEME_REVIEW_URL', 'https://wordpress.org/support/theme/podcast/reviews/#new-post' );
}
if( ! defined( 'ILOVEWP_THEME_UPGRADE_URL' ) ) {
	define( 'ILOVEWP_THEME_UPGRADE_URL', 'https://www.ilovewp.com/product/podcast-plus/?utm_source=dashboard&utm_medium=doc-page&utm_campaign=podcast&utm_content=upgrade-button' );
}
if( ! defined( 'ILOVEWP_THEME_DEMO_IMPORT_URL' ) ) {
	define( 'ILOVEWP_THEME_DEMO_IMPORT_URL', false );
}

/**
 * Specify Hooks/Filters
 */
add_action( 'admin_menu', 'ilovewp_add_menu' );

/**
* The admin menu pages
*/
function ilovewp_add_menu(){
	
	add_theme_page( __('Podcast Theme','podcast'), __('Podcast Theme','podcast'), 'edit_theme_options', ILOVEWP_PAGE_BASENAME, 'ilovewp_settings_page_doc' ); 

}

// ************************************************************************************************************

/*
 * Theme Documentation Page HTML
 * 
 * @return echoes output
 */
function ilovewp_settings_page_doc() {
	// get the settings sections array
	$theme_data = wp_get_theme();
	?>
	
	<div class="ilovewp-wrapper">
		<div class="ilovewp-header">
			<div id="ilovewp-theme-info">
				<div class="ilovewp-message-image">
					<img class="ilovewp-screenshot" src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="<?php esc_attr_e( 'Podcast Theme Screenshot', 'podcast' ); ?>" />
				</div><!-- ws fix
				--><p><?php 

					echo sprintf( 
					/* translators: Theme name and version */
					__( '<span class="theme-name">%1$s Lite Theme</span> <span class="theme-version">(version %2$s)</span>', 'podcast' ), 
					esc_html($theme_data->name),
					esc_html($theme_data->version)
					); ?></p>
					<p class="theme-buttons"><a class="button button-primary" href="<?php echo esc_url(ILOVEWP_THEME_DETAILS); ?>" rel="noopener" target="_blank"><?php esc_html_e('Theme Details','podcast'); ?></a>
				<a class="button button-primary" href="<?php echo esc_url(ILOVEWP_THEME_DEMO); ?>" rel="noopener" target="_blank"><?php esc_html_e('Theme Demo','podcast'); ?></a>
				<?php if ( ILOVEWP_THEME_VIDEO_GUIDE ) { ?><a class="button button-primary ilovewp-button ilovewp-button-youtube" href="<?php echo esc_url(ILOVEWP_THEME_VIDEO_GUIDE); ?>" rel="noopener" target="_blank"><span class="dashicons dashicons-youtube"></span> <?php esc_html_e('Theme Video Tutorial','podcast'); ?></a><?php } ?></p>
			</div><!-- #ilovewp-theme-info --><!-- ws fix
			--><div id="ilovewp-logo">
				<a href="https://www.ilovewp.com/?utm_source=dashboard&utm_medium=doc-page&utm_campaign=podcast&utm_content=ilovewp-logo" target="_blank" rel="noopener"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/ilovewp-admin/images/ilovewp-options-logo.png" width="153" height="33" alt="<?php esc_attr_e('ILoveWP.com Logo','podcast'); ?>" /></a>
			</div><!-- #ilovewp-logo -->
		</div><!-- .ilovewp-header -->
		
		<div class="ilovewp-documentation">

			<ul class="ilovewp-doc-columns clearfix">
				<li class="ilovewp-doc-column ilovewp-doc-column-1">
					<div class="ilovewp-doc-column-wrapper">
						<div class="doc-section">
							<h3 class="column-title"><span class="ilovewp-icon dashicons dashicons-editor-help"></span><span class="ilovewp-title-text"><?php esc_html_e('Documentation and Support','podcast'); ?></span></h3>
							<div class="ilovewp-doc-column-text-wrapper">
								<?php if ( ILOVEWP_THEME_LITE && ILOVEWP_THEME_SUPPORT_FORUM_URL ) { ?><p><?php 
								echo sprintf( 
								/* translators: Theme name and link to WordPress.org Support forum for the theme */
								__( 'Support for %1$s Theme is provided in the official WordPress.org community support forums. ', 'podcast' ), 
								esc_html($theme_data->name)	); ?></p><?php } elseif ( ILOVEWP_THEME_PRO ) { ?>
									<p><?php esc_html_e('The usual response time is less than 45 minutes during regular work hours, Monday through Friday, 9:00am - 6:00pm (GMT+01:00). <br>Response time can be slower outside of these hours.','podcast'); ?></p>
								<?php } ?>

								<p class="doc-buttons"><a class="button button-primary" href="<?php echo esc_url(ILOVEWP_THEME_DOCUMENTATION_URL); ?>" rel="noopener" target="_blank"><?php esc_html_e('View Podcast Documentation','podcast'); ?></a><?php if ( ILOVEWP_THEME_SUPPORT_FORUM_URL ) { ?> <a class="button button-secondary" href="<?php echo esc_url(ILOVEWP_THEME_SUPPORT_FORUM_URL); ?>" rel="noopener" target="_blank"><?php esc_html_e('Go to Podcast Support Forum','podcast'); ?></a><?php } ?></p>

							</div><!-- .ilovewp-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
						<?php if ( ILOVEWP_THEME_VIDEO_GUIDE ) { ?>
						<div class="doc-section">

							<h3 class="column-title"><span class="ilovewp-icon dashicons dashicons-youtube"></span><span class="ilovewp-title-text"><?php esc_html_e('Theme Video Tutorial','podcast'); ?></span></h3>
							<div class="ilovewp-doc-column-text-wrapper">
							
								<p><strong><?php esc_html_e('Click the image below to open the video guide in a new browser tab.','podcast'); ?></strong></p>
								<p><a href="<?php echo esc_url(ILOVEWP_THEME_VIDEO_GUIDE); ?>" rel="noopener" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/ilovewp-admin/images/podcast-video-preview.jpg" class="video-preview" alt="<?php esc_attr_e('Podcast Theme Video Tutorial','podcast'); ?>" /></a></p>

							</div><!-- .ilovewp-doc-column-text-wrapper-->

						</div><!-- .doc-section -->
						<?php } ?>
						<div class="doc-section">
							<?php
							$current_user = wp_get_current_user();

							?>
							<h3 class="column-title"><span class="ilovewp-icon dashicons dashicons-email-alt"></span><span class="ilovewp-title-text"><?php esc_html_e('Subscribe to our newsletter','podcast'); ?></span></h3>
							<div class="ilovewp-doc-column-text-wrapper">
								<form action="https://ilovewp.us14.list-manage.com/subscribe/post?u=b9a9c29fe8fb1b02d49b2ba2b&amp;id=18a2e743db" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
									<p class="newsletter-description"><?php esc_html_e('We send out the newsletter once every few months. It contains information about our new themes and important theme updates.','podcast'); ?></p>
									<div id="mc_embed_signup_scroll" style="margin: 24px 0; ">
										<input type="email" value="<?php echo esc_attr($current_user->user_email); ?>" name="EMAIL" class="email" id="mce-EMAIL" style="min-width: 250px; padding: 2px 8px;" placeholder="email address" required="">
										<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
										<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_b9a9c29fe8fb1b02d49b2ba2b_18a2e743db" tabindex="-1" value=""></div>
										<input type="submit" value="<?php esc_attr_e('Subscribe','podcast'); ?>" name="subscribe" id="mc-embedded-subscribe" class="button button-primary">
									</div><!-- #mc_embed_signup_scroll -->
									<p class="newsletter-disclaimer" style="font-size: 14px;"><?php esc_html_e('We use Mailchimp as our marketing platform. By clicking above to subscribe, you acknowledge that your information will be transferred to Mailchimp for processing.','podcast'); ?></p>
								</form>

							</div><!-- .ilovewp-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
					</div><!-- .ilovewp-doc-column-wrapper -->
				</li><!-- .ilovewp-doc-column --><li class="ilovewp-doc-column ilovewp-doc-column-2">
					<div class="ilovewp-doc-column-wrapper">
						<?php if ( ILOVEWP_THEME_UPGRADE_URL ) { ?>
						<div class="doc-section">
							<h3 class="column-title"><span class="ilovewp-icon dashicons dashicons-cart"></span><span class="ilovewp-title-text"><?php esc_html_e('Upgrade to Podcast Plus','podcast'); ?></span></h3>
							<div class="ilovewp-doc-column-text-wrapper">
								<p><?php 
								echo sprintf( 
								/* translators: Theme name and link to WordPress.org Support forum for the theme */
								__( 'If you like the free version of %1$s Theme, you will love the PRO version.', 'podcast' ), 
								esc_html($theme_data->name)	); ?></p>
								<p><?php esc_html_e('Podcast Plus contains many improvements and features that were suggested by the users of the free Podcast theme.','podcast'); ?><br>

								<p class="doc-buttons"><a class="button button-primary" href="<?php echo esc_url(ILOVEWP_THEME_UPGRADE_URL); ?>" rel="noopener" target="_blank"><?php esc_html_e('Upgrade to Podcast Plus','podcast'); ?></a><?php if ( ILOVEWP_THEME_VIDEO_COMPARISON ) { ?><a class="button button-primary ilovewp-button ilovewp-button-youtube" href="<?php echo esc_url(ILOVEWP_THEME_VIDEO_COMPARISON); ?>" rel="noopener" target="_blank"><span class="dashicons dashicons-youtube"></span> <?php esc_html_e('Podcast vs Podcast Plus - Video Comparison','podcast'); ?></a><?php } ?></p>

								<table class="theme-comparison-table">
									<tr>
										<th class="table-feature-title"><?php esc_html_e('Feature','podcast'); ?></th>
										<th class="table-lite-value"><?php esc_html_e('Podcast','podcast'); ?></th>
										<th class="table-pro-value"><?php esc_html_e('Podcast Plus','podcast'); ?></th>
									</tr>
									<tr>
										<td><div class="ilovewp-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="ilovewp-tooltiptext"><?php esc_html_e('You can use the theme on any number of websites for as long as you wish.','podcast'); ?></span></div><?php esc_html_e('Unlimited theme usage','podcast'); ?></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Responsive Layout','podcast'); ?></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Color Customization','podcast'); ?></td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><div class="ilovewp-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="ilovewp-tooltiptext"><?php esc_html_e('Change the font and font size for the main elements on the website directly from the Customizer.','podcast'); ?></span></div><?php esc_html_e('Font Customization','podcast'); ?></td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span> <strong><?php esc_html_e('1000+ Google Fonts','podcast'); ?></strong></td>
									</tr>
									<tr>
										<td><div class="ilovewp-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="ilovewp-tooltiptext"><?php esc_html_e('Enable/disable the primary and secondary sidebars for the full website.','podcast'); ?></span></div><?php esc_html_e('Sidebar Location Controls','podcast'); ?></td>
										<td><div class="ilovewp-tooltip"><?php esc_html_e('Left or Right','podcast'); ?><span class="ilovewp-tooltiptext"><?php esc_html_e('Support is provided in the WordPress.org community forums.','podcast'); ?></span></div></td>
										<td><div class="ilovewp-tooltip"><strong><?php esc_html_e('Left, Right or None','podcast'); ?></strong><span class="ilovewp-tooltiptext"><?php esc_html_e('Quick and friendly support is available via email and Skype.','podcast'); ?></span></div></td>
									</tr>
									<tr>
										<td><div class="ilovewp-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="ilovewp-tooltiptext"><?php esc_html_e('Select the sidebar location individually for each page or post.','podcast'); ?></span></div><?php esc_html_e('Individual Layout Settings','podcast'); ?></td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><div class="ilovewp-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="ilovewp-tooltiptext"><?php esc_html_e('Import the demo content for an easier start with the theme.','podcast'); ?></span></div><?php esc_html_e('Demo Content Importer','podcast'); ?></td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Custom Block Patterns','podcast'); ?></td>
										<td><?php esc_html_e('0','podcast'); ?></td>
										<td><?php esc_html_e('4','podcast'); ?></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Widgetized Areas','podcast'); ?></td>
										<td><?php esc_html_e('5','podcast'); ?></td>
										<td><?php esc_html_e('11','podcast'); ?></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Support','podcast'); ?></td>
										<td><div class="ilovewp-tooltip"><?php esc_html_e('Nonpriority','podcast'); ?><span class="ilovewp-tooltiptext"><?php esc_html_e('Support is provided in the WordPress.org community forums.','podcast'); ?></span></div></td>
										<td><div class="ilovewp-tooltip"><strong><?php esc_html_e('Priority Support','podcast'); ?></strong><span class="ilovewp-tooltiptext"><?php esc_html_e('Quick and friendly support is available via email and Skype.','podcast'); ?></span></div></td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: center;"><a class="button button-primary" href="<?php echo esc_url(ILOVEWP_THEME_UPGRADE_URL); ?>" rel="noopener" target="_blank"><?php esc_html_e('Upgrade to Podcast Plus','podcast'); ?></a> &nbsp; <a class="button button-secondary" href="https://www.ilovewp.com/podcast-free-vs-podcast-plus-wordpress-themes-comparison/?utm_source=dashboard&utm_medium=doc-page&utm_campaign=podcast&utm_content=comparison-link" rel="noopener" target="_blank"><?php esc_html_e('See a Detailed Comparison','podcast'); ?></a>
										</td>
									</tr>
								</table>

							</div><!-- .ilovewp-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
						<?php } ?>
						<?php if ( ILOVEWP_THEME_REVIEW_URL ) { ?>
						<div class="doc-section">
							<h3 class="column-title"><span class="ilovewp-icon dashicons dashicons-awards"></span><span class="ilovewp-title-text"><?php esc_html_e('Leave a Review','podcast'); ?></span></h3>
							<div class="ilovewp-doc-column-text-wrapper">
								<p><?php esc_html_e('If you enjoy using Podcast Theme, please leave a review for it on WordPress.org. It helps us continue providing updates and support for it.','podcast'); ?></p>

								<p class="doc-buttons"><a class="button button-primary" href="<?php echo esc_url(ILOVEWP_THEME_REVIEW_URL); ?>" rel="noopener" target="_blank"><?php esc_html_e('Write a Review for Podcast','podcast'); ?></a></p>

							</div><!-- .ilovewp-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
						<?php } ?>
					</div><!-- .ilovewp-doc-column-wrapper -->
				</li><!-- .ilovewp-doc-column -->
			</ul><!-- .ilovewp-doc-columns -->

		</div><!-- .ilovewp-documentation -->

	</div><!-- .ilovewp-wrapper -->

<?php }