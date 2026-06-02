<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Listener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\LayoutModel;
use Contao\PageModel;
use Netzmacht\Contao\FormDesigner\Listener\AbstractListener;

final class DefaultFormLayoutListener extends AbstractListener
{
    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    #[AsHook('getPageLayout')]
    public function onGetPageLayout(PageModel $pageModel, LayoutModel $layoutModel): void
    {
        if ($this->manager->hasDefaultThemeLayout()) {
            return;
        }

        $this->manager->setDefaultThemeLayout($this->factory->create('bs_default', []));
    }
}
