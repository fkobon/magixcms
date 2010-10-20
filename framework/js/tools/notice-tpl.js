/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name notice
 * @category plugins jQuery
 *
 */
(function($) { 
    $.notice = function(settings) { 
    	var options =  { 
    		ntype: "simple",
    		nparams: false,
    		delay: 3000,
    		dom: null,
    		uri: null,
    		typesend: 'post',
    		noticedata: null,
    		resetform:false,
    		time:4,
    		reloadhtml:false,
    		beforeSubmit:function(){},
    		successParams:false
    	};
        $.extend(options, settings);
        function getSimpleNotify(time){
        	$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
        		$('#notify-header').meerkat({
        			background:"#efefef",
        			width: '100%',
        			position: 'top',
        			close: '.close-notify',
        			animationIn: 'fade',
        			animationOut: 'slide',
        			animationSpeed: '750',
        			height: '80px',
        			opacity: '0.90',
        			timer: time,
        			onMeerkatShow: function() { 
        				$(this).animate({opacity: 'show'}, 1000); 
        			}
        		}).addClass('pos-top');
        	});
        }
        function submit_noticehead(dom,uri,typesend,noticedata,beforeSubmit,successParams,resetform,time,reloadhtml){
        	$(dom).ajaxSubmit({
        		url:uri,
        		type:typesend,
        		data:noticedata,
        		resetForm: resetform,
        		beforeSubmit:beforeSubmit,
        		success:function(request) {
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
        				$('#notify-header').destroyMeerkat();
        				$('#notify-header').meerkat({
        					background:"#efefef",
        					width: '100%',
        					position: 'top',
        					close: '.close-notify',
        					animationIn: 'fade',
        					animationOut: 'slide',
        					animationSpeed: '750',
        					height: '80px',
        					opacity: '0.90',
        					timer: time,
        					onMeerkatShow: function() { 
        						$(this).animate({opacity: 'show'}, 1000); 
        					}
        				}).addClass('pos-top');
        			});
        			successParams;
        			$(".mc-head-request").html(request);
        			if(reloadhtml == true){
        				setTimeout(function(){
        					location.reload();
        				},options.delay);
        			}
        		}
        	});
        }
        function noticehead(uri,typesend,noticedata,successParams,time){
        	$.ajax({
        		url:uri,
        		type:typesend,
        		async: false,
        		data: noticedata,
        		success:function(request) {
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
        				$('#notify-header').destroyMeerkat();
        				$('#notify-header').meerkat({
        					background:"#efefef",
        					width: '100%',
        					position: 'top',
        					close: '.close-notify',
        					animationIn: 'fade',
        					animationOut: 'slide',
        					animationSpeed: '750',
        					height: '80px',
        					opacity: '0.90',
        					timer: time,
        					onMeerkatShow: function() { 
        						$(this).animate({opacity: 'show'}, 1000); 
        					}
        				}).addClass('pos-top');
        			});
        			successParams;
        			$(".mc-head-request").html(request);
        			if(options.reloadhtml == true){
        				setTimeout(function(){
        					location.reload();
        				},options.delay);
        			}
        		}
        	});
        }
        function getDirNotify(nparams){
        	switch(nparams){
        		case "install":
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
        				$('#notify-install').destroyMeerkat();
        				$('#notify-install').meerkat({
        					background:"#fdd",
        					width: '100%',
        					position: 'top',
        					close: '.close-notify',
        					dontShowAgain: '.dont-notify',
        					animationIn: 'fade',
        					animationOut: 'slide',
        					animationSpeed: '750',
        					height: '80px',
        					opacity: '0.90',
        					onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
        				}).addClass('pos-top');
        			});
        		break;
        		case "chmod":
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
        				$('#notify-folder').destroyMeerkat();
        				$('#notify-folder').meerkat({
        					background:"#efefef",
        					width: '100%',
        					position: 'top',
        					close: '.close-notify',
        					dontShowAgain: '.dont-notify',
        					animationIn: 'fade',
        					animationOut: 'slide',
        					animationSpeed: '750',
        					height: '80px',
        					opacity: '0.90',
        					onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
        				}).addClass('pos-top');
        			});
        		break;
        	}
        }
        switch(options.ntype){
        	case "simple":
        		getSimpleNotify(options.time);
        	case "ajaxsubmit":
        		submit_noticehead(options.dom,options.uri,options.typesend,options.noticedata,options.beforeSubmit,options.successParams,options.resetform,options.time,options.reloadhtml);
        	break;
        	case "ajax":
        		noticehead(options.uri,options.typesend,options.noticedata,options.successParams,options.time);
        	break;
        	case "dir":
        		getDirNotify(options.nparams);
        	break;
        }
        if(options.ntype == ""){
        	console.log("%s: %o","ntype is null");
        	return false;
        }else if(options.ntype == undefined){
        	console.log("%s: %o","ntype is undefined");
        	return false;
        }
    }; 
})(jQuery); 