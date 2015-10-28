<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Form\Subscriber;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Bootstrap\Core\Config;
use Netzmacht\Bootstrap\Core\Config\ContextualConfig;
use Netzmacht\Bootstrap\Core\Config\TypeManager;
use Netzmacht\Bootstrap\Core\Contao\Model\BootstrapConfigModel;

/**
 * Class AbstractSubscriber provides base methods for form rendering subscribers.
 *
 * @package Netzmacht\Bootstrap\Form\Subscriber
 */
abstract class AbstractSubscriber
{
    /**
     * Config cache.
     *
     * @var ContextualConfig[]
     */
    protected static $configs = array();

    /**
     * Get the bootstrap config for the form context.
     *
     * @param \FormModel|null $formModel The form model to which the widget belongs.
     *
     * @return ContextualConfig
     */
    protected static function getConfig($formModel = null)
    {
        if (!$formModel) {
            return Bootstrap::getConfig();
        }

        if (!isset(static::$configs[$formModel->id])) {
            $collection = BootstrapConfigModel::findMultipleByIds(deserialize($formModel->bootstrap_configs, true));
            $config     = static::getTypeManager()->buildContextualConfig($collection);

            static::$configs[$formModel->id] = $config;
        }

        return static::$configs[$formModel->id];
    }

    /**
     * Get form type manager.
     *
     * @return TypeManager
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getTypeManager()
    {
        return $GLOBALS['container']['bootstrap.config-type-manager'];
    }

    /**
     * Get a config value for a given form widget type.
     *
     * @param ContextualConfig|Config $config  The used config.
     * @param string                  $type    The widget type.
     * @param string                  $name    The configuration name.
     * @param mixed                   $default The default value.
     *
     * @return mixed
     */
    protected static function getWidgetConfigValue($config, $type, $name, $default = false)
    {
        return $config->get('form.widgets.' . $type . '.' . $name, $default);
    }
}
