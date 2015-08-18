<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Subscriber;

use Netzmacht\Bootstrap\Core\Event\GetMultipleConfigNamesEvent;

/**
 * Class ConfigNamesProvider provides config names options for the bootstrap backend config system.
 *
 * @package Netzmacht\Bootstrap\Form\Subscriber
 */
class ConfigNamesProvider extends AbstractSubscriber
{
    /**
     * Get all provided config names for the backend config.
     *
     * @param GetMultipleConfigNamesEvent $event Event being handled.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function handle(GetMultipleConfigNamesEvent $event)
    {
        $model = $event->getModel();

        if ($model->type != 'form_widget') {
            return;
        }

        if ($model->override) {
            $typeManager = static::getTypeManager();
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
}
