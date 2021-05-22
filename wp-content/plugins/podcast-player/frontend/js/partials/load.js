import props from './variables';

class LoadmoreEpisodes {

	/**
	 * Manage podcast tabs elements.
	 * 
	 * @since 1.3
	 * 
	 * @param {string} id Podcast player ID.
	 */
	constructor(id) {

		this.id = id;
		this.podcast = props[id].podcast;
		this.settings = props[id].settings;
		this.instance = props[id].instance;
		this.episodes = props[id].episodes;
		this.fetched = props[id].fetched;
		this.isStyleSupport = props.isStyleSupport;
		this.data = props.podcastPlayerData;
		this.loadbtn = this.podcast.find('.episode-list__load-more');

		this.events();
	}

	/**
	 * PodcastTabs event handling.
	 * 
	 * @since 1.3
	 */
	events() {

		this.preLoadEpisodes();
		this.loadbtn.on('click', this.loadEpisodes.bind(this));
	}

	/**
	 * Preload initial set of episodes.
	 * 
	 * @since 1.4.4
	 */
	 preLoadEpisodes() {

		const pid = `pp-podcast-${this.instance}`;
		const from = this.data[pid] ? this.data[pid].rdata.from : false;
		const load = this.data[pid] ? this.data[pid].load_info : false;
		const loaded = load ? load.loaded : false;
		if (from && 'link' !== from) {
			
			// Pre fetch items only if they are already not loaded.
			if (0 != loaded) {
				props[this.id].fetched = true;
			} else {
				this.fetchEpisodes();
			}
		} else if (from) {
			this.fetchMediaURL();
		}
	}

	/**
	 * Create markup for additional set of episodes (if any).
	 * 
	 * @since 1.3
	 */
	loadEpisodes() {
		const pid = `pp-podcast-${this.instance}`;
		if (! this.data[pid]) return;
		const fid = this.episodes.find('.episode-list__entry').first();
		const from = this.data[pid].rdata.from;
		let details = this.data[pid].load_info;
		const excerptLength = this.data[pid].rdata.elen;
		const excerptUnit = this.data[pid].rdata.eunit;
		const nextList = Math.min(details.displayed + details.step, details.loaded);
		let i = details.displayed + 1;
		let overallMarkup = jQuery( '<div />' );
		const feat = fid.find('.pod-entry__image');
		const sizes = feat.length ? feat.attr('sizes') : '';
		let firstElem = false;

		let epititle = '';
		if ( 'posts' === from ) {
			epititle = 'fetch-post-title';
		}

		for( ; i <= nextList; i++  ) {

			let id = `ppe-${this.instance}-${i}`;
			let episode = this.data[pid][id];
			firstElem = firstElem ? firstElem : id;

			if ( 'undefined' !== typeof(episode) ) {
				let {title, description, author, date, link, featured, fset} = episode;
				let linkMarkup = jQuery('<a />', { href: link, class: epititle }).html( title );
				let excerptLink = jQuery('<a />', { href: link, class: epititle }).html( '[...]' );
				let titleMarkup = jQuery('<div />', { class: 'pod-entry__title' }).html( linkMarkup );
				let dateMarkup = jQuery('<div />', { class: 'pod-entry__date' }).text( date );
				let authorMarkup = jQuery('<div />', { class: 'pod-entry__author' }).html( author );
				let markup;

				if (this.podcast.hasClass('postview')) {
					const style = details.args.display;
					const fullText = description ? jQuery(description).text() : '';
					const pplay = jQuery('<div />', { class: 'pod-entry__play' }).html( this.settings.ppPlayCircle + this.settings.ppPauseBtn );
					let imgMarkup, eHtml = '';
					if (style && this.isStyleSupport(style, 'playbtn')) {
						imgMarkup = '';
					} else {
						imgMarkup = featured ? jQuery('<img />', { class: 'pod-entry__image', src: featured, srcset: fset, sizes: sizes }) : '';
						imgMarkup = imgMarkup ? `<div class="pod-entry__thumb">${imgMarkup[0].outerHTML}</div>` : '';
					}
					if (style && this.isStyleSupport(style, 'excerpt')) {
						let excerpt;
						if ( excerptUnit ) {
							excerpt = fullText ? fullText.substr(0, excerptLength) : '';
						} else {
							excerpt = fullText ? fullText.split(/\s+/).splice(0,excerptLength).join(' ') : '';
						}
						const eMarkup = excerpt ? jQuery('<div />', { class: 'pod-entry__excerpt' }).html( excerpt + excerptLink[0].outerHTML ) : '';
						eHtml = eMarkup ? eMarkup[0].outerHTML : '';
					}
					markup = `
					<div id="${id}" class="episode-list__entry pod-entry" data-search-term="${title.toLowerCase()}">
						<div class="pod-entry__wrapper">
							<div class="pod-entry__featured">
								${pplay[0].outerHTML}
								${imgMarkup}
							</div>
							<div class="pod-entry__content">
								${titleMarkup[0].outerHTML}${eHtml}${dateMarkup[0].outerHTML}${authorMarkup[0].outerHTML}
							</div>
						</div>
					</div>
					`;
				} else {
					markup = `
					<div id="${id}" class="episode-list__entry pod-entry" data-search-term="${title.toLowerCase()}">
						<div class="pod-entry__content">
							${titleMarkup[0].outerHTML}${dateMarkup[0].outerHTML}${authorMarkup[0].outerHTML}
						</div>
					</div>
					`;
				}
				overallMarkup.append(jQuery(markup));
			}
		}

		this.loadbtn.parent().before(overallMarkup.html());

		// Better keyboard navigation.
		// Keyboard focus to first element of newly loaded set of episodes.
		if (firstElem) {
			const fEle = this.podcast.find('#' + firstElem);
			if (fEle.length) {
				fEle.find('a').first().focus();
				if (this.podcast.hasClass('postview')) {
					jQuery( 'html, body' ).animate({ scrollTop: fEle.offset().top - 150 }, 400 );
				}
			}
		}
		

		// Update number of post displayed in the podcast player.
		details.displayed = nextList;

		// Fetch more episodes using Ajax.
		this.fetchEpisodes();
	}

	/**
	 * Fetch more episodes from the server using Ajax.
	 * 
	 * @since 1.3
	 */
	fetchEpisodes() {
		const pid  = `pp-podcast-${this.instance}`;
		const load = this.data[pid].rdata;
		if ( 'feedurl' === load.from ) {
			this.fetchFromFeed();
		} else if ( 'posts' === load.from ) {
			this.fetchFromPosts();
		}
	}

	/**
	 * Fetch URL for single episode player from audio/video link.
	 * 
	 * @since 1.4.4
	 */
	fetchMediaURL() {
		const pid = `pp-podcast-${this.instance}`;
		const id = `ppe-${this.instance}-1`;
		const data = this.data[pid][id];
		const ajax = this.data.ajax_info;
		const src = data.src;
		
		// Return if src already seems to be a valid URL.
		if (0 == src.indexOf("http://") || 0 == src.indexOf("https://")) {
			props[this.id].fetched = true;
			return;
		}
		const adata = {
			action  : 'pp_fetch_media_url',
			security: ajax.security,
			src: src
		};

		// Let's get next set of episodes.
		jQuery.ajax( {
			url: ajax.ajaxurl,
			data: adata,
			type: 'POST',
			timeout: 4000,
			success: response => {
				const details = jQuery.parseJSON( response );

				if (data.src === data.link) {
					data.link = details;
				}
				data.src = details;
				props[this.id].fetched = true;
			},
			error: () => {
				data.src = '#';
				data.link = '#';
			}
		} );
	}

	/**
	 * Fetch more episodes from the RSS feed.
	 * 
	 * @since 2.0
	 */
	fetchFromFeed() {
		const pid = `pp-podcast-${this.instance}`;
		let load = this.data[pid].load_info;
		let ajax = this.data.ajax_info;
		let counter = load.step;
		
		// Load twice of the required episodes for first time.
		if (! props[this.id].fetched) {
			counter = 2 * counter;
		}
		let data = {
				action  : 'pp_fetch_episodes',
				security: ajax.security,
				instance: this.instance,
				loaded  : load.loaded,
				maxItems: load.maxItems,
				feedUrl : load.src,
				step    : counter,
				sortby  : load.sortby,
				filterby: load.filterby,
				args    : load.args
			};

		// If all required episodes have already been loaded.
		if ( load.loaded >= load.maxItems ) {

			// If all loaded episodes have already been displayed.
			if ( load.displayed >= load.loaded ) {
				this.loadbtn.slideUp( 'slow' );
			}

			// No need to run ajax request.
			return;
		}

		// Let's get next set of episodes.
		jQuery.ajax( {
			url: ajax.ajaxurl,
			data: data,
			type: 'POST',
			timeout: 4000,
			success: response => {
				const details = jQuery.parseJSON( response );

				// Update total number of episodes fetched.
				load.loaded = details.loaded;

				// Update episodes collection object.
				jQuery.extend( true, this.data[pid], details.episodes );

				props[this.id].fetched = true;
			},
			error: () => {
				this.loadbtn.hide();
			}
		} );
	}

	/**
	 * Fetch more episodes from the Posts.
	 * 
	 * @since 2.0
	 */
	fetchFromPosts() {
		const pid = `pp-podcast-${this.instance}`;
		let load = this.data[pid].load_info;
		let ajax = this.data.ajax_info;
		let ajaxArgs = jQuery.extend(true, {}, load.args);

		// Load twice of the required episodes for first time.
		if (! props[this.id].fetched) {
			ajaxArgs.number = 2 * ajaxArgs.number;
		}

		let data = {
				action  : 'pp_fetch_posts',
				security: ajax.security,
				instance: this.instance,
				offset  : load.offset, // Deprecated, keeping for compatibility.
				loaded  : load.loaded,
				args    : ajaxArgs,
				ids     : load.ids,
			};

		// If all required episodes have already been loaded.
		// This method has been deprecated. Keeping for compatibiltiy.
		if ( load.offset && 0 === load.offset ) {
			this.loadbtn.slideUp( 'slow' );

			// No need to run ajax request.
			return;
		}

		// New method to know if all required episodes have been loaded.
		if ( load.ids && Array.isArray( load.ids ) ) {
			if ( load.loaded >= load.ids.length ) {
				this.loadbtn.slideUp( 'slow' );

				// No need to run ajax request.
				return;
			}
		}

		// Let's get next set of episodes.
		jQuery.ajax( {
			url: ajax.ajaxurl,
			data: data,
			type: 'POST',
			timeout: 4000,
			success: response => {
				const details = jQuery.parseJSON( response );
				if (jQuery.isEmptyObject(details)) {
					load.offset = 0;
					this.loadbtn.slideUp( 'slow' );
				} else {
					// Update total number of episodes fetched.
					load.loaded = details.loaded;

					// Update overall items ids.
					load.ids = details.ids;

					// Update episodes collection object.
					jQuery.extend( true, this.data[pid], details.episodes );
					
					// This method has been deprecated. Keeping for compatibiltiy.
					if ( load.offset ) {
						load.offset += load.step;
					}
				}
				props[this.id].fetched = true;
			},
			error: () => {
				this.loadbtn.hide();
			}
		} );
	}
}

export default LoadmoreEpisodes;
