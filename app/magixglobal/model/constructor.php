<?php
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
 * MAGIX CMS
 * @category   Model
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2011-2013 Gerits Aurelien,
 * http://www.magix-cms.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Lesire Samuel www.sire-sam.Be
 * @name constructor
 *
 */
class magixglobal_model_constructor {

    public function formatPaginationHtml($data,$idActive)
    {
        if ($data == null)
            return null;

        $ouput['html']   =   '<div class="pagination">';
            $ouput['html']   .=   '<ul>';
                foreach ($data as $v)
                {
                    switch ($v['name']) {
                        case 'first':
                            $item['name'] = '<<';
                            break;
                        case 'previous':
                            $item['name'] = '<';
                            break;
                        case 'next':
                            $item['name'] = '>';
                            break;
                        case 'last':
                            $item['name'] = '>>';
                            break;
                        default:
                            $item['name'] = $v['name'];
                    }
                    $item['class']    =  ($item['name'] == $idActive) ? ' class="active"' : null;
                    $ouput['html']   .=  '<li'.$item['class'].'>';
                        $ouput['html']   .=  '<a href="'.$v['url'].'" title="'.$item['name'].'" >';
                            $ouput['html']   .=  $item['name'];
                        $ouput['html']   .=  '</a>';
                    $ouput['html']   .=  '</li>';

                }
            $ouput['html']   .=   '</ul>';
        $ouput['html']   .=  '</div>';

        return $ouput['html'];

    }

    public function mergeHtmlPattern($default,$custom)
    {
        // *** Merge default and custom structure
        if (is_array($custom)){
            $default['display'] = array();
            foreach($custom AS $k => $v){
                foreach($v AS $sk => $sv){
                    if ($sv != null){
                        $default[$k][$sk] = $sv;
                    }
                }
                if (array_search($k,$default['allow']))
                    $default['display'][1][] = $k;
            }
        }
        // *** push null value on each key (allow array_search() on format process)
        foreach($default['display'] AS $k => $v)
        {
            array_unshift($default['display'][$k],null);
        }
        return $default;
    }
    /*
     * Set html pattern fot item with val replacement
     * @access  public
     * @param   array   $htmlPattern
     * @param   int     $position
     * @param   int     $deep
     * @return  array
     */
    public function setItemPattern($htmlPattern,$position,$deep=1)
    {
        $d          =   ($deep > 1) ? '_'.$deep : null;
        $pattern    =   null;
        $htmlPattern['is_last'] = 0;
        if (is_numeric($htmlPattern['last']['col'.$d])) {
            if (
                is_int($htmlPattern['last']['col'.$d]/ $position)
                AND ($position != 1 AND $htmlPattern['last']['col'.$d] != 1)
            ) {
                $htmlPattern['is_last'] = 1;
            }
        }

        if (is_array($htmlPattern)) {
            foreach($htmlPattern AS $k => $v){
                // $k == 'container', 'img', 'items', 'descr', 'current' 'name',...
                if (is_array($v)){
                    foreach($v AS $sk => $sv){
                        // $sk == Item Structure values Key ==  htmlAfter,htmlBefore,class,...
                        // $sk == Item Structure values
                        if (isset($htmlPattern[$k][$sk.$d])) {
                            if ($sk == 'htmlBefore') {

                                $rplc['class']['position']  =   null;
                                if ($htmlPattern['is_last'] == 1) {
                                    $rplc['class']['string'] .= ' '.$htmlPattern['last']['class'.$d];
                                }
                                if ($htmlPattern['is_current'] == 1) {
                                    $rplc['class']['string'] .= ' '.$htmlPattern['current']['class'.$d];
                                }

                                $rplc['class']['attr']  =   null;
                                if ($rplc['class']['string'] != null) {
                                    $rplc['class']['attr']  =   ' class="'.$rplc['class']['string'].'"';
                                }

                                $rplc['key']    =   array(
                                    '#current-last#',
                                    '#class-current-last#',
                                    '#id#',
                                    '#url#'
                                );

                                $rplc['val']    =   array(
                                    $rplc['class']['string'],
                                    $rplc['class']['attr'],
                                    $htmlPattern['id'],
                                    $htmlPattern['url'],
                                );
                                $rplc['class'] = null;

                                $pattern[$k][$sk] = str_replace($rplc['key'],$rplc['val'],$htmlPattern[$k][$sk.$d]);

                            }else{
                                $pattern[$k][$sk] = $htmlPattern[$k][$sk.$d];
                            }
                        }elseif (($k == 'current' AND $sk == 'class') OR ($k == 'descr' AND ($sk == 'lenght' OR $sk == 'delemiter')) OR ($sk == 'htmlBefore') OR ($sk == 'htmlAfter') ) {
                            // si aucune valeur pour mon niveau mais que je suis des valeurs d'héritage => récupére la valeur de premier niveaux
                            $pattern[$k][$sk] = $sv;
                        }else{
                            // si aucune valeur pour mon niveau
                            $pattern[$k][$sk] = null;
                        }
                    }
                }
            }
        }
        return $pattern;
    }

    public function formatDateHtml($date,$pattern)
    {
        if (!(is_array($pattern['date']['format'])))
            return null;

        $date   =   strtotime($date);
        $output =   null;
        foreach ($pattern['date']['format'] as $k => $v)
        {
            $output .=  '<span class="'.$k.'">';
            $output .=  date($v,$date);
            $output .=  '</span>';
        }
        return $output;
    }
}