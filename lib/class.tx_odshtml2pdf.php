<?php
class tx_odshtml2pdf {
	var $prefixId = 'tx_odshtml2pdf'; // Same as class name
	var $scriptRelPath = 'lib/class.tx_odshtml2pdf.php'; // Path to this script relative to the extension dir.
	var $extKey = 'ods_html2pdf'; // The extension key.
	var $pi_checkCHash = TRUE;

	function convert($content,$conf)	{
		$config=unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ods_html2pdf']);

		if($config['wkhtmltopdf_bin']){
			$htmlfile=PATH_site.'typo3temp/tx_odshtml2pdf/'.uniqid().'.html';
			file_put_contents($htmlfile,$content);
			$cmd=$config['wkhtmltopdf_bin'].' -q '.escapeshellarg($htmlfile).' -';
			if($config['prepend_bin']) $cmd=$config['prepend_bin'].' '.$cmd;
			$pdf=shell_exec($cmd);
			unlink($htmlfile);
		}

		return $pdf;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ods_html2pdf/lib/class.tx_odshtml2pdf.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ods_html2pdf/lib/class.tx_odshtml2pdf.php']);
}
?>