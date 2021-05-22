import props from './variables';

class MediaElements {

	/**
	 * Media Elements JS display control.
	 * 
	 * @since 1.3
	 * 
	 * @param {string} id Podcast player ID.
	 */
	constructor(id) {

		this.id = id;
		this.podcast = props[id].podcast;
		this.mediaObj = props[id].mediaObj;
		this.msgMediaObj = props[id].msgMediaObj;
		this.controls = jQuery(this.mediaObj.controls);
		this.msgControls = this.msgMediaObj ? jQuery(this.msgMediaObj.controls) : false;
		this.layers = this.controls.prev('.ppjs__layers');
		this.media = this.mediaObj.media;
		this.msgMedia = this.msgMediaObj ? this.msgMediaObj.media : false;
		this.modalObj = props[id].modal;
		this.settings = props[id].settings;
		this.transcript = props[id].episode;
		this.list = props[id].list;
		this.props = props[id];
		this.instance = props[id].instance;
		this.player = props[id].player;
		this.isPremium = this.settings.isPremium;
		this.isLargeScrn = props.isLrgScrn;
		this.data = props.podcastPlayerData;

		this.fetched = props[id].fetched;
		this.timeOut = false;
		setTimeout(() => {this.timeOut = true}, 3000);

		this.modControlMarkup();
		this.modLayersMarkup();

		this.plBtn = this.controls.find( '.ppjs__playpause-button > button' );
		this.forBtn = this.controls.find( '.ppjs__jump-forward-button > button' );
		this.bckBtn = this.controls.find( '.ppjs__skip-backward-button > button' );
		this.ttBtn = this.controls.find( '.ppjs__episode-excerpt' );
		this.ssBtn = this.controls.find( '.ppjs__share-button > button' );
		this.pbrBtn = this.controls.find( '.ppjs__play-rate-button > button' );
		this.rateLink = this.controls.find('.prl-item');
		this.copylink = this.podcast.find('.ppsocial__copylink');
		this.copyField = this.podcast.find('input.pp-copylink');

		this.rlbtn = this.podcast.find( '.pp-list-btn' );
		if (this.msgControls) {
			this.msgplBtn = this.msgControls.find( '.ppjs__playpause-button > button' );
			this.msgforBtn = this.msgControls.find( '.ppjs__jump-forward-button > button' );
			this.msgbckBtn = this.msgControls.find( '.ppjs__skip-backward-button > button' );
		}

		this.events();
	}

	/**
	 * PodcastTabs event handling.
	 * 
	 * @since 1.3
	 */
	events() {
		const _this = this;

		jQuery(document).on('click', (e) => {
			const elem = jQuery(e.target);
			const wrap = elem.closest('.toggled-window');
			jQuery('.toggled-window').removeClass('toggled-window');
			if (wrap.length) {
				wrap.addClass('toggled-window');
			}
			if (! elem.closest('.ppshare__social').length) {
				this.copylink.removeClass('pp-link-copied');
				this.copyField.hide();
			}
		});

		jQuery(document).on('keyup', function(event) {
			if ('Escape' === event.key) {
				jQuery('.toggled-window').removeClass('toggled-window');
			}
		});

		// Toggle play button class on play or pause events.
		this.media.addEventListener('loadedmetadata', this.condbtnPauseMedia.bind(this));
		this.media.addEventListener('play', this.btnPlayMedia.bind(this));
		this.media.addEventListener('playing', this.btnPlayMedia.bind(this));
		this.media.addEventListener('pause', this.btnPauseMedia.bind(this));
		this.forBtn.on('click', this.forwardMedia.bind(this));
		this.bckBtn.on('click', this.skipbackMedia.bind(this));
		this.ttBtn.on('click', this.showtranscript.bind(this));
		this.ssBtn.on('click', this.showsocialshare.bind(this));
		this.pbrBtn.on('click', this.mediaPlayToggle.bind(this));
		this.rlbtn.on('click', this.revealList.bind(this));

		this.rateLink.on('click', function(e) {
			e.preventDefault();
			_this.mediaPlayRate.call(_this, this);
		});
		this.podcast.find('.episode-single__close').on('click', this.hidetranscript.bind(this));
		if (this.msgMedia) {
			this.msgMedia.addEventListener('loadedmetadata', this.msgcondbtnPauseMedia.bind(this));
			this.msgMedia.addEventListener('play', this.msgbtnPlayMedia.bind(this));
			this.msgMedia.addEventListener('playing', this.msgbtnPlayMedia.bind(this));
			this.msgMedia.addEventListener('pause', this.msgbtnPauseMedia.bind(this));
		}
		if (this.msgControls) {
			this.msgplBtn.on('click', this.msgPlayPause.bind(this));
			this.msgforBtn.on('click', this.msgForwardMedia.bind(this));
			this.msgbckBtn.on('click', this.msgSkipbackMedia.bind(this));
		}
	}

	/**
	 * Forward audio by specified amount of time.
	 */
	forwardMedia() {

		const interval = 30;
		let currentTime;
		let duration;

		duration = !isNaN(this.media.duration) ? this.media.duration : interval;
		currentTime = ( this.media.currentTime === Infinity ) ? 0 : this.media.currentTime;
		this.media.setCurrentTime(Math.min(currentTime + interval, duration));
		this.forBtn.blur();
	}

	/**
	 * Skip back media by specified amount of time.
	 * 
	 * @since 1.3
	 */
	skipbackMedia() {

		const interval = 10;
		let currentTime;

		currentTime = ( this.media.currentTime === Infinity ) ? 0 : this.media.currentTime;
		this.media.setCurrentTime(Math.max(currentTime - interval, 0));
		this.bckBtn.blur();
	}

	/**
	 * Play/pause media on button click.
	 * 
	 * @since 1.3
	 */
	msgPlayPause() {

		if (this.msgMediaObj.paused) {
			this.msgMediaObj.play();
		} else {
			this.msgMediaObj.pause();
		}
	}

	/**
	 * Forward audio by specified amount of time.
	 */
	msgForwardMedia() {

		const interval = 15;
		let currentTime;
		let duration;

		duration = !isNaN(this.msgMedia.duration) ? this.msgMedia.duration : interval;
		currentTime = ( this.msgMedia.currentTime === Infinity ) ? 0 : this.msgMedia.currentTime;
		this.msgMedia.setCurrentTime(Math.min(currentTime + interval, duration));
		this.msgforBtn.blur();
	}

	/**
	 * Skip back media by specified amount of time.
	 * 
	 * @since 1.3
	 */
	msgSkipbackMedia() {

		const interval = 15;
		let currentTime;

		currentTime = ( this.msgMedia.currentTime === Infinity ) ? 0 : this.msgMedia.currentTime;
		this.msgMedia.setCurrentTime(Math.max(currentTime - interval, 0));
		this.msgbckBtn.blur();
	}

	/**
	 * Toggle media play back window.
	 * 
	 * @since 2.0
	 */
	mediaPlayToggle() {
		this.pbrBtn.parent().toggleClass('toggled-window');
	}

	/**
	 * Toggle media play list.
	 * 
	 * @since 2.0
	 */
	revealList() {
		this.list.slideToggle(400);
		this.rlbtn.toggleClass('toggled-on');
		if (!this.rlbtn.hasClass('toggled-on')) {
			// Scroll window to top of the single episode for better UX.
			jQuery( 'html, body' ).animate({ scrollTop: this.player.offset().top }, 400 );
		}
		this.rlbtn.blur();
	}

	/**
	 * Change media play back rate.
	 * 
	 * @since 2.0
	 * 
	 * @param Obj elem
	 */
	mediaPlayRate(el) {
		const elem = jQuery(el);
		const num = parseFloat(elem.text());
		const wrapper = elem.closest('.ppjs__button');
		props[this.id].playRate = num;
		if (wrapper.length && wrapper.hasClass('toggled-window')) {
			const rateHolder = wrapper.find('.pp-rate');
			rateHolder.text(num);
			this.media.playbackRate = num;
			wrapper.removeClass('toggled-window');
		}
	}

	/**
	 * Manage button class for playing media.
	 */
	btnPlayMedia() {

		if (!this.podcast.hasClass('postview')) {
			if (this.modalObj.modal && this.modalObj.modal.hasClass('pp-modal-open')) {
				this.modalObj.returnElem();
			}
		}

		if (!this.plBtn.hasClass('playing')) {
			this.plBtn.removeClass('pause');
			this.bufferedPlay();
		}
	}

	/**
	 * Manage button class for playing media.
	 */
	bufferedPlay() {
		if (this.plBtn.hasClass('pause')) {
			this.plBtn.removeClass('buffering');
			return;
		}
		if (this.media.readyState >= 0 && this.media.readyState < 4 ) {
			this.plBtn.addClass('buffering');
			setTimeout(() => { this.bufferedPlay() }, 250);
		} else {
			this.plBtn.removeClass('buffering');
			this.plBtn.addClass('playing');
		}
	}

	/**
	 * Manage button class for pausing media.
	 */
	btnPauseMedia() {

		this.plBtn.removeClass('playing');
		this.plBtn.addClass('pause');
	}

	/**
	 * Show podcast transcript.
	 */
	showtranscript(e) {
		e.preventDefault();
		this.transcript.slideToggle('fast');
	}

	/**
	 * Hide podcast transcript.
	 */
	hidetranscript() {

		this.transcript.slideUp('fast');
	}

	/**
	 * Show podcast transcript.
	 */
	showsocialshare() {
		this.ssBtn.parent().toggleClass('toggled-window');
		this.podcast.find('.ppsocial__copylink').removeClass('pp-link-copied');
	}

	/**
	 * Conditionally manage button for media.
	 */
	condbtnPauseMedia() {

		if (this.media.rendererName.indexOf('flash') === -1) {
			this.plBtn.removeClass( 'playing' );
		}
	}

	/**
	 * Manage button class for playing media.
	 */
	msgbtnPlayMedia() {

		this.msgplBtn.addClass('playing');
	}

	/**
	 * Manage button class for pausing media.
	 */
	msgbtnPauseMedia() {

		this.msgplBtn.removeClass('playing');
	}

	/**
	 * Conditionally manage button for media.
	 */
	msgcondbtnPauseMedia() {

		if (this.msgMedia.rendererName.indexOf('flash') === -1) {
			this.msgplBtn.removeClass( 'playing' );
		}
	}

	/**
	 * Modify media controls markup
	 * 
	 * @since 1.3
	 */
	modControlMarkup() {

		const pid = `pp-podcast-${this.instance}`;
		const id = `ppe-${this.instance}-1`;
		const rdata = this.data[pid] ? this.data[pid].rdata : false;
		const linfo = this.data[pid] ? this.data[pid].load_info : false;
		let tempMarkup, episodeTitle, episodeContent, details, featured, imgMarkup, elen, eunit;

		if ( this.data[pid] ) {
			details = this.data[pid][id] ? this.data[pid][id] : {};
			featured = details.featured;
		}

		if (this.mediaObj.isVideo) {

			// Add SVG icons to video control section.
			this.controls.find('.ppjs__time, .ppjs__time-rail').wrapAll('<div class="ppjs__video-timer" />');
			this.controls.prepend(this.settings.ppPlayPauseBtn);
			this.controls.find('.ppjs__fullscreen-button > button').html(this.settings.ppMaxiScrnBtn + this.settings.ppMiniScrnBtn);
			this.transcript.find('.ppjs__img-wrapper').hide();

			// Add featured image as video poster.
			if (featured) {
				this.layers.find('.ppjs__poster').empty().append('<img src="'+ featured + '"/>').show();
			}
		} else {
			
			// Add forward and backward buttons to audio control section.
			this.controls.find('.ppjs__time').wrapAll('<div class="ppjs__audio-timer" />');
			this.controls.find('.ppjs__time-rail').wrap('<div class="ppjs__audio-time-rail" />');
			tempMarkup = jQuery('<div />', { class: 'ppjs__audio-controls' });
			imgMarkup = this.transcript.find('.ppjs__img-wrapper').first();
			tempMarkup.html(this.settings.ppAudioControlBtns);
			this.controls.prepend(tempMarkup);
			this.controls.find('.ppjs__head-container').prepend(imgMarkup);
			episodeTitle = this.transcript.find('.episode-single__title');
			episodeTitle = episodeTitle.length ? episodeTitle.html() : false;
			episodeContent = this.transcript.find('.episode-single__description');
			episodeContent = episodeContent.length ? episodeContent.text().trim() : false;
			episodeContent = (episodeContent && episodeContent.length) ? episodeContent : false;
			elen = linfo ? linfo.args.elength : false;
			elen  = elen ? elen : this.podcast.data('elength');
			eunit = this.podcast.data('eunit');
			if (episodeTitle) this.controls.find('.ppjs__episode-title').html(episodeTitle);
			if (elen && episodeContent) {
				if (eunit) {
					if (episodeContent.length > elen) {
						episodeContent = episodeContent.substr(0, elen);
						this.controls.find('.ppjs__more').css('display', 'inline');
					} else {
						this.controls.find('.ppjs__more').css('display', 'none');
					}
				} else if (episodeContent.split(/\s+/).length > elen) {
					episodeContent = episodeContent.split(/\s+/).splice(0,elen).join(" ");
					this.controls.find('.ppjs__more').css('display', 'inline');
				} else {
					this.controls.find('.ppjs__more').css('display', 'none');
				}
				this.controls.find('.ppjs__excerpt-content').text(episodeContent);
				this.controls.find('.ppjs__episode-excerpt').show();
			} else {
				this.controls.find('.ppjs__episode-excerpt').hide();
			}
			if ( this.props.isWide ) {
				if (rdata && 'undefined' !== typeof(rdata.title) && rdata.title) {
					this.controls.find('.ppjs__podcast-title').html(rdata.title);
				} else {
					let podt = this.podcast.find('.pod-items__title');
					podt = podt.length ? podt.html() : false;
					if (podt) {
						this.controls.find('.ppjs__podcast-title').html(podt);
					}
				}
			} else if ( this.isLargeScrn && ( this.podcast.hasClass('narrow-player') || this.podcast.hasClass('wide-player') ) ) {
				const imgBtn = imgMarkup.find('.ppjs__img-btn');
				imgBtn.attr('sizes', '(max-width: 640px) 100vw, 640px');
				if ('undefined' !== typeof(imgBtn.attr('data-sizes'))) {
					imgBtn.attr('data-sizes', '(max-width: 640px) 100vw, 640px');
				}
			}

			// Remove audio tag to prevent exposing audio URLs.
			jQuery(this.media).find('audio.pp-podcast-episode.hide-audio').remove();
		}

		this.modMediaMarkup();

		if (this.msgMediaObj) {
			this.msgControls.find('.ppjs__time').wrapAll('<div class="ppjs__audio-timer" />');
			this.msgControls.find('.ppjs__time-rail').wrap('<div class="ppjs__audio-time-rail" />');
			tempMarkup = jQuery('<div />', { class: 'ppjs__audio-controls' });
			tempMarkup.html(this.settings.ppAudioControlBtns);
			this.msgControls.prepend(tempMarkup);
			if (rdata && 'undefined' !== typeof(rdata.msgtext)) {
				this.msgControls.find('.ppjs__episode-title').text(rdata.msgtext);
			}
		}
	}

	/**
	 * Modify mediaelement layers markup
	 * 
	 * @since 1.3
	 */
	 modMediaMarkup() {

		const _this = this;

		// Wait for data preload, if not already loaded.
		if (false === props[this.id].fetched) {
			if (false === this.timeOut) {
				setTimeout(() => {_this.modMediaMarkup()}, 200);
			}
			return;
		}

		const pid = `pp-podcast-${this.instance}`;
		const id = `ppe-${this.instance}-1`;
		const rdata = this.data[pid] ? this.data[pid].rdata : false;
		let details, featured;

		if ( this.data[pid] ) {
			details = this.data[pid][id] ? this.data[pid][id] : {};
			featured = details.featured;
		}

		if (details && rdata) {
			// Generate social sharing links.
			let ppurl   = encodeURIComponent(details.link);
			let src = jQuery("<div>").html(details.src).html().replace(/&amp;/g, "&");
			const share = this.controls.find('.ppshare__social');
			const pptitle = encodeURIComponent(details.title);

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

			share.find( '.ppsocial__facebook' ).attr( 'href', fburl );
			share.find( '.ppsocial__twitter' ).attr( 'href', twurl );
			share.find( '.ppsocial__linkedin' ).attr( 'href', liurl );
			share.find( '.ppsocial__email' ).attr( 'href', mail );
			share.find( 'input.pp-copylink' ).val(decodeURIComponent(ppurl));

			this.controls.find( '.ppshare__download' ).attr( 'href', src );
			this.controls.find( '.ppshare__download' ).attr( 'download', src );
		}
	}

	/**
	 * Modify mediaelement layers markup
	 * 
	 * @since 1.3
	 */
	modLayersMarkup() {

		// Add SVG icon markup to media layers elements.
		this.layers.find( '.ppjs__overlay-play > .ppjs__overlay-button' ).html( this.settings.ppPlayCircle );
		this.layers.find( '.ppjs__overlay > .ppjs__overlay-loading' ).html( this.settings.ppVidLoading );
	}
}

export default MediaElements;
