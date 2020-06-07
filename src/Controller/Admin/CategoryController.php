<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'title' =>"All Categories",
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    /**
     * @Route("/main-categories", name="category_main_index", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function mainCategoryIndex(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/main-category.html.twig', [
            'title' =>"Main Categories",
            'categories' => $categoryRepository->findBy(['parentid' => null]),
        ]);
    }
    /**
     * @Route("/sub-categories", name="category_sub_index", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function subCategoryIndex(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/sub-category.html.twig', [
            'title' =>"Sub Categories",
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function new(Request $request, CategoryRepository $categoryRepository, ImageRepository $imageRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $file = $form['image']->getData();
            $category->setCreatedAt(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();


            return $this->redirectToRoute('category_index');
        }
        $mainCategoryList = $categoryRepository->findBy(['parentid' => null]);
        return $this->render('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'mainCategoryList' => $mainCategoryList,
            'images' => $imageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository, ImageRepository $imageRepository): Response
    {
        dump($category);
//        die();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

//        $category->setImage($imageRepository->findOneBy(['id'=> (int)$form->getData('image')]));

        if ($form->isSubmitted()) {
            $img = $imageRepository->findOneBy(['id'=> $request->request->get('category')['image']]);
            $pcat = $categoryRepository->findOneBy(['id'=> $request->request->get('category')['parentid']]);
            $category->setImage($img);
            $category->setParentid($pcat);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_index');
        }
        $mainCategoryList = $categoryRepository->findBy(['parentid' => null]);
        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'mainCategoryList' => $mainCategoryList,
            'images' => $imageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }
}
