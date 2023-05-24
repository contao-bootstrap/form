<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Listener;

use Contao\ContentModel;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Model;
use Contao\ModuleModel;
use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Form\Environment\FormContext;

final class FormContextListener
{
    public function __construct(private readonly Environment $environment)
    {
    }

    /** @Hook("isVisibleElement") */
    public function onIsVisibleElement(Model $element, bool $isVisible): bool
    {
        if (! $element instanceof ModuleModel && ! $element instanceof ContentModel) {
            return $isVisible;
        }

        if ($element->type !== 'form' || ! $isVisible) {
            return $isVisible;
        }

        /** @psalm-suppress RedundantCastGivenDocblockType */
        $this->environment->enterContext(FormContext::forForm((int) $element->form));

        return true;
    }

    /** @Hook("getContentElement") */
    public function onGetContentElement(ContentModel $contentModel, string $buffer): string
    {
        if ($contentModel->type !== 'form') {
            return $buffer;
        }

        /** @psalm-suppress RedundantCastGivenDocblockType */
        $this->environment->leaveContext(FormContext::forForm((int) $contentModel->form));

        return $buffer;
    }

    /** @Hook("getFrontendModule") */
    public function onGetFrontendModule(ModuleModel $moduleModel, string $buffer): string
    {
        if ($moduleModel->type !== 'form') {
            return $buffer;
        }

        /** @psalm-suppress RedundantCastGivenDocblockType */
        $this->environment->leaveContext(FormContext::forForm((int) $moduleModel->form));

        return $buffer;
    }
}
