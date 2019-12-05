<?php

namespace App;

use App\Game\WordList;
use App\Security\Voter\LegalAgeVoter;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel implements CompilerPassInterface, ExtensionInterface, ConfigurationInterface
{
    use MicroKernelTrait;

    const HANGMAN_LOADER_TAG = 'hangman.loader';
    const CONFIG_EXTS        = '.{php,xml,yaml,yml}';

    public function getCacheDir()
    {
        return $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->getProjectDir().'/var/log';
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function addGameEventSubscribers(ContainerBuilder $container)
    {
        //dump((new Exception())->getTrace());
        if (!$container->has('hangman.game.dispatcher')) {

            return;
        }

        $dispatcher = $container->getDefinition('hangman.game.dispatcher');
        $ids      = $container->findTaggedServiceIds('game.event_subscriber');
        foreach ($ids as $id => $attribs) {
            $ref = new Reference($id);
            $dispatcher->addMethodCall('addSubscriber', [$ref]);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function addWordListLoaders(ContainerBuilder $container): void
    {
        if (!$container->has(WordList::class)) {

            return;
        }

        $wordList = $container->getDefinition(WordList::class);
        $ids      = $container->findTaggedServiceIds(self::HANGMAN_LOADER_TAG);
        /*
         * App\Game\WordList:
         *     calls:
         *         - [addLoader, ['@App\Game\Loader\TextFileLoader']]
         *         - [addLoader, ['@App\Game\Loader\XmlFileLoader']]
         */
        foreach ($ids as $id => $attribs) {
            $ref = new Reference($id);
            $wordList->addMethodCall('addLoader', [$ref]);
        }

        # App\Security\Voter\LegalAgeVoter:
        #     arguments:
        #         $legalAge: '%hangman.game.required_age%'
        $voter = $container->getDefinition(LegalAgeVoter::class);
        $voter->setArgument(0, $container->getParameter('hangman.game.required_age'));
    }

    public function registerBundles()
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config';
        $loader->load($confDir.'/packages/*'.self::CONFIG_EXTS, 'glob');
        if (is_dir($confDir.'/packages/'.$this->environment)) {
            $loader->load($confDir.'/packages/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        }
        $loader->load($confDir.'/hangman'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/services'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/services_'.$this->environment.self::CONFIG_EXTS, 'glob');
        if (is_dir($confDir.'/custom/')) {
            $loader->load($confDir.'/custom/**/*'.self::CONFIG_EXTS, 'glob');
        }
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/config';
        if (is_dir($confDir.'/routes/')) {
            $routes->import($confDir.'/routes/*'.self::CONFIG_EXTS, '/', 'glob');
        }
        if (is_dir($confDir.'/routes/'.$this->environment)) {
            $routes->import($confDir.'/routes/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        }
        $routes->import($confDir.'/routes'.self::CONFIG_EXTS, '/', 'glob');
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->addWordListLoaders($container);
        $this->addGameEventSubscribers($container);
    }

    protected function build(ContainerBuilder $container)
    {
        parent::build($container);

        # _instanceof:
        #     App\Game\Loader\LoaderInterface:
        #         tags:
        #             name : hangman.loader
        #             foo  : bar
        $container
            ->registerForAutoconfiguration(Game\Loader\LoaderInterface::class)
            ->addTag(self::HANGMAN_LOADER_TAG, ['foo' => 'bar']);
        /*
         * auto register as extension
         */
        $container->registerExtension($this);
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
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
                        ->ifTrue(function ($value) { return !\is_readable($value); })
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
