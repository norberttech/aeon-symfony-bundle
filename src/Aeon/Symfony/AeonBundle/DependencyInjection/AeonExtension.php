<?php

declare(strict_types=1);

namespace Aeon\Symfony\AeonBundle\DependencyInjection;

use Aeon\Calendar\Gregorian\GregorianCalendarStub;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class AeonExtension extends Extension
{
    /** @phpstan-ignore-next-line  */
    public function load(array $configs, ContainerBuilder $container) : void
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         * @phpstan-ignore-next-line
         */
        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('aeon_calendar.php');
        $loader->load('aeon_calendar_twig.php');

        $container->setParameter('aeon.timezone', $config['timezone']);
        $container->setParameter('aeon.datetime_format', $config['datetime_format']);
        $container->setParameter('aeon.date_format', $config['date_format']);
        $container->setParameter('aeon.time_format', $config['time_format']);

        if ($container->hasParameter('kernel.environment')) {
            if ($container->getParameter('kernel.environment') === 'test') {
                $container->getDefinition('calendar')
                    ->setClass(GregorianCalendarStub::class);

                $container->setAlias(GregorianCalendarStub::class, 'calendar')
                    ->setPublic(true);
            }
        }
    }
}
