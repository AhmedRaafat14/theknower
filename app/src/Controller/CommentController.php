<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This controller will be processing any action related to the comments
 *
 * @Route("/contribution/{contributionId}/comment")
 * Class CommentController
 */
class CommentController extends AbstractController
{
    /** @var CommentRepository */
    private $commentRepository;

    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/", methods={"POST"}, name="add_comment")
     *
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param $contributionId
     * @return Response
     */
    public function add(Request $request, $contributionId): Response
    {
        if ($request->isXmlHttpRequest()){
            $comment = $this->commentRepository->insertOne($request->get('content'), $contributionId, $this->getUser());

            $template = $this->render('comment/index.html.twig', [
                'contribution' => $comment->getContribution(),
            ])->getContent();

            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(['template' => $template]);
            return $response;
        }

        return $this->redirectToRoute('show_contribution', [
            'id' => $contributionId
        ]);
    }
}
