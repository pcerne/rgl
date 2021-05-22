<?php
/**
 * Fetch Feed Data from Feed XML file.
 *
 * @link       https://www.vedathemes.com
 * @since      1.0.0
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 */

namespace Podcast_Player\Helper\Feed;

use Podcast_Player\Helper\Feed\SimplePie_Sanitize;

/**
 * Fetch Feed Data from Feed XML file.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 * @author     vedathemes <contact@vedathemes.com>
 */
class Fetch_Feed_Data {

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
	 * Constructor method.
	 *
	 * @since  3.3.0
	 *
	 * @param string $feedurl Feed URL.
	 */
	public function init( $feedurl ) {
		if ( ! class_exists( 'SimplePie', false ) ) {
			require_once ABSPATH . WPINC . '/class-simplepie.php';
		}

		require_once ABSPATH . WPINC . '/class-wp-simplepie-file.php';

		$feed = new \SimplePie();

		// Override default sanitization.
		$feed->set_sanitize_class( 'Podcast_Player\Helper\Feed\SimplePie_Sanitize' );
		$feed->sanitize = new SimplePie_Sanitize();

		// Disable default caching.
		$feed->enable_cache( false );

		$feed->set_file_class( 'WP_SimplePie_File' );
		$feed->set_feed_url( $feedurl );

		/** This action is documented in wp-includes/feed.php */
		do_action_ref_array( 'wp_feed_options', array( &$feed, $feedurl ) );
		$feed->init();
		$feed->set_output_encoding( get_option( 'blog_charset' ) );

		if ( $feed->error() ) {
			return new \WP_Error( 'simplepie-error', $feed->error() );
		}

		return $feed;
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
