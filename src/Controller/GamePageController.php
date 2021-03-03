<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\AiStrategyCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamePageController extends AbstractController
{
    private AiStrategyCollection $strategyCollection;

    public function __construct(AiStrategyCollection $strategyCollection)
    {
        $this->strategyCollection = $strategyCollection;
    }

    /**
     * @Route("/", name="gamepage")
     */
    public function index(): Response
    {
        $strategies = $this->strategyCollection->getSupportedNames();

        return $this->render('game.html.twig', ['strategies' => $strategies]);
    }
}
