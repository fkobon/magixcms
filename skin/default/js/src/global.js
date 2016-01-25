/**
* MAGIX CMS
* @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien,
    * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
    * @license    Dual licensed under the MIT or GPL Version 3 licenses.
    * @version    1.0
* @author Gérits Aurélien <aurelien@magix-cms.com>
* JS theme default
*
*/
function initGallery(titles,iso){
	// *** for gallery pictures
	$(".img-gallery").fancybox({
		helpers : {
			title : 'outside'
		},
		tpl: {
			closeBtn : '<a title="'+titles[iso]['close']+'" class="fancybox-item fancybox-close" href="javascript:;"></a>',
			next     : '<a title="'+titles[iso]['next']+'" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
			prev     : '<a title="'+titles[iso]['prev']+'" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
		}
	});

	$(".show-img").click(function(e){
		e.preventDefault();
		var target = $(this).data('target');
		$(".big-image a").animate({ opacity: 0, 'z-index': 0 }, 200);
		$(target).animate({ opacity: 1, 'z-index': 1 }, 200);
	});

	if ($('.thumbs ul').length) {
		var startPos = parseInt($('.thumbs ul').css('left').slice(0,-2));
		var listW = $('.thumbs ul').width();
		var contW = $('.thumbs').width();
		var maxOffset =  -( startPos + (listW - contW));
		var offset = 128;

		$(".thumbs .button").click(function(e){
			e.preventDefault();
			var posL = parseInt($('.thumbs ul').css('left').slice(0,-2)),
				nextPos = 0;

			if($(this).hasClass('next')) {
				nextPos = posL - offset;
				if( nextPos < maxOffset) {
					nextPos = maxOffset;
				}
			} else if ($(this).hasClass('prev')) {
				nextPos = posL + offset;
				if( nextPos > 0) {
					nextPos = 0;
				}
			}

			$('.thumbs ul').animate({ left: nextPos+'px' },500);
		});
	}
}

$(function()
{
	// *** In case you don't have firebug...
    if (!window.console || !console.firebug) {
        var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
        window.console = {};
        for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
    }

	// *** target_blank
    $('a.targetblank').click( function() {
        window.open($(this).attr('href'));
        return false;
    });

	// *** Bootstrap components
	$('[data-toggle="tooltip"]').tooltip();
	//$('[data-toggle="popover"]').popover();

    // *** Fancybox gallery
    var titles = {
            'fr': {'close':'Fermer','next':'Suivant','prev':'Précédent'},
            'nl': {'close':'Dicht','next':'Volgende','prev':'Voorgaand'},
            'en': {'close':'Close','next':'Next','prev':'Previous'}
        },
        lang = $('html').attr('lang'),
        iso = lang ? lang : 'en';

    // *** for one picture
    $(".img-zoom").fancybox({
        helpers : {
            title : 'outside'
        },
        tpl: {
            closeBtn : '<a title="'+titles[iso]['close']+'" class="fancybox-item fancybox-close" href="javascript:;"></a>'
        }
    });

	initGallery(titles,iso);

	 // *** for gallery videos
	 /*$(".video").fancybox({
		 type: 'iframe',
		  autoSize : true,
		  padding : 5
	 });
	 */

    // *** Smooth Scroll to Top
    var speed = 1000;
    $('.toTop').click(function(e){
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, speed);
        return false;
    });

    // *** Cross effect on mobile
    var width = $(window).width();
    if(width < 768) {
        $('button.navbar-toggle').click(function(){
            var target = $($(this).data('target'));
            if($(this).hasClass('open') || $(target).hasClass('collapse in')){
                $(this).removeClass('open');
            }else{
                $(this).addClass('open');
            }
        });
    }
});