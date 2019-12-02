<?php

namespace App\Game;

use App\Game\Exception\LoadingException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Storage
{
    private const STORAGE_KEY = 'hangman';

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Resets the current game context.
     */
    public function reset(): void
    {
        $this->session->remove(self::STORAGE_KEY);
    }

    /**
     * Creates a new Game instance.
     */
    public function newGame($word): Game
    {
        return Game::createByWord($word);
    }

    /**
     * Checks whether a game has already been started.
     */
    public function hasGame(): bool
    {
        return $this->session->has(self::STORAGE_KEY);
    }

    /**
     * Loads an existing game.
     */
    public function loadGame(): Game
    {
        if (!$this->hasGame()) {
            throw new LoadingException('There is no game to load.');
        }

        return $this->session->get(self::STORAGE_KEY);
    }

    /**
     * Saves the provided game.
     */
    public function save(Game $game): void
    {
        $this->session->set(self::STORAGE_KEY, $game);
    }
}
