<?php

/**
 * @package    Website
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Form\FormLayout;

use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Layout\AbstractFormLayout;
use Netzmacht\Html\Attributes;

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
     * @inheritDoc
     */
    public function getContainerAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getContainerAttributes($widget);
        $attributes->addClass('form-group');

        return $attributes;
    }

    /**
     * @inheritDoc
     */
    public function getLabelAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getLabelAttributes($widget);

        return $attributes;
    }

    /**
     * @inheritDoc
     */
    public function getControlAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getControlAttributes($widget);

        if (!array_key_exists('form_control', $this->widgetConfig[$widget->type])
            || $this->widgetConfig[$widget->type]['form_control']) {
            $attributes->addClass('form-control');
        }

        return $attributes;
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
        if ($section === 'help' && empty($this->widgetConfig[$widget->type]['help'])) {
            return '';
        }

        if (isset($this->widgetConfig[$widget->type]['templates'][$section])) {
            return $this->widgetConfig[$widget->type]['templates'][$section];
        }

        if (isset($this->fallbackConfig['templates'][$section])) {
            return $this->fallbackConfig['templates'][$section];
        }

        return '';
    }

    /**
     * Check if form is horizontal.
     *
     * @return bool
     */
    abstract public function isHorizontal(): bool;

    /**
     * Check if form is inline.
     *
     * @return bool
     */
    abstract public function isInline(): bool;
}
