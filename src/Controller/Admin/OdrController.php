<?php

namespace App\Controller\Admin;

use App\Entity\Odr;
use App\Form\OdrType;
use App\Repository\OdrRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order")
 */
class OdrController extends AbstractController
{
    /**
     * @Route("/order-history", name="order-history", methods={"GET"})
     */
    public function index(OdrRepository $odrRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'title' => "Order Histories",
            'odrs' => $odrRepository->findAll(),
        ]);
    }

    /**
     * @Route("/order-new", name="order-new", methods={"GET"})
     */
    public function orderNew(OdrRepository $odrRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'title' => "New Orders",
            'odrs' => $odrRepository->findBy(['status' => 'Pending']),
        ]);
    }

    /**
     * @Route("/order-on-way", name="order-on-way", methods={"GET"})
     */
    public function orderOnWay(OdrRepository $odrRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'title' => "On Way Orders",
            'odrs' => $odrRepository->findBy(['status' => 'On Way']),
        ]);
    }

    /**
     * @Route("/order-delivered", name="order-delivered", methods={"GET"})
     */
    public function orderDelivered(OdrRepository $odrRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'title' => "Delivered Orders",
            'odrs' => $odrRepository->findBy(['status' => 'Delivered']),
        ]);
    }

    /**
     * @Route("/new", name="odr_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $odr = new Odr();
        $form = $this->createForm(OdrType::class, $odr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($odr);
            $entityManager->flush();

            return $this->redirectToRoute('order-history');
        }

        return $this->render('admin/order/new.html.twig', [
            'odr' => $odr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="odr_show", methods={"GET"})
     */
    public function show(Odr $odr): Response
    {
        return $this->render('admin/order/show.html.twig', [
            'odr' => $odr,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="odr_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Odr $odr): Response
    {
        $form = $this->createForm(OdrType::class, $odr);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $odr->setStatus($request->request->get('odr')['status']);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order-history');
        }

        return $this->render('admin/order/edit.html.twig', [
            'odr' => $odr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="odr_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Odr $odr): Response
    {
        if ($this->isCsrfTokenValid('delete'.$odr->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($odr);
            $entityManager->flush();
        }

        return $this->redirectToRoute('odr_index');
    }
}
