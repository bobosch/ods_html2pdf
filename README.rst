==================
 EXT: HTML to PDF
==================
:Extension Key: ods_html2pdf
:Description: Creates a pdf version of the webpages. Includes static TS for templavoila. Needs wkhtmltopdf (webkit engine) binary on the server.
:Author: Robert Heel <typo3@bobosch.de>
:Copyright: 2011-2017

Introduction
============

What does it do?
----------------
It uses wkhtmltopdf to generate a pdf version of your website.

Administration
==============

Requirements
------------

Debian squeeze:
- Install packages: wkhtmltopdf xvfb
- Configure extension:
  - Path to wkhtmltopdf: /usr/bin/wkhtmltopdf
  - Prepend command: xvfb-run

TYPO3
-----

If you want your complete website in the pdf file, include static TS either for standard installation or templavoila.

Tips and tricks
---------------

To change the source path of additional files use absRefPrefix
 pdf.config.absRefPrefix = xxx
 
Or use a condition
::

	[globalVar = GP:type=123]
		config.absRefPrefix = xxx
	[end]
 
Set it to your domain
 absRefPrefix = http://[domain]/

If javascript loads files from your site, the cross origin policy will prevent this. Load all files localy with
 absRefPrefix = /[httproot]/

To wait for complex javascript code you can change the htmltopdf parameters to
 --quiet --javascript-delay 2000

Other TS examples, feedback and patches are welcome!
https://github.com/bobosch/ods_html2pdf
