<?php
/**
 * Load front-end resources.
 *
 * @link       https://www.vedathemes.com
 * @since      1.0.0
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/public
 */

namespace Podcast_Player\Frontend\Inc;

use Podcast_Player\Frontend\Inc\Instance_Counter;
use Podcast_Player\Helper\Functions\Markup as Markup_Fn;

/**
 * Load front-end resources.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/public
 * @author     vedathemes <contact@vedathemes.com>
 */
class Loader {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * Class cannot be instantiated directly.
	 *
	 * @since  1.0.0
	 */
	private function __construct() {}

	/**
	 * Enqueue mediaelement migrate error-fix script.
	 *
	 * Mediaelement migrate WP script forces to use 'mejs-' class prefix for all
	 * mediaelements. Podcast player only work with 'ppjs__' class prefix. Hence,
	 * fixing this issue.
	 *
	 * All javascripts should be loaded in footer, however many times plugins
	 * load mediaelement files in head, which can break podcast player. If
	 * mediaelement-migrate is enqueued in head, then mm-error-fix must also be
	 * loaded in head before mediaelement-migrate script.
	 *
	 * @since    1.0.0
	 */
	public function mm_error_fix() {

		// Return if mediaelement is not enqueued.
		if ( ! wp_script_is( 'mediaelement-migrate' ) ) {
			return;
		}

		// Mediaelement is loaded in footer.
		if ( $this->is_mediaelement_in_footer() ) {
			return;
		}

		// Enqueue mediaelement error fix script.
		$this->enqueue_mm_error_fix( false );

		// Move mm error fix script to top of the queue.
		$this->move_mm_errorfix_to_top();
	}

	/**
	 * Check if mediaelement is loaded in footer.
	 *
	 * @since    1.0.0
	 */
	public function is_mediaelement_in_footer() {
		$scripts = wp_scripts();
		$queue   = $scripts->queue;
		$in_head = array();
		foreach ( $queue as $handle ) {
			if ( ! $scripts->get_data( $handle, 'group' ) ) {
				array_push( $in_head, $handle );
			}
		}
		$is_mm_in_head = in_array( 'mediaelement-migrate', $in_head, true );
		if ( ! $is_mm_in_head && ! empty( $in_head ) ) {
			$is_mm_in_head = $this->recurse_deps( $in_head, 'mediaelement-migrate' );
		}

		return ! $is_mm_in_head;
	}

	/**
	 * Recursively search the passed dependency tree for $handle.
	 *
	 * @since 4.0.0
	 *
	 * @param string[] $queue  An array of queued _WP_Dependency handles.
	 * @param string   $handle Name of the item. Should be unique.
	 * @return bool Whether the handle is found after recursively searching the dependency tree.
	 */
	public function recurse_deps( $queue, $handle ) {
		$scripts  = wp_scripts();
		$all_deps = array_fill_keys( $queue, true );
		$queues   = array();
		$done     = array();

		while ( $queue ) {
			foreach ( $queue as $queued ) {
				if ( ! isset( $done[ $queued ] ) && isset( $scripts->registered[ $queued ] ) ) {
					$deps = $scripts->registered[ $queued ]->deps;
					if ( $deps ) {
						$all_deps += array_fill_keys( $deps, true );
						array_push( $queues, $deps );
					}
					$done[ $queued ] = true;
				}
			}
			$queue = array_pop( $queues );
		}
		return isset( $all_deps[ $handle ] );
	}

	/**
	 * Enqueue mediaelement migrate error-fix script.
	 *
	 * @since    1.0.0
	 *
	 * @param bool $in_footer whether to load script in footer.
	 */
	public function enqueue_mm_error_fix( $in_footer ) {
		wp_enqueue_script(
			'podcast-player-mmerrorfix',
			PODCAST_PLAYER_URL . 'frontend/js/mmerrorfix.js',
			array( 'jquery', 'mediaelement-core' ),
			PODCAST_PLAYER_VERSION,
			$in_footer
		);
	}

	/**
	 * Enqueue mediaelement migrate error-fix script.
	 *
	 * @since    1.0.0
	 */
	public function move_mm_errorfix_to_top() {
		$scripts = wp_scripts();
		$queue   = $scripts->queue;
		$key     = array_search( 'podcast-player-mmerrorfix', $queue, true );
		if ( false !== $key ) {
			unset( $queue[ $key ] );
			$scripts->queue = array_merge( array( 'podcast-player-mmerrorfix' ), $queue );
		}
	}

	/**
	 * Enqueue podcast player front-end styles and scripts in footer.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_resources() {

		// Return if podcast player is not available on the page.
		if ( ! $this->has_podcast_player() ) {
			return;
		}

		// Enqueue podcast player styles.
		$this->enqueue_styles();

		// Load mm error fix script if not already loaded.
		if ( ! wp_script_is( 'podcast-player-mmerrorfix' ) ) {
			$this->enqueue_mm_error_fix( true );
			$this->move_mm_errorfix_to_top();
		}

		// Enqueue podcast player scripts.
		$this->enqueue_scripts();

	}

	/**
	 * Enqueue front-end styles and scripts in elementor preview screen.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_elementor_resources() {

		// Enqueue podcast player styles.
		$this->enqueue_styles();

		// Load mm error fix script if not already loaded.
		if ( ! wp_script_is( 'podcast-player-mmerrorfix' ) ) {
			$this->enqueue_mm_error_fix( true );
			$this->move_mm_errorfix_to_top();
		}

		// Enqueue podcast player scripts.
		$this->enqueue_scripts();

		// This files defines all svg icons used by the plugin.
		require_once PODCAST_PLAYER_DIR . 'frontend/images/icons.svg';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'pppublic',
			PODCAST_PLAYER_URL . 'frontend/css/podcast-player-public.css',
			array(),
			PODCAST_PLAYER_VERSION,
			'all'
		);
		wp_style_add_data( 'pppublic', 'rtl', 'replace' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// Scripts data.
		$cdata         = apply_filters( 'podcast_player_script_data', array() );
		$ppjs_settings = apply_filters( 'podcast_player_mediaelement_settings', array() );

		/**
		 * Register public facing javascripts.
		 */
		wp_enqueue_script(
			'pppublic',
			PODCAST_PLAYER_URL . 'frontend/js/public.build.js',
			array( 'jquery', 'mediaelement-core' ),
			PODCAST_PLAYER_VERSION,
			true
		);

		wp_localize_script( 'pppublic', 'podcastPlayerData', $cdata );
		wp_localize_script( 'pppublic', 'ppmejsSettings', $ppjs_settings );

	}

	/**
	 * Add SVG definitions to the site footer.
	 *
	 * @since 1.0.0
	 */
	public function svg_icons() {

		// Return if podcast player is not available on the page.
		if ( ! $this->has_podcast_player() ) {
			return;
		}

		// This files defines all svg icons used by the plugin.
		require_once PODCAST_PLAYER_DIR . 'frontend/images/icons.svg';
	}

	/**
	 * Media Element player settings.
	 *
	 * @param array $settings Array of mejs settings.
	 * @since 1.0.0
	 */
	public function mejs_settings( $settings = array() ) {
		$markup = $this->get_js_templates();
		$mejs   = array(
			'pluginPath'  => includes_url( 'js/mediaelement/', 'relative' ),
			'classPrefix' => 'ppjs__',
			'stretching'  => 'responsive',
			'isPremium'   => false,
			'features'    => array( 'current', 'progress', 'duration', 'fullscreen' ),
		);
		return array_merge( $mejs, $markup, $settings );
	}

	/**
	 * Media Element player modern icons.
	 *
	 * @since 1.0.0
	 */
	public function get_js_templates() {
		$templates = array(
			'ppPauseBtn'    => 'pp-pause',
			'ppClose'       => 'pp-x',
			'ppMaxiScrnBtn' => 'pp-maximize',
			'ppMiniScrnBtn' => 'pp-minimize',
			'ppMinMax'      => 'pp-drop-down',
			'ppPlayCircle'  => 'pp-play',
			'ppVidLoading'  => 'pp-refresh',
		);

		// Create icons markup.
		$templates = array_map(
			function( $icon ) {
				return Markup_Fn::get_icon( array( 'icon' => $icon ) );
			},
			$templates
		);

		// Add audio control button's markup.
		$controls = '';
		$template = Markup_Fn::locate_template( 'misc/js', 'controls' );
		if ( $template ) {
			ob_start();
			require $template;
			$controls = ob_get_clean();
		}
		$templates['ppAudioControlBtns'] = $this->remove_breaks( $controls );

		// Add play pause button for video.
		$ppbtn    = '';
		$template = Markup_Fn::locate_template( 'misc/buttons', 'playpause' );
		if ( $template ) {
			ob_start();
			require $template;
			$ppbtn = ob_get_clean();
		}
		$templates['ppPlayPauseBtn'] = $this->remove_breaks( $ppbtn );

		// Screen reader text to close/Minimize the player.
		$templates['ppCloseBtnText'] = sprintf(
			'<span class="ppjs__offscreen">%s</span>',
			esc_html__( 'Minimize or Close the player', 'podcast-player' )
		);

		return $templates;
	}

	/**
	 * Check if podcast player display class is instantiated.
	 *
	 * @since 1.0.0
	 */
	public function has_podcast_player() {
		// Always load scripts on customizer preview screen.
		if ( is_customize_preview() ) {
			return true;
		}

		$pp         = Instance_Counter::get_instance();
		$has_player = $pp->has_podcast_player();

		return apply_filters( 'podcast_player_has_podcast', $has_player );
	}

	/**
	 * Remove breaks from HTML tags.
	 *
	 * @since 1.0.0
	 *
	 * @param string $string String to be processed.
	 */
	private function remove_breaks( $string ) {
		return preg_replace( '~>\\s+<~m', '><', $string );
	}

	/**
	 * Returns the instance of this class.
	 *
	 * @since  1.0.0
	 *
	 * @return object Instance of this class.
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
