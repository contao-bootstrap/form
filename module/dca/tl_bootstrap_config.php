<?php

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