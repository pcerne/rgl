<?php
/**
 * Block API: Display Podcast from feed url class
 *
 * @link       https://www.vedathemes.com
 * @since      1.0.0
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/admin
 */

namespace Podcast_Player\Backend\Inc;

use Podcast_Player\Frontend\Inc\Display;

/**
 * Class used to display podcast episodes from a feed url.
 *
 * @package    Podcast_Player
 * @subpackage Podcast_Player/admin
 * @author     vedathemes <contact@vedathemes.com>
 */
class Block {

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
	 * Register editor block for featured content.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		// Check if the register function exists.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type(
			'podcast-player/podcast-player',
			array(
				'render_callback' => array( $this, 'render_block' ),
				'attributes'      => apply_filters(
					'podcast_player_block_attr',
					array(
						'feedURL'       => array(
							'type'    => 'string',
							'default' => '',
						),
						'sortBy'        => array(
							'type'    => 'string',
							'default' => 'sort_date_desc',
						),
						'filterBy'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'number'        => array(
							'type'    => 'number',
							'default' => 10,
						),
						'excerptLength' => array(
							'type'    => 'number',
							'default' => 18,
						),
						'excerptUnit'   => array(
							'type'    => 'string',
							'default' => '',
						),
						'gridColumns'   => array(
							'type'    => 'number',
							'default' => 3,
						),
						'podcastMenu'   => array(
							'type'    => 'string',
							'default' => '',
						),
						'aspectRatio'   => array(
							'type'    => 'string',
							'default' => 'squr',
						),
						'cropMethod'    => array(
							'type'    => 'string',
							'default' => 'centercrop',
						),
						'coverImage'    => array(
							'type'    => 'string',
							'default' => '',
						),
						'description'   => array(
							'type'    => 'string',
							'default' => '',
						),
						'accentColor'   => array(
							'type'    => 'string',
							'default' => '',
						),
						'displayStyle'  => array(
							'type'    => 'string',
							'default' => '',
						),
						'fetchMethod'   => array(
							'type'    => 'string',
							'default' => 'feed',
						),
						'postType'      => array(
							'type'    => 'string',
							'default' => 'post',
						),
						'taxonomy'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'terms'         => array(
							'type'    => 'array',
							'items'   => array(
								'type' => 'string',
							),
							'default' => array(),
						),
						'podtitle'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'audioSrc'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'audioTitle'    => array(
							'type'    => 'string',
							'default' => '',
						),
						'audioLink'     => array(
							'type'    => 'string',
							'default' => '',
						),
						'headerDefault' => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'listDefault'   => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideHeader'    => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideTitle'     => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideCover'     => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideDesc'      => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideSubscribe' => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideSearch'    => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideAuthor'    => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideContent'   => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideLoadmore'  => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideDownload'  => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'ahideDownload' => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideSocial'    => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'hideFeatured'  => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'ahideSocial'   => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'audioMsg'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'playFreq'      => array(
							'type'    => 'number',
							'default' => 0,
						),
						'msgStart'      => array(
							'type'    => 'string',
							'default' => 'start',
						),
						'msgTime'       => array(
							'type'    => 'array',
							'items'   => array(
								'type' => 'number',
							),
							'default' => array( 0, 0, 0 ),
						),
						'msgText'       => array(
							'type'    => 'string',
							'default' => esc_html__( 'Episode will play after this message.', 'podcast-player' ),
						),
						'fontFamily'    => array(
							'type'    => 'string',
							'default' => '',
						),
						'bgColor'       => array(
							'type'    => 'string',
							'default' => '',
						),
						'txtColor'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'seasons'       => array(
							'type'    => 'string',
							'default' => '',
						),
						'episodes'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'appleSub'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'googleSub'     => array(
							'type'    => 'string',
							'default' => '',
						),
						'spotifySub'    => array(
							'type'    => 'string',
							'default' => '',
						),
						'elist'         => array(
							'type'    => 'array',
							'items'   => array(
								'type' => 'string',
							),
							'default' => array( '' ),
						),
						'edisplay'      => array(
							'type'    => 'string',
							'default' => '',
						),
						'slist'         => array(
							'type'    => 'array',
							'items'   => array(
								'type' => 'string',
							),
							'default' => array( '' ),
						),
						'catlist'       => array(
							'type'    => 'array',
							'items'   => array(
								'type' => 'string',
							),
							'default' => array( '' ),
						),
						'className'     => array(
							'type' => 'string',
						),
					)
				),
			)
		);
	}

	/**
	 * Render editor block for podcast player.
	 *
	 * @since 1.0.0
	 *
	 * @param array $atts Display attributes.
	 */
	public function render_block( $atts ) {
		$img_url  = '';
		$image_id = '';
		if ( $atts['coverImage'] ) {
			$dir = wp_upload_dir();
			if ( false !== strpos( $atts['coverImage'], $dir['baseurl'] . '/' ) ) {
				$image_id = attachment_url_to_postid( esc_url( $atts['coverImage'] ) );
			} else {
				$img_url = $atts['coverImage'];
			}
		}

		$display_args = apply_filters(
			'podcast_player_block_display',
			array(
				'url'              => $atts['feedURL'],
				'sortby'           => $atts['sortBy'],
				'filterby'         => $atts['filterBy'],
				'number'           => $atts['number'],
				'menu'             => $atts['podcastMenu'],
				'image'            => $image_id,
				'description'      => $atts['description'],
				'img_url'          => $img_url,
				'header-default'   => true === $atts['headerDefault'] ? 1 : 0,
				'list-default'     => true === $atts['listDefault'] ? 1 : 0,
				'hide-header'      => true === $atts['hideHeader'] ? 1 : 0,
				'hide-title'       => true === $atts['hideTitle'] ? 1 : 0,
				'hide-cover-img'   => true === $atts['hideCover'] ? 1 : 0,
				'hide-description' => true === $atts['hideDesc'] ? 1 : 0,
				'hide-subscribe'   => true === $atts['hideSubscribe'] ? 1 : 0,
				'hide-search'      => true === $atts['hideSearch'] ? 1 : 0,
				'hide-author'      => true === $atts['hideAuthor'] ? 1 : 0,
				'hide-content'     => true === $atts['hideContent'] ? 1 : 0,
				'hide-loadmore'    => true === $atts['hideLoadmore'] ? 1 : 0,
				'hide-download'    => true === $atts['hideDownload'] ? 1 : 0,
				'hide-social'      => true === $atts['hideSocial'] ? 1 : 0,
				'hide-featured'    => true === $atts['hideFeatured'] ? 1 : 0,
				'accent-color'     => $atts['accentColor'],
				'display-style'    => $atts['displayStyle'],
				'apple-sub'        => $atts['appleSub'],
				'google-sub'       => $atts['googleSub'],
				'spotify-sub'      => $atts['spotifySub'],
				'excerpt-length'   => $atts['excerptLength'],
				'excerpt-unit'     => $atts['excerptUnit'],
				'classes'          => isset( $atts['className'] ) ? $atts['className'] : '',
				'random'           => true,
				'from'             => 'block',
			),
			$atts
		);

		$display = Display::get_instance();
		return $display->init( $display_args, true );
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
