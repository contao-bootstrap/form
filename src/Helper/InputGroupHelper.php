<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Helper;

use Contao\StringUtil;
use Contao\Widget;

use function strlen;

final class InputGroupHelper
{
    /**
     * After entries.
     *
     * @var list<array<string,string|bool>>
     */
    private array $after = [];

    /**
     * Before entries.
     *
     * @var list<array<string,string|bool>>
     */
    private array $before = [];

    /**
     * Create input group helper for a widget.
     *
     * @param Widget $widget Form widget.
     */
    public static function forWidget(Widget $widget): self
    {
        $values = StringUtil::deserialize($widget->bs_inputGroup, true);
        $helper = new self();

        foreach ($values as $entry) {
            if (! strlen($entry['addon'])) {
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
     * @param bool   $text    If true, no input-group-text wrapper is added.
     *
     * @return $this
     */
    public function addAfter(string $content, bool $text = true): self
    {
        $this->after[] = [
            'content' => $content,
            'text'    => $text,
        ];

        return $this;
    }

    /**
     * Add before entry.
     *
     * @param string $content Content of the addon.
     * @param bool   $text    If true, no input-group-text wrapper is added.
     *
     * @return $this
     */
    public function addBefore(string $content, bool $text = true): self
    {
        $this->before[] = [
            'content' => $content,
            'text'    => $text,
        ];

        return $this;
    }

    /**
     * Get before entries.
     *
     * @return list<array<string,string|bool>>
     */
    public function before(): array
    {
        return $this->before;
    }

    /**
     * Get after entries.
     *
     * @return list<array<string,string|bool>>
     */
    public function after(): array
    {
        return $this->after;
    }
}
