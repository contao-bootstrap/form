<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Listener;

use Contao\LayoutModel;
use Contao\PageModel;
use Netzmacht\Contao\FormDesigner\Listener\AbstractListener;

final class DefaultFormLayoutListener extends AbstractListener
{
    /**
     * Create default bootstrap form layout.
     *
     * @param PageModel   $pageModel   Page model.
     * @param LayoutModel $layoutModel Layout model.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onGetPageLayout(PageModel $pageModel, LayoutModel $layoutModel): void
    {
        if ($this->manager->hasDefaultThemeLayout()) {
            return;
        }

        $this->manager->setDefaultThemeLayout($this->factory->create('bs_default', []));
    }
}
