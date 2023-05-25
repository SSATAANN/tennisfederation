<?php

namespace App\Controller;

use App\Entity\Referee;
use App\Form\RefereeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RefereeController extends AbstractController
{
    /**
     * @Route("//Admin/Referee", name="app_referee")
     */
    public function index(): Response
    {
        $referees = $this->getDoctrine()->getManager()->getRepository(Referee::class)->findAll();
        return $this->render('referee/index.html.twig', [
          'r'=>$referees
        ]);
    }
    /**
     * @Route("/addReferee", name="app_addreferee")
     */
    public function addReferee(Request $request): Response
    {
        $referee = new Referee();

        $form = $this->createForm(RefereeType::class,$referee);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
             /** @var UploadedFile $imageFile */
             $imageFile = $form->get('imageFile')->getData();

             if ($imageFile) {
               $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
               $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
           
               try {
                   $imageFile->move(
                       $this->getParameter('referee_images_directory'),
                       $newFilename
                   );
               } catch (FileException $e) {
                   // handle exception if something happens during file upload
               }
           
               // update the Player entity with the new image path
               $referee->setImage($newFilename);
             }
            $em = $this->getDoctrine()->getManager();
            $em->persist($referee); //add
            $em->flush();

            return $this->redirectToRoute('app_referee');
        }
        return $this->render('referee/createReferee.html.twig',['f'=>$form->createView()]);
    }
     /**
     * @Route("/supReferee/{id}", name="app_supreferee")
     */
    public function suppressionReferee(Referee $referee): Response
{
    $em = $this->getDoctrine()->getManager();
    $imageFilename = $referee->getImageFilename();

    if ($imageFilename) {
        $imagePath = $this->getParameter('uploads/referee_images').'/'.$imageFilename;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $em->remove($referee);
    $em->flush();

    return $this->redirectToRoute('app_referee');
}

    /**
     * @Route("/modReferee/{id}", name="app_modreferee")
     */
    public function modReferee(Request $request,$id): Response
    {
        $referee = $this->getDoctrine()->getManager()->getRepository(Referee::class)->find($id);

        $form = $this->createForm(RefereeType::class,$referee);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {
              /** @var UploadedFile $imageFile */
              $imageFile = $form->get('imageFile')->getData();

              if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
            
                try {
                    $imageFile->move(
                        $this->getParameter('referee_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }
            
                // update the Player entity with the new image path
                $referee->setImage($newFilename);
              }
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_referee');
        }
        return $this->render('referee/updateReferee.html.twig',['f'=>$form->createView()]);
    }



}
