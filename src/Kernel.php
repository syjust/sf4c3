<?php

namespace App;

use App\Extension\HangmanExtensionConfiguration;
use App\Game\WordList;
use App\Security\Voter\LegalAgeVoter;
use Exception;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel implements CompilerPassInterface
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

    /**
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     *
     * @throws Exception
     */
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

    /**
     * @param RouteCollectionBuilder $routes
     *
     * @throws LoaderLoadException
     */
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
         * register extension for loading hangman: config tree
         * DO NOT AUTO REGISTER BECAUSE self::process() is launched twice ???
         */
        $container->registerExtension(new HangmanExtensionConfiguration());
    }
}
