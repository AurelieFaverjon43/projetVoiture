<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index()
    {
        $repository =$this->getDoctrine()->getRepository(Voiture::class);
        $voitures = $repository->findAll();
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
            'voiture' => $voitures
        ]);
    }

    /**
     * @Route("/voiture/add", name="voiture-add")
     */
    public function addVoiture(Request $request){
        $form = $this->createForm(VoitureType::class, new Voiture());
        // Ici nous traitons notre requête
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voiture = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('voiture');
        }else {
            return $this->render('voiture/addVoiture.html.twig', [
                'form' => $form->createView(),
                'errors'=>$form->getErrors()
            ]);
        }
    }

    //entre {} pour prendre l'id de la voiture
    /**
     * @Route("/detail/{voiture}", name="voiture-detail", requirements={"voiture"="^(?!register).+"})
     */
    public function detailVoiture(Voiture $voiture)
    {
        return $this->render('voiture/voituredetail.html.twig', [
            'controller_name' => 'VoitureController',
            'voiture' => $voiture
        ]);
    }
}
