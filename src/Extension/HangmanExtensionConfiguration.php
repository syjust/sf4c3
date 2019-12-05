<?php


namespace App\Extension;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class HangmanExtension
 *
 * @package App\Extension
 */
class HangmanExtensionConfiguration implements ExtensionInterface, ConfigurationInterface
{

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        // check config validity & merge multiple configs (@see Kernel::configureContainer for overriding rules)
        $config  = $processor->processConfiguration($this, $configs);

        $container->setParameter('hangman.game.dictionaries', $config['game']['dictionaries']);
        $container->setParameter('hangman.game.default_credits', $config['game']['default_credits']);
        $container->setParameter('hangman.game.required_age', $config['game']['required_age']);
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return '';
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string|false
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'hangman';
    }

    /**
     * Generates the configuration tree builder.
     * - validate
     * - parse
     * - merge
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder($this->getAlias());
        $game = $tree->getRootNode()->children()->arrayNode('game');
        $game->children()
            ->arrayNode('dictionaries')
                ->isRequired()
                ->prototype('scalar')
                    ->isRequired()
                    ->validate()
                        ->ifTrue(function ($value) { return !is_readable($value); })
                        ->thenInvalid('file must exist')
                    ->end() // end validate
                ->end() // end prototype
            ->end() // arrayNode dictionaries
            ->integerNode('default_credits')
                ->defaultValue(10)
                ->min(5)
                ->max(15)
            ->end() // integerNode
                ->integerNode('required_age')
                ->defaultValue(10)
                ->min(16)
                ->max(23)
            ->end() // integerNode
        ->end() // end game
        ;

        return $tree;
    }
}