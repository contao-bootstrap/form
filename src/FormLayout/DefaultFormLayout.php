<?php

/**
 * Contao Bootstrap form.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

namespace ContaoBootstrap\Form\FormLayout;

/**
 * Class BootstrapFormLayout
 *
 * @package ContaoBootstrap\Form\FormLayout
 */
class DefaultFormLayout extends AbstractBootstrapFormLayout
{
    /**
     * {@inheritDoc}
     */
    public function isInline(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isHorizontal(): bool
    {
        return false;
    }
}
