<?php

/**
 * Contao Bootstrap form.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Form\Helper;

use Contao\StringUtil;
use Contao\Widget;

/**
 * Class InputGroupHelper.
 *
 * @package ContaoBootstrap\Form\Helper
 */
class InputGroupHelper
{
    const TYPE_BUTTON = 'btn';
    const TYPE_ADDON  = 'addon';

    /**
     * After entries.
     *
     * @var array
     */
    private $after = [];

    /**
     * Before entries.
     *
     * @var array
     */
    private $before = [];

    /**
     * Create input group helper for a widget.
     *
     * @param Widget $widget Form widget.
     *
     * @return static
     */
    public static function forWidget(Widget $widget): self
    {
        $values = StringUtil::deserialize($widget->bs_inputGroup, true);
        $helper = new static();

        foreach ($values as $entry) {
            if (!strlen($entry['addon'])) {
                continue;
            }

            if ($entry['position'] === 'after') {
                $helper->addAfter($entry['addon']);
            } else {
                $helper->addBefore($entry['addon']);
            }
        }

        return $helper;
    }

    /**
     * Add after entry.
     *
     * @param string $content Content of the addon.
     * @param string $type    Input group addon type: addon or btn.
     *
     * @return $this
     */
    public function addAfter(string $content, string $type = self::TYPE_ADDON): self
    {
        $this->after[] = [
            'type'    => $type,
            'content' => $content,
        ];

        return $this;
    }

    /**
     * Add before entry.
     *
     * @param string $content Content of the addon.
     * @param string $type    Input group addon type: addon or btn.
     *
     * @return $this
     */
    public function addBefore(string $content, string $type = self::TYPE_ADDON): self
    {
        $this->before[] = [
            'type'    => $type,
            'content' => $content,
        ];

        return $this;
    }

    /**
     * Get before entries.
     *
     * @return array
     */
    public function before(): array
    {
        return $this->before;
    }

    /**
     * Get after entries.
     *
     * @return array
     */
    public function after(): array
    {
        return $this->after;
    }
}