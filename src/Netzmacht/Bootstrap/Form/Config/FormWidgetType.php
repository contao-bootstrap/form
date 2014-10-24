<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Form\Config;


use Netzmacht\Bootstrap\Core\Config;
use Netzmacht\Bootstrap\Core\Config\Type;
use Netzmacht\Bootstrap\Core\Contao\Model\BootstrapConfigModel;

class FormWidgetType implements Type
{
    /**
     * @param Config $config
     * @param BootstrapConfigModel $model
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
     * @param $key
     * @param Config $config
     * @param BootstrapConfigModel $model
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
     * @return bool
     */
    public function hasGlobalScope()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'form.widgets';
    }

    /**
     * @return bool
     */
    public function isNameEditable()
    {
        return false;
    }
}
