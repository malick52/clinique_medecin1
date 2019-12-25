<?php

namespace App\Controller;

use App\Entity\Medcin;
use App\Form\MedcinType;
use App\Repository\MedcinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedcinController extends AbstractController
{
    /**
     * @Route("/", name="medcin_index", methods={"GET"})
     */
    public function index(MedcinRepository $medcinRepository): Response
    {
        return $this->render('medcin/index.html.twig', [
            'medcins' => $medcinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="medcin_new")
     */
    public function new(Request $request): Response
    {
        $idMatricule = $this->getLastMedcin() +1;

        $medcin = new Medcin();
        $form = $this->createForm(MedcinType::class, $medcin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           

            $twoFirstLettrer = \strtoupper(\substr($medcin->getServices()->getLibelle(),0,2));
            $longId = strlen((string)$idMatricule);
            $matricule= \str_pad("M".$twoFirstLettrer,8 - $longId, "0").$idMatricule;
            $medcin->setMatricule($matricule);

            

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medcin);

            $entityManager->flush();

            return $this->redirectToRoute('medcin_index');
        }

        return $this->render('medcin/_form.html.twig', [
            'medcin' => $medcin,
            'form' => $form -> createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medcin_show", methods={"GET"})
     */
    public function show(Medcin $medcin): Response
    {
        return $this->render('medcin/show.html.twig', [
            'medcin' => $medcin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medcin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Medcin $medcin): Response
    {
        $form = $this->createForm(MedcinType::class, $medcin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medcin_index');
        }

        return $this->render('medcin/edit.html.twig', [
            'medcin' => $medcin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medcin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Medcin $medcin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medcin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medcin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medcin_index');
    }
    public function getLastMedcin ()
    {
        $ripo=$this->getDoctrine()->getRepository(Medcin::class);
        $medcinLast = $ripo->findBy([],['id' => 'DESC']);
        if($medcinLast == null)
        {
            return $id = 0 ;
        }
        else
        {
            return $medcinLast[0]->getId();
    }
}
    }