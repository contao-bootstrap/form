<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

$GLOBALS['TL_HOOKS']['getPageLayout'][] = [
    'contao_bootstrap.form.listener.default_form_layout',
    'onGetPageLayout'
];
