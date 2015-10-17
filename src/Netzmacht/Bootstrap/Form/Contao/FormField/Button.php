<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Contao\FormField;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Contao\FormHelper\GeneratesAnElement;
use Netzmacht\Html\Element;

/**
 * Class Button is a form element directly renders a form element.
 *
 * @package Netzmacht\Bootstrap\Form\Contao\FormField
 */
class Button extends \FormSubmit implements GeneratesAnElement
{
    /**
     * Generate the widget and return it as string.
     *
     * @return string
     */
    public function generate()
    {
        $buttonClass = $this->strClass ? $this->strClass : Bootstrap::getConfigVar('form.default-submit-btn');
        $button      = Element::create('button', $this->arrAttributes)
            ->setId('ctrl_' . $this->strId)
            ->addAttributes(
                array(
                    'type'  => 'submit',
                    'class' => array('submit', 'btn', $buttonClass),
                    'title' => specialchars($this->slabel),
                )
            );

        if ($this->imageSubmit) {
            $model = \FilesModel::findByPk($this->singleSRC);

            if ($model !== null && is_file(TL_ROOT . '/' . $model->path)) {
                $button->addChild(\Image::getHtml($model->path, $this->slabel));

                return $button;
            }
        }

        $label = specialchars($this->slabel);

        if ($this->bootstrap_addIcon) {
            $icon = Bootstrap::generateIcon($this->bootstrap_icon);

            if ($this->bootstrap_iconPosition == 'right') {
                $button
                    ->addChild($label)
                    ->addChild(' ' . $icon);
            } else {
                $button
                    ->addChild($icon . ' ')
                    ->addChild($label);
            }
        } else {
            $button->addChild($label);
        }

        return $button;
    }
}
