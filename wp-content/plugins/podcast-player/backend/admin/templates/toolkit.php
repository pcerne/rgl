<?php
/**
 * Podcast player toolkit page
 *
 * @package Podcast Player
 * @since 3.3.0
 */

use Podcast_Player\Helper\Functions\Getters as Get_Fn;

$feed_index = Get_Fn::get_feed_index();
$keep_old   = Get_Fn::get_plugin_option( 'keep_old' );
?>

<div class="pp-toolkit-page">
	<div class="pp-toolkit-wrapper">
		<h3 class="pp-toolkit-title">Feed Updation Tool</h3>
		<div class="pp-toolkit-content">
			<div class="pp-opt-desc" style="margin-bottom: 20px;">
				<?php esc_html_e( 'This tool is NOT for displaying the podcast. It is only for manually updating the podcast for latest changes. To know how to display podcast player, refer ', 'podcast-player' ); ?>
				<?php $this->mlink( 'https://vedathemes.com/docs7/', 'documentation' ); ?>
			</div>
			<?php if ( $feed_index && is_array( $feed_index ) ) : ?>
				<?php
				$feed_index = array_merge(
					array( '' => esc_html__( 'Select a Podcast to update / reset', 'podcast-player' ) ),
					$feed_index
				);
				?>
				<select id="pp-feed-index" name="pp-feed-index" class="select-pp-feed-index">
					<?php
					foreach ( $feed_index as $key => $label ) {
						if ( is_array( $label ) ) {
							$label = isset( $label['title'] ) ? $label['title'] : '';
						}
						echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</option>';
					}
					?>
				</select>
				<h4 class="pp-index-optional" style="padding: 0 20px;"><?php esc_html_e( 'OR', 'podcast-player' ); ?></h4>
			<?php endif; ?>
			<input class="pp-toolkit-url" type="url" placeholder="Enter Your Podcast Feed URL" title="Feed Editor">
			<button class="pp-toolkit-buttons pp-feed-refresh button">
				<span class="dashicons dashicons-update"></span>
				<span class="pp-toolkit-btn-text">Update Feed</span>
			</button>
			<button class="pp-toolkit-buttons pp-feed-reset button">
				<span class="dashicons dashicons-trash"></span>
				<span class="pp-toolkit-btn-text">Reset Feed</span>
			</button>
			<div class="pp-toolkit-feedback">
				<span class="dashicons dashicons-update"></span>
				<span class="dashicons dashicons-no"></span>
				<span class="dashicons dashicons-yes"></span>
				<span class="pp-feedback"></span>
			</div>
		</div>
	</div>
</div>
