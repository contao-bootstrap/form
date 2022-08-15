<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Listener;

use Contao\CoreBundle\ContaoCoreBundle;
use ContaoBootstrap\Core\Config\ArrayConfig;
use ContaoBootstrap\Core\Message\Command\BuildContextConfig;

use function method_exists;

final class FormPasswordListener
{
    public function __invoke(BuildContextConfig $command): void
    {
        // BC compatibility for repeated password field
        if (method_exists(ContaoCoreBundle::class, 'getVersion')) {
            return;
        }

        $config = $command->getConfig()->get([]);

        $config['form']['widgets']['password']['templates']['layout']                          =
            'fd_layout_bs_default_password';
        $config['form']['layouts']['horizontal']['widgets']['password']['templates']['layout'] =
            'fd_layout_bs_horizontal_password';

        $command->setConfig(new ArrayConfig($config));
    }
}
