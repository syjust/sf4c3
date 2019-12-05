<?php


namespace App\Game\Listener;

use App\Game\Event\AbstractGameEvent;
use App\Game\Event\GameEndEvent;
use App\Game\Event\GameStartEvent;
use Psr\Log\LoggerInterface;
use App\Game\EventDispatcher\EventSubscriberInterface;

/**
 * Class GameLogListener
 *
 * @package App\Game\Listener
 */
class GameLogListener implements EventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * GameLogListener constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
        return [
            GameEndEvent::class   => 'onGameEnd',
            GameStartEvent::class => 'onGameStart',
        ];
    }

    /**
     * @param AbstractGameEvent $event
     */
    public function onGameEnd(AbstractGameEvent $event)
    {
        $game = $event->getGame();
        $this->logger->info(
            sprintf(
                "Game end with status '%s'",
                $game->isWon() ? 'won' : 'hanged'
            )
        );
    }

    /**
     * @param AbstractGameEvent $event
     */
    public function onGameStart(AbstractGameEvent $event)
    {
        $game = $event->getGame();
        $this->logger->info(sprintf("Game start with word '%s'", $game->getWord()));
    }
}