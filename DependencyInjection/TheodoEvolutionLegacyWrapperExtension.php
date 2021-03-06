<?php

namespace Theodo\Evolution\Bundle\LegacyWrapperBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TheodoEvolutionLegacyWrapperExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setDefinition('composer.loader', new Definition())->setSynthetic(true);

        $container->setParameter('theodo_evolution_legacy_wrapper.root_dir', $config['root_dir']);
        $container->setParameter('theodo_evolution_legacy_wrapper.assets', $config['assets']);
        $container->setParameter('theodo_evolution_legacy_wrapper.legacy_kernel.id', $config['kernel']['id']);
        $container->setParameter('theodo_evolution_legacy_wrapper.legacy_kernel.options', isset($config['kernel']['options']) ? $config['kernel']['options'] : array());

        if (isset($config['class_loader_id'])) {
            $container->setAlias('theodo_evolution_legacy_wrapper.autoload.class_loader', $config['class_loader_id']);
        }
    }
}
