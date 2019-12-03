<?php


namespace App\Game\Event;

use App\Game\Game;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AbstractGameEvent
 *
 * @package App\Game\Event
 */
abstract class AbstractGameEvent extends Event
{
    private $game;

    /**
     * AbstractGameEvent constructor.
     *
     * @param $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

}