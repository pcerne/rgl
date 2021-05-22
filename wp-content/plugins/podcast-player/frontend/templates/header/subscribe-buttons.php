<?php
/**
 * Podcast pod entry for episode entry list.
 *
 * This template can be overridden by copying it to yourtheme/podcast-player/header/subscribe-buttons.php.
 *
 * HOWEVER, on occasion Podcast Player will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Podcast Player
 * @version 1.0.0
 * @since   1.0.0
 */

use Podcast_Player\Helper\Functions\Markup as Markup_Fn;

if ( ! $this->args['apple-sub'] && ! $this->args['google-sub'] && ! $this->args['spotify-sub'] ) {
	return;
}

?>

<?php if ( $this->args['apple-sub'] ) : ?>
<a href="<?php echo esc_url( $this->args['apple-sub'] ); ?>" class="subscribe-item" target="_blank">
	<?php Markup_Fn::the_icon( array( 'icon' => 'pp-apple' ) ); ?>
	<span class="sub-text">
		<span class="sub-listen-text"><?php esc_html_e( 'Listen On', 'podcast-player' ); ?></span>
		<span class="sub-item-text"><?php esc_html_e( 'Apple Podcast', 'podcast-player' ); ?></span>
	</span>
</a>
<?php endif; ?>

<?php if ( $this->args['google-sub'] ) : ?>
<a href="<?php echo esc_url( $this->args['google-sub'] ); ?>" class="subscribe-item" target="_blank">
	<?php Markup_Fn::the_icon( array( 'icon' => 'pp-google' ) ); ?>
	<span class="sub-text">
		<span class="sub-listen-text"><?php esc_html_e( 'Listen On', 'podcast-player' ); ?></span>
		<span class="sub-item-text"><?php esc_html_e( 'Google Podcast', 'podcast-player' ); ?></span>
	</span>
</a>
<?php endif; ?>

<?php if ( $this->args['spotify-sub'] ) : ?>
<a href="<?php echo esc_url( $this->args['spotify-sub'] ); ?>" class="subscribe-item" target="_blank">
	<?php Markup_Fn::the_icon( array( 'icon' => 'pp-spotify' ) ); ?>
	<span class="sub-text">
		<span class="sub-listen-text"><?php esc_html_e( 'Listen On', 'podcast-player' ); ?></span>
		<span class="sub-item-text"><?php esc_html_e( 'Spotify', 'podcast-player' ); ?></span>
	</span>
</a>
<?php endif; ?>
