<?php
/**
 * Podcast player miscellaneous actions.
 *
 * @link       https://www.vedathemes.com
 * @since      1.0.0
 *
 * @package    Podcast_Player
 */

namespace Podcast_Player\Backend\Inc;

/**
 * Display podcast player instance.
 *
 * @package    Podcast_Player
 * @author     vedathemes <contact@vedathemes.com>
 */
class Misc {

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
	 * Save feed episode images locally.
	 *
	 * @since 2.9.0
	 *
	 * @param string $fprint Feed footprint.
	 */
	public function save_images_locally( $fprint ) {
		$data_key = 'pp_feed_data_' . $fprint;
		$uploaded = false;

		// Get saved feed data.
		$feed_arr = get_option( $data_key );
		if ( ! $feed_arr ) {
			return;
		}

		set_time_limit( 540 ); // Give it 9 minutes.

		// Check and get podcast cover art image.
		if ( ! isset( $feed_arr['cover_id'] ) ) {
			if ( isset( $feed_arr['image'] ) && $feed_arr['image'] ) {
				$ctitle = isset( $feed_arr['title'] ) ? $feed_arr['title'] : '';
				$cid    = $this->upload_image( $feed_arr['image'], $ctitle );
				if ( $cid ) {
					$feed_arr['cover_id'] = $cid;
					$uploaded             = true;
				}
			}
		}

		// Check and get podcast episodes featured images.
		$items      = $feed_arr['items'];
		$counter    = 0;
		$batch_size = 10;

		// Download images for 10 latest episodes.
		uasort(
			$items,
			function( $a, $b ) {
				return $a['date'] <= $b['date'];
			}
		);

		foreach ( $items as $item => $args ) {
			if ( $counter >= $batch_size ) {
				break;
			}
			if ( ! isset( $args['featured_id'] ) ) {
				if ( isset( $args['featured'] ) && $args['featured'] ) {
					$title = isset( $args['title'] ) ? $args['title'] : '';
					$id    = $this->upload_image( $args['featured'], $title );
					if ( $id ) {
						$args['featured_id'] = $id;
						$items[ $item ]      = $args;
						$uploaded            = true;
						$counter++;
					}
				}
			}
		}

		if ( $uploaded ) {
			$feed_arr['items'] = $items;
			update_option( $data_key, $feed_arr, 'no' );
		}
	}

	/**
	 * Upload image to wp upload directory.
	 *
	 * @since 2.9.0
	 *
	 * @param string $url   Image URL.
	 * @param string $title Podcast episode title.
	 */
	public function upload_image( $url = '', $title = '' ) {
		$url   = esc_url_raw( $url );
		$title = sanitize_text_field( $title );
		if ( ! $url ) {
			return false;
		}

		global $wpdb;

		$fid     = md5( $url );
		$sql     = $wpdb->prepare(
			"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'pp_featured_key' AND meta_value = %s",
			$fid
		);
		$post_id = $wpdb->get_var( $sql );
		$post_id = (int) $post_id;
		if ( $post_id ) {
			return $post_id;
		} else {
			// Require relevant WordPress core files for processing images.
			require_once ABSPATH . 'wp-admin/includes/media.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/image.php';
			$post_id = media_sideload_image( $url, 0, $title, 'id' );
			if ( ! is_wp_error( $post_id ) ) {
				add_post_meta( $post_id, 'pp_featured_key', $fid, true );
				return $post_id;
			}
		}
		return false;
	}

	/**
	 * Add plugin action links.
	 *
	 * Add actions links for better user engagement.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $links List of existing plugin action links.
	 * @return array         List of modified plugin action links.
	 */
	public function action_links( $links ) {
		$links = array_merge(
			array(
				'<a href="' . esc_url( admin_url( 'admin.php?page=pp-options' ) ) . '">' . __( 'Settings', 'podcast-player' ) . '</a>',
			),
			$links
		);

		if ( defined( 'PP_PRO_VERSION' ) ) {
			return $links;
		}

		$links = array_merge(
			array(
				'<a href="' . esc_url( 'https://vedathemes.com/blog/vedaitems/podcast-player-pro/' ) . '" style="color: #35b747; font-weight: 700;">' . __( 'Get Pro', 'podcast-player' ) . '</a>',
			),
			$links
		);
		return $links;
	}

	/**
	 * Returns the instance of this class.
	 *
	 * @since  1.0.0
	 *
	 * @return object Instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


}
