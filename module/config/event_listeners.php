<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

use Netzmacht\Bootstrap\Core\Event\GetMultipleConfigNamesEvent;
use Netzmacht\Bootstrap\Form\Subscriber\ContaoFormsRenderer;
use Netzmacht\Bootstrap\Form\Subscriber\ElementRenderer;
use Netzmacht\Bootstrap\Form\Subscriber\ElementStyler;
use Netzmacht\Contao\FormHelper\Event\Events;

return array(
    Events::GENERATE_VIEW => array(
        array(new ElementStyler(), 'handle'),
        array(new ElementRenderer(), 'handle'),
    ),
    GetMultipleConfigNamesEvent::NAME => array(
        'Netzmacht\Bootstrap\Form\Subscriber\ConfigNamesProvider::handle'
    ),
);
