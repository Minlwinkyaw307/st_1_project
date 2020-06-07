<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\FoodRepository;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("admin/image/", name="image_index", methods={"GET", "POST"})
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
     * @Route("admin/image/food-image-gallery/{id}", name="image_food_index", methods={"GET", "POST"})
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
     * @Route("admin/image/new/{id?}", name="image_new", methods={"GET","POST"})
     * @param Request $request
     * @param $id
     * @param FoodRepository $foodRepository
     * @return Response
     */
    public function new(Request $request, $id, FoodRepository $foodRepository, UserInterface $user): Response
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
                    $image->setUploadedBy($user);
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
     * @Route("admin/image/{id}", name="image_show", methods={"GET"})
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
     * @Route("admin/image/{id}/edit", name="image_edit", methods={"GET","POST"})
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
     * @Route("/image/{id}", name="image_delete", methods={"DELETE"})
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
     * @Route("admin/image/update-food-image/{id}/{food_id}", name="image_update_food_image", methods={"GET", "POST"})
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


    //Profile Part

    /**
     * @Route("/profile/update/{id}", name="profile_image_update", methods={"GET","POST"})
     * @param Request $request
     * @param $id
     * @param UserRepository $userRepository
     * @param $user
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function updateProfile(Request $request, $id, UserRepository $userRepository,ImageRepository $imageRepository): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $userRepository->findOneBy(['id' => $id]);

        if ($form->isSubmitted() && $form->isValid() && $image->getTitle() != null) {
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
                    $image->setUploadedBy($user);
                } catch (FileException $e) {
                    die();
                }
                if ($id) {
                    $entityManager->persist($image);
                    $entityManager->flush();

                    $user->setProfileImg($image);


                    $entityManager->persist($user);
                    $entityManager->flush();
                } else {
                    dump("No Id");
                    die();
                }
                return $this->render('front/SubTwig/profile/close-tab.html.twig');
            }
        }else if($image->getTitle() == null && $form->isSubmitted())
        {
            $this->addFlash('error', 'Please Enter Titile for this Image');
        }

        return $this->render('front/SubTwig/profile/update-image.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
            'id' => $id,
            'images' => $imageRepository->findBy(['uploaded_by' => $user]),
        ]);
    }

    /**
     * @Route("profile/general/{imgid}/{uid}/update", name="profile_change_image", methods={"GET","POST"})
     * @param Request $request
     * @param Image $image
     * @return Response
     */
    public function changeProfile(Request $request, $imgid, $uid, ImageRepository $imageRepository, UserRepository $userRepository): Response
    {
        $image = $imageRepository->findOneBy(['id' => $imgid]);
        $user = $userRepository->findOneBy(['id' => $uid]);

        $em = $this->getDoctrine()->getManager();
        $user->setProfileImg($image);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('profile_image_update', ['id'=>$user->getId()]);
    }

    /**
     * @Route("profile/setting/image/{id}/{uid}", name="profile_image_delete", methods={"DELETE"})
     */
    public function deleteProfile(Request $request, Image $image,$uid,  UserInterface $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            if(unlink((string)$this->getParameter('Upload_Image') ."/". $image->getLocation()))
            {
                $this->addFlash('success', "Image have been removed");
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($image);
                $entityManager->flush();
            }else{
                $this->addFlash('error', "couldn't remove image, please try again");
            }
        }

        return $this->redirectToRoute('profile_image_update', ['id' => $uid]);
    }
}
