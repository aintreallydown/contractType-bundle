<?php

namespace aintreallydown\ContractTypeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContractTypeExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('framework', [
            'translator' => [
                'paths' => [
                    __DIR__ . '/../../translations',
                ],
            ],
        ]);
        $container->prependExtensionConfig('doctrine', [
            'orm' => [
                'mappings' => [
                    'ContractTypeBundle' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => __DIR__ . '/../Entity',
                        'prefix' => 'aintreallydown\\ContractTypeBundle\\Entity',
                        'alias' => 'ContractTypeBundle',
                    ],
                ],
            ],
        ]);
        $container->prependExtensionConfig('twig', [
            'paths' => [
                __DIR__ . '/../../templates' => 'ContractTypeBundle',
            ],
        ]);
    }
}
