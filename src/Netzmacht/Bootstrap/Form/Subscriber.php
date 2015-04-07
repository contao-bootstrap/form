<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

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

/**
 * Class Subscriber subscribes to form helper to adjust bootstrap form output.
 *
 * @package Netzmacht\Bootstrap\Form
 */
class Subscriber implements EventSubscriberInterface
{
    /**
     * Bootstrap-Select localization mapping.
     *
     * @var array
     */
    private static $selectLocalizations = array(
        'cs' => 'cs_CZ',
        'de' => 'de_DE',
        'en' => 'eu_US',
        'es' => 'es_CL',
        'eu' => 'eu',
        'fr' => 'fr_FR',
        'it' => 'it_IT',
        'nl' => 'nl_NL',
        'pl' => 'pl_PL',
        'bt' => 'pt_BR',
        'ro' => 'ro_RO',
        'ru' => 'ru_RU',
        'ua' => 'ua_UA',
        'zh' => 'zh_CN',
        // Not supported zh_TW
    );

    /**
     * {@inheritdoc}
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
     * Get All provides config names for the backend config.
     *
     * @param GetMultipleConfigNamesEvent $event Event being handled.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getConfigNames(GetMultipleConfigNamesEvent $event)
    {
        $model = $event->getModel();

        if ($model->type != 'form_widget') {
            return;
        }

        if ($model->override) {
            $typeManager = $this->getTypeManager();
            $names       = $typeManager->getExistingNames($model->type);

            // filter not existing values. basically to remove widgets which only exists in Contao 3.3 when being in
            // Contao 3.2
            $names = array_intersect($names, array_keys($GLOBALS['TL_FFL']));
        } else {
            $names = array_keys($GLOBALS['TL_FFL']);
        }

        \Controller::loadLanguageFile('tl_form_field');
        $options = array();

        foreach ($names as $name) {
            if (isset($GLOBALS['TL_LANG']['FFL'][$name][0])) {
                $options[$name] = $GLOBALS['TL_LANG']['FFL'][$name][0];
            } else {
                $options[$name] = $name;
            }
        }

        $event->setOptions($options);
        $event->stopPropagation();

    }

    /**
     * Handle select layout event.
     *
     * @param ViewEvent $event View event subscribed.
     *
     * @return void
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
     * Generate the form wiedget view.
     *
     * @param ViewEvent $event The form widget view event.
     *
     * @return void
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
                ->addClass('has-error');
        }
    }

    /**
     * Generate the upload field.
     *
     * @param Container $container Form element container.
     * @param \Widget   $widget    Form widget.
     *
     * @return void
     */
    protected function generateUpload(Container $container, $widget)
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
        } elseif ($widget->placeholder) {
            $input->setAttribute('placeholder', $widget->placeholder);
        }

        $click  = sprintf('$(%s).click();return false;', $element->getId());
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
     * Get a config value for a given form widget type.
     *
     * @param string $type    The widget type.
     * @param string $name    The configuration name.
     * @param mixed  $default The default value.
     *
     * @return mixed
     */
    protected function getConfig($type, $name, $default = false)
    {
        return Bootstrap::getConfigVar('form.widgets.' . $type . '.' . $name, $default);
    }

    /**
     * Adjust an element.
     *
     * @param ViewEvent $event     The view event subscribed to.
     * @param mixed     $element   The current element.
     * @param \Widget   $widget    The original form wiedget.
     * @param Container $container The form widget container.
     *
     * @return void
     */
    private function adjustElement(ViewEvent $event, $element, $widget, Container $container)
    {
        if ($element instanceof Element) {
            $this->applyFormControl($element, $widget, $container);

            // add helper inline class. It is used
            if ($this->getConfig($widget->type, 'inline-style-option') && $widget->bootstrap_inlineStyle) {
                $element->addClass('inline');
            }

            // enable styled select
            if (Bootstrap::getConfigVar('form.styled-select.enabled')
                && $this->getConfig($widget->type, 'styled-select')) {

                $element->addClass(Bootstrap::getConfigVar('form.styled-select.class'));
                $element->setAttribute('data-style', Bootstrap::getConfigVar('form.styled-select.style'));

                $this->registerStyledSelectAssets();
                $this->setDataStyleAttribute($element, $widget);
            }

            if ($event->getWidget()->type == 'upload' && Bootstrap::getConfigVar('form.styled-upload.enabled')) {
                $this->generateUpload($container, $widget);
            }
        }
    }

    /**
     * Set bootstrap column layout.
     *
     * @param \Widget         $widget    The form widget.
     * @param Container       $container The form element container.
     * @param Label           $label     The form label.
     * @param \FormModel|null $form      The form model if it is part of the form generator.
     *
     * @return void
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

            if ($container->hasChild('repeatLabel')) {
                $label = $container->getChild('repeatLabel');
                $label->addClass('control-label');

                if ($this->getConfig($widget->type, 'label', true)) {
                    $label->addClass(Bootstrap::getConfigVar('form.horizontal.label'));
                }
            }
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
     * Add a unit to the input group.
     *
     * @param \Widget    $widget     The form widget.
     * @param InputGroup $inputGroup The Input group.
     *
     * @return void
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
     * Handle submit buttons added to a field.
     *
     * @param Container  $container  Form element container.
     * @param \Widget    $widget     The form widget.
     * @param InputGroup $inputGroup The input group.
     *
     * @return void
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
            } else {
                $submit->addClass(Bootstrap::getConfigVar('form.default-submit-btn'));
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
     * @param \Widget       $widget    The form widget.
     * @param Container     $container The element container.
     * @param CastsToString $element   The element.
     *
     * @return void
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
     * Get form type manager.
     *
     * @return TypeManager
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getTypeManager()
    {
        return $GLOBALS['container']['bootstrap.config-type-manager'];
    }

    /**
     * Apply the form control.
     *
     * @param mixed     $element   Current form element.
     * @param \Widget   $widget    The form widget.
     * @param Container $container The container.
     *
     * @return void
     */
    private function applyFormControl($element, $widget, Container $container)
    {
        // apply form control class to the element
        if ($this->getConfig($widget->type, 'form-control', true)) {
            $element->addClass('form-control');

            if ($container->hasChild('repeat')) {
                $repeat = $container->getChild('repeat');
                $repeat->addClass('form-control');
            }
        }
    }

    /**
     * Register styled select assets.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function registerStyledSelectAssets()
    {
        $javascripts = (array) Bootstrap::getConfigVar('form.styled-select.javascript');
        $stylesheets = Bootstrap::getConfigVar('form.styled-select.stylesheet');
        $language    = substr($GLOBALS['TL_LANGUAGE'], 0, 2);

        if (isset(static::$selectLocalizations[$language])) {
            $javascripts[] = 'system/modules/bootstrap-form/assets/bootstrap-select/js/i18n/defaults-' .
                static::$selectLocalizations[$language] . '.min.js';
        }

        AssetsManager::addJavascripts($javascripts, 'bootstrap-styled-select');
        AssetsManager::addStylesheets($stylesheets, 'bootstrap-styled-select');
    }

    /**
     * Set data style attribute for bootstrap select.
     *
     * @param Element $element The select element.
     * @param \Widget $widget  The widget.
     *
     * @return void
     */
    private function setDataStyleAttribute($element, $widget)
    {
        // If a btn-* class isset, set it as data-style attribute.
        $classes = explode(' ', $widget->class);
        foreach ($classes as $class) {
            if (strpos($class, 'btn-') === 0) {
                $element->removeClass($class);
                $element->setAttribute('data-style', $class);
                break;
            }
        }
    }
}
