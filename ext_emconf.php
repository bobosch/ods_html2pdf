<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ods_html2pdf".
 *
 * Auto generated 26-08-2013 17:25
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'HTML to PDF',
	'description' => 'Creates a pdf version of the webpages. Includes static TS for templavoila. Needs wkhtmltopdf (webkit engine) binary on the server.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.2.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => 'typo3temp/tx_odshtml2pdf/',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Robert Heel',
	'author_email' => 'typo3@bobosch.de',
	'author_company' => 'http://www.1drop.de/',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-7.6.99',
			'php' => '5.0.0-0.0.0',
			'cms' => '',
		),
		'conflicts' => array(
			'pdf_generator2' => '',
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:9:{s:9:"ChangeLog";s:4:"d692";s:21:"ext_conf_template.txt";s:4:"4b19";s:12:"ext_icon.gif";s:4:"7e7d";s:14:"ext_tables.php";s:4:"3569";s:11:"gen_pdf.php";s:4:"52a4";s:10:"README.txt";s:4:"305c";s:28:"lib/class.tx_odshtml2pdf.php";s:4:"3f08";s:32:"static/templavoila/constants.txt";s:4:"048a";s:28:"static/templavoila/setup.txt";s:4:"98ff";}',
);

?>