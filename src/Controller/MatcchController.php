<?php

namespace App\Controller;
use App\Form\MatcchType;
use App\Entity\Matcch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatcchController extends AbstractController
{
    /**
     * @Route("/Match", name="app_match")
     */
    public function index(): Response
    {
        $matches = $this->getDoctrine()->getManager()->getRepository(Matcch::class)->findAll();
        return $this->render('matcch/index.html.twig', [
          'm'=>$matches
        ]);
    }


    /**
     * @Route("/addMatch", name="app_addMatch")
     */
    public function addMatch(Request $request): Response
    {
        $match = new Matcch();

        $form = $this->createForm(MatcchType::class,$match);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($match); //add
            $em->flush();

            return $this->redirectToRoute('app_match');
        }
        return $this->render('matcch/createMatch.html.twig',['f'=>$form->createView()]);
    }
    
    /**
     * @Route("/supMatch/{id}", name="app_supmatch")
     */
    public function supprissionMatch(Matcch $match): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($match);
        $em->flush();

        return $this->redirectToRoute('app_match');
    }

    
    /**
     * @Route("/modMatch/{id}", name="app_modmatch")
     */
    public function modMatch(Request $request,$id): Response
    {
        $match = $this->getDoctrine()->getManager()->getRepository(Matcch::class)->find($id);

        $form = $this->createForm(MatcchType::class,$match);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_match');
        }
        return $this->render('Matcch/updateMatch.html.twig',['f'=>$form->createView()]);
}

}

