<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Form\ContributionType;
use App\Repository\ContributionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributionController extends AbstractController
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
        return $this->render('contribution/index.html.twig', [
            'contributions' => $this->contributionRepository->findBy([], ['created_at' => 'ASC']),
        ]);
    }

    /**
     * @Route("/contribution", methods={"GET", "POST"}, name="add_contribution")
     */
    public function add(Request $request): Response
    {
        // build the form
        $contribution = new Contribution();
        $form = $this->createForm(ContributionType::class, $contribution);

        // Handle the save click with the POST method only
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contribution->setUser($this->getUser());
            $contribution->setCreatedAt(new \DateTime('now'));
            $contribution->setUpdatedAt(new \DateTime('now'));

            $this->contributionRepository->save($contribution);

            $this->addFlash('string', 'Contribution Added successfully!');

            return $this->redirectToRoute('home');
        }

        return $this->render('contribution/add.html.twig', ['form' => $form->createView()]);
    }
}
