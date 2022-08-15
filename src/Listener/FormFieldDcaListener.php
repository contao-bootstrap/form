<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Listener;

use Contao\CoreBundle\DataContainer\PaletteNotFoundException;
use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Form\Environment\FormContext;
use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;

use function defined;

class FormFieldDcaListener
{
    /**
     * Bootstrap environment.
     */
    private Environment $environment;

    /**
     * @param Environment $environment Bootstrap environment.
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Adjust the palettes.
     */
    public function adjustPalettes(): void
    {
        if (! defined('CURRENT_ID')) {
            return;
        }

        // Load custom form config.
        $this->environment->enterContext(FormContext::forForm((int) CURRENT_ID));
        $widgets = $this->environment->getConfig()->get('form.widgets', []);

        foreach ($widgets as $name => $config) {
            if (empty($config['input_group'])) {
                continue;
            }

            try {
                MetaPalettes::appendFields('tl_form_field', $name, 'fconfig', ['bs_addInputGroup']);
            } catch (PaletteNotFoundException $e) {
                // Palette does not exist. Just skip it.
            }

            foreach ($config['palettes'] ?? [] as $palette) {
                try {
                    MetaPalettes::appendFields('tl_form_field', $palette, 'fconfig', ['bs_addInputGroup']);
                } catch (PaletteNotFoundException $e) {
                    // Palette does not exist. Just skip it.
                }
            }
        }
    }
}
