<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form;

use ContaoBootstrap\Core\ContaoBootstrapComponent;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class ContaoBootstrapFormComponent implements ContaoBootstrapComponent
{
    public function addBootstrapConfiguration(ArrayNodeDefinition $builder): void
    {
        $form    = $builder->children()->arrayNode('form');
        $widgets = $form->children()->arrayNode('widgets');
        $layouts = $form->children()->arrayNode('layouts');
        $buttons = $form->children()->arrayNode('buttons');

        $form->children()
            ->scalarNode('margin')
                ->info('Margin class between form widgets')
            ->end();

        $this->describeWidgetConfiguration($widgets);
        $this->describeDefaultLayout($layouts);
        $this->describeHorizontalLayout($layouts);
        $this->describeFloatingLayout($layouts);
        $this->describeButtons($buttons);
    }

    public function describeWidgetConfiguration(ArrayNodeDefinition $builder): void
    {
        $builder
            ->arrayPrototype()
                ->children()
                    ->arrayNode('templates')
                        ->scalarPrototype()->end()
                    ->end()
                    ->booleanNode('input_group')
                        ->info('Set to true if widget supports input groups')
                    ->end()
                    ->booleanNode('floating')
                        ->info('Set to true if widget supports floating labels')
                    ->end()
                    ->arrayNode('palettes')
                        ->info('Palettes also containing to the widget')
                        ->scalarPrototype()->end()
                    ->end()
                    ->booleanNode('form_control')
                        ->info('Widget has the form-control class')
                    ->end()
                        ->scalarNode('control_class')
                        ->info('Customize the control class')
                    ->end()
                ->end()
            ->end();
    }

    public function describeDefaultLayout(ArrayNodeDefinition $layouts): void
    {
        $layout  = $layouts->children()->arrayNode('default');
        $widgets = $layout->children()->arrayNode('widgets');

        $this->describeLayoutTemplatesSection($layout);
        $this->describeWidgetConfiguration($widgets);
    }

    public function describeHorizontalLayout(ArrayNodeDefinition $layouts): void
    {
        $layout  = $layouts->children()->arrayNode('horizontal');
        $widgets = $layout->children()->arrayNode('widgets');

        $layout
            ->children()
                ->arrayNode('classes')
                    ->children()
                        ->scalarNode('row')
                        ->end()
                        ->scalarNode('label')
                        ->end()
                        ->scalarNode('control')
                        ->end()
                        ->scalarNode('offset')
                        ->end()
                    ->end()
                ->end()
            ->end();

        $this->describeLayoutTemplatesSection($layout);
        $this->describeWidgetConfiguration($widgets);
    }

    public function describeFloatingLayout(ArrayNodeDefinition $layouts): void
    {
        $layout  = $layouts->children()->arrayNode('floating');
        $widgets = $layout->children()->arrayNode('widgets');

        $this->describeLayoutTemplatesSection($layout);
        $this->describeWidgetConfiguration($widgets);
    }

    public function describeLayoutTemplatesSection(ArrayNodeDefinition $layout): void
    {
        $layout
            ->children()
                ->arrayNode('templates')
                    ->children()
                        ->scalarNode('layout')
                        ->end()
                        ->scalarNode('help')
                        ->end()
                        ->scalarNode('error')
                        ->end()
                    ->end()
                 ->end()
            ->end();
    }

    private function describeButtons(ArrayNodeDefinition $buttons): void
    {
        $buttons
            ->children()
                ->scalarNode('submit')
                ->end()
            ->end();
    }
}
