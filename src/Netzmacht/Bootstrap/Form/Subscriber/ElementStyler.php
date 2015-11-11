<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Subscriber;

use Netzmacht\Bootstrap\Core\Config;
use Netzmacht\Bootstrap\Core\Config\ContextualConfig;
use Netzmacht\Bootstrap\Core\Util\AssetsManager;
use Netzmacht\Bootstrap\Form\InputGroup;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Html\Element;

/**
 * The ElementStyler creates styled form element replacements.
 *
 * @package Netzmacht\Bootstrap\Form\Subscriber
 */
class ElementStyler extends AbstractSubscriber
{
    /**
     * Bootstrap-Select localization mapping.
     *
     * @var array
     */
    private static $selectLocalizations = array(
        'ar' => 'ar_AR',
        'bg' => 'bg_BG',
        'cs' => 'cs_CZ',
        'da' => 'da_DK',
        'de' => 'de_DE',
        'en' => 'en_US',
        'es' => 'es_CL',
        'eu' => 'eu',
        'fa' => 'fa_IR',
        'fr' => 'fr_FR',
        'it' => 'it_IT',
        'nl' => 'nl_NL',
        'pl' => 'pl_PL',
        'bt' => 'pt_BR',
        'ro' => 'ro_RO',
        'ru' => 'ru_RU',
        'sk' => 'sk_SK',
        'sl' => 'sl_SI',
        'sv' => 'sv_SE',
        'tr' => 'tr_TR',
        'ua' => 'ua_UA',
        'zh' => 'zh_CN',
        // Not supported zh_TW
    );

    /**
     * Register styled select assets.
     *
     * @param Config|ContextualConfig $config The bootstrap config.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function registerStyledSelectAssets($config)
    {
        $javascripts = (array) $config->get('form.styled-select.javascript');
        $stylesheets = $config->get('form.styled-select.stylesheet');
        $language    = substr($GLOBALS['TL_LANGUAGE'], 0, 2);

        if (isset(static::$selectLocalizations[$language])) {
            $javascripts[] = sprintf($config->get('form.styled-select.i18n'), static::$selectLocalizations[$language]);
        }

        AssetsManager::addJavascripts($javascripts, 'bootstrap-styled-select');
        AssetsManager::addStylesheets($stylesheets, 'bootstrap-styled-select');
    }

    /**
     * Check if the select has passed the options threshold.
     *
     * @param ContextualConfig|Config $config The config.
     * @param \Widget                 $widget The widget.
     *
     * @return bool
     */
    private function hasExceededOptionsThreshold($config, $widget)
    {
        if (!is_array($widget->options) || !$config->get('form.styled-select.search-threshold')) {
            return false;
        }

        return (count($widget->options) >= $config->get('form.styled-select.search-threshold'));
    }

    /**
     * Set bootstrap select element attributes..
     *
     * @param ContextualConfig|Config $config  The config.
     * @param Element                 $element The select element.
     * @param \Widget                 $widget  The widget.
     *
     * @return void
     */
    private function setStyledSelectAttributes($config, $element, $widget)
    {
        $element->addClass($config->get('form.styled-select.class'));
        $element->setAttribute('data-style', $config->get('form.styled-select.style'));

        $size = $config->get('form.styled-select.size');
        if ($size !== 'auto') {
            $element->setAttribute('data-size', $size);
        }

        if ($widget->bootstrap_select_search || $this->hasExceededOptionsThreshold($config, $widget)) {
            $element->setAttribute('data-live-search', 'true');
        }

        $format = $config->get('form.styled-select.selected-text-format');
        if ($widget->multiple && $format) {
            $element->setAttribute('data-selected-text-format', html_entity_decode($format));
        }

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

    /**
     * Generate the upload field.
     *
     * @param ContextualConfig|Config $config    The bootstrap config.
     * @param Container               $container Form element container.
     * @param \Widget                 $widget    Form widget.
     *
     * @return void
     */
    private function generateUpload($config, Container $container, $widget)
    {
        $config  = $config->get('form.styled-upload');
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
     * Handle the event to style the widgets.
     *
     * @param ViewEvent $event The subscribed events.
     *
     * @return void
     */
    public function handle(ViewEvent $event)
    {
        $container = $event->getContainer();
        $element   = $container->getElement();

        if (!$element instanceof Element) {
            return;
        }

        $config = static::getConfig($event->getFormModel());
        $widget = $event->getWidget();

        // Create styled select field.
        if ($config->get('form.styled-select.enabled')
            && static::getWidgetConfigValue($config, $widget->type, 'styled-select')) {

            $this->registerStyledSelectAssets($config);
            $this->setStyledSelectAttributes($config, $element, $widget);
        }

        // Create styled upload field.
        if ($event->getWidget()->type == 'upload' && $config->get('form.styled-upload.enabled')) {
            $this->generateUpload($config, $container, $widget);
        }
    }
}
