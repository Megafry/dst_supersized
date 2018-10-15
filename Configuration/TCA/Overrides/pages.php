<?php
defined('TYPO3_MODE') or die();


$tempColumns = array (
	'tx_dstsupersized_image' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:dst_supersized/locallang_db.xml:pages.tx_dstsupersized_image',
		'config' => array (
			'type' => 'group',
			'internal_type' => 'file',
			'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'uploadfolder' => 'uploads/tx_dstsupersized',
			'show_thumbs' => 1,
			'size' => 10,
			'minitems' => 0,
			'maxitems' => 10,
		)
	),
);



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages',$tempColumns,1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','tx_dstsupersized_image;;;;1-1-1');


?>
