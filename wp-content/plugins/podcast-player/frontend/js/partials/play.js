import props from './variables';

class PlayEpisode {

	/**
	 * Currently clicked list item.
	 */
	listItem;

	/**
	 * Load more class object.
	 */
	loadMore;

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
		this.list = props[id].list;
		this.episode = props[id].episode;
		this.player = props[id].player;
		this.mediaObj = props[id].mediaObj;
		this.instance = props[id].instance;
		this.modalObj = props[id].modal;
		this.singleWrap = props[id].singleWrap;
		this.data = props.podcastPlayerData;
		this.msgMediaObj = props[id].msgMediaObj;
		this.msgControls = this.msgMediaObj ? jQuery(this.msgMediaObj.controls) : false;
		this.msgMedia = this.msgMediaObj ? this.msgMediaObj.media : false;
		this.msgFreqCounter = 0;
		this.controls = jQuery(this.mediaObj.controls);
		this.plBtn = this.controls.find( '.ppjs__playpause-button > button' );
		this.prevBtn = this.podcast.find('.pp-prev-btn').attr('disabled', true);
		this.nxtBtn = this.podcast.find('.pp-next-btn');
		this.copylink = this.podcast.find('.ppsocial__copylink');
		this.copyField = this.podcast.find('input.pp-copylink');
		this.playingAmsg = false;
		this.playAmsg = false;
		this.played = false;
		this.settings = props[id].settings;
		this.isPremium = this.settings.isPremium;
		this.timeOut = false;
		setTimeout(() => {this.timeOut = true}, 3000);

		this.events();
	}

	/**
	 * PodcastTabs event handling.
	 * 
	 * @since 1.3
	 */
	events() {

		const _this = this;
		if (! _this.podcast.hasClass('postview')) {
			_this.list.on('click', '.episode-list__entry, .episode-list__search-entry', function(e) {
				e.preventDefault();
				_this.listItem = jQuery(this);
				_this.modPrevBtn();
				_this.modNextBtn();
				_this.play();

				// Displable buttons if search window is opened.
				if (_this.podcast.hasClass('search-opened')) {
					_this.prevBtn.attr('disabled', true);
					_this.nxtBtn.attr('disabled', true);
				}
			});
		} else {
			_this.list.on('click', '.pod-entry__title a, .pod-entry__excerpt a, .pod-entry__featured', function(e) {
				const $this = jQuery(this);
				if ( $this.hasClass('fetch-post-title') ) return;
				const pid = `pp-podcast-${_this.instance}`;
				const info = _this.data[pid].load_info;
				let hideDescription = info ? (info.args ? info.args.hddesc : false) : false;
				hideDescription = hideDescription ? hideDescription : false;
				const isModalView = (! $this.hasClass('pod-entry__featured') && ! hideDescription) || _this.mediaObj.isVideo;
				e.preventDefault();
				_this.listItem = $this.closest('.pod-entry');
				_this.modPrevBtn();
				_this.modNextBtn();
				_this.playModal(isModalView);

				// Let's shift focus inside modal window for better keyboard navigation.
				if (isModalView && _this.modalObj.modal) {
					setTimeout(() => {
						_this.modalObj.modal.find('.ppjs__audio-controls button').first().focus();
					}, 200);
				}

				// Displable buttons if search window is opened.
				if (_this.podcast.hasClass('search-opened')) {
					_this.prevBtn.attr('disabled', true);
					_this.nxtBtn.attr('disabled', true);
				}
			});
		}

		this.prevBtn.on('click', this.playPreviousEpisode.bind(this));
		this.nxtBtn.on('click', this.playNextEpisode.bind(this));

		if (this.msgMedia) {
			this.msgMedia.addEventListener('ended', this.msgMediaEnded.bind(this));
		}
		this.mediaObj.media.addEventListener('ended', this.mediaEnded.bind(this));
		this.plBtn.on('click', this.playPauseBtn.bind(this));
		this.copylink.on('click', function(e) {
			e.preventDefault();
			_this.copyLink();
		});
		jQuery(window).on( 'load', function() {
			if (! _this.podcast.parent().hasClass('pp-sticky-player') ) {
				return;
			}
			_this.listItem = _this.podcast.find('.pod-entry').first();
			_this.modPrevBtn();
			_this.modNextBtn();
			_this.showStickyPlayer();
		} );
	}

	/**
	 * Play previous Episode.
	 * 
	 * @since 2.0
	 */
	playPreviousEpisode() {
		this.prevBtn.attr('disabled', true);
		if (this.listItem && !this.listItem.hasClass('episode-list__search-entry')) {
			const item = this.listItem.prev('.episode-list__entry');
			if (item.length) {
				this.listItem = item;
				this.modNextBtn();
				if ( this.podcast.hasClass('postview') ) {
					this.playModal(this.modalObj.modal && this.modalObj.modal.hasClass('modal-view'));
				} else {
					this.play();
				}
				const newItem = this.listItem.prev('.episode-list__entry');
				if (newItem.length) this.prevBtn.attr('disabled', false);
				return;
			}
		}
		this.prevBtn.blur();
	}

	/**
	 * Modify status of previous Episode Button.
	 * 
	 * @since 2.0
	 */
	modPrevBtn() {
		this.prevBtn.attr('disabled', true);
		if (this.listItem && !this.listItem.hasClass('episode-list__search-entry')) {
			if (this.listItem.prev('.episode-list__entry').length) {
				this.prevBtn.attr('disabled', false);
			}
		}
	}

	/**
	 * Play Next Episode.
	 * 
	 * @since 2.0
	 */
	playNextEpisode() {
		if (this.listItem && !this.listItem.hasClass('episode-list__search-entry')) {
			const item = this.listItem.next('.episode-list__entry');
			if (item.length) {
				this.listItem = item;
				this.modPrevBtn();
				if ( this.podcast.hasClass('postview') ) {
					this.playModal(this.modalObj.modal && this.modalObj.modal.hasClass('modal-view'));
				} else {
					this.play();
				}
				const newItem = this.listItem.next('.episode-list__entry');
				if (!newItem.length) {
					this.checkforNextEpisode(false);
				}
			} else {
				this.checkforNextEpisode(true);
			}
		} else {
			const firstElem = this.list.find('.episode-list__entry').first();
			if (firstElem.length) {
				this.listItem = firstElem;
				if ( this.podcast.hasClass('postview') ) {
					this.playModal(this.modalObj.modal && this.modalObj.modal.hasClass('modal-view'));
				} else {
					this.play();
				}
			}
		}
		this.nxtBtn.blur();
	}

	/**
	 * Check for next Next Episode.
	 * 
	 * @since 2.0
	 * 
	 * @param {bool} play
	 */
	checkforNextEpisode(play) {
		if (this.podcast.hasClass('single-audio')) {
			this.nxtBtn.attr('disabled', true);
			return;
		}
		if (!this.loadMore) this.loadMore = props[this.id].loadMore;
		if (this.loadMore) {
			this.loadMore.loadEpisodes();
			const item = this.listItem.next('.episode-list__entry');
			if (item.length) {
				if (play) {
					this.listItem = item;
					this.modPrevBtn();
					this.play();
				}
			} else {
				this.nxtBtn.attr('disabled', true);
			}
		}
	}

	/**
	 * Modify status of previous Episode Button.
	 * 
	 * @since 2.0
	 */
	modNextBtn() {
		if (this.nxtBtn.is(':disabled')) {
			if (this.listItem && !this.listItem.hasClass('episode-list__search-entry')) {
				if (this.listItem.next('.episode-list__entry').length) {
					this.nxtBtn.attr('disabled', false);
				}
			}
		}
		if (this.listItem && !this.listItem.hasClass('episode-list__search-entry')) {
			const newItem = this.listItem.next('.episode-list__entry');
			if (!newItem.length) {
				this.checkforNextEpisode();
			}
		}
	}

	/**
	 * Common actions before plating podcast episode.
	 * 
	 * @since 2.0
	 */
	common() {
		const pid = `pp-podcast-${this.instance}`;
		const rdata = this.data[pid] ? this.data[pid].rdata : false;
		const info = this.data[pid] ? this.data[pid].load_info : false;
		const args = info ? info.args : false;
		const id = this.listItem.attr('id');
		const pbr = props[this.id].playRate || 1;
		let share = this.controls.find('.ppshare__social');
		let active, details, ppurl, pptitle, src, excerpt, elen, eunit;

		// Remove active class from previously active episode.
		active = this.list.find('.activeEpisode')
		if ( 0 < active.length ) {
			active.removeClass( 'activeEpisode media-playing' );
		}

		if (this.msgMediaObj) {
			if ( ! this.msgMediaObj.paused ) {
				this.msgMediaObj.pause();
			}
			this.msgMediaObj.currentTime = 0;
		}

		this.played = true;
		this.playingAmsg = false;
		this.player.removeClass('msg-playing');

		// Update podcast data on single podcast wrapper.
		if ( this.listItem.hasClass( 'episode-list__search-entry' ) ) {
			details = this.data.search[id];
		} else {
			details = this.data[pid][id];
		}

		// Generate social sharing links.
		ppurl   = encodeURIComponent(details.link);
		pptitle = encodeURIComponent(details.title);
		src = jQuery("<div>").html(details.src).html().replace(/&amp;/g, "&");

		if (this.isPremium && false !== rdata && 'feedurl' === rdata.from) {
			if ('undefined' !== typeof details.key) {
				const query = {
					ppplayer : rdata.fprint,
					ppepisode: details.key,
				}
				const qstr = jQuery.param( query );
				const plink = rdata.permalink;
				ppurl = plink ? (plink + ( plink.indexOf('?') < 0 ? '?' : '&') + qstr) : ppurl;
				ppurl = encodeURIComponent(ppurl);
			}
		} else if (this.isPremium) {
			const query = {
				sharedby : 'pplayer',
			}
			const qstr = jQuery.param( query );
			ppurl = ppurl + ( ppurl.indexOf('?') < 0 ? '?' : '&') + encodeURIComponent(qstr);
		}

		const fburl = "https://www.facebook.com/sharer.php?u=" + ppurl;
		const twurl = "https://twitter.com/intent/tweet?url=" + ppurl + "&text=" + pptitle;
		const liurl = "https://www.linkedin.com/shareArticle?mini=true&url=" + ppurl;
		const mail  = "mailto:?subject=" + pptitle + "&body=Link:" + ppurl;

		this.listItem.addClass( 'activeEpisode media-playing' );
		this.episode.find( '.episode-single__title' ).html( details.title );
		this.episode.find( '.episode-single__author > .single-author' ).html( details.author );
		this.controls.find('.ppjs__episode-title').html(details.title);
		this.episode.find( '.episode-single__description' ).html( details.description );
		share.find( '.ppsocial__facebook' ).attr( 'href', fburl );
		share.find( '.ppsocial__twitter' ).attr( 'href', twurl );
		share.find( '.ppsocial__linkedin' ).attr( 'href', liurl );
		share.find( '.ppsocial__email' ).attr( 'href', mail );
		share.find( 'input.pp-copylink' ).val(decodeURIComponent(ppurl));
		this.controls.find( '.ppshare__download' ).attr( 'href', src );
		this.controls.find( '.ppshare__download' ).attr( 'download', src );
		elen = this.podcast.data('elength');
		eunit = this.podcast.data('eunit');
		if (elen) {
			excerpt = this.episode.find('.episode-single__description');
			excerpt = excerpt.length ? excerpt.text().trim() : false;
			if (excerpt && excerpt.length) {
				if (eunit) {
					if (excerpt.length > elen) {
						excerpt = excerpt.substr(0, elen);
						this.controls.find('.ppjs__more').css('display', 'inline');
					} else {
						this.controls.find('.ppjs__more').css('display', 'none');
					}
				} else if (excerpt.split(/\s+/).length > elen) {
					excerpt = excerpt.split(/\s+/).splice(0,elen).join(" ");
					this.controls.find('.ppjs__more').css('display', 'inline');
				} else {
					this.controls.find('.ppjs__more').css('display', 'none');
				}
				this.controls.find('.ppjs__excerpt-content').text(excerpt);
				this.controls.find('.ppjs__episode-excerpt').show();
			} else {
				this.controls.find('.ppjs__episode-excerpt').hide();
			}
		}

		this.mediaObj.setSrc( src );
		this.mediaObj.load();
		this.mediaObj.media.playbackRate = pbr;
		this.playMessage();
		return true;
	}

	/**
	 * Display btn image.
	 * 
	 * @since 2.3
	 */
	btnImage() {
		const pid = `pp-podcast-${this.instance}`;
		const id = this.listItem.attr('id');
		const dsrc = this.player.find('.ppjs__img-btn').attr('data-src');
		let details;

		// Update podcast data on single podcast wrapper.
		if ( this.listItem.hasClass( 'episode-list__search-entry' ) ) {
			details = this.data.search[id];
		} else {
			details = this.data[pid][id];
		}

		const { title, featured, fset } = details;

		if (featured) {
			this.player.find('.ppjs__img-btn').attr('srcset', fset).attr('src', featured).attr('alt', title).closest('.ppjs__img-wrapper').removeClass('noimg');

			// Compatibility with lazy load plugins (Only if they use data-src attribute).
			if ( typeof dsrc !== typeof undefined && dsrc !== false ) {
				this.player.find('.ppjs__img-btn').attr('data-srcset', fset).attr('data-src', featured);
			}
			if (this.modalObj) {
				this.modalObj.modal.find('.ppjs__img-btn').attr('scrset', fset).attr('src', featured).attr('alt', title).closest('.ppjs__img-wrapper').removeClass('noimg');
			}
		} else {
			this.player.find('.ppjs__img-wrapper').addClass('noimg');
			if (this.modalObj) {
				this.modalObj.modal.find('.ppjs__img-wrapper').addClass('noimg');
			}
		}
	}

	/**
	 * Play/pause media on button click.
	 * 
	 * @since 1.3
	 */
	playPauseBtn() {

		// Playing the podcast for the first time after page load.
		if (false === this.played) {
			this.played = true;
			this.listItem = this.list.find('.episode-list__entry').first();

			if (! this.listItem.length) {
				const id = `ppe-${this.instance}-1`;
				this.listItem = jQuery('<div />', { class: 'episode-list__entry', id: id })
			}

			this.play();
			return;
		}

		if (this.mediaObj.paused) {
			this.mediaObj.play();
			if (this.listItem) this.listItem.addClass('activeEpisode media-playing');
		} else {
			this.mediaObj.pause();
			if (this.listItem) this.listItem.removeClass('activeEpisode media-playing');
		}
	}

	/**
	 * Play episode in player view.
	 * 
	 * @since 1.3
	 */
	play() {
		const _this = this;

		// If clicked on the currently playing episode.
		if (this.listItem.hasClass( 'activeEpisode' )) {
			this.listItem.removeClass( 'activeEpisode' );
			this.mediaObj.pause();
			this.player.removeClass('msg-playing');
			this.playingAmsg = false;
			if (this.msgMediaObj) {
				this.msgMediaObj.pause();
				this.msgMediaObj.currentTime = 0;
			}
			return;
		}

		if (this.modalObj.modal && this.modalObj.modal.hasClass('pp-modal-open')) {
			this.modalObj.returnElem();
		}

		// Wait for data preload, if not already loaded.
		if (false === props[this.id].fetched) {
			if (false === this.timeOut) {
				setTimeout(() => {_this.play()}, 200);
			}
			return;
		}

		// Perform common actions before plating podcast.
		this.common();
		this.btnImage()

		// Auto play the media.
		if (!this.playingAmsg) this.mediaObj.play();

		if (this.podcast.hasClass('wide-player')) {
			// Scroll window to top of the single episode for better UX.
			jQuery( 'html, body' ).animate({ scrollTop: this.player.offset().top - 200 }, 400 );
		} else {
			// Scroll window to top of the single episode for better UX.
			jQuery( 'html, body' ).animate({ scrollTop: this.player.offset().top }, 400 );
		}
	}

	/**
	 * Play episode in post view.
	 * 
	 * Episodes will be played in a Modal window.
	 * 
	 * @since 2.0
	 * 
	 * @param {bool} isModalView
	 */
	playModal(isModalView) {
		const _this = this;
		if (! this.modalObj) return;
		// If current episode is already playing. Let's pause it.
		if (this.listItem.hasClass('activeEpisode')) {
			if (isModalView) {
				this.modalObj.modal.removeClass('inline-view').addClass('modal-view');
				this.modalObj.scrollDisable();
				if (!this.playingAmsg) {
					const wrapper = this.modalObj.modal.find('.episode-primary__title');
					let customTitle = wrapper.find('.episode-single__title');
					customTitle.html(this.episode.find( '.episode-single__title' ).html());
					this.mediaObj.play();
					this.modalObj.modal.removeClass('media-paused');
					this.listItem.addClass('media-playing');
				}
			} else {
				if (this.msgMediaObj && this.playingAmsg) {
					if (!this.msgMediaObj.paused) {
						this.msgMediaObj.pause();
						this.modalObj.modal.addClass('media-paused');
						this.listItem.removeClass('media-playing');
					} else {
						this.msgMediaObj.play();
						this.modalObj.modal.removeClass('media-paused');
						this.listItem.addClass('media-playing');
					}
				} else if (!this.mediaObj.paused) {
					this.mediaObj.pause();
					this.modalObj.modal.addClass('media-paused');
					this.listItem.removeClass('media-playing');
				} else {
					this.mediaObj.play();
					this.modalObj.modal.removeClass('media-paused');
					this.listItem.addClass('media-playing');
				}
			}
			return;
		}

		// Wait for data preload, if not already loaded.
		if (false === props[this.id].fetched) {
			if (false === this.timeOut) {
				setTimeout(() => {_this.playModal()}, 200);
			}
			return;
		}

		// Perform common actions before playing podcast.
		this.common();

		if (!this.singleWrap.hasClass('activePodcast')) {
			if (this.modalObj.modal.hasClass('pp-modal-open')) {
				this.modalObj.returnElem();
			}
			this.modalObj.create(this.singleWrap, this.mediaObj, this.msgMediaObj, isModalView);
			this.singleWrap.addClass('activePodcast');
		} else {
			if (isModalView) {
				const wrapper = this.modalObj.modal.find('.episode-primary__title');
				let customTitle = wrapper.find('.episode-single__title');
				customTitle.html(this.episode.find( '.episode-single__title' ).html());
				this.modalObj.modal.removeClass('inline-view').addClass('modal-view');
				this.modalObj.scrollDisable();
			}
		}

		// Auto play the media.
		if (!this.playingAmsg) this.mediaObj.play();
		this.modalObj.modal.removeClass('media-paused');
		this.btnImage();
	}

	/**
	 * Show sticky player on page load.
	 * 
	 * @since 4.0.0
	 */
	showStickyPlayer() {
		const _this = this;
		if (! this.modalObj) return;

		// Wait for data preload, if not already loaded.
		if (false === props[this.id].fetched) {
			if (false === this.timeOut) {
				setTimeout(() => {_this.showStickyPlayer()}, 200);
			}
			return;
		}

		// Perform common actions before playing podcast.
		this.common();

		if (!this.singleWrap.hasClass('activePodcast')) {
			if (this.modalObj.modal.hasClass('pp-modal-open')) {
				this.modalObj.returnElem();
			}
			this.modalObj.create(this.singleWrap, this.mediaObj, this.msgMediaObj, false);
			this.singleWrap.addClass('activePodcast');
		}
	}

	/**
	 * Play appropriate media.
	 * 
	 * @since 2.5.0
	 */
	playMessage() {
		const pid  = `pp-podcast-${this.instance}`;
		const rdata = this.data[pid] ? this.data[pid].rdata : false;

		// Set episode src, if custom audio message is not set.
		if (!rdata || 'undefined' === typeof(rdata.audiomsg)) {
			return;
		}

		if (rdata.playfreq <= this.msgFreqCounter || false === this.played) {
			this.msgFreqCounter = 0;
			if ('start' === rdata.msgstart) {
				this.playingAmsg = true;
				this.player.addClass('msg-playing');
				if (this.msgMediaObj) this.msgMediaObj.play();
			} else if ('end' === rdata.msgstart) {
				this.playAmsg = true;
			} else if ('custom' === rdata.msgstart) {
				const time = rdata.msgtime[0] * 60 * 60 + rdata.msgtime[1] * 60 + rdata.msgtime[2];
				this.deferredPlay(time);
			}
		} else {
			this.msgFreqCounter++;
			this.playingAmsg = false;
		}
	}

	/**
	 * Deferred play media message.
	 * 
	 * @since 2.5.0
	 * 
	 * @param int time
	 */
	deferredPlay(time) {
		if (time) {
			const currentTime = this.mediaObj.currentTime;
			if (currentTime && currentTime >= time) {
				this.playingAmsg = true;
				this.mediaObj.pause();
				if (this.msgMediaObj) this.msgMediaObj.play();
				this.player.addClass('msg-playing');
			} else {
				setTimeout(() => { this.deferredPlay(time) }, 1000);
			}
		}
	}

	/**
	 * Actions when current media has ended.
	 * 
	 * @since 2.5.0
	 */
	mediaEnded() {

		if (true === this.playAmsg) {
			this.playingAmsg = false;
			this.player.addClass('msg-playing');
			if (this.msgMediaObj) this.msgMediaObj.play();
		} else {
			if (this.listItem && !this.listItem.hasClass('episode-list__search-entry')) {
				this.playNextEpisode();
			}
		}
	}

	/**
	 * Actions when current media has ended.
	 * 
	 * @since 2.5.0
	 */
	msgMediaEnded() {

		if (true === this.playingAmsg) {
			this.player.removeClass('msg-playing');
			this.playingAmsg = false;
			this.mediaObj.play();
		} else if (true === this.playAmsg) {
			if (this.listItem && !this.listItem.hasClass('episode-list__search-entry')) {
				this.playNextEpisode();
			}
		}
	}

	/**
	 * Copy episode link to clipboard.
	 * 
	 * @since 3.7.0
	 */
	copyLink() {

		if ( ! this.copyField.length ) return;
		this.copyField.show();
		this.copyField[0].select();
		this.copyField[0].setSelectionRange(0, 99999);
		document.execCommand("copy");
		this.copylink.addClass('pp-link-copied');
	}
}

export default PlayEpisode;
