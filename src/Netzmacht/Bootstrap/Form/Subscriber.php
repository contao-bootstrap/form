<?php

namespace Netzmacht\Bootstrap\Form;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Bootstrap\Core\Config\TypeManager;
use Netzmacht\Bootstrap\Core\Event\GetMultipleConfigNamesEvent;
use Netzmacht\Bootstrap\Core\Util\AssetsManager;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element;
use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StaticHtml;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{

    /**
     * @{inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::CREATE_VIEW               => 'selectLayout',
            Events::GENERATE_VIEW             => 'generate',
            GetMultipleConfigNamesEvent::NAME => 'getConfigNames',
        );
    }

    /**
     * @param GetMultipleConfigNamesEvent $event
     */
    public function getConfigNames(GetMultipleConfigNamesEvent $event)
    {
        $model = $event->getModel();

        if ($model->type != 'form_widget') {
            return;
        }

        if ($model->override) {
            $typeManager = $this->getTypeManager();
            $names = $typeManager->getExistingNames($model->type);

            // filter not existing values. basically to remove widgets which only exists in Contao 3.3 when being in
            // Contao 3.2
            $names = array_intersect($names, array_keys($GLOBALS['TL_FFL']));
        }
        else {
            $names = array_keys($GLOBALS['TL_FFL']);
        }

        \Controller::loadLanguageFile('tl_form_field');
        $options = array();

        foreach ($names as $name) {
            if (isset($GLOBALS['TL_LANG']['FFL'][$name][0])) {
                $options[$name] = $GLOBALS['TL_LANG']['FFL'][$name][0];
            }
            else {
                $options[$name] = $name;
            }
        }

        $event->setOptions($options);
        $event->stopPropagation();

    }

    /**
     * @param ViewEvent $event
     */
    public function selectLayout(ViewEvent $event)
    {
        if (Bootstrap::isEnabled()) {
            $view = $event->getView();

            $view->setLayout('bootstrap');
            $view->getAttributes()->addClass('form-group');
        }
    }

    /**
     * @param ViewEvent $event
     */
    public function generate(ViewEvent $event)
    {
        $container = $event->getContainer();
        $element   = $event->getContainer()->getElement();
        $widget    = $event->getWidget();
        $label     = $event->getLabel();
        $errors    = $event->getErrors();
        $form      = $event->getFormModel();

        // add label class
        $label->addClass('control-label');
        $errors->addClass('help-block');

        if (!$widget->label || !$this->getConfig($widget->type, 'label', true)) {
            $label->hide();
        }

        $this->setColumnLayout($widget, $container, $label, $form);
        $this->adjustElement($event, $element, $widget, $container);
        $this->addInputGroup($widget, $container, $element);

        // inject errors into container
        $container->addChild('errors', $errors);

        if ($widget->hasErrors()) {
            $view = $event->getView();
            $view->getAttributes()
                ->addClass('has-feedback')
                ->addClass('has-errors');
        }
    }

    /**
     * @param Container $container
     */
    protected function generateUpload(Container $container)
    {
        $config  = Bootstrap::getConfigVar('form.styled-upload');
        $element = $container->getElement();

        /** @var Element $element */
        $element->addClass('sr-only');
        $element->setAttribute('onchange', sprintf($config['onchange'], $element->getId()));

        $input = Element::create('input', array('type' => 'text'))
            ->setId($element->getId() . '_value')
            ->addClass('form-control')
            ->setAttribute('disabled', true)
            ->setAttribute('name', $element->getAttribute('name') . '_value');

        if ($element->hasAttribute('placeholder')) {
            $input->setAttribute('placeholder', $element->getAttribute('placeholder'));
        }

        $click = sprintf('$(%s).click();return false;', $element->getId());
        $submit = Element::create('button', array('type' => 'submit'))
            ->addChild($config['label'])
            ->addClass($config['class'])
            ->setAttribute('onclick', $click);

        $inputGroup = new InputGroup();
        $inputGroup->setElement($input);

        if ($config['position'] == 'left') {
            $inputGroup->setLeft($submit, $inputGroup::BUTTON);
        } else {
            $inputGroup->setRight($submit, $inputGroup::BUTTON);
        }

        $container->addChild('upload', $inputGroup);
    }

    /**
     * @param $type
     * @param $name
     * @param bool $default
     * @return mixed
     */
    protected function getConfig($type, $name, $default = false)
    {
        return Bootstrap::getConfigVar('form.widgets.' . $type . '.' . $name, $default);
    }

    /**
     * @param ViewEvent $event
     * @param $element
     * @param $widget
     * @param $container
     */
    private function adjustElement(ViewEvent $event, $element, $widget, $container)
    {
        if ($element instanceof Element) {
            // apply form control class to the element
            if ($this->getConfig($widget->type, 'form-control', true)) {
                $element->addClass('form-control');
            }

            // add helper inline class. It is used
            if ($this->getConfig($widget->type, 'inline-style-option') && $widget->bootstrap_inlineStyle) {
                $element->addClass('inline');
            }

            // enable styled select
            if (Bootstrap::getConfigVar('form.styled-select.enabled')
                && $this->getConfig($widget->type, 'styled-select')) {
                $javascripts = Bootstrap::getConfigVar('form.styled-select.javascript');
                $stylesheets = Bootstrap::getConfigVar('form.styled-select.stylesheet');

                AssetsManager::addJavascripts($javascripts, 'bootstrap-styled-select');
                AssetsManager::addStylesheets($stylesheets, 'bootstrap-styled-select');

                $element->addClass(Bootstrap::getConfigVar('form.styled-select.class'));
                $element->setAttribute('data-style', Bootstrap::getConfigVar('form.styled-select.style'));
            }

            if ($event->getWidget()->type == 'upload' && Bootstrap::getConfigVar('form.styled-upload.enabled')) {
                $this->generateUpload($container);
            }
        }
    }

    /**
     * @param $widget
     * @param \Netzmacht\Contao\FormHelper\Partial\Container $container
     * @param \Netzmacht\Contao\FormHelper\Partial\Label $label
     * @param $form
     */
    private function setColumnLayout($widget, Container $container, Label $label, $form)
    {
        if (($form && !$widget->tableless)
            || (!$form && Bootstrap::getConfigVar('form.default-horizontal'))
        ) {
            $container->setRenderContainer(true);
            $container->addClass(Bootstrap::getConfigVar('form.horizontal.control'));

            if (!$widget->label || !$this->getConfig($widget->type, 'label', true)) {
                $container->addClass(Bootstrap::getConfigVar('form.horizontal.offset'));
            } else {
                $label->addClass(Bootstrap::getConfigVar('form.horizontal.label'));
            }
        }
    }

    /**
     * @param $widget
     * @param $inputGroup
     * @return string
     */
    private function addIcon($widget, InputGroup $inputGroup)
    {
        if ($widget->bootstrap_addIcon) {
            $icon = Bootstrap::generateIcon($widget->bootstrap_icon);

            if ($widget->bootstrap_iconPosition == 'right') {
                $inputGroup->setRight($icon);
            } else {
                $inputGroup->setLeft($icon);
            }
        }
    }

    /**
     * @param $widget
     * @param InputGroup $inputGroup
     */
    private function addUnit($widget, InputGroup $inputGroup)
    {
        // add unit
        if ($widget->bootstrap_addUnit) {
            if ($widget->bootstrap_unitPosition == 'right') {
                $inputGroup->setRight($widget->bootstrap_unit);
            } else {
                $inputGroup->setLeft($widget->bootstrap_unit);
            }
        }
    }

    /**
     * @param $container
     * @param $widget
     * @param $inputGroup
     */
    private function adjustSubmitButton(Container $container, $widget, InputGroup $inputGroup)
    {
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
            }

            if ($widget->bootstrap_addSubmitIcon) {
                $icon     = Bootstrap::generateIcon($widget->bootstrap_addSubmitIcon);
                $position = null;

                if ($widget->bootstrap_addSubmitIconPosition == 'left') {
                    $position = Node::POSITION_FIRST;
                    $icon .= ' ';
                } else {
                    $icon = ' ' . $icon;
                }

                $submit->addChild(new StaticHtml($icon), $position);
            }

            $inputGroup->setRight($submit, $inputGroup::BUTTON);
        }
    }

    /**
     * @param $widget
     * @param $container
     * @param $inputGroup
     */
    private function adjustCaptcha($widget, Container $container, InputGroup $inputGroup)
    {
        if ($widget instanceof \FormCaptcha) {
            $captcha = $container->removeChild('question');
            $inputGroup->setRight($captcha);
        }
    }

    /**
     * @param $widget
     * @param $container
     * @param $element
     */
    private function addInputGroup($widget, Container $container, CastsToString $element)
    {
        if ($this->getConfig($widget->type, 'input-group') &&
            ($widget->bootstrap_addIcon ||
                $widget->bootstrap_addUnit ||
                $container->hasChild('submit') ||
                $widget->type == 'captcha'
            )
        ) {
            $inputGroup = new InputGroup();
            $inputGroup->setElement($element);
            $container->setWrapper($inputGroup);

            $this->addIcon($widget, $inputGroup);
            $this->addUnit($widget, $inputGroup);
            $this->adjustSubmitButton($container, $widget, $inputGroup);
            $this->adjustCaptcha($widget, $container, $inputGroup);
        }
    }

    /**
     * @return TypeManager
     */
    public function getTypeManager()
    {
        return $GLOBALS['container']['bootstrap.config-type-manager'];
    }
}
