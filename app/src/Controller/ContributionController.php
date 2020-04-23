<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Form\ContributionType;
use App\Repository\ContributionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContributionController extends AbstractController
{
    /** @var ContributionRepository */
    protected $contributionRepository;

    /** @var \Parsedown */
    protected $markdownParser;

    public function __construct(ContributionRepository $contributionRepository)
    {
        $this->contributionRepository = $contributionRepository;
        $this->markdownParser = new \Parsedown();
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
     * @IsGranted("ROLE_USER")
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

            $this->addFlash('success', 'Contribution Added successfully!');

            return $this->redirectToRoute('home');
        }

        return $this->render('contribution/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contribution/{id}", methods={"GET"}, name="show_contribution")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function show(Request $request, $id): Response
    {
        $contribution = $this->contributionRepository->find($id);
        $contribution->setDescription($this->markdownParser->parse($contribution->getDescription()));

        return $this->render('contribution/show.html.twig', [
            'contribution' => $contribution
        ]);
    }

    /**
     * @Route("/contribution/{id}", methods={"DELETE"}, name="delete_contribution")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id): Response
    {
        $contribution = $this->contributionRepository->find($id);
        $this->denyAccessUnlessGranted('delete', $contribution);

        $this->contributionRepository->remove($contribution);

        $this->addFlash('success', 'Contribution have been deleted successfully!');

        return $this->redirectToRoute('home');
    }
}
