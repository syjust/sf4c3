<?php


namespace App\DataCollector;

use App\Game\Game;
use App\Game\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Throwable;

/**
 * Class GameDataCollector
 * GameDataCollector Given to Twig Template
 *
 * @package App\DataCollector
 */
class GameDataCollector extends DataCollector
{

    /** @var Storage */
    private $gameStorage;

    /**
     * GameDataCollector constructor.
     *
     * @param $gameStorage
     */
    public function __construct(Storage $gameStorage)
    {
        $this->gameStorage = $gameStorage;
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
        if (!$this->gameStorage->hasGame()) {
            $this->data['hangman'] = null;
            return;
        }
        $this->data['hangman'] = $this->gameStorage->loadGame();
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
     * reset data collected
     */
    public function reset()
    {
        $this->data['hangman'] = null;
    }

    /**
     * @return null|Game
     */
    public function getData() : ?Game
    {
        return $this->data['hangman'];
    }
}