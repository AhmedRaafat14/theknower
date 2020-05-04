<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Form\ContributionType;
use App\Repository\ContributionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This will hold whatever actions related on the contributions.
 *
 * @Route("/contribution")
 * Class ContributionController
 */
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
     * @Route("/{id}", methods={"GET"}, name="show_contribution")
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
     * @Route("/", methods={"GET", "POST"}, name="add_contribution")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
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

            return $this->redirectToRoute('show_contribution', [
                'id' => $contribution->getId()
            ]);
        }

        return $this->render('contribution/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="edit_contribution")
     * @IsGranted("ROLE_USER")
     * @IsGranted("manage", subject="contribution")
     *
     * @param Contribution $contribution
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function edit(Contribution $contribution, Request $request, $id): Response
    {
        $form = $this->createForm(ContributionType::class, $contribution);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contribution->setUpdatedAt(new \DateTime('now'));

            $this->contributionRepository->save($contribution);

            $this->addFlash('success', 'Contribution updated successfully!');

            return $this->redirectToRoute('show_contribution', [
                'id' => $contribution->getId()
            ]);
        }

        return $this->render('contribution/edit.html.twig', [
            'form' => $form->createView(),
            'contribution' => $contribution,
        ]);
    }

    /**
     * @Route("/{id}/remove", methods={"DELETE"}, name="delete_contribution")
     * @IsGranted("ROLE_USER")
     * @IsGranted("manage", subject="contribution")
     *
     * @param Contribution $contribution
     * @param $id
     * @return Response
     */
    public function delete(Contribution $contribution, $id): Response
    {
        $this->contributionRepository->remove($contribution);

        $this->addFlash('success', 'Contribution have been deleted successfully!');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}/likes", name="toggle_likes_contribution")
     * @IsGranted("ROLE_USER")
     *
     * @param Contribution $contribution
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function toggleLikes(Contribution $contribution, Request $request, $id): Response
    {
        if ($request->isXmlHttpRequest()) {
            if ($contribution->getLikes()->contains($this->getUser())) {
                # Remove the logged-in user like for the contribution
                $contribution->removeLike($this->getUser());
            } else {
                # Save that is the logged-in user likes this contribution
                $contribution->addLike($this->getUser());
            }
            $this->contributionRepository->save($contribution);

            return new JsonResponse(array('success' => true, 'new_likes' => count($contribution->getLikes())));
        }

        return $this->redirectToRoute('show_contribution', [
            'id' => $contribution->getId()
        ]);
    }
}
