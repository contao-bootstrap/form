<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\FormLayout;

use Contao\StringUtil;
use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Core\Util\ArrayUtil;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;

use function array_merge;
use function substr;
use function ucfirst;

class BootstrapFormLayoutFactory implements FormLayoutFactory
{
    /**
     * Bootstrap environment.
     */
    private Environment $environment;

    /**
     * Widget config.
     *
     * @var array<string,array<string,mixed>>
     */
    private array $widgetConfig;

    /**
     * Fallback config.
     *
     * @var array<string,mixed>
     */
    private array $fallbackConfig;

    /**
     * Sections of the form.
     *
     * @var list<string>
     */
    private array $sections = ['layout', 'label', 'control', 'error', 'help'];

    /**
     * @param array<string,array<string,mixed>> $widgetConfig
     * @param array<string,mixed>               $fallbackConfig
     */
    public function __construct(Environment $environment, array $widgetConfig, array $fallbackConfig)
    {
        $this->environment    = $environment;
        $this->widgetConfig   = $widgetConfig;
        $this->fallbackConfig = $fallbackConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function supportedTypes(): array
    {
        return ['bs_default', 'bs_horizontal'];
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $type, array $config): FormLayout
    {
        $config         = array_merge(['widgets' => []], $config);
        $widgetConfig   = $this->buildWidgetConfig($type, $config);
        $fallbackConfig = $this->buildFallbackConfig($type, $config);

        switch ($type) {
            case 'bs_horizontal':
                return new HorizontalFormLayout(
                    $widgetConfig,
                    $fallbackConfig,
                    $this->buildHorizontalConfig($config)
                );

            default:
                return new DefaultFormLayout($widgetConfig, $fallbackConfig);
        }
    }

    /**
     * Build the widget config.
     *
     * @param string              $type   Widget type.
     * @param array<string,mixed> $config Configuration.
     *
     * @return array<string,array<string,mixed>>
     */
    private function buildWidgetConfig(string $type, array $config): array
    {
        $type            = substr($type, 3);
        $configKey       = 'form.layouts.' . $type . '.widgets';
        $bootstrapConfig = $this->environment->getConfig();
        $widgetConfig    = ArrayUtil::merge($this->widgetConfig, $bootstrapConfig->get('form.widgets'));

        if ($bootstrapConfig->has($configKey)) {
            $widgetConfig = ArrayUtil::merge($widgetConfig, $bootstrapConfig->get($configKey));
        }

        foreach (StringUtil::deserialize($config['widgets'], true) as $widget) {
            if ($widget['widget'] === '') {
                continue;
            }

            foreach ($this->sections as $section) {
                if (! $widget[$section]) {
                    continue;
                }

                $widgetConfig[$widget['widget']]['templates'][$section] = $widget[$section];
            }
        }

        return $widgetConfig;
    }

    /**
     * Build the fallback config.
     *
     * @param string              $type   Widget type.
     * @param array<string,mixed> $config Configuration.
     *
     * @return array<string,mixed>
     */
    private function buildFallbackConfig(string $type, array $config): array
    {
        $type           = substr($type, 3);
        $fallbackConfig = $this->environment->getConfig()->get('form.layouts.' . $type, []);
        $fallbackConfig = ArrayUtil::merge($this->fallbackConfig, $fallbackConfig);

        foreach ($this->sections as $section) {
            $name = 'fallback' . ucfirst($section);

            if (empty($config[$name])) {
                continue;
            }

            $fallbackConfig['templates'][$section] = $config[$name];
        }

        return $fallbackConfig;
    }

    /**
     * Build horizontal config.
     *
     * @param array<string,mixed> $config Horizontal config.
     *
     * @return array<string,mixed>
     */
    private function buildHorizontalConfig(array $config): array
    {
        $horizontalConfig = $this->environment->getConfig()->get('form.layouts.horizontal.classes', []);

        foreach (['row', 'label', 'control', 'offset'] as $key) {
            if (empty($config['bs_' . $key])) {
                continue;
            }

            $horizontalConfig[$key] = $config['bs_' . $key];
        }

        return $horizontalConfig;
    }
}
