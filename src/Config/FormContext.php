<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Form\Config;

use ContaoBootstrap\Core\Environment\AbstractContext;
use ContaoBootstrap\Core\Environment\ApplicationContext;
use ContaoBootstrap\Core\Environment\Context;
use ContaoBootstrap\Core\Environment\ThemeContext;

/**
 * Class FormContext
 *
 * @package ContaoBootstrap\Form\Config
 */
class FormContext extends AbstractContext
{
    /**
     * Form id.
     * @var int
     */
    private $formId;

    /**
     * FormContext constructor.
     *
     * @param int $formId Form id.
     */
    private function __construct($formId)
    {
        $this->formId = $formId;
    }

    /**
     * Create context for given form.
     *
     * @param int $formId Form id.
     *
     * @return static
     */
    public static function forForm($formId)
    {
        return new static($formId);
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Context $context)
    {
        if ($context instanceof ApplicationContext) {
            return true;
        }

        if ($context instanceof ThemeContext) {
            return true;
        }

        return $this->match($context);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return 'form:' . $this->formId;
    }
}
