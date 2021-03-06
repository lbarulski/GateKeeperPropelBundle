<?php

namespace GateKeeperPropelBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GateKeeperPropelExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

	/**
	 * Allow an extension to prepend the extension configurations.
	 *
	 * @param ContainerBuilder $container
	 */
	public function prepend(ContainerBuilder $container)
	{
		$container->getExtension('gate_keeper');

		$config = $container->getExtensionConfig('gate_keeper');
		$config = $config[0];

		$configIfNotSet = [
			'repository_service' => 'gate_keeper_panel.repository',
		];

		$container->prependExtensionConfig('gate_keeper', array_merge($configIfNotSet, $config));
	}
}
