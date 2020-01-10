<?php

namespace App\Controller\Home;

use App\Entity\Comment;
use App\Entity\Odr;
use App\Form\CommentType;
use App\Repository\CartRepository;
use App\Repository\FoodRepository;
use App\Repository\OdrRepository;
use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @Route("", name="front.")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/order", name="user-order")
     * @param Request $request
     * @param CartRepository $cartRepository
     * @param UserInterface $user
     * @param FoodRepository $foodRepository
     * @param OdrRepository $odrRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function orderList(SettingsRepository $settingsRepository, Request $request, CartRepository $cartRepository , UserInterface $user, FoodRepository $foodRepository, OdrRepository $odrRepository)
    {

        $fids = $request->request->get('fids');
        $amounts = $request->request->get('amt');

        if($fids != null && $amounts != null)
        {
            $amounts = explode(',', $amounts);
            $fids = explode(',', $fids);

            $fam = [];
            $foods = $foodRepository->findBy(['id' => $fids]);

            for($i = 0; $i < count($fids); $i++)
            {
                $fam[(string)$fids[$i]] = $amounts[$i];
            }
            $em = $this->getDoctrine()->getManager();
            for($i = 0; $i < count($foods); $i++)
            {
                $order = new Odr();
                $order->setProduct($foods[$i]);
                $order->setAmount($fam[$foods[$i]->getId()]);
                $order->setOrderedBy($user);
                $order->setOrderedAt(new DateTime());
                $order->setStatus('Pending');

                $crt = $cartRepository->findOneBy(['amount' => $fam[$foods[$i]->getId()], 'product' => $foods[$i]]);
                if($crt != null)
                    $em->remove($crt);
                $em->persist($order);
            }

            try{
                $em->flush();
                $this->addFlash('success', "You Order have been made.");
                return JsonResponse::fromJsonString('{"result" :  false}');
            }catch (\Exception $e)
            {
                $this->addFlash('error', "Couldn't Make Order");
                return JsonResponse::fromJsonString('{"result" :  true}');
            }
        }
        $myOrder = $odrRepository->findBy(['ordered_by'=> $user]);
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => "Orders",
            'orders' => $myOrder,
            'cart_count' => $cart_count,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
        return $this->render('front/SubTwig/Order/order.html.twig', $transferValue);
//        return $this->generateUrl('front.user-order', $transferValue);
//        return $this->redirectToRoute('front.user-order', $transferValue);
//        return $this->redirect('')
    }

    /**
     * @Route("/profile/order/confirm", name="user-confirm-order")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function profileOrder(SettingsRepository $settingsRepository, Request $request, CartRepository $cartRepository, FoodRepository $foodRepository)
    {
        //get all the queries that was pass
        $f = $request->query->get('fids');
        $fids = explode(',', $f);
        $a = $request->query->get('amt');
        $amounts = explode(',', $a);
        //make empyt food and amount array to store them
        $fam = [];

        for($i = 0; $i < count($fids); $i++)
        {
            //push food and amount in the array as sub array
            array_push($fam, ([$fids[$i], $amounts[$i]]));
        }
        $foods = $foodRepository->findBy(['id' => $fids]);

        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => "Confirm Orders",
            'cart_count' => $cart_count,
            'foods'=> $foods,
            'amounts' => $fam,
            'fids' => $f,
            'amount' => $a,
            'foodids' => $fids,
            'foodamount' => $amounts,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
        return $this->render('front/SubTwig/Order/confirm-order.html.twig', $transferValue);
    }

    /**
     * @Route("profile/order/delete/{id}", name="odr_delete", methods={"DELETE"}, requirements={"id":"\d+"})
     * @param Request $request
     * @param Odr $odr
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteOrder(SettingsRepository $settingsRepository, Request $request, Odr $odr): \Symfony\Component\HttpFoundation\Response
    {
        if ($this->isCsrfTokenValid('delete'.$odr->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($odr);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front.user-order');
    }

    /**
     * @Route("comment/profile/new", name="comment_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserInterface $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function new(SettingsRepository $settingsRepository, Request $request, UserInterface $user): \Symfony\Component\HttpFoundation\Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $comment->setCommentedBy($user);
            $comment->setIp($_SERVER['REMOTE_ADDR']);
            $comment->setStatus(true);
            $comment->setCommentedAt(new DateTime());
            $comment->setUpdatedAt(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', "Your Comment have been successfully added");
            return $this->redirectToRoute('front.food-detail', ['id' => $comment->getProduct()->getId()]);
        }
        return $this->redirectToRoute('front.food-detail', ['id' => $comment->getProduct()->getId()]);
    }

    /**
     * @Route("profile/general", name="user-general",)
     * @param Request $request
     * @param CartRepository $cartRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function profileGeneral(SettingsRepository $settingsRepository, Request $request, CartRepository $cartRepository)
    {
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => "General",
            'cart_count' => $cart_count,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),

        ];
        return $this->render('front/SubTwig/profile/general.html.twig', $transferValue);
    }

    /**
     * @Route("profile/general/update", name="user-general-update", methods={"POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateProfile(SettingsRepository $settingsRepository, Request $request,UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $nuser = $request->request->get('user');
        $user = $userRepository->findOneBy(['id' => $nuser['id']]);
        $em = $this->getDoctrine()->getManager();
        if($user->getUsername() != $nuser['username'])
        {
            $user->setUsername($nuser['username']);
            $em->persist($user);


            $this->addFlash('success', 'Username have been updated');
        }

        if($nuser['password'] != null)
        {
            if( $nuser['password'] == $nuser['repassword'])
            {
                $user->setPassword($passwordEncoder->encodePassword($user, $nuser['repassword']));
                $em->persist($user);
                $this->addFlash('success', 'Password have been resetted');

            }else{
                $this->addFlash('error', 'Passwords are not match.');
            }
        }
        $em->flush();
        return $this->redirectToRoute('front.user-general');
    }
}
