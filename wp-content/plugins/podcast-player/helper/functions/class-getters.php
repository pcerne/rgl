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

use Podcast_Player\Helper\Feed\Get_Feed_Data;
use Podcast_Player\Helper\Functions\Validation as Validation_Fn;
use Podcast_Player\Backend\Admin\Options;
use Podcast_Player\Helper\Functions\Utility as Utility_Fn;

/**
 * Podcast player utility functions.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 * @author     vedathemes <contact@vedathemes.com>
 */
class Getters {

	/**
	 * Constructor method.
	 *
	 * @since  3.3.0
	 */
	public function __construct() {}

	/**
	 * Add attributes strings to all HTML A elements in content.
	 *
	 * @since 3.3.0
	 *
	 * @param string $feed_url Podcast feed url.
	 * @param array  $mods     Feed episode filter args.
	 * @param array  $fields   Required episode field keys.
	 */
	public static function get_feed_data( $feed_url, $mods = array(), $fields = array() ) {
		$feed_url = self::get_valid_feed_url( $feed_url );
		if ( is_wp_error( $feed_url ) ) {
			return $feed_url;
		}
		$obj = new Get_Feed_Data( $feed_url, $mods, $fields );
		return $obj->init();
	}

	/**
	 * Check and Get valid podcast feed url.
	 *
	 * @since 1.0.0
	 *
	 * @param str $url Url to be checked or fetched.
	 * @return str
	 */
	public static function get_valid_feed_url( $url ) {

		// Check if a valid url has been provided.
		if ( Validation_Fn::is_valid_url( $url ) ) {
			return wp_strip_all_tags( $url );
		}

		// Check if url has been provided in as a custom field.
		$custom_keys = get_post_custom_keys();
		if ( $custom_keys && in_array( $url, $custom_keys, true ) ) {
			$murl = get_post_custom_values( $url );
			$murl = is_array( $murl ) ? $murl[0] : $murl;

			// Check if a valid url has been provided.
			if ( Validation_Fn::is_valid_url( $murl ) ) {
				return wp_strip_all_tags( $murl );
			}
		}

		$url = self::get_feed_url_from_index( $url );
		if ( $url ) {
			return wp_strip_all_tags( $url );
		}

		return new \WP_Error( 'invalid_url', esc_html__( 'Please provide a valid feed url.', 'podcast-player' ) );
	}

	/**
	 * Check and Get valid podcast episode media url.
	 *
	 * @since 4.0.0
	 *
	 * @param str $url Url to be checked or fetched.
	 * @return str
	 */
	public static function get_valid_media_url( $url ) {
		// Check if a valid url has been provided.
		if ( Validation_Fn::is_valid_url( $url ) ) {
			return wp_strip_all_tags( $url );
		}

		// Check if url has been provided in as a custom field.
		$custom_keys = get_post_custom_keys();
		if ( $custom_keys && in_array( $url, $custom_keys, true ) ) {
			$murl = get_post_custom_values( $url );
			$murl = is_array( $murl ) ? $murl[0] : $murl;

			// Check if a valid url has been provided.
			if ( Validation_Fn::is_valid_url( $murl ) ) {
				return wp_strip_all_tags( $murl );
			}
		}

		return false;
	}

	/**
	 * Get feed url from the feed index.
	 *
	 * @since 3.5.0
	 *
	 * @param string $key Feed unique key.
	 */
	public static function get_feed_url_from_index( $key ) {
		$feed_index = self::get_feed_index();
		if ( $feed_index && isset( $feed_index[ $key ] ) ) {
			$info = $feed_index[ $key ];
			if ( isset( $info['url'] ) && $info['url'] ) {
				return wp_strip_all_tags( $info['url'] );
			}
		}
		return false;
	}

	/**
	 * Check if url is video or audio media url.
	 *
	 * @since 3.3.0
	 *
	 * @param string $media Media url to be checked.
	 */
	public static function get_media_type( $media ) {
		$audio_ext  = wp_get_audio_extensions();
		$video_ext  = wp_get_video_extensions();
		$mime_types = wp_get_mime_types();
		$media_type = false;
		$media_url  = $media ? preg_replace( '/\?.*/', '', $media ) : false;
		if ( $media_url ) {
			$type = wp_check_filetype( $media_url, $mime_types );
			if ( in_array( strtolower( $type['ext'] ), $audio_ext, true ) ) {
				$media_type = 'audio';
			} elseif ( in_array( strtolower( $type['ext'] ), $video_ext, true ) ) {
				$media_type = 'video';
			}
		}
		return $media_type;
	}

	/**
	 * Get all available display styles.
	 *
	 * @return array
	 */
	public static function display_styles() {

		/**
		 * Get podcast player display styles.
		 *
		 * @since 3.3.0
		 *
		 * @param array $styles Array of styles available in podcast player.
		 */
		return apply_filters(
			'podcast_player_display_styles',
			array(
				array(
					'style_id' => '',
					'label'    => esc_html__( 'Default Player', 'podcast-player' ),
					'support'  => array( 'excerpt', 'bgcolor' ),
				),
				array(
					'style_id' => 'legacy',
					'label'    => esc_html__( 'Catalogue (Legacy) Player', 'podcast-player' ),
					'support'  => array( 'bgcolor' ),
				),
			)
		);
	}

	/**
	 * Get elements supported by selected style.
	 *
	 * @return array
	 */
	public static function get_styles() {
		return array_column( self::display_styles(), 'label', 'style_id' );
	}

	/**
	 * Get elements supported by selected style.
	 *
	 * @return array
	 */
	public static function get_style_supported() {
		return array_column( self::display_styles(), 'support', 'style_id' );
	}

	/**
	 * Get plugin options.
	 *
	 * @since 3.3.0
	 *
	 * @param string $key Get option value for an option key.
	 */
	public static function get_plugin_option( $key ) {
		$all_options = get_option( 'pp-common-options' );
		$params      = self::get_plugin_option_fields( $key );

		// Return false if plugin option do not exists.
		if ( ! $params ) {
			return false;
		}

		// Return default value if options are not yet saved.
		if ( false === $all_options ) {
			return $params['default'];
		}

		// Return saved or default plugin option.
		if ( 'checkbox' === $params['type'] ) {
			return isset( $all_options[ $key ] ) ? $all_options[ $key ] : false;
		} else {
			return isset( $all_options[ $key ] ) ? $all_options[ $key ] : $params['default'];
		}
	}

	/**
	 * Get plugin's options fields array.
	 *
	 * @since 3.5.0
	 *
	 * @param string $key Plugin option key.
	 */
	public static function get_plugin_option_fields( $key ) {
		$options = Options::get_instance();
		$fields  = $options->get_setting_fields();
		if ( isset( $fields[ $key ] ) ) {
			return $fields[ $key ];
		}
		return false;
	}

	/**
	 * Get podcast feed index.
	 *
	 * @return array
	 */
	public static function get_feed_index() {
		$all_feeds = get_option( 'pp_feed_index' );

		// Check and update depricated feed index.
		if ( $all_feeds && is_array( $all_feeds ) ) {
			foreach ( $all_feeds as $key => $args ) {
				if ( ! ( is_array( $args ) && isset( $args['url'] ) && $args['url'] ) ) {
					$all_feeds = Utility_Fn::refresh_index();
					break;
				}
			}
		}

		return $all_feeds;
	}

	/**
	 * Get image src and srcset.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id Image attachment ID.
	 * @param str $size Required Image size.
	 * @return array
	 */
	public static function get_image_src_set( $id, $size ) {
		$image  = wp_get_attachment_image_src( $id, $size );
		$src    = '';
		$srcset = '';
		if ( $image ) {
			list( $url, $width, $height ) = $image;
			// Get src and srcset of the image.
			$src        = $url;
			$image_meta = wp_get_attachment_metadata( $id );
			if ( is_array( $image_meta ) ) {
				$size_array = array( absint( $width ), absint( $height ) );
				$srcset     = wp_calculate_image_srcset( $size_array, $src, $image_meta, $id );
				$srcset     = $srcset ? $srcset : '';
			}
		}
		return array(
			'src'    => $src,
			'srcset' => $srcset,
		);
	}

	/**
	 * Get unique key of the given url.
	 *
	 * @since 3.3.0
	 *
	 * @param string $url Url for which unique key to be generated.
	 */
	public static function get_url_key( $url ) {
		$url = wp_strip_all_tags( $url );
		if ( ! Validation_Fn::is_valid_url( $url ) ) {
			return '';
		}
		return md5( $url );
	}
}
