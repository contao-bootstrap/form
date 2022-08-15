<?php

declare(strict_types=1);

$GLOBALS['TL_DCA']['tl_form_layout']['metapalettes']['bs_default extends standard'] = [];

$GLOBALS['TL_DCA']['tl_form_layout']['metapalettes']['bs_horizontal extends standard'] = [
    'bs_grid before widgets' => ['bs_row', 'bs_label', 'bs_control', 'bs_offset'],
];

$GLOBALS['TL_DCA']['tl_form_layout']['fields']['bs_label'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['bs_label'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => [
        'tl_class'       => 'w50',
        'maxlength'      => 64,
    ],
    'sql'       => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_layout']['fields']['bs_control'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['bs_control'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => [
        'tl_class'       => 'w50',
        'maxlength'      => 64,
    ],
    'sql'       => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_layout']['fields']['bs_offset'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['bs_offset'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => [
        'tl_class'       => 'w50',
        'maxlength'      => 64,
    ],
    'sql'       => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_layout']['fields']['bs_row'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['bs_row'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => [
        'tl_class'       => 'w50',
        'maxlength'      => 64,
    ],
    'sql'       => "varchar(64) NOT NULL default ''",
];
