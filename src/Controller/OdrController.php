<?php

namespace App\Controller;

use App\Entity\Odr;
use App\Form\OdrType;
use App\Repository\OdrRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/odr")
 */
class OdrController extends AbstractController
{
    /**
     * @Route("/", name="odr_index", methods={"GET"})
     */
    public function index(OdrRepository $odrRepository): Response
    {
        return $this->render('odr/index.html.twig', [
            'odrs' => $odrRepository->findAll(),
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

            return $this->redirectToRoute('odr_index');
        }

        return $this->render('odr/new.html.twig', [
            'odr' => $odr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="odr_show", methods={"GET"})
     */
    public function show(Odr $odr): Response
    {
        return $this->render('odr/show.html.twig', [
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

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('odr_index');
        }

        return $this->render('odr/edit.html.twig', [
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
