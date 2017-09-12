<?php

/**
 * @package    Website
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Form\Listener;

use Contao\LayoutModel;
use Contao\PageModel;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\LayoutManager;
use Netzmacht\Contao\FormDesigner\Listener\AbstractListener;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;
use Psr\Log\LoggerInterface;

/**
 * Class DefaultFormLayoutListener
 *
 * @package ContaoBootstrap\Form\Listener
 */
class DefaultFormLayoutListener extends AbstractListener
{
    /**
     * DefaultFormLayoutListener constructor.
     *
     * @param LayoutManager        $layoutManager
     * @param FormLayoutRepository $repository
     * @param FormLayoutFactory    $factory
     *
     * @param LoggerInterface      $logger
     *
     * @internal param BootstrapFormLayoutFactory $formLayoutFactory
     */
    public function __construct(
        LayoutManager $layoutManager,
        FormLayoutRepository $repository,
        FormLayoutFactory $factory,
        LoggerInterface $logger
    ) {
        parent::__construct($layoutManager, $repository, $factory, $logger);
    }


    /**
     * Create default bootstrap form layout.
     *
     * @param PageModel   $pageModel   Page model.
     * @param LayoutModel $layoutModel Layout model.
     *
     * @return void
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
