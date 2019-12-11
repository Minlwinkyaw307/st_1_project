<?php

namespace App\Controller\Admin;

use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Repository\FoodRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.")
     */
    public function index(CartRepository $cartRepository)
    {

        return $this->render('admin/admin-index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

}
