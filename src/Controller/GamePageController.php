<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamePageController extends AbstractController
{
    /**
     * @Route("/", name="gamepage")
     */
    public function index(): Response
    {
        $strategies = ['random' => 'Random'];

        return $this->render('game.html.twig', ['strategies' => $strategies]);
    }
}
