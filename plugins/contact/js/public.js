/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * Copyright: MAGIX CMS
 * Date: 6/03/13
 * Time: 21:39
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_plugins_contact = (function ($, undefined) {
    //Fonction Private
    function add(iso,address){
        // *** Set required fields for validation
        var rules = {
            lastname: {
                required: true,
                minlength: 2
            },
            firstname: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            title: {
                required: true,
                minlength: 2
            },
            content: {
                required: true,
                minlength: 2
            }
        };

        if(address) {
            rules['address'] = { required: true, minlength: 2 };
            rules['postcode'] = { required: true, minlength: 2 };
            rules['city'] = { required: true, minlength: 2 };
        }

        $("#contact-form").validate({
            onsubmit: true,
            event: 'submit',
            rules: rules,
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+iso+'/contact/',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                    }
                });
                return false;
            }
        });
    }
    return {
        //Fonction Public        
        run:function (iso,address) {
            add(iso,address);
        }
    };
})(jQuery);