<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\AiStrategyCollection;
use App\Service\StatisticsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamePageController extends AbstractController
{
    private AiStrategyCollection $strategyCollection;
    private StatisticsProvider $statisticsProvider;

    public function __construct(AiStrategyCollection $strategyCollection, StatisticsProvider $statisticsProvider)
    {
        $this->strategyCollection = $strategyCollection;
        $this->statisticsProvider = $statisticsProvider;
    }

    /**
     * @Route("/", name="gamepage")
     */
    public function index(): Response
    {
        $strategies = $this->strategyCollection->getSupportedNames();
        $statistics = $this->statisticsProvider->getStatistics();

        return $this->render('game.html.twig', ['strategies' => $strategies, 'statistics' => $statistics]);
    }
}
