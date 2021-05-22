<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class podcast_notice_welcome extends podcast_notice {

	public function __construct() {
		
		add_action( 'wp_loaded', array( $this, 'welcome_notice' ), 20 );
		add_action( 'wp_loaded', array( $this, 'hide_notices' ), 15 );

	}

	public function welcome_notice() {
		
		$this_notice_was_dismissed = $this->get_notice_status('welcome');
		
		if ( !$this_notice_was_dismissed ) {
			if ( isset($_GET['page']) && 'podcast-doc' == $_GET['page'] ) {
				return;
			}

			add_action( 'admin_notices', array( $this, 'welcome_notice_markup' ) ); // Display this notice.
		}
		
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice_markup() {
		
		$dismiss_url = wp_nonce_url(
			remove_query_arg( array( 'activated' ), add_query_arg( 'podcast-hide-notice', 'welcome' ) ),
			'podcast_hide_notices_nonce',
			'_podcast_notice_nonce'
		);

		$theme_data	 = wp_get_theme();

		?>
		<div id="message" class="notice notice-success ilovewp-notice ilovewp-welcome-notice">
			<a class="ilovewp-message-close notice-dismiss" href="<?php echo esc_url( $dismiss_url ); ?>"></a>

			<div class="ilovewp-message-content">
				<div class="ilovewp-message-image">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=podcast-doc' ) ); ?>"><img class="ilovewp-screenshot" src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="<?php esc_attr_e( 'Podcast', 'podcast' ); ?>" /></a>
				</div><!-- ws fix
				--><div class="ilovewp-message-text">
					<h2 class="ilovewp-message-heading"><?php esc_html_e( 'Thank you for choosing Podcast Theme!', 'podcast' ); ?></h2>
					<?php
					echo '<p>';
						/* translators: %1$s: theme name, %2$s link */
						printf( __( 'To take advantage of everything that this theme can offer, please take a look at the <a href="%2$s">Get Started with %1$s</a> page. %3$sIf you like the free version of Podcast Theme, you will love the PLUS version. %3$s%4$s contains many improvements and features that were suggested by our users.', 'podcast' ), 
							esc_html( $theme_data->Name ), 
							esc_url( admin_url( 'themes.php?page=podcast-doc' )),
							'<br>',
							'<strong><a href="https://www.ilovewp.com/product/podcast-plus/">Podcast Plus</a></strong>' );
					echo '</p>';

					echo '<p class="notice-buttons">';
					echo '<a href="'. esc_url( admin_url( 'themes.php?page=podcast-doc' ) ) .'" class="button button-primary">';
						/* translators: %s theme name */
						printf( esc_html__( 'Get started with %s', 'podcast' ), esc_html( $theme_data->Name ) );
					echo '</a>';
					echo ' <a href="'. esc_url( 'https://youtu.be/-vHV7_FpFLY' ) .'" target="_blank" rel="noopener" class="button button-primary ilovewp-button ilovewp-button-youtube"><span class="dashicons dashicons-youtube"></span> ';
						/* translators: %s theme name */
						printf( esc_html__( '%s Video Guide', 'podcast' ), esc_html( $theme_data->Name ) );
					echo '</a>';
					echo ' <a href="'. esc_url( 'https://www.ilovewp.com/podcast-free-vs-podcast-plus-wordpress-themes-comparison/?utm_source=dashboard&utm_medium=customizer-page&utm_campaign=podcast&utm_content=comparison-link' ) .'" target="_blank" rel="noopener" class="button button-primary ilovewp-button"> ';
						/* translators: %s theme name */
						printf( esc_html__( 'Podcast vs Podcast Plus Comparison', 'podcast' ), esc_html( $theme_data->Name ) );
					echo '</a>';
					echo'</p>';
					?>
				</div><!-- .ilovewp-message-text -->
			</div><!-- .ilovewp-message-content -->
		</div><!-- #message -->
		<?php
	}

}

new podcast_notice_welcome();