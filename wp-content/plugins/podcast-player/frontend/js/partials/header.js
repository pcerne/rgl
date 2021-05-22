import props from './variables';

class PodcastHeader {

	/**
	 * Screen resize timeout.
	 */
	resizeTimeout = null;

	/**
	 * Manage podcast player header elements.
	 * 
	 * @since 1.3
	 * 
	 * @param {string} id Podcast player ID. 
	 */
	constructor(id) {

		// Define variables.
		this.id = id;
		this.podcast = props[id].podcast;
		this.menuToggle = this.podcast.find('.pod-items__menu-open');
		this.infoToggle = this.podcast.find('.pod-launch__info');

		// Run methods.
		this.events();
	}

	// Event handling.
	events() {

		this.menuToggle.on('click', function() {
			this.menuToggle.parent().toggleClass('toggled-window');
			this.menuToggle.toggleClass('toggled-on').attr('aria-expanded', this.menuToggle.hasClass('toggled-on'));
		}.bind(this) );

		this.infoToggle.on('click', function() {
			this.podcast.toggleClass('header-toggle');
			this.infoToggle.toggleClass('toggled-on').attr('aria-expanded', this.menuToggle.hasClass('toggled-on'));
		}.bind(this) );
	}
}

export default PodcastHeader;
