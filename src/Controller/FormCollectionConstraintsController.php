<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\FormCollectionConstraintsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Helper for debugging form collection constraints
 */
class FormCollectionConstraintsController extends AbstractController
{
    #[Route('/form-collection-constraints', name: 'debug_form_collection_constraints')]
    public function index(Request $request): Response
    {
        $data = [
            'items' => [
                'data' => [
                    'value' => null,
                ],
            ],
        ];

        $form = $this->createForm(FormCollectionConstraintsType::class, $data, [
            'csrf_protection' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            dump($form->getData());
        }

        return $this->renderForm('form_collection_constraints.html.twig', [
            'form' => $form,
        ]);
    }
}