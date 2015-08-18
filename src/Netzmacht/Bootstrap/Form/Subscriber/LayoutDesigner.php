<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Subscriber;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\Partial\Label;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * LayoutDesigner is responsible for creating the bootstrap form layout.
 *
 * @package Netzmacht\Bootstrap\Form\Subscriber
 */
class LayoutDesigner extends AbstractSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::CREATE_VIEW   => 'setViewLayout',
            Events::GENERATE_VIEW => 'setColumnLayout',
        );
    }

    /**
     * Select the view layout if bootstrap is enabled.
     *
     * @param ViewEvent $event The event.
     *
     * @return void
     */
    public function setViewLayout(ViewEvent $event)
    {
        if (Bootstrap::isEnabled()) {
            $view = $event->getView();

            $view->setLayout('bootstrap');
            $view->getAttributes()->addClass('form-group');
        }
    }

    /**
     * Set bootstrap column layout.
     *
     * @param ViewEvent $event The view event.
     *
     * @return void
     */
    public function setColumnLayout(ViewEvent $event)
    {
        $form   = $event->getFormModel();
        $widget = $event->getWidget();
        $config = $this->getConfig($form);

        if (($form && $widget->tableless) || (!$form && !$config->get('form.default-horizontal'))) {
            return;
        }

        $container = $event->getContainer();
        $label     = $event->getLabel();

        $container->setRenderContainer(true);
        $container->addClass($config->get('form.horizontal.control'));

        if (!$widget->label || !$this->getWidgetConfigValue($config, $widget->type, 'label', true)) {
            $container->addClass($config->get('form.horizontal.offset'));
        } else {
            $label->addClass($config->get('form.horizontal.label'));
        }

        if ($container->hasChild('repeatLabel')) {
            /** @var Label $label */
            $label = $container->getChild('repeatLabel');
            $label->addClass('control-label');

            if ($this->getWidgetConfigValue($config, $widget->type, 'label', true)) {
                $label->addClass($config->get('form.horizontal.label'));
            }
        }
    }
}
