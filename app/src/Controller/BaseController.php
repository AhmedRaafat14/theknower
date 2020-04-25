<?php

namespace App\Controller;

use App\Repository\ContributionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This will work as our Base/Entry-point to view the home page and do most of
 * the common things away from entity controllers
 *
 * Class BaseController
 */
class BaseController extends AbstractController
{
    /** @var ContributionRepository */
    protected $contributionRepository;

    public function __construct(ContributionRepository $contributionRepository)
    {
        $this->contributionRepository = $contributionRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
            'contributions' => $this->contributionRepository->findBy([], ['created_at' => 'DESC']),
        ]);
    }
}
