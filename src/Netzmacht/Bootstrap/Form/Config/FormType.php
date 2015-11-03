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
 * Class FormType stores configuration for forms.
 *
 * @package Netzmacht\Bootstrap\Form\Config
 */
class FormType implements Type
{
    /**
     * {@inheritdoc}
     */
    public function buildConfig(Config $config, BootstrapConfigModel $model)
    {
        $config->set('form.default-horizontal', (bool) $model->form_default_horizontal);
        $config->set('form.default-submit-btn', $model->form_default_submit_btn);
        $config->set(
            'form.horizontal',
            array(
                'label'   => $model->form_horizontal_label,
                'control' => $model->form_horizontal_control,
                'offset'  => $model->form_horizontal_offset,
            )
        );

        if ($model->form_styled_select) {
            $config->merge(
                array(
                    'enabled'              => true,
                    'class'                => $model->form_styled_select_class,
                    'style'                => $model->form_styled_select_style,
                    'size'                 => $model->form_styled_select_size,
                    'search-threshold'     => $model->form_styled_select_threshold,
                    'selected-text-format' => $model->form_styled_select_format
                ),
                'form.styled-select'
            );
        } else {
            $config->set('form.styled-select.enabled', false);
        }

        if ($model->form_styled_upload) {
            $config->merge(
                array(
                    'enabled'  => true,
                    'class'    => $model->form_styled_upload_class,
                    'position' => $model->form_styled_upload_position,
                ),
                'form.styled-upload'
            );
        } else {
            $config->set('form.styled-upload.enabled', false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function extractConfig($key, Config $config, BootstrapConfigModel $model)
    {
        $model->form_default_horizontal = $config->get('form.default-horizontal');
        $model->form_default_submit_btn = $config->get('form.default-submit-btn');
        $model->form_horizontal_label   = $config->get('form.horizontal.label');
        $model->form_horizontal_control = $config->get('form.horizontal.control');
        $model->form_horizontal_offset  = $config->get('form.horizontal.offset');

        $model->form_styled_select           = $config->get('form.styled-select.enabled');
        $model->form_styled_select_class     = $config->get('form.styled-select.class');
        $model->form_styled_select_style     = $config->get('form.styled-select.style');
        $model->form_styled_select_size      = $config->get('form.styled-select.size');
        $model->form_styled_select_threshold = $config->get('form.styled-select.search-threshold');
        $model->form_styled_select_format    = $config->get('form.styled-select.selected-text-format');

        $model->form_styled_upload          = $config->get('form.styled-upload.enabled');
        $model->form_styled_upload_class    = $config->get('form.styled-upload.class');
        $model->form_styled_upload_position = $config->get('form.styled-upload.position');
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
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isNameEditable()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return 'form';
    }
}
