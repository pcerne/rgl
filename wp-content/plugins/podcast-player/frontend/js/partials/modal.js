class Modal {

	/**
	 * Currently clicked list item.
	 */
	modal;

	/**
	 * Create and manager podcast player modal window.
	 * 
	 * @since 2.0 
	 */
	constructor() {

		this.settings = window.ppmejsSettings || {};
		this.mediaObj = false;
		this.msgMediaObj = false;

		// Scrolling specific
		this.bodyScrollDisabled = false;
		this.scrollPosition = 0;
		this.scrollingElem = document.scrollingElement || document.documentElement || document.body;

		// Create modal markup.
		this.setup();

		// Run methods.
		this.events();

		this.pauseMedia = this.mediaPause.bind(this);
		this.playMedia = this.mediaPlay.bind(this);
	}

	// Setup modal markup.
	setup() {
		const { ppClose, ppMaxiScrnBtn, ppMiniScrnBtn, ppCloseBtnText } = this.settings;
		const close = jQuery('<button />', { class: 'pp-modal-close' }).html( ppCloseBtnText + ppClose + ppMaxiScrnBtn + ppMiniScrnBtn );
		const modal = `
		<div id="pp-modal-window" class="pp-modal-window">
			<div class="pp-modal-wrapper"></div>
			${close[0].outerHTML}
		</div>`;

		jQuery('body').append(modal);
		this.modal = jQuery('#pp-modal-window');
	}

	// Event handling.
	events() {
		const _this = this;
		this.modal.on('click', '.pp-modal-close', function() {
			if ( !_this.modal.hasClass('media-paused') ) {
				if (_this.modal.hasClass('modal-view')) {
					if (_this.mediaObj.isVideo) {
						_this.modalClose();
					} else {
						_this.modal.removeClass('modal-view').addClass('inline-view');
						_this.scrollEnable();
					}
				} else if (_this.modal.hasClass('inline-view') ) {
					_this.modal.removeClass('inline-view').addClass('modal-view');
					_this.scrollDisable();
				}
			} else {
				_this.modalClose();
			}
		});

		jQuery(document).on('keyup', function(event) {
			if ('Escape' === event.key) {
				if ( !_this.modal.hasClass('media-paused') ) {
					if (_this.modal.hasClass('modal-view') && !_this.mediaObj.isVideo) {
						_this.modal.removeClass('modal-view').addClass('inline-view');
						_this.scrollEnable();
					}
				} else {
					_this.modalClose();
				}
			}
		});

		this.modal.on('click', function(e) {
			const elem = jQuery(e.target);
			if (!_this.modal.hasClass('modal-view')) return;
			if (elem.closest('.pp-modal-wrapper').length || elem.closest('.pp-modal-close').length) return;
			if (_this.modal.hasClass('media-paused')) {
				_this.modalClose();
			} else {
				if (_this.mediaObj.isVideo) {
					_this.modalClose();
				} else {
					_this.modal.removeClass('modal-view').addClass('inline-view');
					_this.scrollEnable();
				}
			}
		});
	}

	// Create & display modal markup.
	create(elem, mediaObj, msgMediaObj, isModalView) {
		const placeHolder = jQuery('<div />', { id: 'pp-modal-placeholder' });
		const wrapper = this.modal.find('.pp-modal-wrapper');
		const podcast = elem.closest('.pp-podcast');
		const id = podcast.attr('id');
		const inst = id.replace( 'pp-podcast-', '' );
		const _this = this;
		const clsTrasnfer = [
			'light-accent',
			'light-color',
			'hide-share',
			'hide-download',
			'hide-social',
		];

		placeHolder.insertBefore(elem);
		wrapper.empty().append(elem);
		wrapper.children().wrapAll('<div class="modal-' + inst +'">');
		if (isModalView) {
			this.modal.addClass('modal-view pp-modal-open');
			this.scrollDisable();
		} else {
			this.modal.addClass('inline-view pp-modal-open');
		}

		// Transfer required styling classes from main player to sticky player.
		jQuery.each(
			clsTrasnfer,
			function( index, value ) {
				if (podcast.hasClass(value)) _this.modal.addClass(value);
			}
		);

		if (this.mediaObj) {
			this.mediaObj.pause();
		}
		this.mediaObj = mediaObj;
		this.msgMediaObj = msgMediaObj;
		this.mediaObj.media.addEventListener('ended', this.pauseMedia);
		this.mediaObj.media.addEventListener('pause', this.pauseMedia);
		this.mediaObj.media.addEventListener('play', this.playMedia);
		this.mediaObj.media.addEventListener('playing', this.playMedia);
		if (this.msgMediaObj) {
			this.msgMediaObj.media.addEventListener('ended', this.pauseMedia);
			this.msgMediaObj.media.addEventListener('pause', this.pauseMedia);
			this.msgMediaObj.media.addEventListener('play', this.playMedia);
			this.msgMediaObj.media.addEventListener('playing', this.playMedia);
		}
	}

	// Setup modal markup.
	mediaPause() {
		this.modal.addClass('media-paused');
		jQuery('#pp-modal-placeholder').parent().find('.activeEpisode').removeClass('media-playing');
	}

	// Setup modal markup.
	mediaPlay() {
		this.modal.removeClass('media-paused');
		jQuery('#pp-modal-placeholder').parent().find('.activeEpisode').addClass('media-playing');
	}

	// Close or minimize modal window.
	modalClose() {
		this.returnElem();
		this.modal.removeClass().addClass('pp-modal-window');
		this.scrollEnable();
		if (this.mediaObj) {
			this.mediaObj.pause();
			this.mediaObj = false;
		}
		if (this.msgMediaObj) {
			this.msgMediaObj.pause();
			this.msgMediaObj.currentTime = 0;
			this.msgMediaObj = false;
		}
	} 

	// Return element to its original position.
	returnElem() {
		const wrapper = this.modal.find('.pp-modal-wrapper');
		const elem = wrapper.find('.pp-podcast__single');
		const placeHolder = jQuery('#pp-modal-placeholder');

		this.mediaObj.media.removeEventListener('ended', this.pauseMedia);
		this.mediaObj.media.removeEventListener('pause', this.pauseMedia);
		this.mediaObj.media.removeEventListener('play', this.pauseMedia);
		this.mediaObj.media.removeEventListener('playing', this.pauseMedia);
		if (this.msgMediaObj) {
			this.msgMediaObj.media.removeEventListener('ended', this.pauseMedia);
			this.msgMediaObj.media.removeEventListener('pause', this.pauseMedia);
			this.msgMediaObj.media.removeEventListener('play', this.playMedia);
			this.msgMediaObj.media.removeEventListener('playing', this.playMedia);
		}

		if (elem.length) {
			// Remove active class from the element.
			elem.removeClass('activePodcast');
			if (placeHolder.length) {
				//Returning elem to its original position.
				elem.insertAfter(placeHolder);
			}
		}

		if (placeHolder.length) {
			// remove activeEpisode.
			placeHolder.parent().find('.activeEpisode').removeClass('activeEpisode media-playing');
			placeHolder.remove();
		}

		// Reset modal class.
		this.modal.removeClass().addClass('pp-modal-window');

		// Removing temporary items.
		wrapper.empty();
	}

	/**
	 * Disable scroll on the element that scrolls the document.
	 * 
	 * @since 1.3.5
	 */
	scrollDisable() {

		// Return if scroll is already disabled.
		if (this.bodyScrollDisabled) {
			return;
		}

		this.scrollPosition = this.scrollingElem.scrollTop;
		this.bodyScrollDisabled = true;
		setTimeout(() => {
			this.scrollingElem.scrollTop = 0;
			this.scrollingElem.classList.add('no-scroll');
		}, 250);
	}

	/**
	 * Enable scroll on the element that scrolls the document.
	 * 
	 * @since 1.3.5
	 */
	scrollEnable() {

		// Return if scroll is already Enabled.
		if (! this.bodyScrollDisabled) {
			return;
		}

		this.scrollingElem.classList.remove('no-scroll');
		this.scrollingElem.scrollTop = this.scrollPosition;
		this.bodyScrollDisabled = false;
	}
}

export default Modal;
