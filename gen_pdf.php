<?php
require_once('lib/class.tx_odshtml2pdf.php');

// turn off admin panel
$GLOBALS{TSFE}->config['config']['admPanel']=0;
// generate original content
require_once(PATH_tslib.'class.tslib_pagegen.php');
include(PATH_tslib.'pagegen.php');

// instead of calling processOutput...
//---------------------------- begin ProcessOutput --------------
// substitute fe user
$token = trim($GLOBALS{TSFE}->config['config']['USERNAME_substToken']);
$token = $token ? $token : '<!--###USERNAME###-->';
if (strpos($GLOBALS{TSFE}->content, $token)) {
	$GLOBALS{TSFE}->set_no_cache();
	if ($GLOBALS{TSFE}->fe_user->user['uid'])	{
		$GLOBALS{TSFE}->content = str_replace($token,$GLOBALS{TSFE}->fe_user->user['uid'],$GLOBALS{TSFE}->content);
	}
}
// Substitutes get_URL_ID in case of GET-fallback
if ($GLOBALS{TSFE}->getMethodUrlIdToken)	{
	$GLOBALS{TSFE}->content = str_replace($GLOBALS{TSFE}->getMethodUrlIdToken, $GLOBALS{TSFE}->fe_user->get_URL_ID, $GLOBALS{TSFE}->content);
}

// Tidy up the code, if flag...
if ($GLOBALS{TSFE}->TYPO3_CONF_VARS['FE']['tidy_option'] == 'output'){
	$GLOBALS['TT']->push('Tidy, output','');
	$GLOBALS{TSFE}->content = $GLOBALS{TSFE}->tidyHTML($GLOBALS{TSFE}->content);
	$GLOBALS['TT']->pull();
}
// XHTML-clean the code, if flag set
if ($GLOBALS{TSFE}->doXHTML_cleaning() == 'output'){
	$GLOBALS['TT']->push('XHTML clean, output','');
	$XHTML_clean = t3lib_div::makeInstance('t3lib_parsehtml');
	$GLOBALS{TSFE}->content = $XHTML_clean->XHTML_clean($GLOBALS{TSFE}->content);
	$GLOBALS['TT']->pull();
}
//---------------------------- end ProcessOutput --------------

// ------------------------ Handle UserInt Objects --------------------------
// ********************************
// $GLOBALS['TSFE']->config['INTincScript']
// *******************************
if ($TSFE->isINTincScript())		{
	$TT->push('Non-cached objects','');
	$INTiS_config = $GLOBALS['TSFE']->config['INTincScript'];
	$GLOBALS{TSFE}->set_no_cache();
	// Special feature: Include libraries
	$TT->push('Include libraries');
	reset($INTiS_config);
	while(list(,$INTiS_cPart)=each($INTiS_config))	{
		if ($INTiS_cPart['conf']['includeLibs'])	{
			$INTiS_resourceList = t3lib_div::trimExplode(',',$INTiS_cPart['conf']['includeLibs'],1);
			$GLOBALS['TT']->setTSlogMessage('Files for inclusion: "'.implode(', ',$INTiS_resourceList).'"');
			reset($INTiS_resourceList);
			while(list(,$INTiS_theLib)=each($INTiS_resourceList))	{
				$INTiS_incFile=$GLOBALS['TSFE']->tmpl->getFileName($INTiS_theLib);
				if ($INTiS_incFile)	{
					require_once('./'.$INTiS_incFile);
				} else {
					$GLOBALS['TT']->setTSlogMessage('Include file "'.$INTiS_theLib.'" did not exist!',2);
				}
			}
		}
	}
	$TT->pull();
	$TSFE->INTincScript();
	$TT->pull();
}
//---------------------------- end Handle UserInt Objects --------------

//---------------------------- make links absolute --------------

function fix_links_callback($matches){
	return $matches[1].t3lib_div::locationHeaderUrl($matches[2]).$matches[3];
}

$GLOBALS{TSFE}->content = preg_replace_callback('/(<a [^>]*href=\")(?!#)(.*?)(\")/',     'fix_links_callback', $GLOBALS{TSFE}->content );
$GLOBALS{TSFE}->content = preg_replace_callback('/(<form [^>]*action=\")(?!#)(.*?)(\")/','fix_links_callback', $GLOBALS{TSFE}->content );
$GLOBALS{TSFE}->content = preg_replace_callback('/(<img [^>]*src=\")(?!#)(.*?)(\")/',    'fix_links_callback', $GLOBALS{TSFE}->content );
$GLOBALS{TSFE}->content = preg_replace_callback('/(<link [^>]*href=\")(?!#)(.*?)(\")/',  'fix_links_callback', $GLOBALS{TSFE}->content );

//---------------------------- end make links absolute --------------
$pdf=tx_odshtml2pdf::convert($GLOBALS{TSFE}->content,array());

if(substr($pdf,0,4)=='%PDF'){
	header('Content-type: application/pdf');
	$GLOBALS{TSFE}->content=$pdf;
}else{
	// don't cache errors
	$GLOBALS{TSFE}->set_no_cache();
	$GLOBALS{TSFE}->content = '<html><title>wkhtmltopdf problem</title><body><h1>HTML2PDF Problem:</h1>';
	if($errors){
		$GLOBALS{TSFE}->content.='wkhtmltopdf produced the following errors:';
		$GLOBALS{TSFE}->content.='<table borders=1 bgcolor="#e0e0e0"><tr><td>'.$errors.'</td></tr></table>';
	}else{
		$GLOBALS{TSFE}->content.= 'wkhtmltopdf produced no pdf-output.<br>';
	}
	$GLOBALS{TSFE}->content.='</body></html>';
}
?>