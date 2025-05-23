<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\FormLayout;

use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Util\WidgetUtil;
use Netzmacht\Html\Attributes;
use Override;

final class FloatingFormLayout extends AbstractBootstrapFormLayout
{
    #[Override]
    public function getControlAttributes(Widget $widget): Attributes
    {
        $attributes = parent::getControlAttributes($widget);
        $type       = WidgetUtil::getType($widget);
        $floating   = (bool) ($this->widgetConfig[$type]['floating'] ?? false);

        if ($floating && ! $attributes->hasAttribute('placeholder')) {
            $attributes->setAttribute('placeholder', $widget->label);
        }

        return $attributes;
    }
}
