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

namespace ContaoBootstrap\Form\Listener;

use Contao\LayoutModel;
use Contao\PageModel;
use Netzmacht\Contao\FormDesigner\Listener\AbstractListener;

/**
 * Class DefaultFormLayoutListener
 *
 * @package ContaoBootstrap\Form\Listener
 */
class DefaultFormLayoutListener extends AbstractListener
{
    /**
     * Create default bootstrap form layout.
     *
     * @param PageModel   $pageModel   Page model.
     * @param LayoutModel $layoutModel Layout model.
     *
     * @return void
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
