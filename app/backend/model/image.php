<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
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
/**
 * MAGIX CMS
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.4
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name image
 * Model image
 */
class backend_model_image {
	/**
	 * Vérifie si le type est bien une image
	 * @param $filename
	 * @return size
	 */
	public static function  image_valid($filename){
			$size = getimagesize($filename);
			switch ($size['mime']) {
			    case "image/gif":
			        break;
			    case "image/jpeg":
			        break;
			    case "image/png":
			        break;
			    case false:
			    	break;
			}
			return $size;
		}
	/**
	 * Retourne l'extension du fichier image
	 * @param $filename
	 * @return size
	 */	
	public static function image_analyze($filename){
		$size = getimagesize($filename);
			switch ($size['mime']) {
			    case "image/gif":
			    	$imgtype = '.gif';
			        break;
			    case "image/jpeg":
			    	$imgtype = '.jpg';
			        break;
			    case "image/png":
			    	$imgtype = '.png';
			        break;
			    case false:
			    	break;
			}
			return $imgtype;
	}
		/**
		 * function fixe maxsize
		 * @param $maxh hauteur maximum
		 * @param $maxw largeur maximum
		 * @param string $source
		 * @return bool
		 */
	public static function imgSizeMax($source,$maxw,$maxh){  
		list($width, $height) = getimagesize($source);
		if($width>$maxw || $height>$maxh){
			return false;
		}else{	
			return true;
		}
	}
	/**
		 * function fixe minsize
		 * @param $maxh hauteur minimum
		 * @param $maxw largeur minimum
		 * @param string $source
		 * @return bool
		 */
	public static function imgSizeMin($source,$maxw,$maxh){  
		list($width, $height) = getimagesize($source);
		if($width<$maxw || $height<$maxh){
			return false;
		}else{	
			return true;
		}
	}
	/**
	 * Upload une image 
	 * @param files $img
	 * @param dir $path
	 */
	public static function upload_img($img,$path,$debug = false){
				$error = null;
				if (isset($_FILES[$img])) {
					if ($_FILES[$img]['error'] == UPLOAD_ERR_OK){
						if(self::image_valid($_FILES[$img]['tmp_name']) === false){
							$error .='<div class="error">Mauvais format d\'image (gif,png,jpeg uniquement)</div>';		    
						}else{		
							if(chmod($_FILES[$img]["tmp_name"],0777)){
								if(is_uploaded_file($_FILES[$img]["tmp_name"])){
									$source = $_FILES[$img]['tmp_name'];
									$pathdir = dirname(realpath( __FILE__ ));
									$arraydir = array('app\backend\model', 'app/backend/model');
									//$cible = $_SERVER['DOCUMENT_ROOT'].magixcjquery_html_helpersHtml::unixSeparator().$path.magixcjquery_html_helpersHtml::unixSeparator().magixcjquery_url_clean::rplMagixString($_FILES[$img]["name"]);
									$cible = magixglobal_model_system::root_path($arraydir,array("",""),$pathdir).$path.magixcjquery_html_helpersHtml::unixSeparator().magixcjquery_url_clean::rplMagixString($_FILES[$img]["name"]);
									if($debug != false){
										if(M_LOG == 'debug'){
											magixcjquery_debug_magixfire::magixFireGroup('Upload Log:',
								                array('Collapsed' => false,
								                      'Color' => '#042139')
								          	);
								          	magixcjquery_debug_magixfire::magixFireInfo($source,"Img source");
									        magixcjquery_debug_magixfire::magixFireInfo($cible,"Path target");
											magixcjquery_debug_magixfire::magixFireGroupEnd();
										}
									}
									if (self::imgSizeMax($source,3000,3000) == false) {
											$error .= '<div class="error">La taille maximum excéde</div>';
										}else{
											if (!move_uploaded_file($source, $cible)) {
												$error .= '<div class="error">Erreur de fichier temporaire</div>';
											}
										}	
								}else{
									$error .= 'Erreur d\'écriture du disque</div>';
								}
							}
						}
					}
				}elseif (UPLOAD_ERR_NO_FILE == true){
					$error .= '<div class="error">Aucun fichier</div>';
				}elseif (UPLOAD_ERR_INI_SIZE == true){
					$error .=  '<div class="error">Le fichier est trop grand</div>';
				}elseif (UPLOAD_ERR_CANT_WRITE == true){
					$error .= '<div class="error">Erreur d\'écriture du disque</div>';	
				}elseif (UPLOAD_ERR_FORM_SIZE == true){
					$error .= '<div class="error">Le fichier est trop grand <br /> Taille maximum 800x600</div>';
				}else{
					$error .= '<div class="error">Erreur d\'écriture du disque</div>';
				}
			return $error;
		}
}
?>