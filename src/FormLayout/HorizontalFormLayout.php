<?php

/**
 * Contao Bootstrap form.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Form\FormLayout;

use Contao\Widget;
use Netzmacht\Html\Attributes;

/**
 * Class BootstrapFormLayout
 *
 * @package ContaoBootstrap\Form\FormLayout
 */
class HorizontalFormLayout extends AbstractBootstrapFormLayout
{
    /**
     * Horizontal config.
     *
     * @var array
     */
    private $horizontalConfig;

    /**
     * AbstractFormLayout constructor.
     *
     * @param array $widgetConfig     Widget config map.
     * @param array $fallbackConfig   Control fallback config.
     * @param array $horizontalConfig Horizontal config.
     */
    public function __construct(array $widgetConfig, array $fallbackConfig, array $horizontalConfig)
    {
        parent::__construct($widgetConfig, $fallbackConfig);

        $this->horizontalConfig = $horizontalConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getContainerAttributes($widget);
        $attributes->addClass('row');

        return $attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabelAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getLabelAttributes($widget);
        $attributes->addClass('col-form-label');
        $attributes->addClass($this->horizontalConfig['label']);

        return $attributes;
    }

    /**
     * Get the column class.
     *
     * @param bool $withOffset If true the offset class is added.
     *
     * @return string
     */
    public function getColumnClass(bool $withOffset = false): string
    {
        $class = $this->horizontalConfig['control'];

        if ($withOffset) {
            $class .= ' ' . $this->horizontalConfig['offset'];
        }

        return $class;
    }
}
