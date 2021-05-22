<?php
/**
 * Podcast player premium.
 *
 * @link       https://www.vedathemes.com
 * @since      4.5.0
 *
 * @package    Podcast_Player
 */

namespace Podcast_Player\Frontend\Inc;

/**
 * Podcast player premium.
 *
 * @package    Podcast_Player
 * @author     vedathemes <contact@vedathemes.com>
 */
class General {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  4.5.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * Class cannot be instantiated directly.
	 *
	 * @since  4.5.0
	 */
	private function __construct() {}

	/**
	 * Prevent exposing podcast feed data.
	 *
	 * @param array $data Podcast episodes data.
	 *
	 * @since 4.5.0
	 */
	public function data_protect( $data ) {
		return array( array(), 0 );
	}

	/**
	 * Prevent exposing episode audio URL.
	 *
	 * @param string $url Podcast episode audio URL.
	 *
	 * @since 4.5.0
	 */
	public function mask_audio_url( $url ) {
		return md5( esc_url( $url ) );
	}

	/**
	 * Returns the instance of this class.
	 *
	 * @since  4.5.0
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
