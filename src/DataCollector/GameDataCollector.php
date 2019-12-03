<?php


namespace App\DataCollector;

use App\Entity\Player;
use App\Game\Storage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Throwable;

/**
 * Class GameDataCollector
 * GameDataCollector Given to Twig Template
 *
 * @package App\DataCollector
 */
class GameDataCollector extends DataCollector implements EventSubscriberInterface
{
    /**
     *
     */
    const HANGMAN_RESPONSE_HEADER = 'X-Hangman-Word';

    /** @var Storage */
    private $gameStorage;
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * GameDataCollector constructor.
     *
     * @param Storage               $gameStorage
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(Storage $gameStorage, TokenStorageInterface $tokenStorage)
    {
        $this->gameStorage  = $gameStorage;
        $this->tokenStorage = $tokenStorage;
        $this->reset();
    }

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request        $request
     * @param Response       $response
     * @param Throwable|null $throwable
     */
    public function collect(Request $request, Response $response, Throwable $throwable = null)
    {
        if ($this->gameStorage->hasGame()) {
            $this->data['game'] = $this->gameStorage->loadGame();
        }
        $token = $this->tokenStorage->getToken();
        if ($token) {
            $user = $token->getUser();
            if ($user instanceof Player) {
                $this->data['player'] = $user;
            }
        }
    }

    /**
     * @return null|array
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName()
    {
        return 'hangman';
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::RESPONSE => 'onKernelResponse'];
    }

    /**
     * @param ResponseEvent $event
     */
    public function onKernelResponse(ResponseEvent $event)
    {
        if ($this->gameStorage->hasGame()) {
            $event->getResponse()->headers->set(
                self::HANGMAN_RESPONSE_HEADER,
                $this->gameStorage->loadGame()->getWord()
            );
        }
    }

    /**
     * reset data collected
     */
    public function reset()
    {
        $this->data['game']   = null;
        $this->data['player'] = null;
    }
}