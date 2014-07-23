<?php

return array(
	'form' => array(
		'widgets' => array
		(
			'button' => array
			(
				'noFormControl'    => true,
				'modalFooter'      => true,
			),

			'captcha' => array
			(
				'allowInputGroup'  => true,
			),

			'checkbox' => array
			(
				'noFormControl'    => true,
				'noLabel'          => true,
				'generateTemplate' => 'form_checkbox_generate',
			),

			'explanation' => array(
				'noFormControl'    => true,
			),

			'headline' => array(
				'noFormControl'    => true,
			),

			'radio' => array
			(
				'noFormControl'    => true,
				'noLabel'          => true,
				'generateTemplate' => 'form_radio_generate',
			),

			'submit' => array
			(
				'noFormControl'    => true,
				'modalFooter'      => true,
			),

			'select' => array
			(
				'styledSelect'     => true,
			),

			'text' => array
			(
				'allowInputGroup'  => true,
			),

			'email' => array
			(
				'allowInputGroup'  => true,
			),

			'digit' => array
			(
				'allowInputGroup'  => true,
			),

			'tel' => array
			(
				'allowInputGroup'  => true,
			),

			'url' => array
			(
				'allowInputGroup'  => true,
			),


			'textarea' => array
			(
				'allowInputGroup'  => true,
			),

			'password' => array
			(
				'allowInputGroup'  => true,
			),

		),

		// which columns shall be used for the form in table mode
		'tableFormat' => array
		(
			'label'         => 'col-lg-3',
			'control'       => 'col-lg-9',
			'offset'        => 'col-lg-offset-3',
		),

		// how to display forms like comments form by default
		'defaultTableless'  => true,

		// add style select to select list, set to false to disable
		'styledSelect' => array
		(
			'enabled'       => true,
			'class'         => 'selectpicker',
			'defaultStyle'  => 'btn-default',
			'javascript'    => array(
				'system/modules/bootstrap-form/assets/bootstrap-select/bootstrap-select.min.js',
				'system/modules/bootstrap-form/assets/bootstrap-select.js'
			),
			'stylesheet'    => 'system/modules/bootstrap-form/assets/bootstrap-select/bootstrap-select.min.css',
		),

		// style the upload button
		'styledUpload' => array
		(
			'enabled'	    => true,
			'class'			=> 'btn btn-primary',
			'position'	    => 'right',
			'onchange'	    => 'document.getElementById(\'%s_value\').value=this.value.replace(/C:\\\\fakepath\\\\/i, "");return false;',
			'label'			=> &$GLOBALS['TL_LANG']['MSC']['bootstrapUploadButton']
		),

		// provides data attributes for custom select
		'dataAttributes' => array('target', 'toggle', 'dismiss', 'remote'),
	)
);