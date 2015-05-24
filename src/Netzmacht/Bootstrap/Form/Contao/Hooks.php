<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Contao;

use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * Hooks for the form component.
 *
 * @package Netzmacht\Bootstrap\Form\Contao\FormField
 */
class Hooks
{
    /**
     * Listen to the form field hook.
     *
     * @param \Widget $widget The form field hook.
     *
     * @return \Widget
     */
    public function loadFormField($widget)
    {
        // Force table less mode in the form field. Otherwise it is not rendered.
        if ($widget->type === 'fieldset' && Bootstrap::isEnabled()) {
            $widget->tableless = true;
        }

        return $widget;
    }
}
