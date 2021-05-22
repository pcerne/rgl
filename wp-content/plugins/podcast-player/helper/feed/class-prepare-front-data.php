<?php
/**
 * Escape data and prepare to send to frontend.
 *
 * @link       https://www.vedathemes.com
 * @since      1.0.0
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 */

namespace Podcast_Player\Helper\Feed;

use Podcast_Player\Helper\Functions\Getters as Get_Fn;

/**
 * Escape data and prepare to send to frontend.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 * @author     vedathemes <contact@vedathemes.com>
 */
class Prepare_Front_Data {

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
	 * @param array $data Fetched feed data to be sent to frontend.
	 */
	public function init( $data ) {
		$feed_items = $data['items'];

		if ( ! $feed_items ) {
			return false;
		}

		// Escape data to be sent to front-end.
		$items = $this->escape_data( $feed_items );

		return $items;
	}

	/**
	 * Escape feed items.
	 *
	 * @since  3.3.0
	 *
	 * @param array $items Feed items to be escaped and prepared.
	 */
	public function escape_data( $items ) {
		return array_map( array( $this, 'escape_item' ), $items );
	}

	/**
	 * Escape feed item fields.
	 *
	 * @since  3.3.0
	 *
	 * @param array $item Feed item to be escaped and prepared.
	 */
	public function escape_item( $item ) {
		array_walk(
			$item,
			function( &$val, $key ) {
				$callback = $this->get_callback( $key );
				if ( is_callable( $callback ) ) {
					$val = call_user_func( $callback, $val );
				}
			}
		);
		return $item;
	}

	/**
	 * List of callbacks for item fields.
	 *
	 * @since  3.3.0
	 *
	 * @param array $key Feed item field key.
	 */
	public function get_callback( $key ) {

		/**
		 * List of callbacks for item fields.
		 *
		 * @since 3.3.0
		 *
		 * @param array $callbacks All feed items field callbacks.
		 */
		$callbacks = apply_filters(
			'podcast_player_frontend_callback',
			array(
				'title'       => array( $this, 'title' ),
				'description' => array( $this, 'description' ),
				'date'        => array( $this, 'date' ),
				'categories'  => array( $this, 'categories' ),
				'link'        => 'esc_url',
				'src'         => 'esc_url',
				'featured'    => 'esc_url',
				'author'      => 'esc_html',
				'mediatype'   => 'esc_html',
				'episode'     => 'esc_html',
				'season'      => 'absint',
			)
		);

		return isset( $callbacks[ $key ] ) ? $callbacks[ $key ] : '';
	}

	/**
	 * Escape feed item title.
	 *
	 * @since  3.3.0
	 *
	 * @param string $title Feed item title.
	 */
	public function title( $title ) {
		return trim( convert_chars( wptexturize( $title ) ) );
	}

	/**
	 * Escape feed item description.
	 *
	 * @since  3.3.0
	 *
	 * @param string $description Feed item description.
	 */
	public function description( $description ) {
		return wpautop( wptexturize( $description ) );
	}

	/**
	 * Escape feed item date.
	 *
	 * @since  3.3.0
	 *
	 * @param string|Array $d Feed item date.
	 */
	public function date( $d ) {

		$timezone = Get_Fn::get_plugin_option( 'timezone' );
		$date     = is_array( $d ) ? $d['date'] : $d;
		$offset   = is_array( $d ) ? $d['offset'] : 0;

		if ( 'local' === $timezone ) {
			return date_i18n( get_option( 'date_format' ), $date + 60 * 60 * get_option( 'gmt_offset' ) );
		} elseif ( 'feed' === $timezone ) {
			return date_i18n( get_option( 'date_format' ), $date + $offset );
		} else {
			return date_i18n( get_option( 'date_format' ), $date );
		}
	}

	/**
	 * Escape feed item categories.
	 *
	 * @since  3.3.0
	 *
	 * @param string $categories Feed item categories.
	 */
	public function categories( $categories ) {
		return array_map( 'esc_html', $categories );
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
