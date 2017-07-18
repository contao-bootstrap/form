<?php

/**
 * @package    contao-bootstrap.
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

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
    /**
     * After entries.
     *
     * @var array
     */
    private $after;

    /**
     * Before entries.
     *
     * @var array
     */
    private $before;

    /**
     * InputGroupHelper constructor.
     *
     * @param array $before Before entries.
     * @param array $after  After entries.
     */
    public function __construct(array $before, array $after)
    {
        $this->after  = $after;
        $this->before = $before;
    }

    /**
     * Create input group helper for a widget.
     *
     * @param Widget $widget Form widget.
     *
     * @return static
     */
    public static function forWidget($widget)
    {
        $values = StringUtil::deserialize($widget->bs_inputGroup, true);
        $before = [];
        $after  = [];

        foreach ($values as $entry) {
            if (!strlen($entry['addon'])) {
                continue;
            }

            if ($entry['position'] === 'after') {
                $after[] = $entry['addon'];
            } else {
                $before[] = $entry['addon'];
            }
        }

        return new static($before, $after);
    }

    /**
     * Get before entries.
     *
     * @return array
     */
    public function before()
    {
        return $this->before;
    }

    /**
     * Get after entries.
     *
     * @return array
     */
    public function after()
    {
        return $this->after;
    }
}
