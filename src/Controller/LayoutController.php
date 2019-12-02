<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LayoutController extends AbstractController
{
    public function testimonials(): Response
    {
        return $this->render('layout/testimonials.html.twig', [
            'testimonials' => [
                'John Doe' => 'I love this game, so addictive!',
                'Martin Durand' => 'Best web application ever',
                'Paula Smith' => 'Awesomeness!',
            ],
        ]);
    }

    public function listPlayers(): Response
    {
    	return $this->render('layout/list_players.html.twig', [
    			'players' => [ ],
    	]);
    }
}
