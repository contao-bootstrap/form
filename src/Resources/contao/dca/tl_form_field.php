<?php

declare(strict_types=1);

// Config
$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = [
    'contao_bootstrap.form.listener.form_field_dca',
    'adjustPalettes',
];

// Subpalettes
$GLOBALS['TL_DCA']['tl_form_field']['metasubpalettes']['bs_addInputGroup'] = ['bs_inputGroup'];

// Fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['bs_addInputGroup'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_addInputGroup'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class'       => 'clr w50',
        'submitOnChange' => true,
    ],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bs_inputGroup'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup'],
    'exclude'   => true,
    'inputType' => 'group',
    'palette'   => ['position', 'addon'],
    'eval'      => ['tl_class' => 'clr'],
    'fields'    => [
        'position' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup_position'],
            'inputType' => 'select',
            'options'   => ['before', 'after'],
            'eval'      => ['tl_class' => 'w50'],
        ],
        'addon'    => [
            'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup_addon'],
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50'],
        ],
    ],
    'sql'       => 'mediumblob NULL',
];
