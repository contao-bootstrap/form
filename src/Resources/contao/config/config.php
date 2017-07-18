<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

$GLOBALS['TL_FFL']['button'] = 'Netzmacht\Bootstrap\Form\Contao\FormField\Button';

$GLOBALS['TL_HOOKS']['loadFormField'][] = array('Netzmacht\Bootstrap\Form\Contao\Hooks', 'loadFormField');
