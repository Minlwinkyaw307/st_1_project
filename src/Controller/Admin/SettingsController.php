<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/settings")
 */
class SettingsController extends AbstractController
{
    /**
     * @Route("/", name="settings_index", methods={"GET"})
     * @param SettingsRepository $settingsRepository
     * @return Response
     */
    public function index(SettingsRepository $settingsRepository): Response
    {
        if($settingsRepository->findAll())
        {
            return $this->redirectToRoute('settings_edit', ['id' => 1]);
        }
        return $this->redirectToRoute('settings_new');
    }

    /**
     * @Route("/new", name="settings_new", methods={"GET","POST"})
     */
    public function new(Request $request, SettingsRepository $settingsRepository): Response
    {
        $settings = $settingsRepository->findAll();
        if($settings)
        {
            return $this->redirectToRoute('settings_edit', [
                'setting' => $settingsRepository->findBy(['id' => 1]),
                'id' => 1,

            ]);
        }

        $setting = new Settings();
        $form = $this->createForm(SettingsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($setting);
            $entityManager->flush();

            return $this->redirectToRoute('settings_index');
        }

        return $this->render('admin/settings/new.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="settings_show", methods={"GET"})
     */
    public function show(Settings $setting): Response
    {
        return $this->render('admin/settings/show.html.twig', [
            'setting' => $setting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="settings_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Settings $setting): Response
    {

        $form = $this->createForm(SettingsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $em->flush();
//            $this->getDoctrine()->getManager()->flush();
//            return $this->redirectToRoute('settings_index');
        }

        return $this->render('admin/settings/new.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="settings_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Settings $setting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$setting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($setting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('settings_index');
    }
}
