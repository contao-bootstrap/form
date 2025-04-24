<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Environment;

use ContaoBootstrap\Core\Environment\AbstractContext;
use ContaoBootstrap\Core\Environment\ApplicationContext;
use ContaoBootstrap\Core\Environment\Context;
use ContaoBootstrap\Core\Environment\ThemeContext;
use Override;

final class FormContext extends AbstractContext
{
    private function __construct(public readonly int $formId)
    {
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

    #[Override]
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

    #[Override]
    public function toString(): string
    {
        return 'form:' . $this->formId;
    }
}
