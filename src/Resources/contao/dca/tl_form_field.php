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
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'tl_class'     => 'clr',
        'columnFields' => [
            'position' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup_position'],
                'inputType' => 'select',
                'options'   => ['before', 'after'],
                'eval'      => ['style' => 'width: 150px;'],
            ],
            'addon'    => [
                'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup_addon'],
                'inputType' => 'text',
                'eval'      => ['style' => 'width: 400px;'],
            ],
        ],
    ],
    'sql'       => 'mediumblob NULL',
];
