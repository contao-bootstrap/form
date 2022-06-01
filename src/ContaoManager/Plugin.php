<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use ContaoBootstrap\Core\ContaoBootstrapCoreBundle;
use ContaoBootstrap\Form\ContaoBootstrapFormBundle;
use Netzmacht\Contao\FormDesigner\NetzmachtContaoFormDesignerBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritDoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoBootstrapFormBundle::class)
                ->setLoadAfter(
                    [
                        ContaoCoreBundle::class,
                        ContaoBootstrapCoreBundle::class,
                        NetzmachtContaoFormDesignerBundle::class,
                    ]
                ),
        ];
    }
}
