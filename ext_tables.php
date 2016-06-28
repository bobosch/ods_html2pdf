<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

t3lib_extMgm::addStaticFile($_EXTKEY,'static/standard/', 'PDF page');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/templavoila/', 'PDF page with templavoila');
?>