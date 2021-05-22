<?php
/**
 * Get Feed Data from Database OR from Feed XML file.
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
 * Get Feed Data from Database OR from Feed XML file.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/Helper
 * @author     vedathemes <contact@vedathemes.com>
 */
class Get_Feed_Data {

	/**
	 * Holds feed url for current instance.
	 *
	 * @since  3.3.0
	 * @access private
	 * @var    string
	 */
	private $feed_url = '';

	/**
	 * Holds feed filter and sort args.
	 *
	 * @since  3.3.0
	 * @access private
	 * @var    array
	 */
	private $mods = array();

	/**
	 * Holds required episodes field keys.
	 *
	 * @since  3.3.0
	 * @access private
	 * @var    array
	 */
	private $fields = array();

	/**
	 * Holds feed key prefix.
	 *
	 * @since  3.3.0
	 * @access private
	 * @var    string
	 */
	private $prefix = 'pp_feed';

	/**
	 * Constructor method.
	 *
	 * @since  3.3.0
	 *
	 * @param string $feedurl Feed URL.
	 * @param array  $mods    Feed episode filter args.
	 * @param array  $fields  Required episode field keys.
	 */
	public function __construct( $feedurl = '', $mods = array(), $fields = array() ) {
		// Set Object Properties.
		$this->mods     = $mods;
		$this->fields   = $fields;
		$this->feed_url = $feedurl;
	}

	/**
	 * Init method.
	 *
	 * @since  3.3.0
	 */
	public function init() {

		// Get feed data from DB or from feed url.
		$fdata = $this->get_feed_data();
		if ( is_wp_error( $fdata ) ) {
			return $fdata;
		}

		// Check and use custom data for feed items.
		$fdata = $this->override_customizations( $fdata );
		if ( is_wp_error( $fdata ) ) {
			return $fdata;
		}

		// Apply sort, filter and other customizations.
		$fdata = $this->modify_fetched_data( $fdata );
		if ( is_wp_error( $fdata ) ) {
			return $fdata;
		}

		// Get only requested fields of feed item.
		$fdata = $this->get_required_fields( $fdata );
		if ( is_wp_error( $fdata ) ) {
			return $fdata;
		}

		// Prepare data for frontend.
		$fdata = $this->prepare_data( $fdata );
		if ( is_wp_error( $fdata ) ) {
			return $fdata;
		}

		return $fdata;
	}

	/**
	 * Constructor method.
	 *
	 * @since  3.3.0
	 */
	public function get_feed_data() {
		$feed_key        = $this->prepare_feed_key();
		$is_feed_expired = $this->is_feed_expired( $feed_key );

		if ( $is_feed_expired ) {
			$feed_data = $this->fetch_new_feed_data( $feed_key );
		} else {
			$feed_data = $this->get_stored_feed_data( $feed_key );
		}

		return $feed_data;
	}

	/**
	 * Prepare feed key from feed url.
	 *
	 * @since  3.3.0
	 */
	public function prepare_feed_key() {
		return md5( $this->feed_url );
	}

	/**
	 * Check if feed data has been expired.
	 *
	 * @since  3.3.0
	 *
	 * @param string $key Unique feed identifier key.
	 */
	public function is_feed_expired( $key ) {
		$time_key         = $this->prefix . '_time_' . $key;
		$cache_time_start = get_transient( $time_key );
		$cache_time       = absint( Get_Fn::get_plugin_option( 'refresh_interval' ) );

		/** This filter is documented in wp-includes/class-wp-feed-cache-transient.php */
		$life = apply_filters( 'wp_feed_cache_transient_lifetime', $cache_time * 60, $this->feed_url );
		if ( $cache_time_start && ( $cache_time_start + $life ) > time() ) {
			return false;
		}

		return true;
	}

	/**
	 * Get stored data for podcast feed.
	 *
	 * @since  3.3.0
	 *
	 * @param string $key Unique feed identifier key.
	 */
	public function fetch_new_feed_data( $key ) {
		$obj      = Fetch_Feed_Data::get_instance();
		$raw_data = $obj->init( $this->feed_url );
		if ( is_wp_error( $raw_data ) ) {
			return $raw_data;
		}

		// Get data prepared for storage.
		return $this->data_storage( $raw_data, $key );
	}

	/**
	 * Get stored data for podcast feed.
	 *
	 * @since  3.3.0
	 *
	 * @param string $key Unique feed identifier key.
	 */
	public function get_stored_feed_data( $key ) {
		$data_key    = $this->prefix . '_data_' . $key;
		$stored_data = get_option( $data_key );

		if ( false === $stored_data ) {
			return $this->fetch_new_feed_data( $key );
		}

		return $stored_data;
	}

	/**
	 * Get stored data for podcast feed.
	 *
	 * @since  3.3.0
	 *
	 * @param object $raw_data Raw feed data fetched from feed url.
	 * @param string $key Unique feed identifier key.
	 */
	public function data_storage( $raw_data, $key ) {
		$obj      = new Prepare_Storage_Data( $raw_data, $key, $this->feed_url );
		$data_arr = $obj->init();
		if ( ! $data_arr ) {
			return new \WP_Error(
				'no-items-error',
				esc_html__( 'No feed items available.', 'podcast-player' )
			);
		}

		// Fetch data from the array.
		list( $data, $is_changed, $is_img_save ) = $data_arr;

		// Update fetched data in database.
		$this->save_fetched_data( $data, $key, $is_changed );

		if ( $is_img_save && $this->is_img_save_enabled() ) {
			$this->schedule_img_save( $key );
		}

		return $data;
	}

	/**
	 * Check if image save option is enabled.
	 *
	 * @since  3.3.0
	 */
	public function is_img_save_enabled() {
		return 'yes' === Get_Fn::get_plugin_option( 'img_save' );
	}

	/**
	 * Schedule next image save.
	 *
	 * @since  3.3.0
	 *
	 * @param string $key Unique feed identifier key.
	 */
	public function schedule_img_save( $key ) {
		wp_schedule_single_event( time(), 'pp_save_images_locally', array( $key ) );
	}

	/**
	 * Save fetched data.
	 *
	 * @since  3.3.0
	 *
	 * @param array  $data       Feed data to be saved.
	 * @param string $key        Unique feed identification key.
	 * @param bool   $is_changed Check if feed data has been changed.
	 */
	public function save_fetched_data( $data, $key, $is_changed ) {
		new Save_Feed_Data( $data, $key, $this->feed_url, $is_changed );
	}

	/**
	 * Save fetched data.
	 *
	 * @since  3.3.0
	 *
	 * @param array $data Apply sort and filters on fetched data.
	 */
	public function modify_fetched_data( $data ) {
		$obj                   = Modify_Feed_Data::get_instance();
		list( $total, $items ) = $obj->init( $data, $this->mods );

		if ( is_array( $items ) && empty( $items ) ) {
			return new \WP_Error(
				'no-filtered-items',
				esc_html__( 'No feed items for your specific filters.', 'podcast-player' )
			);
		}

		if ( ! $items ) {
			return new \WP_Error(
				'no-items-error',
				esc_html__( 'No feed items available.', 'podcast-player' )
			);
		}

		$data['items'] = $items;
		$data['total'] = $total;
		return $data;
	}

	/**
	 * Save fetched data.
	 *
	 * @since  3.3.0
	 *
	 * @param array $data Apply sort and filters on fetched data.
	 */
	public function prepare_data( $data ) {
		$obj   = Prepare_Front_Data::get_instance();
		$items = $obj->init( $data );

		if ( is_array( $items ) && empty( $items ) ) {
			return new \WP_Error(
				'no-filtered-items',
				esc_html__( 'No feed items for your specific filters.', 'podcast-player' )
			);
		}

		if ( ! $items ) {
			return new \WP_Error(
				'no-items-error',
				esc_html__( 'No feed items available.', 'podcast-player' )
			);
		}

		$data['items'] = $items;
		return $data;
	}

	/**
	 * Check and use custom data for feed items..
	 *
	 * @since  3.3.0
	 *
	 * @param array $data Feed data to be overridden by customizations.
	 */
	public function override_customizations( $data ) {
		$items       = $data['items'];
		$fkey        = $this->prepare_feed_key();
		$ckey        = $this->prefix . '_data_custom_' . $fkey;
		$custom_data = get_option( $ckey );

		/**
		 * Custom data for the feed to override original data.
		 *
		 * @since 3.3.0
		 *
		 * @param array  $custom_data    Feed items custom data.
		 * @param string $this->feed_url Feed URL.
		 */
		$custom_data = apply_filters( 'podcast_player_custom_data', $custom_data, $this->feed_url );

		// Return if custom data do not exist.
		if ( ! $custom_data || ! is_array( $custom_data ) ) {
			return $data;
		}

		// Replace / Add original data with customized data.
		$items = array_replace_recursive( $items, $custom_data );

		// Get cumulative array of all available seasons.
		$seasons = array_values( array_filter( array_unique( array_column( $items, 'season' ) ) ) );

		// Get cumulative array of all available categories.
		$cats = array_column( $items, 'categories' );
		$cats = array_unique( call_user_func_array( 'array_merge', $cats ) );

		if ( empty( $items ) ) {
			return new \WP_Error(
				'no-items-custom',
				esc_html__( 'No feed items after customization override', 'podcast-player' )
			);
		}

		$data['seasons']    = $seasons;
		$data['categories'] = $cats;
		$data['items']      = $items;
		return $data;
	}

	/**
	 * Get required data fields for an item.
	 *
	 * @since  3.3.0
	 *
	 * @param array $data Get only required fields from the data.
	 */
	public function get_required_fields( $data ) {
		if ( empty( $this->fields ) ) {
			return $data;
		}

		$items  = $data['items'];
		$fields = array_flip( $this->fields );

		/**
		 * Remove all fields from the item array which are not required.
		 * Also, remove all items which do not have any fields left.
		 */
		$items = array_filter(
			array_map(
				function( $item ) use ( $fields ) {
					return array_intersect_key( $item, $fields );
				},
				$items
			)
		);

		if ( empty( $items ) ) {
			return new \WP_Error(
				'no-items-field',
				esc_html__( 'Required item fields are not available.', 'podcast-player' )
			);
		}

		$data['items'] = $items;
		return $data;
	}
}