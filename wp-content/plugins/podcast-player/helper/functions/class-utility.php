<?php
/**
 * Podcast player utility functions.
 *
 * @link       https://www.vedathemes.com
 * @since      3.3.0
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 */

namespace Podcast_Player\Helper\Functions;

/**
 * Podcast player utility functions.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 * @author     vedathemes <contact@vedathemes.com>
 */
class Utility {

	/**
	 * Constructor method.
	 *
	 * @since  3.3.0
	 */
	public function __construct() {}

	/**
	 * Convert hex color code to equivalent RGB code.
	 *
	 * @since 3.3.0
	 *
	 * @param string  $hex_color Hexadecimal color value.
	 * @param boolean $as_string Return as string or associative array.
	 * @param string  $sep       String to separate RGB values.
	 * @return string
	 */
	public static function hex_to_rgb( $hex_color, $as_string, $sep = ',' ) {
		$hex_color = preg_replace( '/[^0-9A-Fa-f]/', '', $hex_color );
		$rgb_array = array();
		if ( 6 === strlen( $hex_color ) ) {
			$color_val          = hexdec( $hex_color );
			$rgb_array['red']   = 0xFF & ( $color_val >> 0x10 );
			$rgb_array['green'] = 0xFF & ( $color_val >> 0x8 );
			$rgb_array['blue']  = 0xFF & $color_val;
		} elseif ( 3 === strlen( $hex_color ) ) {
			$rgb_array['red']   = hexdec( str_repeat( substr( $hex_color, 0, 1 ), 2 ) );
			$rgb_array['green'] = hexdec( str_repeat( substr( $hex_color, 1, 1 ), 2 ) );
			$rgb_array['blue']  = hexdec( str_repeat( substr( $hex_color, 2, 1 ), 2 ) );
		} else {
			return false; // Invalid hex color code.
		}
		return $as_string ? implode( $sep, $rgb_array ) : $rgb_array;
	}

	/**
	 * Calculate color contrast.
	 *
	 * The returned value should be bigger than 5 for best readability.
	 *
	 * @link https://www.splitbrain.org/blog/2008-09/18-calculating_color_contrast_with_php
	 *
	 * @since 1.5
	 *
	 * @param int $r1 First color R value.
	 * @param int $g1 First color G value.
	 * @param int $b1 First color B value.
	 * @param int $r2 First color R value.
	 * @param int $g2 First color G value.
	 * @param int $b2 First color B value.
	 * @return float
	 */
	public static function lumdiff( $r1, $g1, $b1, $r2, $g2, $b2 ) {
		$l1 = 0.2126 * pow( $r1 / 255, 2.2 ) + 0.7152 * pow( $g1 / 255, 2.2 ) + 0.0722 * pow( $b1 / 255, 2.2 );
		$l2 = 0.2126 * pow( $r2 / 255, 2.2 ) + 0.7152 * pow( $g2 / 255, 2.2 ) + 0.0722 * pow( $b2 / 255, 2.2 );

		if ( $l1 > $l2 ) {
			return ( $l1 + 0.05 ) / ( $l2 + 0.05 );
		} else {
			return ( $l2 + 0.05 ) / ( $l1 + 0.05 );
		}
	}

	/**
	 * Get multiple columns from an array.
	 *
	 * @since 3.3.0
	 *
	 * @param array $keys     Array keys to be fetched.
	 * @param array $get_from Array from which data needs to be fetched.
	 */
	public static function multi_array_columns( $keys, $get_from ) {
		$keys = array_flip( $keys );
		array_walk(
			$keys,
			function( &$val, $key ) use ( $get_from ) {
				if ( isset( $get_from[ $key ] ) ) {
					$val = $get_from[ $key ];
				} else {
					$val = array();
				}
			}
		);
		return $keys;
	}

	/**
	 * Update feeds and their data in the feed index.
	 *
	 * @since 3.4.0
	 */
	public static function refresh_index() {
		$all_feeds = get_option( 'pp_feed_index' );
		$new       = array();
		$updated   = false;
		if ( $all_feeds && is_array( $all_feeds ) ) {
			foreach ( $all_feeds as $key => $args ) {
				$feed = get_option( 'pp_feed_data_' . $key );
				if ( $feed ) {
					if ( is_array( $args ) && isset( $args['url'] ) && $args['url'] ) {
						$new[ $key ] = $args;
					} else {
						$title       = isset( $feed['title'] ) && $feed['title'] ? $feed['title'] : esc_html__( 'Untitled Feed', 'podcast-player' );
						$url         = isset( $feed['furl'] ) && $feed['furl'] ? $feed['furl'] : '';
						$new[ $key ] = array(
							'title' => $title,
							'url'   => $url,
						);
						$updated     = true;
					}
				}
			}
			if ( $updated || count( $new ) !== count( $all_feeds ) ) {
				update_option( 'pp_feed_index', $new, 'no' );
			}
		}
		return $new;
	}
}
