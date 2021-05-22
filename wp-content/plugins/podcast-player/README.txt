=== Podcast Player - Your Podcasting Companion ===
Contributors: vedathemes
Tags: podcast, podcasting, rss feed, feed to audio, podcaster
Requires at least: 4.9
Tested up to: 5.7
Requires PHP: 5.6
Stable tag: 4.6.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Showcase your podcast only using podcasting feed url. Use custom widget, shortcode or editor block to display podcast player anywhere on your site.

== Description ==
[Podcast Player](https://vedathemes.com/blog/vedaitems/podcast-player-pro/) provides an easy way to show and play your podcast episodes using podcasting feed url. It is a must have plugin for your podcast website. Give your listeners an easy access to all your episodes from any page or even from all the pages of your website.

[Podcast Player Pro](https://vedathemes.com/blog/vedaitems/podcast-player-pro/) | [Live Demo](https://vedathemes.com/pp-demo/) | [Documentation](https://vedathemes.com/blog/help/documentation/)

[youtube https://youtu.be/5AO6CGZD-p8]

= Podcast player key features =

* Give your listeners an easy access to your podcast episodes.
* Display responsive podcast player just by entering your podcast's feed url.
* Fetch all required details from feed url.
* Option to modify fetched details of your podcast.
* Option to Show or Hide individual player elements.
* Give your listener an option to share your podcast episodes.
* Ajax live search episodes from the podcast.
* It is possible to have multiple instances of podcast player on single page.
* Self adjusting layout according to width of the podcast player.

= Podcast player pro features =

* Professionally showcase your podcast using our unified player, episode list and grid templates.
* Use powerful filter options to choose which episodes or seasons you want to display on your website.
* Make your entire podcast catalogue easily available using our ajax approximate search feature.
* Add an audio message within your podcast episode.
* Add audio mp3 to your WordPress posts and display as podcast episodes.
* Show or hide specific elements and customize color and fonts to personalize your podcast display


= Setup Podcast Player Widget =

Display searchable podcast episodes list on any widget area of your website.

Minimum Setup

1. After activating the plugin, visit Appearance > Widgets in admin dashboard.
1. Look for 'Podcast player' widget in left 'Available Widgets' section.
1. Drag the widget to any available sidebar/widget area.
1. Enter feed url in the appropriate field.
1. Click [Save] button.

Advanced Setup

1. After activating the plugin, visit Appearance > Widgets in admin dashboard.
1. Look for 'Podcast player' widget in left 'Available Widgets' section.
1. Drag the widget to any available sidebar/widget area.
1. Enter feed url in the appropriate field.
1. Optionally, click on "Change podcast content" button to customize feed's auto fetched details.
1. Optionally, click on "Show/Hide player items" button to show or hide player elements.
1. Optionally, click on "Podcast player styling" button to customize player's accent color.
1. Optionally, click on "Sort & Filter" button to sort or filter podcast episodes.
1. Click [Save] button.

= Setup Podcast Player Block =

Display searchable podcast episodes list on any post or page. Make sure you have not disabled WordPress latest block editor.

Setup

1. After activating the plugin, visit any post or page's edit screen.
1. In main content area, click on '+' icon to add a new block.
1. Search for 'Podcast Player' block.
1. Enter feed url in the appropriate field. A preview of your podcast player will appear.
1. Click on the podcast player preview.
1. Select appropriate options from the right sidebar to customize the player.
1. Save or Update the post.

= Setup Podcast Player using shortcode =

Minimum Setup

	[podcastplayer feed_url ='']

1. feed_url - Your podcast feed url.

Advanced Setup

	[podcastplayer feed_url ='' number='' podcast_menu='' cover_image_url='' hide_cover='true' hide_description='true' hide_subscribe='true' hide_search='true' hide_loadmore='true' hide_download='true' accent_color='#65b84f']Short Description [/podcastplayer]

1. feed_url: Your podcast feed url.
1. number: Number of podcasts episodes to be displayed at a time.
1. podcast_menu: Any previously created WordPress menu's name OR ID OR slug. (optional)
1. cover_image_url: Podcast's cover image url. The image must be from your WP media library. (optional)
1. header_default: (false/true) Show player header items by default
1. hide_header: Hide player header items
1. hide_title: (false/true) Show / Hide podcast Title in header info section
1. hide_cover: (false/true) Show / Hide podcast cover image
1. hide_description: (false/true) Show / Hide podcast description
1. hide_subscribe: (false/true) Show / Hide podcast subscribe button.
1. hide_search: (false/true) Show / Hide podcast search field.
1. hide_author: (false/true) Show / Hide author/podcaster's name.
1. hide_content: (false/true) Show / Hide podcast episode's content.
1. hide_loadmore: (false/true) Show / Hide podcast load more button.
1. hide_download: (false/true) Show/ Hide podcast episode download link.
1. hide_social: (false/true) Show/ Hide podcast episode social sharing links.
1. accent_color: Podcast player's accent color (Color hex-code to be entered).
1. sortby: Sort podcast episodes (sort_date_desc/sort_date_asc/sort_title_desc/sort_title_asc)
1. filterby: Filter by any string in episode's title
1. list_default: (false/true) Display Episodes list by default on small screen
1. hide_featured: (false/true) Show / Hide podcast episode featured image
1. apple_sub: Apple podcast subscription link
1. google_sub: Google podcast subscription link
1. Short Description:  Podcast short text description. (optional)

== Installation ==

Installing “Podcast player” can be done either by searching for “Podcast Player” via the “Plugins > Add New” screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org
1. Upload the ZIP file through the ‘Plugins > Add New > Upload’ in your WordPress dashboard
1. Activate the plugin through the ‘Plugins’ menu in WordPress

== Frequently Asked Questions ==

= Why my latest episode is NOT visible in Podcast Player? =
By default, WordPress cache RSS feeds for 12 hours. Therefore, new episodes will be visible after 12 hours from last update. However, you can manually refresh your podcast by going to WordPress Dashboard > Settings > Podcast player. Use "Feed updation tool" in toolkit section.

= Why podcast episode appear twice? =
It happens when your podcast episode's audio url changes. To fix this, just reset your podcast by going to WordPress Dashboard > Settings > Podcast player. Use "Feed updation tool" in toolkit section.

= Why podcast player is not visible on the front-end? =
If Podcast player is not visible on the front-end, most probably there is some JavaScript error on the webpage. Refer [this link](https://wordpress.org/support/article/using-your-browser-to-diagnose-javascript-errors/) to know how to diagnose JavaScript errors.

= Why podcast player download podcast images to my media folder =
Podcast Player download images to your WordPress media folder to serve smaller images and help make your site load faster. However, you can disable this feature by going to WordPress Dashboard > Settings > Podcast player. Uncheck "Download & Serve responsive images" in settings section.

= Is podcast player compatible with AMP =
Presently, Podcast player is not compatible with AMP (Accelerated mobile pages).

= Where can I host my podcast files? =
You can host your podcast files anywhere. This plugin only uses rss feed link to fetch and display your podcast episodes.

= Does it support video podcasts? =
Yes, this plugin supports video podcasts (mp4 format).

= Can it support multiple feeds in a single player? =
No, you cannot use multiple podcast feed urls in one player instance.

= Is it responsive friendly? =
Yes, podcast player is completely mobile responsive. It can even change its layout according to its container width. For example, on larger screen, layout of podcast player on a narrow sidebar will be different than on a wider content section.

= Can I show multiple podcast players on a single page? =
Yes. You can display multiple instances of podcast player on a single page/post.

= I have added podcast player block, but I cannot play episodes in edit screen? =
Podcast player block, which appear in post's or page's edit screen is only for previewing purpose. Though, it will play nicely on front-end.

= Does this plugin respect end-user privacy? =
Podcast player plugin (on its own) does not create and save any cookies and does not use or store end-user's IP address. However, website owners (who uses this plugin to display podcast player on their website) are  solely responsible for all user privacy on their site.

== Screenshots ==
1. Display podcast player using custom widget
2. Display podcast player using shortcode
3. Display podcast player using editor block
4. Podcats player on small size container
5. Podcast player on large size container

== Changelog ==

= 4.6.0 =
* Error Fix: Elementor content issue with pro version
* Error Fix: Ajax loading compatibility for podcast player
* Modify: Hide Audio Tag on front end to prevent exposing audio URL.

= 4.5.0 =
* Modify: Option to hide podcast related data from front source code.
* Error Fix: Compatibility error with Seriously simple podcasting.

= 4.4.0 =
* Error Fix: Fix for image URL validation function.
* Error Fix: Fix for fethching feed items using Ajax.

= 4.3.0 =
* Error Fix: Compatibility with IE11
* Error Fix: Handle getting srcset of image if srcset is false.
* Error Fix: Removed jQuery depricated functions.
* Modify: More options in default sticky player tool (pro)
* Modify: Compatibility test with WordPress 5.7
* New: Bulk single player display tool (pro)

= 4.2.0 =
* Modify: Remove compatibility codes for PP Pro versions before 1.9.0
* Modify: Plugin's documentation links update.
* Add: Added a filter to display custom error message on feed fetch failure.
* Add: Settings for episode date time zone modification.

= 4.1.0 =
* Modify: Improvements in Podcast player settings
* Modify: Compatibility tested with WordPress 5.6
* Add: Improvements in sticky player tool (pro)
* Add: Option for compatibility with Ajax specific websites

= 4.0.0 =
* Error Fix: Styling error fixes
* Error FIx: Minor PHP error fixes
* Add: Additional tools support for pro player.

= 3.9.0 =
* Error Fix: Compatibility with lazy load plugin (Autoptimize and similar).
* Error Fix: Create playlist from local episodes having single filtered feed pp in content.
* Error Fix: Playbackrate not working when playing next episode.
* Error Fix: PP button color styling.
* Add: Support for additional CSS classes feature for podcast player block.
* Add: Option to set excerpt length as number of words OR number of characters.

= 3.8.0 =
* Error Fix: Download and display correctly sized responsive images.
* Error Fix: Show download button on top level, if sharing links are hidden.
* Modify: Excerpt words split by regex to handle any type of white space.
* Add: Subscription buttons on single audio player.

= 3.7.0 =
* Error Fix: removed jQuery deprecated 'ready' event.
* Error Fix: Proper sorting of episode filter list.
* Error Fix: Add a filter to load js and css on all pages. (For ajax websites)
* Error Fix: Minor error in shortcode implementation.
* Add: Button to copy episode link to clipboard.
* Removed: Removed email button in sharing links.

= 3.6.0 =
* Compatibility check with WordPress 5.5
* Minor CSS improvements and bug fixes

= 3.5.0 =
* New: Option to change auto feed refresh interval.
* Modify: Make caching older episodes optional and removed by default.
* Modify: Improve plugin options functions.
* Error Fix: Minor JavaScript related error fixes.
* Error Fix: Improved method for feed index check and refresh.
* Error Fix: Fix in fetching feed data in widget's admin screen.
* Error Fix: Combine all player instances inline css and put them at the bottom of the page.
* Error Fix: Override customization in feed data before applying mod filters.

= 3.4.0 =
* New: Spotify subscribe button
* New: Dropdown list of podcast in feed updation tool
* Modify: Update translation strings pot file
* Modify: Move podcast player settings page out of settings section.
* Modify: Add action links to the free version.
* Modify: Template override for pro templates.
* Modify: Improve plugin's readme file, cover images and screenshots.
* Error Fix: Elementor and ACF support reinstated.

= 3.3.0 =
* Modify: Major codebase changes.
* Modify: Excerpt length change option for default layout.
* Modify: Admin Page and Backend improvement.
* Modify: Load script only if podcast player is displayed on a page.
* Modify: Better support for elementor editor screen.
* Error Fix: Podcast player script to handle defer loading of dependencies.
* New: Option to add rel attributes to all external links in episode content.

= 3.2.0 =
* Error Fix: Fallback to old good data if feed returns error (for non admins).
* Error Fix: Featured images are too big for small and medium players
* Modify: Remove old legacy player related codes
* Modify: Playpause button styling improvements
* Post fetch method compatibility with Powerpress and Seriously simple podcasting
* Seasons filter checkbox (if applicable)
* Episode list checkbox to display specific episodes only

= 3.1.0 =
* Error Fix: Accessibility and RTL audit and error fixes
* Modify: Elementor edit screen compatibility
* Modify: Podcast search feature improvements.
* Add: Option to use a custom field name in place of feed url.

= 3.0.0 =
* Error Fix: Floating time text invisible on dark background color.
* Modify: Podcast header information button improvements
* Modify: Podcast player overall design improvements
* Add: Mini podcast header for default and Catalogue layouts
* Add: Show episodes list by default on mini player.
* Add: Option to add Apple and google subsciprtion links

= 2.9.0 =
* Error Fix: Legacy player episode description overflow if there is no search field.
* Error Fix: Social sharing link only share mp3 even if episode link is available.
* Error Fix: Proper screen-reader only (offscreen) class for social sharing icons.
* Add: Add buffering icon on play pause button.
* Add: compatibility for various premium options.

= 2.8.0 =
* Error Fix: Error in feed URI encoding.

= 2.7.0 =
* Error Fix: Error in feed URI encoding.

= 2.6.0 =
* Add: Preserve older podcast episodes even they are removed from RSS feed.
* Modify: Modify & Improve backend CSS, JS and PHP codes.
* Add: Support new functionality in Podcast Player Pro.

= 2.5.0 =
* Error Fix: Play episodes where audio URL contains query strings.
* Error Fix: Encode audio URI to properly parse episode URL.
* Add: Set custom cover image as video's cover image on page load.
* Add: Support for new features in Podcast player pro.

= 2.4.0 =
* Error Fix: Undefined variable in widget update function.
* Error Fix: Play audio files even if media url contains query strings.
* Error Fix: Minor typographical error in front-end message.
* Error Fix: Fixed background color for Play-Pause button if cover image is available.
* Modify: Display HTML in episode description transcript.
* Modify: Custom sanitization and caching of feed data.
* Modify: Podcast player widget backend code cleanup.
* Modify: Additional css for heading elements in episode description.
* Modify: Minimum PHP requirement has been changed to PHP 5.6+

= 2.3.0 =
* Modify: Accessibility improvements.
* Modify: License changed from GPL2+ to GPL3+.
* Add: Display episode featured image on play pause button.
* Add: Podcast player pro version compatibility.

= 2.2.0 =
* Error Fix: Podcast episodes not playing properly.

= 2.1.0 =
* Error Fix: No podcast player block if legacy player is activated.
* Error Fix: Legacy player fatal error.
* Error Fix: Episode list wrapper height in legacy style correction.
* Modify: Hide close option if header is visible by default.

= 2.0.0 =
* Add: Option to modify audio playback rate.
* Add: Additional podcast player display layout.
* Modify: Major structural changes in backend codes to make plugin more flexible.
* Modify: Major changes in backend functions.

= 1.9.0 =
* Bug Fix: Semi colon and other basic html display error in podcast title.
* Bug Fix: Always load mmerrorfix in header to avoid conflict with other plugins.
* Modify: Display podcast author on narrow width player.

= 1.8.0 =
* Bug Fix: Player not fetching correct media enclosure (if multiple media enclosure).
* Bug Fix: Wrong episode ID in initially loaded episodes.

= 1.7.0 =
* Bug Fix: Styling breaks if more than one player editor block is added.
* Bug Fix: Episode title in Media controls overflow the container.
* Bug Fix: Minor RTL styling error fixed.
* Add: Option to hide podcast header.

= 1.6.0 =
* Add: episode author to the episode list.
* Add: RTL languages support
* Add: Podcats Episodes sort and filter options.
* Add: Option to display a single podcast episode.
* Add: Add podcast player editor block

= 1.5.0 =
* Bug Fix - Fallback to media src if share link is not available.
* Modify - Major styling changes in Podcast Player.
* Modify - Use a custom font stack for the player to reduce font inconsistancy.

= 1.4.0 =
* Bug Fix: Button element styling issue resolved.
* Bug Fix: Bug due to Mediaelement class mutation by mediaelement-migrate script
* Bug Fix: Podcast episode list height on large sreen.
* Bug Fix: Increasing simplebar-placeholder width inside flexbox.
* Remove: Repititive PHP scipt removed from class-podcast-player-display.php
* Remove: Cleaner script removed as it is not required.
* Modify: Minor PHP script improvements.
* Add: Options to download or share podcast episode.
* Compliance with latest WordPress coding standards.

= 1.3.0 =
* Implement OOJS and es-next with webpack and babel setup.
* Scrollbar re-position on load more episodes.
* Styling improvements
* Styles modifications for compatibility with various themes
* Script for removing blank text nodes.

= 1.2.0 =
* Improved media player style and functionality.
* Improved podcast player styling.
* Support for video podcasts.
* Ajax load more episodes in real time.
* Ajax live search episodes
* Display episode content in the player.
* Additional options to show or hide player elements.

= 1.1.0 =
* Option to choose mediaelement.js or html5 audio player.
* Fetch external cover images from url (using shortcode).
* Auto fetch feed items from feed url.
* Podcast player widget's ux improvements.
* Change player layout css for larger wrappers.
* Minor css improvements.

= 1.0.0 =
* First version.

== Upgrade Notice ==

= 1.6.0 =
* Update for many new and improved features.

= 1.5.0 =
* Update required for bug fixes and latest podcast player design.

= 1.4.0 =
* Update required for bug fixes and plugin improvements.

= 1.3.0 =
* Update required for bug fixes and compatibility with various themes.

= 1.2.0 =
* Update required to get better design and functionality of podcast player.

= 1.1.0 =
* Update required for additional features and code optimization.

