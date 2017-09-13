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

namespace ContaoBootstrap\Form\FormLayout;

use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Core\Util\ArrayUtil;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;

/**
 * Class BootstrapFormLayoutFactory.
 *
 * @package ContaoBootstrap\Form\FormLayout
 */
class BootstrapFormLayoutFactory implements FormLayoutFactory
{
    /**
     * Bootstrap environment.
     *
     * @var Environment
     */
    private $environment;

    /**
     * Widget config.
     *
     * @var array
     */
    private $widgetConfig;

    /**
     * Fallback config.
     *
     * @var array
     */
    private $fallbackConfig;

    /**
     * Sections of the form.
     *
     * @var array
     */
    private $sections = ['layout', 'label', 'control', 'error', 'help'];

    /**
     * AbstractFormLayout constructor.
     *
     * @param Environment $environment    Bootstrap environment.
     * @param array       $widgetConfig   Widget config map.
     * @param array       $fallbackConfig Control fallback config.
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
    public function create($type, array $config): FormLayout
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
     * @param string $type   Widget type.
     * @param array  $config Configuration.
     *
     * @return array
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

        foreach (deserialize($config['widgets'], true) as $widget) {
            if ($widget['widget'] === '') {
                continue;
            }

            foreach ($this->sections as $section) {
                if ($widget[$section]) {
                    $widgetConfig[$widget['widget']]['templates'][$section] = $widget[$section];
                }
            }
        }

        return $widgetConfig;
    }

    /**
     * Build the fallback config.
     *
     * @param string $type   Layout type.
     * @param array  $config Configuration.
     *
     * @return array
     */
    private function buildFallbackConfig(string $type, array $config): array
    {
        $type           = substr($type, 3);
        $fallbackConfig = $this->environment->getConfig()->get('form.layouts.' . $type, []);
        $fallbackConfig = ArrayUtil::merge($this->fallbackConfig, $fallbackConfig);

        foreach ($this->sections as $section) {
            $name = 'fallback' . ucfirst($section);

            if ($config[$name]) {
                $fallbackConfig['templates'][$section] = $config[$name];
            }
        }

        return $fallbackConfig;
    }

    /**
     * Build horizontal config.
     *
     * @param array $config Horizontal config.
     *
     * @return array
     */
    private function buildHorizontalConfig(array $config): array
    {
        $horizontalConfig = $this->environment->getConfig()->get('form.layouts.horizontal.classes', []);

        foreach (['label', 'control', 'offset'] as $key) {
            if (!empty($config['bs_' . $key])) {
                $horizontalConfig[$key] = $config['bs_' . $key];
            }
        }

        return $horizontalConfig;
    }
}
