<?php

namespace App\Controller\Home;

use App\Entity\Cart;
use App\Entity\Comment;
use App\Entity\Food;
use App\Entity\Message;
use App\Entity\Odr;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\MessageType;
use App\Form\UserType;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\FoodRepository;
use App\Repository\OdrRepository;
use App\Repository\SettingsRepository;
use App\Repository\SliderRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Bridge\Google\Smtp\GmailTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
     * @Route("/", name="front.")
     */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CartRepository $cartRepository
     * @param SliderRepository $sliderRepository
     * @param CategoryRepository $categoryRepository
     * @param FoodRepository $foodRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(SettingsRepository $settingsRepository, CartRepository $cartRepository ,SliderRepository $sliderRepository, CategoryRepository $categoryRepository, FoodRepository $foodRepository)
    {
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => 'Crispy | Home',
            'sliders' => $sliderRepository->findBy(['status' => 1]),
            'categories' => $categoryRepository->findAll(),
            'foods' => $foodRepository->findBy([], array('updated_at'=>'ASC')),
            'showAllMenu' => false,
            'listLimit' => 6,
            'cart_count' => $cart_count,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
        return $this->render('front/index.html.twig',$transferValue);
    }


    /**
     * @Route("/about", name="aboutUs")
     */
    public function aboutUs(CartRepository $cartRepository, SettingsRepository $settingsRepository)
    {
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => 'Crispy | About Us',
            'cart_count' => $cart_count,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
        return $this->render('front/front.aboutUs.html.twig',$transferValue);
    }

    /**
     * @Route("/prefrences", name="prefrences")
     * @param CartRepository $cartRepository
     * @param SettingsRepository $settingsRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function prefrences(CartRepository $cartRepository, SettingsRepository $settingsRepository)
    {
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => 'Crispy | References',
            'cart_count' => $cart_count,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
        return $this->render('front/SubTwig/front.prefrences.html.twig',$transferValue);
    }

    /**
     * @Route("/contactus", name="contactus")
     * @param CartRepository $cartRepository
     * @param SettingsRepository $settingsRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function contactus(Request $request, CartRepository $cartRepository, SettingsRepository $settingsRepository)
    {   $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        $setting = $settingsRepository->findAll()[0];
        $cart_count = 0;
        if($form->isSubmitted())
        {
            $message->setIp($_SERVER['REMOTE_ADDR']);
            $message->setStatus("New");
            $message->setCreatedAt(new DateTime());
            $message->setUpdatedAt(new DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $email = (new Email())
                ->from($setting->getSmtpemail())
                ->to($message->getEmail())
                ->subject("Cripsy Food Delivery | Your Request")
                ->html('Dear'. $message->getName() . ',<br>'.
                    "<p>We are really happy to recieve message from you</p>".
                    "<p>We will evaluate your message as soon as possilbe</p>".
                    "<p>Much Love From Cripsy Food Delivery</p>"
                );
            $transport = new GmailTransport($setting->getSmtpemail(), $setting->getSmtppasw());
            $mailer = new Mailer($transport);
            $sentEmail = $mailer->send($email);
            $this->addFlash('success', "You Message Has Been Sent. Please Check Your E-mail To Confirm.");
            return $this->redirectToRoute('front.contactus');
        }
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => 'Crispy | Contact Us',
            'cart_count' => $cart_count,
            'setting' => $setting,
            'form' => $form->createView(),
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
        return $this->render('front/SubTwig/front.contactus.html.twig',$transferValue);
    }

    /**
     * @Route("/food/{id}", name="food-detail")
     * @param Request $request
     * @param Food $food
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function foodDetail(SettingsRepository $settingsRepository,Request $request, Food $food, $id, CartRepository $cartRepository, CommentRepository $commentRepository)
    {
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => $food->getName(),
            'keywords' => $food->getKeywords(),
            'description' => $food->getDescription(),
            'food' => $food,
            'cart_count' => $cart_count,
            'foodid' => $id,
            'comments' => $commentRepository->findBy(['product' => $food]),
            'setting' => $settingsRepository->findAll()[0],
        ];
        return $this->render('front/SubTwig/FoodDetail/index.html.twig', $transferValue);
//        return $this->render()
    }

    /**
     * @Route("/{id}", name="cart_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cart $cart): \Symfony\Component\HttpFoundation\Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cart);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully Removed From the Cart');
        }

        return $this->redirectToRoute('front.user-cart');
    }


    /**
     * @Route("/meal-category", name="meal-category")
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @param FoodRepository $foodRepository
     * @param CartRepository $cartRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function frontCategory(SettingsRepository $settingsRepository, Request $request, CategoryRepository $categoryRepository, FoodRepository $foodRepository, CartRepository $cartRepository)
    {
        $food = null;
        $subid = $request->query->get('subid');
        if($subid == null)
            $food = $foodRepository->findAll();
        else
            $food = $foodRepository->findBy(['category' => $subid]);
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => 'Crispy | Categories',
            'categories' => $categoryRepository->findAll(),
            'foods' => $food,
            'showAllMenu' => true,
            'listLimit' => 6,
            'cart_count' => $cart_count,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
        return $this->render('front/SubTwig/Category/index.html.twig', $transferValue);
    }

    /**
     * @Route("/profile/cart", name="user-cart")
     **/
    public function userCart(SettingsRepository $settingsRepository, Request $request, UserInterface $user, CartRepository $cartRepository)
    {
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();

        /** @var User $user */
        $transferValue = [
            'title' => 'Cart',
            'carts' => $cartRepository->findAll(['added_by' => $user]),
            'cart_count' => $cart_count,
            'setting' => $settingsRepository->findAll()[0],
            'description' => $settingsRepository->findAll()[0]->getDescription(),
            'keywords' => $settingsRepository->findAll()[0]->getKeywords(),
        ];
//        dump($cartRepository->findBy(['added_by' => $user]));
//        die();
        return $this->render('front/SubTwig/cart.html.twig', $transferValue);
    }

    /**
     * @Route("/add", name="cart_add")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param CartRepository $cartRepository
     * @param FoodRepository $foodRepository
     * @return Response|JsonResponse
     */
    public function addToCart(SettingsRepository $settingsRepository,Request $request, UserRepository $userRepository, CartRepository $cartRepository, FoodRepository $foodRepository)
    {
//        $response = JsonResponse::fromJsonString('{ "data": 123 }');
        $amount = $request->query->get('amount');
        $food_id = $request->query->get('fid');
        $userid = $request->query->get('uid');


        if($amount == null || $food_id == null /*|| $userid == null*/)
            return JsonResponse::fromJsonString('{"result" :  false}');
        else
        {
            $cart = new Cart();
            $cart->setAddedBy($userRepository->findOneBy(['id' => (int)$userid]));
            $cart->setAmount((int)$amount);
            $cart->setProduct($foodRepository->findOneBy(['id' => (int)$food_id]));

//            $totalUser = $userRepository->createQueryBuilder('u')
//                ->select('count(a.id)')
//                ->getQuery()
//                ->getSingleScalarResult();
            $em = $this->getDoctrine()->getManager();

            $em->persist($cart);
            $em->flush();
            return JsonResponse::fromJsonString('{"result" :  true}');
        }

    }




}
