<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Subscriber;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Bootstrap\Core\Config;
use Netzmacht\Bootstrap\Core\Config\ContextualConfig;
use Netzmacht\Bootstrap\Form\InputGroup;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element;
use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StaticHtml;

/**
 * The element renderer adjust the element stylings to support Bootstrap syntax.
 *
 * @package Netzmacht\Bootstrap\Form
 */
class ElementRenderer extends AbstractSubscriber
{
    /**
     * Modify the label.
     *
     * @param ContextualConfig|Config $config The bootstrap config.
     * @param Label                   $label  The label class.
     * @param \Widget                 $widget The widget.
     *
     * @return void
     */
    private function modifyLabel($config, Label $label, \Widget $widget)
    {
        if (!$widget->label || !$this->getWidgetConfigValue($config, $widget->type, 'label', true)) {
            $label->hide();
        } else {
            $label->addClass('control-label');
        }
    }

    /**
     * Apply the form control.
     *
     * @param ContextualConfig|Config $config    The bootstrap config.
     * @param Element                 $element   Current form element.
     * @param \Widget                 $widget    The form widget.
     * @param Container               $container The container.
     *
     * @return void
     */
    private function applyFormControl($config, $element, $widget, Container $container)
    {
        // apply form control class to the element
        if ($this->getWidgetConfigValue($config, $widget->type, 'form-control', true)) {
            $element->addClass('form-control');

            if ($container->hasChild('repeat')) {
                /** @var Element $repeat */
                $repeat = $container->getChild('repeat');
                $repeat->addClass('form-control');
            }
        }
    }

    /**
     * Adjust an element.
     *
     * @param ContextualConfig|Config $config    The bootstrap config.
     * @param mixed                   $element   The current element.
     * @param \Widget                 $widget    The original form widget.
     * @param Container               $container The form widget container.
     *
     * @return void
     */
    private function modifyElement($config, $element, $widget, Container $container)
    {
        if ($element instanceof Element) {
            $this->applyFormControl($config, $element, $widget, $container);

            // add helper inline class. It is used
            if ($this->getWidgetConfigValue($config, $widget->type, 'inline-style-option')
                && $widget->bootstrap_inlineStyle) {
                $element->addClass('inline');
            }
        }
    }

    /**
     * Move errors into the container and set css classes.
     *
     * @param ViewEvent $event     The view event.
     * @param \Widget   $widget    The widget.
     * @param Container $container The container.
     *
     * @return void
     */
    private function modifyErrors(ViewEvent $event, \Widget $widget, Container $container)
    {
        $errors = $event->getErrors();

        $errors->addClass('help-block');
        $container->addChild('errors', $errors);

        if ($widget->hasErrors()) {
            $view = $event->getView();
            $view->getAttributes()
                ->addClass('has-feedback')
                ->addClass('has-error');
        }
    }


    /**
     * Add an icon to the input group.
     *
     * @param \Widget    $widget     The form widget.
     * @param InputGroup $inputGroup The input group.
     *
     * @return void
     */
    private function addIcon(\Widget $widget, InputGroup $inputGroup)
    {
        if ($widget->bootstrap_addIcon) {
            $icon = Bootstrap::generateIcon($widget->bootstrap_icon);

            if ($widget->bootstrap_iconPosition === 'right') {
                $inputGroup->setRight($icon);
            } else {
                $inputGroup->setLeft($icon);
            }
        }
    }

    /**
     * Add a unit to the input group.
     *
     * @param \Widget    $widget     The form widget.
     * @param InputGroup $inputGroup The Input group.
     *
     * @return void
     */
    private function addUnit($widget, InputGroup $inputGroup)
    {
        if ($widget->bootstrap_addUnit) {
            if ($widget->bootstrap_unitPosition === 'right') {
                $inputGroup->setRight($widget->bootstrap_unit);
            } else {
                $inputGroup->setLeft($widget->bootstrap_unit);
            }
        }
    }

    /**
     * Handle submit buttons added to a field.
     *
     * @param ContextualConfig|Config $config     The bootstrap config.
     * @param Container               $container  Form element container.
     * @param \Widget                 $widget     The form widget.
     * @param InputGroup              $inputGroup The input group.
     *
     * @return void
     */
    private function adjustSubmitButton(
        $config,
        Container $container,
        \Widget $widget,
        InputGroup $inputGroup
    ) {
        if ($container->hasChild('submit')) {
            /** @var Node $submit */
            $submit = $container->removeChild('submit');

            // recreate as button
            if ($submit->getTag() != 'button') {
                $submit = Element::create('button');
                $submit->setAttribute('type', 'submit');
                $submit->addChild($widget->slabel);
            }

            $submit->addClass('btn');

            if ($widget->bootstrap_addSubmitClass) {
                $submit->addClass($widget->bootstrap_addSubmitClass);
            } else {
                $submit->addClass($config->get('form.default-submit-btn'));
            }

            if ($widget->bootstrap_addSubmitIcon) {
                $icon     = Bootstrap::generateIcon($widget->bootstrap_addSubmitIcon);
                $position = null;

                if ($widget->bootstrap_addSubmitIconPosition == 'left') {
                    $position = Node::POSITION_FIRST;
                    $icon    .= ' ';
                } else {
                    $icon = ' ' . $icon;
                }

                $submit->addChild(new StaticHtml($icon), $position);
            }

            $inputGroup->setRight($submit, $inputGroup::BUTTON);
        }
    }

    /**
     * Adjust the captcha element.
     *
     * @param \Widget    $widget     The form widget.
     * @param Container  $container  The element container.
     * @param InputGroup $inputGroup The input group.
     *
     * @return void
     */
    private function adjustCaptcha($widget, Container $container, InputGroup $inputGroup)
    {
        if ($widget instanceof \FormCaptcha) {
            $captcha = $container->removeChild('question');
            $inputGroup->setRight($captcha);
        }
    }

    /**
     * Add input group to the form container.
     *
     * @param ContextualConfig|Config $config    The bootstrap config.
     * @param \Widget                 $widget    The form widget.
     * @param Container               $container The element container.
     * @param CastsToString           $element   The element.
     *
     * @return void
     */
    private function addInputGroup($config, $widget, Container $container, CastsToString $element)
    {
        if ($this->getWidgetConfigValue($config, $widget->type, 'input-group')
            && ($widget->bootstrap_addIcon || $widget->bootstrap_addUnit || $container->hasChild('submit')
                || $widget->type == 'captcha'
            )
        ) {
            $inputGroup = new InputGroup();
            $inputGroup->setElement($element);
            $container->setWrapper($inputGroup);

            $this->addIcon($widget, $inputGroup);
            $this->addUnit($widget, $inputGroup);
            $this->adjustSubmitButton($config, $container, $widget, $inputGroup);
            $this->adjustCaptcha($widget, $container, $inputGroup);
        }
    }

    /**
     * Generate the form wiedget view.
     *
     * @param ViewEvent $event The form widget view event.
     *
     * @return void
     */
    public function handle(ViewEvent $event)
    {
        $container = $event->getContainer();
        $element   = $event->getContainer()->getElement();
        $widget    = $event->getWidget();
        $label     = $event->getLabel();
        $config    = $this->getConfig($event->getFormModel());

        $this->modifyLabel($config, $label, $widget);
        $this->modifyElement($config, $element, $widget, $container);
        $this->modifyErrors($event, $widget, $container);
        $this->addInputGroup($config, $widget, $container, $element);
    }
}
