<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    /**
     * @Route("/marque", name="marque")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Marque::class);
        $marques=$repository->findAll();
        return $this->render('marque/index.html.twig', [
            'marques' => $marques
        ]);
    }

    /**
     * @Route("/marque/add", name="marque-add")
     */
    public function addMarque(Request $request){
        $form = $this->createForm(MarqueType::class, new Marque());
        // Ici nous traitons notre requête
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $marque = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();
            return $this->redirectToRoute('marque');
        }else {
            return $this->render('marque/addMarque.html.twig', [
                'form' => $form->createView(),
                'errors'=>$form->getErrors()
            ]);
        }
    }

    //entre {} pour prendre l'id de la voiture
    /**
     * @Route("/detail/{marque}", name="marque-detail", requirements={"marque"="^(?!register).+"})
     */
    public function detailMarque(Marque $marque)
    {
        return $this->render('marque/marquedetail.html.twig', [
            'controller_name' => 'MarqueController',
            'marque' => $marque
        ]);
    }
}
