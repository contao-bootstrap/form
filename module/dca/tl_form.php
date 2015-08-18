<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

MetaPalettes::appendFields('tl_form', 'bootstrap', array(':hide', 'bootstrap_configs'));

$GLOBALS['TL_DCA']['tl_form']['fields']['bootstrap_configs'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_form']['bootstrap_configs'],
    'inputType'        => 'checkboxWizard',
    'options_callback' => array('Netzmacht\Bootstrap\Form\Contao\Dca\Form', 'getConfigTypes'),
    'eval'             => array(
        'tl_class' => 'clr',
        'multiple' => true,
    ),
    'sql'              => "mediumblob NULL"
);
