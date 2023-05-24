<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Listener;

use Contao\CoreBundle\DataContainer\PaletteNotFoundException;
use Contao\DataContainer;
use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Form\Environment\FormContext;
use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;

final class FormFieldDcaListener
{
    public function __construct(private readonly Environment $environment)
    {
    }

    /**
     * Adjust the palettes.
     */
    public function adjustPalettes(DataContainer $dataContainer): void
    {
        // Load custom form config.
        /** @psalm-suppress RedundantCastGivenDocblockType */
        $this->environment->enterContext(FormContext::forForm((int) $dataContainer->currentPid));
        $widgets = $this->environment->getConfig()->get(['form', 'widgets'], []);

        foreach ($widgets as $name => $config) {
            if (empty($config['input_group'])) {
                continue;
            }

            try {
                MetaPalettes::appendFields('tl_form_field', $name, 'fconfig', ['bs_addInputGroup']);
            } catch (PaletteNotFoundException) {
                // Palette does not exist. Just skip it.
            }

            foreach ($config['palettes'] ?? [] as $palette) {
                try {
                    MetaPalettes::appendFields('tl_form_field', $palette, 'fconfig', ['bs_addInputGroup']);
                } catch (PaletteNotFoundException) {
                    // Palette does not exist. Just skip it.
                }
            }
        }
    }
}
