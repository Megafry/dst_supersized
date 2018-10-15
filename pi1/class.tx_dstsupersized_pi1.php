<?php

/***************************************************************

*  Copyright notice

*

*  (c) 2011 Daniel Stark <info@test-typo3.de>

*  All rights reserved

*

*  This script is part of the TYPO3 project. The TYPO3 project is

*  free software; you can redistribute it and/or modify

*  it under the terms of the GNU General Public License as published by

*  the Free Software Foundation; either version 2 of the License, or

*  (at your option) any later version.

*

*  The GNU General Public License can be found at

*  http://www.gnu.org/copyleft/gpl.html.

*

*  This script is distributed in the hope that it will be useful,

*  but WITHOUT ANY WARRANTY; without even the implied warranty of

*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

*  GNU General Public License for more details.

*

*  This copyright notice MUST APPEAR in all copies of the script!

***************************************************************/

/**

 * [CLASS/FUNCTION INDEX of SCRIPT]

 *

 * Hint: use extdeveval to insert/update function index above.

 */



// require_once(PATH_tslib.'class.tslib_pibase.php');



/**

 * Plugin 'supersized' for the 'dst_supersized' extension.

 *

 * @author	Daniel Stark <info@test-typo3.de>

 * @package	TYPO3

 * @subpackage	tx_dstsupersized

 */

class tx_dstsupersized_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {

	var $prefixId      = 'tx_dstsupersized_pi1';		// Same as class name

	var $scriptRelPath = 'pi1/class.tx_dstsupersized_pi1.php';	// Path to this script relative to the extension dir.

	var $extKey        = 'dst_supersized';	// The extension key.

	var $pi_checkCHash = true;



	/**

	 * The main method of the PlugIn

	 *

	 * @param	string		$content: The PlugIn content

	 * @param	array		$conf: The PlugIn configuration

	 * @return	The content that is displayed on the website

	 */

	function main($content, $conf)	{

            $this->conf = $conf;

            $this->pi_loadLL();

            $this->extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->extKey);

            $this->id=$GLOBALS['TSFE']->id;



            //check whether to include jQuery library
						//change this for typo3 9 >_ https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.0/Deprecation-82254-DeprecateGLOBALSTYPO3_CONF_VARSEXTextConf.html
						$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['dst_supersized']);


            if (!$extConf['dontIncludeJquery']) {

                //check whether extension t3jquery is loaded


								if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('t3jquery')) {
									require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('t3jquery').'class.tx_t3jquery.php');

									//if t3jquery is loaded and the custom library has been created

									if (T3JQUERY === true) {

											tx_t3jquery::addJqJS();

									}
						 		 }
                else {
										//otherwise include jQuery file
                    $addJsFiles[] = $this->extPath.'res/js/jquery-1.4.4.min.js';
                }
            }



            $addJsFiles[] = $this->extPath.'res/js/supersized.3.1.2.core.min.js';



            //check TYPO3 version to see whether pagerenderer is available
            if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 4003000) {

                //get pagerenderer

                $pagerender = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);


                //add JS and CSS files

                foreach($addJsFiles as $jsFile) {

                    $pagerender->addJsFile($jsFile);

                }

            }

            //if pagerenderer is not available add JS and CSS files the old way

            else {

                foreach($addJsFiles as $jsFile) {

                    $headerParts .= '<script type="text/javascript" src="'.$jsFile.'"></script>';

                }

                $GLOBALS['TSFE']->additionalHeaderData['EXT:' . $this->extKey] = $headerParts;

            }







            $verzeichnis = $this->conf['imagepfad'];

            $verzeichniszwei = "uploads/tx_dstsupersized/";





        	if ($verzeichnis == ''){

        		$res=$GLOBALS['TYPO3_DB']->exec_SELECTquery('tx_dstsupersized_image','pages','hidden=0 and deleted=0 and uid='.$this->id);

          		while($row=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {

                $imgArr=explode(',',$row['tx_dstsupersized_image']);

					for($i=0;$i<count($imgArr);$i++)

					$supersized[] = array('image' => $verzeichniszwei . $imgArr[$i]);

            	}

        	} else {

			$handle = openDir($verzeichnis); // Verzeichnis öffnen

            while ($datei = readDir($handle)) { // Verzeichnis auslesen

            	if ($datei != "." && $datei != ".." && !is_dir($datei)) { // Verzeichnisse filtern

            	if (strstr($datei, ".gif") || strstr($datei, ".png") || strstr($datei, ".jpg")) { // Bilder filtern

            	$verzeichnis_datei = $verzeichnis . $datei; // Pfad zur aktuellen Datei

            	$info = getImageSize($verzeichnis_datei); // Bildinfos ermitteln (Breite, Höhe)



   				$supersized[] = array('image' => $verzeichnis_datei);

  				}

            }

            }

            };



			$GLOBALS['TSFE']->inlineJS['$this->extKey'] = '

			jQuery(function($){

				jQuery.supersized({

				slideshow: '.$this->conf['slideshow'].',

				autoplay: '.$this->conf['autoplay'].',

				start_slide: '.$this->conf['start_slide'].',

				random: '.$this->conf['random'].',

				slide_interval: '.$this->conf['slide_interval'].',

				transition: '.$this->conf['transition'].',

				transition_speed: '.$this->conf['transition_speed'].',

				new_window: '.$this->conf['new_window'].',

				pause_hover: '.$this->conf['pause_hover'].',

				keyboard_nav: '.$this->conf['keyboard_nav'].',

				performance: '.$this->conf['performance'].',

				image_protect: '.$this->conf['image_protect'].',





				min_width: '.$this->conf['min_width'].',

				min_height: '.$this->conf['min_height'].',

				vertical_center: '.$this->conf['vertical_center'].',

				horizontal_center: '.$this->conf['horizontal_center'].',

				fit_portrait: '.$this->conf['fit_portrait'].',

				fit_landscape: '.$this->conf['fit_landscape'].',



				navigation: 1,

				thumbnail_navigation: 0,

				slide_counter: 0,

				slide_captions: 0,



 				slides: '.json_encode($supersized).'

				});

		});

			';















    }

}







if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dst_supersized/pi1/class.tx_dstsupersized_pi1.php'])	{

	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dst_supersized/pi1/class.tx_dstsupersized_pi1.php']);

}



?>
