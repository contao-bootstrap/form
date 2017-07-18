<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Form\Dca;

use Bit3\Contao\MetaPalettes\MetaPalettes;
use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Form\Config\FormContext;

/**
 * Class FormField.
 *
 * @package ContaoBootstrap\Form\Dca
 */
class FormField
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
    public function adjustPalettes()
    {
        // Load custom form config.
        $this->environment->enterContext(FormContext::forForm(CURRENT_ID));

        $widgets = $this->environment->getConfig()->get('form.widgets', []);
        foreach ($widgets as $name => $config) {
            if (!empty($config['input_group'])) {
                MetaPalettes::appendFields('tl_form_field', $name, 'fconfig', ['bs_addInputGroup']);
            }
        }
    }
}
