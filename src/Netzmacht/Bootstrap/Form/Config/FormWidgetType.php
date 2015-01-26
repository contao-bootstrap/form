<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Config;

use Netzmacht\Bootstrap\Core\Config;
use Netzmacht\Bootstrap\Core\Config\Type;
use Netzmacht\Bootstrap\Core\Contao\Model\BootstrapConfigModel;

/**
 * Class FormWidgetType handles backend config of a form widget configuration.
 *
 * @package Netzmacht\Bootstrap\Form\Config
 */
class FormWidgetType implements Type
{
    /**
     * {@inheritdoc}
     */
    public function buildConfig(Config $config, BootstrapConfigModel $model)
    {
        $key   = $this->getPath() . '.' . $model->name;
        $value = array(
            'form-control'        => (bool) $model->form_widget_control,
            'modal-footer'        => (bool) $model->form_widget_modal_footer,
            'input-group'         => (bool) $model->form_widget_input_group,
            'label'               => (bool) $model->form_widget_label,
            'styled-select'       => (bool) $model->form_widget_styled_select,
        );

        // merge config, so that not configurable options won't be overriden (e.g. inline style option)
        $config->merge($value, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function extractConfig($key, Config $config, BootstrapConfigModel $model)
    {
        $keys = explode('.', $key);

        $model->name                      = end($keys);
        $model->form_widget_control       = $config->get($key . '.form-control', true);
        $model->form_widget_modal_footer  = $config->get($key . '.modal-footer', false);
        $model->form_widget_input_group   = $config->get($key . '.input-group', false);
        $model->form_widget_styled_select = $config->get($key . '.styled-select', false);
        $model->form_widget_label         = $config->get($key . '.label', true);
    }

    /**
     * {@inheritdoc}
     */
    public function hasGlobalScope()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isMultiple()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return 'form.widgets';
    }

    /**
     * {@inheritdoc}
     */
    public function isNameEditable()
    {
        return false;
    }
}
