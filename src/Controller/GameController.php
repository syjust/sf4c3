<?php

namespace App\Controller;

use App\Game\Exception\LogicException;
use App\Game\Runner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/game")
 * @IsGranted("ROLE_PLAYER")
 * @IsGranted("HAS_ENOUGH_CREDITS")
 * IsGranted("HAS_LEGAL_AGE")
 */
class GameController extends AbstractController
{

    /** @var Runner */
    private $gameRunner;

    public function __construct(Runner $gameRunner, Security $security)
    {
        $this->gameRunner = $gameRunner;
        if (!$security->isGranted('HAS_LEGAL_AGE')) {
            throw $this->createAccessDeniedException('bad age !');
        }
        // only for a method because setContainer is not already set
        //$this->denyAccessUnlessGranted('HAS_LEGAL_AGE');
    }

    /**
     * @Route("/", name="game_home", methods="GET")
     */
    public function home(): Response
    {

        return $this->render('game/home.html.twig', [
            'game' => $this->gameRunner->loadGame()
        ]);
    }

    /**
     * @Route("/won", name="game_won", methods="GET")
     */
    public function won(): Response
    {
        $game       = $this->gameRunner->loadGame();

        try {
            $this->gameRunner->resetGameOnSuccess();
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
        $game       = $this->gameRunner->loadGame();

        try {
            $this->gameRunner->resetGameOnFailure();
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
        $this->gameRunner->resetGame();

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
        $game       = $this->gameRunner->playLetter($letter);

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
        $game       = $this->gameRunner->playWord($request->request->get('word'));

        return $this->redirectToRoute($game->isWon() ? 'game_won' : 'game_failed');
    }
}
