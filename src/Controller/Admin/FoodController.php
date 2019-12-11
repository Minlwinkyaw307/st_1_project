<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Food;
use App\Entity\Image;
use App\Form\FoodType;
use App\Repository\CategoryRepository;
use App\Repository\FoodRepository;
use App\Repository\ImageRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/food")
 */
class FoodController extends AbstractController
{
    /**
     * @Route("/", name="food_index", methods={"GET"})
     * @param FoodRepository $foodRepository
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function index(FoodRepository $foodRepository, ImageRepository $imageRepository): Response
    {

        return $this->render('admin/food/index.html.twig', [
            'foods' => $foodRepository->findAll(),
            'images' => $imageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="food_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageRepository $imageRepository, CategoryRepository $categoryRepository): Response
    {
        $food = new Food();
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $food->setCategory($categoryRepository->findOneBy(['id' => $request->request->get('food')['category']]));
            $food->setCreatedAt(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($food);
            $entityManager->flush();

            return $this->redirectToRoute('food_index');
        }

        return $this->render('admin/food/new.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
            'images' => $imageRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="food_show", methods={"GET"})
     */
    public function show(Food $food): Response
    {
        return $this->render('admin/food/show.html.twig', [
            'food' => $food,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="food_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Food $food
     * @return Response
     */
    public function edit(Request $request, Food $food, ImageRepository $imageRepository, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $cat = $categoryRepository->findOneBy(['id' => $request->request->get('food')['category']]);
            $food->setCategory($cat);
//            dump($food);
//            die();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('food_index');
        }

        return $this->render('admin/food/edit.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
            'images' => $imageRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="food_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Food $food): Response
    {
        if ($this->isCsrfTokenValid('delete'.$food->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($food);
            $entityManager->flush();
        }

        return $this->redirectToRoute('food_index');
    }
}
