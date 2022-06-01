<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Environment;

use ContaoBootstrap\Core\Environment\AbstractContext;
use ContaoBootstrap\Core\Environment\ApplicationContext;
use ContaoBootstrap\Core\Environment\Context;
use ContaoBootstrap\Core\Environment\ThemeContext;

class FormContext extends AbstractContext
{
    /**
     * Form id.
     */
    private int $formId;

    private function __construct(int $formId)
    {
        $this->formId = $formId;
    }

    /**
     * Create context for given form.
     *
     * @param int $formId Form id.
     */
    public static function forForm(int $formId): self
    {
        return new self($formId);
    }

    /**
     * Get form id.
     */
    public function getFormId(): int
    {
        return $this->formId;
    }

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

    public function __toString(): string
    {
        return 'form:' . $this->formId;
    }
}
