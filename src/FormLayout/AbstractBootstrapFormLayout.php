<?php

/**
 * Contao Bootstrap form.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017-2019 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0-or-later
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Form\FormLayout;

use Contao\Widget;
use ContaoBootstrap\Form\Helper\InputGroupHelper;
use Netzmacht\Contao\FormDesigner\Layout\AbstractFormLayout;
use Netzmacht\Contao\FormDesigner\Util\WidgetUtil;
use Netzmacht\Html\Attributes;
use function array_key_exists;

/**
 * Class AbstractBootstrapFormLayout
 *
 * @package ContaoBootstrap\Form\FormLayout
 */
abstract class AbstractBootstrapFormLayout extends AbstractFormLayout
{
    /**
     * Fallback templates config.
     *
     * @var array
     */
    private $fallbackConfig;

    /**
     * AbstractFormLayout constructor.
     *
     * @param array $widgetConfig   Widget config map.
     * @param array $fallbackConfig Control fallback config.
     */
    public function __construct(array $widgetConfig, array $fallbackConfig)
    {
        parent::__construct($widgetConfig);

        $this->fallbackConfig = $fallbackConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getContainerAttributes($widget);
        $attributes->addClass('form-group');

        return $attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabelAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getLabelAttributes($widget);

        return $attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function getControlAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getControlAttributes($widget);
        $type       = WidgetUtil::getType($widget);

        if (!isset($this->widgetConfig[$type])
            || !array_key_exists('form_control', $this->widgetConfig[$type])
            || $this->widgetConfig[$type]['form_control']
        ) {
            $attributes->addClass('form-control');
        }

        if (!$widget->controlClass && isset($this->widgetConfig[$type]['control_class'])) {
            $attributes->addClass($this->widgetConfig[$type]['control_class']);
        }

        if ($widget->hasErrors()) {
            $attributes->addClass('is-invalid');
        }

        return $attributes;
    }

    /**
     * Get the input group.
     *
     * @param Widget $widget Widget.
     *
     * @return InputGroupHelper
     */
    public function getInputGroup(Widget $widget)
    {
        $type = WidgetUtil::getType($widget);

        if (isset($this->widgetConfig[$type]['input_group']) && $widget->bs_addInputGroup) {
            return InputGroupHelper::forWidget($widget);
        }

        return null;
    }

    /**
     * Get a template for a section.
     *
     * @param Widget $widget  Widget.
     * @param string $section Section.
     *
     * @return string
     */
    protected function getTemplate(Widget $widget, string $section): string
    {
        $type = WidgetUtil::getType($widget);

        if ($section === 'help' && empty($this->widgetConfig[$type]['help'])) {
            return '';
        }

        if (isset($this->widgetConfig[$type]['templates'][$section])) {
            return $this->widgetConfig[$type]['templates'][$section];
        }

        if (isset($this->fallbackConfig['templates'][$section])) {
            return $this->fallbackConfig['templates'][$section];
        }

        return '';
    }
}
