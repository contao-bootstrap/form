<?php

/**
 * Contao Bootstrap form.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017-2019 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0-or-later
 * @filesource
 */

// Config
$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = [
    'contao_bootstrap.form.listener.form_field_dca',
    'adjustPalettes'
];


// Subpalettes
$GLOBALS['TL_DCA']['tl_form_field']['metasubpalettes']['bs_addInputGroup'] = ['bs_inputGroup'];

// Fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['bs_addInputGroup'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_addInputGroup'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => array(
        'tl_class'       => 'clr w50',
        'submitOnChange' => true
    ),
    'sql'       => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bs_inputGroup'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup'],
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => array(
        'tl_class'     => 'clr',
        'columnFields' => [
            'position' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup_position'],
                'inputType' => 'select',
                'options'   => ['before', 'after'],
                'eval'      => [
                    'style' => 'width: 150px;'
                ]
            ],
            'addon'    => [
                'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['bs_inputGroup_addon'],
                'inputType' => 'text',
                'eval'      => [
                    'style' => 'width: 400px;'
                ]
            ]
        ],
    ),
    'sql'       => "mediumblob NULL"
];
