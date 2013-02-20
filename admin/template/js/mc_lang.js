/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 sc-box.com <support@magix-cms.com>
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
 * Date: 17/12/12
 * Time: 01:01
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_lang = (function ($, undefined) {
    //Fonction Private
    function graph(){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/lang.php?json_graph=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/admin/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#graph').html(loader);
            },
            successParams:function(data){
                $('#graph').empty();
                $.nicenotify.initbox(data,{
                    display:false
                });
                var $graph = data;
                new Morris.Bar({
                    element: 'graph',
                    data: $graph,
                    xkey: 'x',
                    ykeys: ['y', 'z', 'a', 'b'],
                    labels: ['HOME', 'NEWS', 'PAGES', 'PRODUCT']
                });
            }
        });
    }
    function jsonLang(){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/lang.php?action=list&json_list_lang=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/admin/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_lang').html(loader);
            },
            successParams:function(j){
                $('#list_lang').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_lang")
                    .addClass('table table-bordered table-condensed table-hover')
                    .append(
                    $(document.createElement("thead"))
                        .append(
                        $(document.createElement("tr"))
                            .append(
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th"))
                            .append(
                                $(document.createElement("span"))
                                    .attr("title","first tooltip")
                                    .attr("rel","tooltip")
                                    .append("ISO")
                            ),
                            $(document.createElement("th")).append("Language"),
                            $(document.createElement("th")).append("Défaut"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span")).addClass("icon-eye-open")
                            ),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-edit")
                            )
                            ,
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
                            )
                        )
                    ),
                    tbody
                );
                tbl.appendTo('#list_lang');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.default_lang != 0){
                            var default_lang = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var default_lang = $(document.createElement("span")).addClass("icon-check-empty");
                        }
                        if(item.active_lang == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idlang)
                                    .attr("title", "Activer la langue: "+item.iso).append(
                                    $(document.createElement("span")).addClass("icon-eye-close")
                                )
                            )
                        }else if(item.active_lang == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idlang)
                                    .attr("title", "Activer la langue: "+item.iso).append(
                                    $(document.createElement("span")).addClass("icon-eye-open")
                                )
                            )
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/lang.php?action=edit&edit='+item.idlang)
                                .attr("title", "Editer "+item.iso)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-lang")
                                .attr("href", "#")
                                .attr("data-delete", item.idlang)
                                .attr("title", "Supprimer "+": "+item.iso)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
                            )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .append(
                                $(document.createElement("td")).append(
                                    item.idlang
                                ),
                                $(document.createElement("td")).append(item.iso),
                                $(document.createElement("td")).append(item.language)
                                ,
                                $(document.createElement("td")).append(
                                    default_lang
                                )
                                ,
                                active
                                ,
                                edit
                                ,
                                remove
                            )
                        )
                    });
                }else{
                    tbody.append(
                        $(document.createElement("tr"))
                            .append(
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            )
                        )
                    )
                }
            }
        });
    }
    function add(){
        var formsAddLang = $("#forms_lang_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                iso: {
                    required: true
                },
                language: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/admin/lang.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonLang();
                    }
                });
                return false;
            }
        });
        $('#open-add').on('click',function(){
            $('#forms-add').dialog({
                modal: true,
                resizable: true,
                width: 350,
                height:'auto',
                minHeight: 300,
                buttons: {
                    'Save': function() {
                        //$(this).dialog('close');
                        $("#forms_lang_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAddLang.resetForm();
                    }
                }
            });
            return false;
        });
    }
    function update(edit){
        var formsUpdatelang = $('#forms_lang_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                iso: {
                    required: true
                },
                language: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/admin/lang.php?action=edit&edit='+edit,
                    typesend: 'post',
                    idforms: $(form),
                    resetform:false,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                    }
                });
                return false;
            }
        });
        $('#forms_lang_edit').formsUpdatelang;
    }
    function updateActive(){
        $(document).on("click","a.active-pages",function(event){
            event.preventDefault();
            var id = $(this).data("active");
            $("#window-dialog:ui-dialog").dialog( "destroy" );
            $("#window-dialog").dialog({
                resizable: false,
                height:180,
                width:350,
                modal: true,
                title: "Changer le status d'une langue",
                buttons: [
                    {
                        text: "Activer",
                        click: function() {
                            $(this).dialog('close');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/admin/lang.php?action=edit',
                                typesend: 'post',
                                noticedata:{active_lang:1,idlang:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    jsonLang();
                                }
                            });
                            return false;
                        }
                    },
                    {
                        text: "Désactiver",
                        click: function() {
                            $(this).dialog('close');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/admin/lang.php?action=edit',
                                typesend: 'post',
                                noticedata:{active_lang:0,idlang:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    jsonLang();
                                }
                            });
                            return false;
                        }
                    }
                ]
            });
        });
    }
    return {
        //Fonction Public
        runCharts:function(){
            graph();
        },
        runList:function(){
            jsonLang();
            add();
            updateActive();
        },
        runEdit:function(edit){
            update(edit);
        }
    };
})(jQuery);