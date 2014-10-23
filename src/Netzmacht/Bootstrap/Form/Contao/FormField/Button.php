<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   netzmacht-bootstrap
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form\Contao\FormField;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Contao\FormHelper\GeneratesAnElement;
use Netzmacht\Html\Element;

class Button extends \FormSubmit implements GeneratesAnElement
{
    /**
     * Generate the widget and return it as string
     * @return string
     */
    public function generate()
    {
        $buttonClass = (($this->strClass != '') ? ' ' . $this->strClass : 'btn-default');
        $button      = Element::create('button', $this->arrAttributes)
            ->setId('ctrl_' . $this->strId)
            ->addAttributes(array(
                'type'  => 'submit',
                'class' => array('submit', 'btn', $buttonClass),
                'title' => specialchars($this->slabel),
                'alt'   => specialchars($this->slabel),
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
        }

        return $button;
    }

}
