<?php
/**
 * Podcast episodes options page template
 *
 * @package Podcast Player
 * @since 1.0.0
 */

?>

<div class="updated notice is-dismissible pp-welcome-notice">
	<p class="intro-msg">
		<?php esc_html_e( 'Thanks for trying/updating Podcast Player.', 'podcast-player' ); ?>
	</p>
	<p><strong style="color: red;"><?php esc_html_e( 'Important: ', 'podcast-player' ); ?></strong><?php esc_html_e( 'If you are using a caching plugin, please clear (purge) the cache to update plugin CSS and JS files.', 'podcast-player' ); ?></p>
	<p>
		<a href="<?php echo esc_url( 'https://vedathemes.com/pp-demo/' ); ?>" target="_blank">
			<?php esc_html_e( 'Check Podcast Player Pro Demo Page', 'podcast-player' ); ?>
		</a>
	</p>
	<p>
		<a href="<?php echo esc_url( 'https://www.youtube.com/watch?v=5AO6CGZD-p8' ); ?>" target="_blank">
			<?php esc_html_e( 'Podcast Player Introductory Video', 'podcast-player' ); ?>
		</a>
	</p>
	<p>
		<a href="<?php echo esc_url( 'https://vedathemes.com/docs7/' ); ?>" target="_blank">
			<?php esc_html_e( 'Podcast Player Video Tutorials', 'podcast-player' ); ?>
		</a>
	</p>
	<h4 style="margin-bottom: 0.25em;padding: 5px;">
		<?php esc_html_e( 'What\'s New?', 'podcast-player' ); ?>
	</h4>
	<ol>
	<li class="premium">
		<?php esc_html_e( 'Compatibility with Ajax enabled themes and plugins.', 'podcast-player' ); ?>
	</li>
	<li class="premium">
		<?php esc_html_e( 'Option to hide podcast data from Page source. Useful if you are showing private podcasts on your website.', 'podcast-player' ); ?>
	</li>
	</ol>
	<p><strong style="color: orange;"><?php esc_html_e( 'Important Note: ', 'podcast-player' ); ?></strong><?php esc_html_e( 'If you are facing any issues after the recent update, please inform us at contact@vedathemes.com', 'podcast-player' ); ?></p>
	<div class="common-links">
		<p class="pp-link">
			<a href="https://wordpress.org/support/plugin/podcast-player/" target="_blank">
				<?php esc_html_e( 'Raise a support request', 'podcast-player' ); ?>
			</a>
		</p>
		<p class="pp-link">
			<a href="https://wordpress.org/support/plugin/podcast-player/reviews/" target="_blank">
				<?php esc_html_e( 'Give us 5 stars rating', 'podcast-player' ); ?>
			</a>
		</p>
		<p class="pp-link">
			<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'pp-dismiss', 'dismiss_admin_notices' ), 'pp-dismiss-' . get_current_user_id() ) ); ?>" target="_parent">
				<?php esc_html_e( 'Dismiss this notice', 'podcast-player' ); ?>
			</a>
		</p>
	</div>
</div>
