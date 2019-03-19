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

declare(strict_types=1);

namespace ContaoBootstrap\Form\Environment;

use ContaoBootstrap\Core\Environment\AbstractContext;
use ContaoBootstrap\Core\Environment\ApplicationContext;
use ContaoBootstrap\Core\Environment\Context;
use ContaoBootstrap\Core\Environment\ThemeContext;

/**
 * Class FormContext.
 *
 * @package ContaoBootstrap\Form\Config
 */
class FormContext extends AbstractContext
{
    /**
     * Form id.
     *
     * @var int
     */
    private $formId;

    /**
     * FormContext constructor.
     *
     * @param int $formId Form id.
     */
    private function __construct(int $formId)
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
    public static function forForm(int $formId): self
    {
        return new static($formId);
    }

    /**
     * Get form id.
     *
     * @return int
     */
    public function getFormId(): int
    {
        return $this->formId;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Context $context): bool
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
    public function __toString(): string
    {
        return 'form:' . $this->formId;
    }
}
