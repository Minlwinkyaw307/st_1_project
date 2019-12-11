<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\FoodRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/image")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/", name="image_index", methods={"GET", "POST"})
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('admin/image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/food-image-gallery/{id}", name="image_food_index", methods={"GET", "POST"})
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function foodImageIndex(ImageRepository $imageRepository, $id): Response
    {
        return $this->render('admin/image/food-image-index.html.twig', [
            'images' => $imageRepository->findAll(),
            'id' => $id,
        ]);
    }

    /**
     * @Route("/new/{id?}", name="image_new", methods={"GET","POST"})
     * @param Request $request
     * @param $id
     * @param FoodRepository $foodRepository
     * @return Response
     */
    public function new(Request $request, $id, FoodRepository $foodRepository): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();


        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['location']->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFileName = $originalFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('Upload_Image'),
                        $newFileName
                    );
                    $image->setLocation((string)$newFileName);
                } catch (FileException $e) {
                    die();
                }
                if ($id) {
                    $entityManager->persist($image);
                    $entityManager->flush();

                    $food = $foodRepository->findOneBy(['id' => $id]);
                    $food->setImage($image);

                    $entityManager->persist($food);
                    $entityManager->flush();
                } else {
                    dump("No Id");
                    die();
                }
                return $this->redirectToRoute('image_index');
            }
        }

        return $this->render('admin/image/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }

    /**
     * @Route("/{id}", name="image_show", methods={"GET"})
     * @param Image $image
     * @return Response
     */
    public function show(Image $image): Response
    {
        return $this->render('admin/image/show.html.twig', [
            'image' => $image,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="image_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Image $image
     * @return Response
     */
    public function edit(Request $request, Image $image): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('image_index');
        }

        return $this->render('admin/image/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_index');
    }

    /**
     * @Route("/update-food-image/{id}/{food_id}", name="image_update_food_image", methods={"GET", "POST"})
     * @param Request $request
     * @param Image $image
     * @param $food_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateFoodImage(Request $request, Image $image, $food_id, FoodRepository $foodRepository)
    {
        $food = $foodRepository->findOneBy(['id' => $food_id]);
        $entityManager = $this->getDoctrine()->getManager();
        $food->setImage($image);
        $entityManager->persist($food);
        $entityManager->flush();

        return $this->redirectToRoute('image_food_index', [
            'id' => $food_id,
        ]);
    }
}
