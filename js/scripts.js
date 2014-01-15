jQuery(document).ready(function($){

	$('.lightbox-counter').appendTo('.lightbox-menu a').css('display', 'block');
	$('.menu-cart-info').appendTo('.cart-menu a').show();
	$('#masthead .smas-form').append('<div id="smas-advanced" style="display:none;"></div>');
	$('<a href="#" id="advanced-search-toggle"><span class="advanced-search-toggle-icon genericon genericon-downarrow"></span></a>').appendTo('#masthead #smas_keywords');
	$('#masthead .smas-button-container').appendTo('#smas_keywords');

	$('#masthead #smas_price_range, #masthead #smas_image_orientation, #masthead #smas_color_picker, #masthead #smas_collections, #masthead #smas_licenses, #masthead #smas_aspect_ratio').appendTo('#smas-advanced');

	$('#masthead .smas-container .smas-button-container input[type="submit"]').attr('value', 'Search');
	$('#header-smas').show();
	$("#advanced-search-toggle").toggle(
	  function () {
		$('#smas-advanced').toggle();
		$('.advanced-search-toggle-icon').removeClass('genericon-downarrow');
		$('.advanced-search-toggle-icon').addClass('genericon-uparrow');
	  },
	  function () {
		$('#smas-advanced').toggle();
		$('.advanced-search-toggle-icon').removeClass('genericon-uparrow');
		$('.advanced-search-toggle-icon').addClass('genericon-downarrow');
	  }
	);
  $('.sell-media-grid').find('.sell-media-cart-trigger,.sell-media-item-details,.remove-lightbox, .sell-media-shortcode-all-item-title').hide();
	$('.sell-media-grid').hover(
		function () {
			$(this).find('.sell-media-cart-trigger,.sell-media-item-details,.remove-lightbox, .sell-media-shortcode-all-item-title').show();
		},
		function () {
			$(this).find('.sell-media-cart-trigger,.sell-media-item-details,.remove-lightbox, .sell-media-shortcode-all-item-title').hide();
			$(this).find('.sell-media-item-details-collection').show();
		}
	);

	$('#main-collections .sell-media-grid, .page-template-page-collections-php .sell-media-grid, .sell-media-collections-shortcode .sell-media-grid').hover(
	  function () {
	  $(this).find('.collection-details').show();
		$(this).find('.sell_media_image, .attachment-sell_media_item').css('opacity', '0.1');
		$(this).find('.sell-media-item-details').css('background', 'transparent');
	},
	  function () {
		$(this).find('.collection-details').hide();
		$(this).find('.sell_media_image, .attachment-sell_media_item').css('opacity', '1');
		$(this).find('.sell-media-item-details').css('background', 'rgba(0,0,0, 0.2)');
	  }
	);
	
	$('.sell-media-collections-shortcode .sell-media-grid').hover(
	  function () {
	    $(this).find('.sell-media-collections-shortcode-item-details').show();
		$(this).find('.sell_media_image, .attachment-sell_media_item').css('opacity', '0.1');
		$(this).find('.sell-media-collections-shortcode-item-title').css('background', 'transparent');
	},
	  function () {
		$(this).find('.sell-media-collections-shortcode-item-details').hide();
		$(this).find('.sell_media_image, .attachment-sell_media_item').css('opacity', '1');
		$(this).find('.sell-media-collections-shortcode-item-title').css('background', 'rgba(0,0,0, 0.2)');
	  }
	);

	var $archive_entry = jQuery(".archive .hentry, .blog-grid .hentry, .hentry");

    if (!($archive_entry.length == 0)) {
		$archive_entry.each(function (index, domEle) {
		// domEle == this
		if ((index+1)%3 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
		});
	}

	var $author_grid = jQuery(".team-page-grid .author-wrap, #homewidgets .widget");

    if (!($author_grid.length == 0)) {
		$author_grid.each(function (index, domEle) {
		// domEle == this
		if ((index+1)%3 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
		});
	}

	// Like Icons
    if($('.like-count').length) {
    	$('.like-count').live('click',function() {
    		var id = $(this).attr('id');
    		id = id.split('like-');
    		$.ajax({
    			url: sellphotos.ajaxurl,
    			type: "POST",
    			dataType: 'json',
    			data: { action : 'sellphotos_liked_ajax', id : id[1] },
    			success:function(data) {
    				if(true==data.success) {
    					$('#like-'+data.postID).text(" " + data.count);
    					$('#like-'+data.postID).addClass('active');
    				}
    			}
    		});
    		return false;
    	});
    }

	// Like Active Class
	$('.like-count').each(function() {
	    var $like_count = 0;
		var $like_count = $(this).text();
		if($like_count != 0) {
	        $(this).addClass('active');
	    }
	});

	$('#twitter').sharrre({
	        share: {
	            twitter: true
	        },
	        template: '<a class="share" href="#"><div class="genericon genericon-twitter"></div></a>',
	        enableHover: false,
	        click: function(api, options){
	            api.simulateClick();
	            api.openPopup('twitter');
	        }
	    });

	    $('#facebook').sharrre({
	        share: {
	            facebook: true
	        },
	        template: '<a class="share" href="#"><div class="genericon genericon-facebook"></div></a>',
	        enableHover: false,
	        click: function(api, options){
	            api.simulateClick();
	            api.openPopup('facebook');
	        }
		});


	// Add to Lightbox
    if($('.add-to-lightbox').length) {
    	$('.add-to-lightbox').live('click',function() {
			if ($(this).hasClass('saved-to-lightbox')) {
				return false;
			} else {
	    		var id = $(this).attr('id');
	    		id = id.split('lightbox-');
				$(this).attr('disabled', true);
				$(this).text('Saving...');
	    		$.ajax({
	    			url: sellphotos.ajaxurl,
	    			type: "POST",
	    			dataType: 'json',
	    			data: { action : 'sellphotos_lightbox_ajax', id : id[1] },
	    			success:function(data) {
	    				if(true==data.success) {
	    					$('#lightbox-'+data.postID).text("Saved to lightbox");
	    					$('#lightbox-'+data.postID).prev().addClass('lightbox-active');
							var count = $('.lightbox-menu .lightbox-counter').html();
							count = parseInt(count) + 1;
							$('.lightbox-menu .lightbox-counter').html(count);
							$('#lightbox-'+data.postID).removeAttr("disabled");
							$('#lightbox-'+data.postID).addClass("saved-to-lightbox");
	    				}
	    			}
	    		});
	    		return false;
			}
    	});
    }

	// Remove from Lightbox
    if($('.remove-lightbox').length) {
    	$('.remove-lightbox').live('click',function() {
    		var id = $(this).attr('id');
    		id = id.split('lightbox-');
    		$.ajax({
    			url: sellphotos.ajaxurl,
    			type: "POST",
    			dataType: 'json',
    			data: { action : 'sellphotos_lightbox_remove_ajax', id : id[1] },
    			success:function(data) {
    				if(true==data.success) {
    					$('#lightbox-'+data.postID).parent().remove();
						var count = $('.lightbox-menu .lightbox-counter').html();
						count = parseInt(count) - 1;
						$('.lightbox-menu .lightbox-counter').html(count);
    				}
    			}
    		});
    		return false;
    	});
    }

	// Removing AJAX security field only when form is not used as a shortcode
	$('#header-inner #smas_security').remove();
});