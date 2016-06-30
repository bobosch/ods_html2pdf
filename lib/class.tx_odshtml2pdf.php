<?php
class tx_odshtml2pdf {
	var $prefixId = 'tx_odshtml2pdf'; // Same as class name
	var $scriptRelPath = 'lib/class.tx_odshtml2pdf.php'; // Path to this script relative to the extension dir.
	var $extKey = 'ods_html2pdf'; // The extension key.
	var $pi_checkCHash = TRUE;

	function convert($content,$conf)	{
		$config=unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ods_html2pdf']);

		if($config['wkhtmltopdf_bin']){
			$cmd = $config['prepend_bin'] . ' ' . $config['wkhtmltopdf_bin'] . ' -q - -';
			return tx_odshtml2pdf::shell($cmd, $content);
		}
	}
	
	function shell($command,$stdin) {
		$descriptorspec = array(
			0 => array("pipe", "r"), // stdin
			1 => array("pipe", "w"), // stdout
		);

		$process = proc_open($command, $descriptorspec, $pipes);

		if (is_resource($process)) {
			fwrite($pipes[0], $stdin);
			fclose($pipes[0]);

			$stdout = stream_get_contents($pipes[1]);
			fclose($pipes[1]);

			proc_close($process);

			return $stdout;
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ods_html2pdf/lib/class.tx_odshtml2pdf.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ods_html2pdf/lib/class.tx_odshtml2pdf.php']);
}
?>