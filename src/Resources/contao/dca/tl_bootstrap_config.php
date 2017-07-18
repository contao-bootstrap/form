<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

/*
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_bootstrap_config']['metapalettes']['form_widget extends default'] = array
(
    '+config' => array(
        'form_widget_control',
        'form_widget_label',
        'form_widget_input_group',
        'form_widget_styled_select',
        'form_widget_styled_upload',
        'form_widget_modal_footer',
    ),
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['metapalettes']['form extends default'] = array
(
    '+config' => array(
        'form_default_horizontal',
        'form_horizontal_control',
        'form_horizontal_label',
        'form_horizontal_offset',
        'form_default_submit_btn',
        'form_styled_select',
        'form_styled_upload',
    ),
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['metasubpalettes']['form_styled_select'] = array(
    'form_styled_select_class',
    'form_styled_select_style',
    'form_styled_select_size',
    'form_styled_select_threshold',
    'form_styled_select_format'
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['metasubpalettes']['form_styled_upload'] = array(
    'form_styled_upload_class',
    'form_styled_upload_position',
);

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_widget_control'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_widget_control'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_widget_modal_footer'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_widget_modal_footer'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_widget_input_group'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_widget_input_group'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_widget_label'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_widget_label'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_widget_styled_select'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_widget_styled_select'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_widget_styled_upload'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_widget_styled_upload'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_default_horizontal'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_default_horizontal'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_horizontal_control'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_horizontal_control'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'w50',
        'submitOnChange' => true,
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_horizontal_label'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_horizontal_label'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'w50',
        'submitOnChange' => true,
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_horizontal_offset'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_horizontal_offset'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'w50',
        'submitOnChange' => true,
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_select'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_select'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'clr w50 m12',
        'submitOnChange' => true,
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_select_class'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_select_class'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'clr w50',
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_select_style'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_select_style'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'w50',
        'submitOnChange' => true,
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_select_threshold'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_select_threshold'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'w50',
        'maxlength'      => 4,
    ),
    'sql'       => "char(4) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_select_size'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_select_size'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'w50',
        'maxlength'      => 5,
    ),
    'sql'       => "char(5) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_select_format'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_select_format'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'clr w50',
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_upload'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_upload'],
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'clr w50 m12',
        'submitOnChange' => true,
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_upload_class'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_upload_class'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'clr w50',
        'submitOnChange' => true,
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_styled_upload_position'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_styled_upload_position'],
    'inputType' => 'select',
    'options'   => array('left', 'right'),
    'reference' => &$GLOBALS['TL_LANG']['tl_bootstrap_config'],
    'default'   => 'right',
    'eval'      => array(
        'tl_class'       => 'w50',
        'submitOnChange' => true,
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default 'right'"
);

$GLOBALS['TL_DCA']['tl_bootstrap_config']['fields']['form_default_submit_btn'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap_config']['form_default_submit_btn'],
    'inputType' => 'text',
    'eval'      => array(
        'tl_class'       => 'w50',
        'submitOnChange' => true,
        'maxlength'      => 32,
    ),
    'sql'       => "varchar(32) NOT NULL default ''"
);
