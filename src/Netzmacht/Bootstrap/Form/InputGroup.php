<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Form;

use Netzmacht\Contao\FormHelper\Component;
use Netzmacht\Contao\FormHelper\HasElement;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element;

/**
 * Class InputGroup provides a form wrapper with left right parts.
 * 
 * @package Netzmacht\Bootstrap\Form
 */
class InputGroup extends Component implements HasElement
{

    const ADDON = 'input-group-addon';

    const BUTTON = 'input-group-btn';

    /**
     * The left addon.
     * 
     * @var CastsToString|string
     */
    protected $left;

    /**
     * The right addon.
     * 
     * @var CastsToString|string
     */
    protected $right;

    /**
     * Current element being wrapped.
     * 
     * @var Element
     */
    protected $element;

    /**
     * Construct.
     * 
     * @param array $attributes Form attributes.
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->addClass('input-group');
    }

    /**
     * Set left addon.
     * 
     * @param mixed  $addon The extra.
     * @param string $type  Extra Type.
     *
     * @return $this
     */
    public function setLeft($addon, $type = self::ADDON)
    {
        $this->left = array(
            'addon' => $addon,
            'type'  => $type,
        );

        return $this;
    }

    /**
     * Get left addon.
     * 
     * @return CastsToString|null
     */
    public function getLeft()
    {
        if (is_array($this->left)) {
            return $this->left['addon'];
        }

        return null;
    }

    /**
     * Set right addon.
     *
     * @param mixed  $addon Right addon.
     * @param string $type  Type of addon.
     *
     * @return $this
     */
    public function setRight($addon, $type = self::ADDON)
    {
        $this->right = array(
            'addon' => $addon,
            'type'  => $type,
        );

        return $this;
    }

    /**
     * Get right addon.
     *
     * @return CastsToString|null
     */
    public function getRight()
    {
        if (is_array($this->right)) {
            return $this->right['addon'];
        }

        return null;
    }

    /**
     * Set widget element.
     *
     * @param mixed $element The widget element.
     *
     * @return $this
     */
    public function setElement($element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get widget element.
     *
     * @return Element|CastsToString|string
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Generate the input group.
     *
     * @return string
     */
    public function generate()
    {
        return sprintf(
            '<div %s>%s%s%s</div>',
            $this->generateAttributes(),
            $this->generateAddon($this->left),
            $this->element,
            $this->generateAddon($this->right)
        );
    }

    /**
     * Generate an addon.
     *
     * @param array|string $addon Addon data.
     *
     * @return string
     */
    protected function generateAddon($addon)
    {
        if (!is_array($addon)) {
            return '';
        }

        return Element::create('div')
            ->addClass($addon['type'])
            ->addChild($addon['addon'])
            ->generate();
    }

    /**
     * Casts to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->generate();
    }
}
