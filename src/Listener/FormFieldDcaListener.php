<?php

/**
 * Contao Bootstrap form.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @author     Nikolas Runde <mail@nrun.de>
 * @copyright  2017-2018 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Form\Listener;

use Contao\CoreBundle\DataContainer\PaletteNotFoundException;
use Contao\CoreBundle\Exception\PaletteNotFoundException as LegacyPaletteNotFoundException;
use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;
use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Form\Environment\FormContext;

/**
 * Class FormField.
 *
 * @package ContaoBootstrap\Form\Dca
 */
class FormFieldDcaListener
{
    /**
     * Bootstrap environment.
     *
     * @var Environment
     */
    private $environment;

    /**
     * FormField constructor.
     *
     * @param Environment $environment Bootstrap environment.
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Adjust the palettes.
     *
     * @return void
     */
    public function adjustPalettes(): void
    {
        // Load custom form config.
        $this->environment->enterContext(FormContext::forForm((int) CURRENT_ID));
        $widgets = $this->environment->getConfig()->get('form.widgets', []);

        foreach ($widgets as $name => $config) {
            if (!empty($config['input_group'])) {
                try {
                    MetaPalettes::appendFields('tl_form_field', $name, 'fconfig', ['bs_addInputGroup']);
                } catch (PaletteNotFoundException | LegacyPaletteNotFoundException $e) {
                    // Palette does not exist. Just skip it.
                }
            }
        }
    }
}
