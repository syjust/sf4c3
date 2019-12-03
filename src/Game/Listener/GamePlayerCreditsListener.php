<?php


namespace App\Game\Listener;

use App\Entity\Player;
use App\Game\Event\AbstractGameEvent;
use App\Game\Event\GameEndEvent;
use App\Game\Event\GameStartEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class GamePlayerCreditsListener
 *
 * @package App\Game\Listener
 */
class GamePlayerCreditsListener implements EventSubscriberInterface
{

    /** @var EntityManagerInterface */
    private $em;
    /** @var TokenStorageInterface */
    private $storage;
    /** @var AuthorizationCheckerInterface */
    private $checker;
    private $defaultCredits;

    /**
     * GamePlayerCreditsListener constructor.
     *
     * @param TokenStorageInterface         $storage
     * @param EntityManagerInterface        $em
     * @param AuthorizationCheckerInterface $checker
     * @param int                           $defaultCredits
     */
    public function __construct(
        TokenStorageInterface $storage,
        EntityManagerInterface $em,
        AuthorizationCheckerInterface $checker,
        int $defaultCredits
    ) {
        $this->storage        = $storage;
        $this->em             = $em;
        $this->checker        = $checker;
        $this->defaultCredits = $defaultCredits;
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
            GameStartEvent::class => 'onGameStart',
            GameEndEvent::class   => 'onGameEnd',
        ];
    }

    /**
     * @param AbstractGameEvent $event
     */
    public function onGameEnd(AbstractGameEvent $event)
    {
        $user = $this->storage->getToken()->getUser();
        if ($user instanceof Player) {
            if ($user->getCredits() <= 0 && $this->checker->isGranted('ROLE_ADMIN')) {
                $user->setCredits($this->defaultCredits);
                $this->em->flush();
            }
        }
    }

    /**
     * @param AbstractGameEvent $event
     */
    public function onGameStart(AbstractGameEvent $event)
    {
        $user = $this->storage->getToken()->getUser();
        if ($user instanceof Player) {
            $user->consumeOneCredit();
            $this->em->flush();
        }
    }
}