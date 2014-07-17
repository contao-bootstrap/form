<?php

TemplateLoader::addFiles(array(
	'form'         				    => 'system/modules/bootstrap-form/templates',
	'formhelper_element_radios'     => 'system/modules/bootstrap-form/templates',
	'formhelper_element_checkboxes' => 'system/modules/bootstrap-form/templates',
));


if(version_compare(VERSION, '3.3', '<')) {
	TemplateLoader::addFile('formhelper_layout_bootstrap', 'system/modules/bootstrap-form/templates/3.2');
}
else {
	TemplateLoader::addFile('formhelper_layout_bootstrap', 'system/modules/bootstrap-form/templates/3.3');
}