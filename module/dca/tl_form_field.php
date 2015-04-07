<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['button'] = $GLOBALS['TL_DCA']['tl_form_field']['palettes']['submit'];


foreach(Bootstrap::getConfigVar('form.widgets', array()) as $widget => $config) {
    if(isset($config['input-group']) && $config['input-group']) {
        \MetaPalettes::appendAfter('tl_form_field', $widget, 'fconfig', array
        (
            'icon' => array(':hide', 'bootstrap_addIcon'),
            'unit' => array(':hide', 'bootstrap_addUnit'),
        ));
    }
}

\MetaPalettes::appendAfter('tl_form_field', 'button', 'type', array
(
    'icon' => array('bootstrap_addIcon'),
));

// append inlineStyle option to radio and checkbox
\MetaPalettes::appendFields('tl_form_field', 'radio', 'fconfig', array('bootstrap_inlineStyle'));
\MetaPalettes::appendFields('tl_form_field', 'checkbox', 'fconfig', array('bootstrap_inlineStyle'));

if (Bootstrap::getConfigVar('form.styled-upload.enabled')) {
    \MetaPalettes::appendFields('tl_form_field', 'upload', 'fconfig', array('placeholder'));
}

/**
 * meta palettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['metasubpalettes']['bootstrap_addIcon'] = array('bootstrap_icon', 'bootstrap_iconPosition');
$GLOBALS['TL_DCA']['tl_form_field']['metasubpalettes']['bootstrap_addUnit'] = array('bootstrap_unit', 'bootstrap_unitPosition');

unset($GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['addSubmit']);
$GLOBALS['TL_DCA']['tl_form_field']['metasubpalettes']['addSubmit'] = array('slabel', 'bootstrap_addSubmitIcon', 'bootstrap_addSubmitIconPosition', 'bootstrap_addSubmitClass');


/**
 * fields
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['type']['options_callback'] = function () {
    return array_keys($GLOBALS['TL_FFL']);
};

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_addIcon'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_addIcon'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange' => true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_icon'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_icon'],
    'exclude'                 => true,
    'inputType'               => 'icon',
    'options'                 => Bootstrap::getIconSet()->getIcons(),
    'eval'                    => array('tl_class' => 'w50', 'iconTemplate' => Bootstrap::getIconSet()->getTemplate()),
    'sql'                     => "varchar(32) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_iconPosition'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_iconPosition'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('left', 'right'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_form_field'],
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_addUnit'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_addUnit'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange' => true, 'tl_class' => 'clr'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_unit'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_unit'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_unitPosition'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_unitPosition'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('left', 'right'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_form_field'],
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_inlineStyle'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_inlineStyle'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_addSubmitClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_addSubmitClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_addSubmitIcon'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_icon'],
    'exclude'                 => true,
    'inputType'               => 'icon',
    'options'                 => Bootstrap::getIconSet()->getIcons(),
    'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
    'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true, 'iconTemplate' => Bootstrap::getIconSet()->getTemplate()),
    'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['bootstrap_addSubmitIconPosition'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['bootstrap_iconPosition'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('left', 'right'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_form_field'],
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);
