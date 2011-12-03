/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Jimagine.
# Toolbox for jQuery
# Copyright (C) 2011 - 2012  Gerits Aurelien <aurelien[at]magix-dev[dot]be>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
*/
/**
 * MAGIX DEV
 * @copyright  MAGIX DEV Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-dev.be
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @name showitmenu
 * @category plugin jquery
 */
/**
 * Exemple : 
 * $('a.showit').showitmenu({
	   showcontener : 'div.showcontent'
   });
 */
(function($){
	$.fn.showitmenu = function(options){
		var defaults = {
			showcontener : 'div.showcontent',
			debug : false
		},
		opts = $.extend(true,{}, defaults, options);
		return this.each(function(i, item){
			var jObjContainers = $(opts.showcontener);
			jObjContainers.hide();
			$(item).click(function(e){
				e.preventDefault();
				var selfid = $(this).attr('href');
				var jObjShowit = $(selfid);
				//var jObjShowit = $(opts.elem_id + $(this).data("showit"));
				if(opts.debug!=false){
					console.log(jObjShowit);
				}
				jObjContainers.each(function(j, jtem){
					//console.log('jtem: ',jtem);
					if ((jtem != jObjShowit[0]) && ($(jtem).css("display") != "none")){
						$(jtem).slideToggle();
					}
				});
				jObjShowit.slideToggle();
				return false;
			});
		});
	};
})(jQuery);