<?php

namespace App\Controller;

use App\Game\Exception\LogicException;
use App\Game\Runner;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Game\WordList;
use App\Game\Loader\TextFileLoader;
use App\Game\Loader\XmlFileLoader;
use App\Game\Storage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/", name="game_home", methods="GET")
     */
    public function home(): Response
    {
    	$gameRunner = $this->createGameRunner();

        return $this->render('game/home.html.twig', [
            'game' => $gameRunner->loadGame()
        ]);
    }

    /**
     * @Route("/won", name="game_won", methods="GET")
     */
    public function won(): Response
    {
    	$gameRunner = $this->createGameRunner();
        $game       = $gameRunner->loadGame();

        try {
            $gameRunner->resetGameOnSuccess();
        } catch (LogicException $e) {
            throw $this->createAccessDeniedException($e->getMessage(), $e);
        }

        return $this->render('game/won.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/failed", name="game_failed", methods="GET")
     */
    public function failed(): Response
    {
    	$gameRunner = $this->createGameRunner();
        $game       = $gameRunner->loadGame();

        try {
            $gameRunner->resetGameOnFailure();
        } catch (LogicException $e) {
            throw $this->createAccessDeniedException($e->getMessage(), $e);
        }

        return $this->render('game/failed.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/reset", name="game_reset", methods={"GET", "POST"})
     */
    public function reset(): RedirectResponse
    {
    	$gameRunner = $this->createGameRunner();
        $gameRunner->resetGame();

        return $this->redirectToRoute('game_home');
    }

    /**
     * This action plays a letter.
     *
     * @Route("/play/{letter}", name="game_play_letter", methods={"GET"}, requirements={
     *   "letter"="[A-Z]"
     * })
     */
    public function playLetter(string $letter): RedirectResponse
    {
    	$gameRunner = $this->createGameRunner();
        $game       = $gameRunner->playLetter($letter);

        if ($game->isOver()) {
            return $this->redirectToRoute($game->isWon() ? 'game_won' : 'game_failed');
        }

        return $this->redirectToRoute('game_home');
    }

    /**
     * This action plays a word.
     *
     * @Route("/play", name="game_play_word", condition="request.request.has('word')", methods={"POST"})
     */
    public function playWord(Request $request): RedirectResponse
    {
    	$gameRunner = $this->createGameRunner();
        $game       = $gameRunner->playWord($request->request->get('word'));

        return $this->redirectToRoute($game->isWon() ? 'game_won' : 'game_failed');
    }

    private function createGameRunner()
    {
    	$wordList = new WordList($this->getParameter('app.dictionaries'));
    	$wordList->addLoader(new TextFileLoader());
    	$wordList->addLoader(new XmlFileLoader());
    	$wordList->addWord('customer');
    	$wordList->addWord('lemonade');
    	$wordList->addWord('employee');

    	return new Runner(new Storage($this->get('session')), $wordList);
    }
}
