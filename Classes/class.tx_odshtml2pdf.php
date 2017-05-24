<?php
class tx_odshtml2pdf {
	public static function convert($content) {
		$config=unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ods_html2pdf']);

		if($config['wkhtmltopdf_bin']){
			if ($config['debug']) {
				$htmlfile = PATH_site . 'typo3temp/tx_odshtml2pdf/' . $GLOBALS['TSFE']->id . '.html';
				file_put_contents($htmlfile, $content);
			}

			$cmd = $config['prepend_bin'] . ' ' . $config['wkhtmltopdf_bin'] . ' ' . $config['wkhtmltopdf_opt'] . ' - -';
			
			$output = explode('%PDF', tx_odshtml2pdf::shell($cmd, $content), 2);
			if(isset($output[1])) $output[1] = '%PDF' . $output[1];

			return $output;
		}
	}

    public static function shell($command,$stdin) {
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