<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\FormLayout;

use Contao\Widget;
use ContaoBootstrap\Core\Environment;
use Netzmacht\Html\Attributes;

class HorizontalFormLayout extends AbstractBootstrapFormLayout
{
    /**
     * Horizontal config.
     *
     * @var array<string,mixed>
     */
    private array $horizontalConfig;

    /**
     * @param array<string,array<string,mixed>> $widgetConfig     Widget config map.
     * @param array<string,mixed>               $fallbackConfig   Control fallback config.
     * @param array<string,mixed>               $horizontalConfig Horizontal config.
     */
    public function __construct(
        Environment $environment,
        array $widgetConfig,
        array $fallbackConfig,
        array $horizontalConfig
    ) {
        parent::__construct($environment, $widgetConfig, $fallbackConfig);

        $this->horizontalConfig = $horizontalConfig;
    }

    public function getContainerAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getContainerAttributes($widget);
        $attributes->addClass($this->getRowClass());

        return $attributes;
    }

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
     */
    public function getColumnClass(bool $withOffset = false): string
    {
        $class = (string) $this->horizontalConfig['control'];

        if ($withOffset) {
            $class .= ' ' . $this->horizontalConfig['offset'];
        }

        return $class;
    }

    /**
     * Get the offset class.
     */
    public function getOffsetClass(): string
    {
        return (string) $this->horizontalConfig['offset'];
    }

    /**
     * Get the label column class.
     */
    public function getLabelColumnClass(): string
    {
        return (string) $this->horizontalConfig['label'];
    }

    /**
     * Get the row class.
     */
    public function getRowClass(): string
    {
        return (string) $this->horizontalConfig['row'];
    }
}
