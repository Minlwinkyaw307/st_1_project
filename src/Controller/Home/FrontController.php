<?php

namespace App\Controller\Home;

use App\Entity\Cart;
use App\Entity\Comment;
use App\Entity\Food;
use App\Entity\Odr;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\FoodRepository;
use App\Repository\OdrRepository;
use App\Repository\OrderRepository;
use App\Repository\SliderRepository;
use App\Repository\UserRepository;
use DateTime;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
    public function index(CartRepository $cartRepository ,SliderRepository $sliderRepository, CategoryRepository $categoryRepository, FoodRepository $foodRepository)
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
        ];
        return $this->render('front/index.html.twig',$transferValue);
    }


    /**
     * @Route("/about", name="aboutUs")
     */
    public function aboutUs()
    {
        $transferValue = [
            'title' => 'Crispy | Home',
        ];
        return $this->render('front/front.aboutUs.html.twig',$transferValue);
    }

    /**
     * @Route("/food/{id}", name="food-detail")
     * @param Request $request
     * @param Food $food
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function foodDetail(Request $request, Food $food, $id, CartRepository $cartRepository, CommentRepository $commentRepository)
    {
        $cart_count = 0;
        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))
            $cart_count =  $cartRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $transferValue = [
            'title' => 'Crispy | Home',
            'food' => $food,
            'cart_count' => $cart_count,
            'foodid' => $id,
            'comments' => $commentRepository->findBy(['product' => $food]),
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function frontCategory(Request $request, CategoryRepository $categoryRepository, FoodRepository $foodRepository)
    {
        $food = null;
        $subid = $request->query->get('subid');
        if($subid == null)
            $food = $foodRepository->findAll();
        else
            $food = $foodRepository->findBy(['category' => $subid]);
        $transferValue = [
            'title' => 'Crispy | Home',
            'categories' => $categoryRepository->findAll(),
            'foods' => $food,
            'showAllMenu' => true,
            'listLimit' => 6,
            ''
        ];
        return $this->render('front/SubTwig/Category/index.html.twig', $transferValue);
    }

    /**
     * @Route("/profile/cart", name="user-cart")
     **/
    public function userCart(Request $request, UserInterface $user, CartRepository $cartRepository)
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
    public function addToCart(Request $request, UserRepository $userRepository, CartRepository $cartRepository, FoodRepository $foodRepository)
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
    public function orderList(Request $request, CartRepository $cartRepository , UserInterface $user, FoodRepository $foodRepository, OdrRepository $odrRepository)
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
    public function profileOrder(Request $request, CartRepository $cartRepository, FoodRepository $foodRepository)
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
        ];
        return $this->render('front/SubTwig/Order/confirm-order.html.twig', $transferValue);
    }

    /**
     * @Route("/{id}", name="odr_delete", methods={"DELETE"})
     */
    public function deleteOrder(Request $request, Odr $odr): \Symfony\Component\HttpFoundation\Response
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
    public function new(Request $request, UserInterface $user): \Symfony\Component\HttpFoundation\Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $comment->setCommentedBy($user);
            $comment->setCommentedAt(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('front.food-detail', ['id' => $comment->getProduct()->getId()]);
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

}
