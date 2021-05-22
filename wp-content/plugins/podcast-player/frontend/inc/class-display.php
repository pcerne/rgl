<?php
/**
 * Display a podcast instance.
 *
 * @link       https://www.vedathemes.com
 * @since      1.0.0
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/public
 */

namespace Podcast_Player\Frontend\Inc;

use Podcast_Player\Helper\Functions\Validation as Validation_Fn;

/**
 * Display a podcast instance.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/public
 * @author     vedathemes <contact@vedathemes.com>
 */
class Display {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * Is pp pro version available.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var int
	 */
	private $is_pro;

	/**
	 * Class cannot be instantiated directly.
	 *
	 * @since  1.0.0
	 */
	private function __construct() {

		/**
		 * Is pp pro version available.
		 *
		 * @since 3.3.0
		 *
		 * @param bool $is_pro Pro version status.
		 */
		$this->is_pro = apply_filters( 'podcast_player_is_premium', false );
	}

	/**
	 * Display a podcast instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args    Podcast display args.
	 * @param bool  $return  Display or return.
	 */
	public function init( $args, $return = true ) {
		$defaults = $this->get_defaults();
		$args     = wp_parse_args( $args, $defaults );
		$podcast  = $this->get_fetch_instance( $args['fetch-method'] );

		if ( is_wp_error( $podcast ) ) {
			if ( $return ) {
				return $podcast->get_error_message();
			}
			echo $podcast->get_error_message(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		// Get podcast player markup for current instance.
		ob_start();
		$podcast->display_podcast( $args );
		$markup = ob_get_clean();

		if ( $return ) {
			return $markup;
		}
		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Get podcast player fetch instance.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Podcast fetch method.
	 */
	private function get_fetch_instance( $method ) {
		$class = $this->get_fetch_class( $method );

		// Return if fetch class is not defined.
		if ( false === $class ) {
			return new \WP_Error(
				'fetch-not-defined',
				esc_html__( 'Podcast fetch class not defined.', 'podcast-player' )
			);
		}

		// Return if defined class does not exist.
		if ( ! class_exists( $class, true ) ) {
			return new \WP_Error(
				'fetch-not-exist',
				esc_html__( 'Podcast fetch class does not exist.', 'podcast-player' )
			);
		}

		// Return instance of the fetch class.
		return $class::get_instance();
	}

	/**
	 * Get podcast player fetch class.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Podcast fetch method.
	 */
	private function get_fetch_class( $method ) {

		/**
		 * Podcast player fetch class.
		 *
		 * @since 3.3.0
		 *
		 * @param array List of fetch method classes.
		 */
		$classes = apply_filters(
			'podcast_player_fetch_method_class',
			array(
				'feed' => 'Podcast_Player\Frontend\Inc\Feed',
			)
		);

		if ( $method && isset( $classes[ $method ] ) ) {
			return $classes[ $method ];
		}

		return false;
	}

	/**
	 * Podcast player shortcode defaults.
	 *
	 * @since 3.3.0
	 */
	private function get_defaults() {
		return array(
			'url'              => '',
			'sortby'           => 'sort_date_desc',
			'filterby'         => '',
			'number'           => 10,
			'menu'             => '',
			'image'            => '',
			'description'      => '',
			'img_url'          => '',
			'excerpt-length'   => 18,
			'excerpt-unit'     => '',
			'aspect-ratio'     => 'squr',
			'crop-method'      => 'centercrop',
			'header-default'   => '',
			'list-default'     => '',
			'hide-header'      => '',
			'hide-title'       => '',
			'hide-cover-img'   => '',
			'hide-description' => '',
			'hide-subscribe'   => '',
			'hide-search'      => '',
			'hide-author'      => '',
			'hide-content'     => '',
			'hide-loadmore'    => '',
			'hide-download'    => '',
			'hide-social'      => '',
			'hide-featured'    => '',
			'accent-color'     => '',
			'display-style'    => '',
			'grid-columns'     => 3,
			'fetch-method'     => 'feed',
			'post-type'        => 'post',
			'taxonomy'         => '',
			'terms'            => '',
			'podtitle'         => '',
			'audiosrc'         => '',
			'audiotitle'       => '',
			'audiolink'        => '',
			'ahide-download'   => '',
			'ahide-social'     => '',
			'audio-msg'        => '',
			'play-freq'        => 0,
			'msg-start'        => 'start',
			'msg-time'         => array( 0, 0 ),
			'msg-text'         => esc_html__( 'Episode will play after this message.', 'podcast-player' ),
			'font-family'      => '',
			'bgcolor'          => '',
			'txtcolor'         => '',
			'seasons'          => '',
			'episodes'         => '',
			'apple-sub'        => '',
			'google-sub'       => '',
			'spotify-sub'      => '',
			'elist'            => array( '' ),
			'slist'            => array(),
			'catlist'          => array(),
			'edisplay'         => '',
			'from'             => false,
			'classes'          => '',
		);
	}

	/**
	 * Returns the instance of this class.
	 *
	 * @since 3.3.0
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
