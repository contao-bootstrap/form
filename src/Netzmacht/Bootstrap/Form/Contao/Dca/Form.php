<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Form\Contao\Dca;

use Netzmacht\Bootstrap\Core\Contao\Model\BootstrapConfigModel;

/**
 * Class Form provides helper methods for the form data container.
 *
 * @package Netzmacht\Bootstrap\Form\Contao\Dca
 */
class Form
{
    /**
     * Get config type options.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getConfigTypes()
    {
        \Controller::loadLanguageFile('tl_bootstrap_config');

        $options    = array();
        $collection = BootstrapConfigModel::findBy(
            array('(type = ? OR type=?)'),
            array('form_widget', 'form'),
            array('order' => 'name')
        );

        if ($collection) {
            foreach ($collection as $model) {
                $type = isset($GLOBALS['TL_LANG']['bootstrap_config_type'][$model->type])
                    ? $GLOBALS['TL_LANG']['bootstrap_config_type'][$model->type]
                    : $model->type;

                $options[$model->id] = sprintf(
                    '%s (%s): %s %s (%s)',
                    $model->getRelated('pid')->name,
                    $model->pid,
                    $type,
                    $model->name,
                    $model->id
                );
            }
        }

        return $options;
    }
}
