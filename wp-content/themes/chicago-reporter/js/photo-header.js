(function () {

	// scroll-based actions
	var $ = jQuery;
	var win_height;

	function setStickyNav(scrollY){
		var $ = jQuery;
		// sticky nav
		var nav = $('#site-navigation.lf-sticky');
		var photo = $('.photo-header-background');
		if(scrollY >= win_height) {
			//nav.show();
			photo.css('opacity',0);
		} else {
			//nav.hide();
			photo.css('opacity',1);
		}

	}

	function setEmbeds(){
		var embeds = $('.full-width-visual');
		embeds.each(function(){
			var $this = $(this);
			var spacer = '<div class="spacer" style="height:' + $this.height() + 'px;"></div>';
			$this.nextAll('.spacer').first().remove();
			$this.after(spacer);
		});
	}

	function stripInlineStyles(){
		//$('.module.image').attr('style','');
		$('img.size-full').parent().attr('style','');
		$('img.size-large').parent().attr('style','');
	}

	function adjustFullImages(){
		var full_width = $('#main').width();
		var imgs = $('.size-full');

		imgs.each(function(){
			var $this = $(this);
			var $parent = $this.parent()
			$this.attr('width','100%');
			$this.attr('height','');
			var margin = 0;

			var win_width = $(window).width();
			var content_width = $('article .entry-content').width();

			if (win_width>1170) {
				margin = -(full_width - content_width)/2;
			} else if (win_width>550) {
				margin = -(full_width - content_width)/2;
			} else {
				margin = 0;
			}
			$parent.css({
				'width': full_width,
				'margin-left': margin
			});
			$parent.find('.wp-caption-text').css('max-width',content_width);
		})
		
	}

	function getSelectionText() {
	    var text = "";
	    if (window.getSelection) {
	        text = window.getSelection().toString();
	    } else if (document.selection && document.selection.type != "Control") {
	        text = document.selection.createRange().text;
	    }
	    return text;
	}

	function share_selection(){
		var selection_sharer_html = '<div class="selectionSharer anim" id="selectionSharerPopover">  <div id="selectionSharerPopover-inner">    <ul>      <li><span class="action tweet" title="Share this selection on Twitter">Tweet</span></li>      <li><span class="action facebook" title="Share this selection on Facebook" target="_blank">Facebook</span></li>      <li><a class="action email" title="Share this selection by email" target="_blank"><svg width="20" height="20"><path stroke="#FFF" stroke-width="6" d="m16,25h82v60H16zl37,37q4,3 8,0l37-37M16,85l30-30m22,0 30,30"></path></svg></a></li>    </ul>  </div>  <div class="selectionSharerPopover-clip"><span class="selectionSharerPopover-arrow"></span></div></div>'
		var quote_sharer_html = '<div class="quoteSharer anim" id="quoteSharer">  <div id="quoteSharer-inner">    <ul>      <li><span class="action tweet" title="Share this selection on Twitter">Tweet</span></li>      <li><span class="action facebook" title="Share this selection on Facebook" target="_blank">Facebook</span></li>      <li><a class="action email" title="Share this selection by email" target="_blank"><svg width="20" height="20"><path stroke="#FFF" stroke-width="6" d="m16,25h82v60H16zl37,37q4,3 8,0l37-37M16,85l30-30m22,0 30,30"></path></svg></a></li>    </ul>  </div>  </div>'


		$('body').prepend(selection_sharer_html);

		$('.type-pull-quote').each(function(){
			var $this = $(this);
			var text = $this.text();

			$this.append(quote_sharer_html);

			$this.wrapInner('<div></div>')

			$this.find('.tweet').click(function(){
				share_twitter(text);
			});
			$this.find('.facebook').click(function(){
				share_facebook(text);
			});
			$this.find('.email').click(function(){
				share_email(text, $(this));
			});
		})

		document.onmouseup = document.onkeyup = function(event) {
			var text = getSelectionText();
			var $content = $('#content .entry-content');
			var left = $content.offset().left;
			var top = event.pageY - 50;
			var sharer = $('.selectionSharer');

			
			if (text.length > 3) {
				sharer.css({
					'top': top,
					'right': left - 40,
					'display': 'block'
				});
				$('.selectionSharer .tweet').click(function(){
					share_twitter(text);
				});
				$('.selectionSharer .facebook').click(function(){
					share_facebook(text);
				});
				$('.selectionSharer .email').click(function(){
					share_email(text, $(this));
				});
			} else {
				sharer.css({
					'display': 'none'
				});
			}
			
		};

	}

	function share_twitter(text){
		var link = window.location.href;
		var text = text + " " + link + " via @chicagoreporter";
		var twitter_url = "https://twitter.com/home?status=" + encodeURIComponent(text);
		window.open(twitter_url, 'newwindow', 'width=600, height=400');
	}

	function share_facebook(text){
		var link = window.location.href;
		var facebook_url = "https://www.facebook.com/sharer/sharer.php?u=" + link; 
  		window.open(facebook_url, 'newwindow', 'width=600, height=400');
	}

	function share_email(text, elem){
		var link = window.location.href;
		var html = elem;
		text = text.replace(' ','%20');
		var string = 'mailto:?subject=From The Chicago Reporter&body=' + text + '...Read More: ' + link;

		html.attr('href', string);
	}

	jQuery(document).ready(function(){
		win_height = jQuery(window).height();
		setStickyNav(window.scrollY);
		setEmbeds();
		stripInlineStyles();
		adjustFullImages();

		var $body = $('body');
		if ($body.hasClass('single-format-standard') && $body.hasClass('photo-header')){
			share_selection();
		}
	});

	jQuery(window).resize(function(){
		win_height = jQuery(window).height();
		setStickyNav(window.scrollY);
		setEmbeds();
		adjustFullImages();
	});

	var latestKnownScrollY = 0,
		ticking = false;

	function onScroll() {
		latestKnownScrollY = window.scrollY;
		requestTick();
	}

	function requestTick() {
		if(!ticking) {
			requestAnimationFrame(update);
		}
		ticking = true;
	}

	function update() {
		// reset the tick so we can
		// capture the next onScroll
		ticking = false;

		var currentScrollY = latestKnownScrollY;

		//backgroundCheck(currentScrollY);
		setStickyNav(currentScrollY);
	}

	window.addEventListener('scroll', onScroll, false);

})();
