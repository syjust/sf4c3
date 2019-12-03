<?php

namespace App\Game;

use App\Game\Event\GameEndEvent;
use App\Game\Event\GameStartEvent;
use App\Game\Exception\LogicException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Runner
{
    private $storage;
    private $wordList;
    private $dispatcher;

    public function __construct(Storage $storage, WordList $wordList, EventDispatcherInterface $dispatcher)
    {
        $this->storage    = $storage;
        $this->wordList   = $wordList;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Loads the current game or creates a new one.
     */
    public function loadGame(): Game
    {
        if ($this->storage->hasGame()) {
            return $this->storage->loadGame();
        }

        return $this->createGame();
    }

    /**
     * Tests the given letter against the current game.
     */
    public function playLetter(string $letter): Game
    {
        $game = $this->storage->loadGame();

        $game->tryLetter($letter);
        $this->storage->save($game);

        return $game;
    }

    /**
     * Tests the given word against the current game.
     */
    public function playWord(string $word): Game
    {
        $game = $this->storage->loadGame();

        $game->tryWord($word);
        $this->storage->save($game);

        return $game;
    }

    public function resetGame(): void
    {
        $game = $this->storage->loadGame();
        $this->storage->reset();
    }

    /**
     * @throws LogicException
     */
    public function resetGameOnSuccess(): void
    {
        $game = $this->storage->loadGame();
        $this->dispatcher->dispatch(new GameEndEvent($game));

        if (!$game->isOver()) {
            throw new LogicException('Current game is not yet over.');
        }

        if (!$game->isWon()) {
            throw new LogicException('Current game must be won.');
        }

        $this->resetGame();
    }

    /**
     * @throws LogicException
     */
    public function resetGameOnFailure(): void
    {
        $game = $this->storage->loadGame();
        $this->dispatcher->dispatch(new GameEndEvent($game));

        if (!$game->isOver()) {
            throw new LogicException('Current game is not yet over.');
        }

        if (!$game->isHanged()) {
            throw new LogicException('Current game must be lost.');
        }

        $this->resetGame();
    }

    private function createGame(): Game
    {
        $word = $this->wordList->getRandomWord();
        $game = $this->storage->newGame($word);
        $this->storage->save($game);
        $this->dispatcher->dispatch(new GameStartEvent($game));

        return $game;
    }
}
