<?php
/**
 * MAGIX CMS
 * @category   adminuser 
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name database
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
$pathinstall = dirname(realpath( __FILE__ ));
$arrayinstall = array('install');
$incinstall = str_replace($arrayinstall,array('') , $pathinstall);
require(dirname(__FILE__).'/exec/autoload.php');
$loaderFilename = $incinstall.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Webmestre: aurelien@web-solution-way.be</p>";
	exit;
}else{
	require $loaderFilename;
}
/**
 * Autoload Exec install
 */
exec_Autoloader::register();
$user = new exec_controller_adminuser();
if(magixcjquery_filter_request::isGet('postadm')){
	$user->display_completes_install();
}else{
	$user->display_user_page();
}
?>