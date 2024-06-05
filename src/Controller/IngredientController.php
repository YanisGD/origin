<?php

namespace App\Controller;

use App\Form\IngredientType;
use App\Entity\Ingredient;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;;



class IngredientController extends AbstractController
{
    /**
     * This function displays all ingredients
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'app_ingredient', methods:['GET'])]
    public function index(IngredientRepository $repository,
     PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/ingredient/index.html.twig',
            ['ingredients' => $ingredients]);
    }

    #[Route('/ingredient/nouveau', name: 'app_ingredient.new', methods:['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $ingredient = $form->getData();

            $manager->persist($ingredient);
            $manager->flush();

            $this->redirectToRoute('ingredient.index');
        }else{
            
        }


        return $this->render('pages/ingredient/new.html.twig', [ 'form'=>$form->createView()]);
    }
}
