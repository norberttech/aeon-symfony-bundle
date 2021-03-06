<?php

declare(strict_types=1);

namespace Aeon\Symfony\AeonBundle\DependencyInjection;

use Aeon\Calendar\Gregorian\TimeZone;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('aeon');
        /**
         * @psalm-suppress MixedAssignment
         * @phpstan-ignore-next-line
         */
        $rootNode = \method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('aeon');

        $rootNode
            ->children()
                ->scalarNode('timezone')->defaultValue(TimeZone::UTC)->end()
                ->scalarNode('datetime_format')->defaultValue('Y-m-d H:i:s')->end()
                ->scalarNode('date_format')->defaultValue('Y-m-d')->end()
                ->scalarNode('time_format')->defaultValue('H:i:s')->end()
            ->end();

        return $treeBuilder;
    }
}
