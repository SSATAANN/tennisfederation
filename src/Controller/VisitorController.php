<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Form\VisitorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitorController extends AbstractController
{
    /**
     * @Route("/Visitor", name="app_visitor")
     */
   
    public function index(): Response
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('visitor/index.html.twig', [
          'u'=>$users
        ]);
    }
 

     /**
     * @Route("/addVisitor", name="app_addvisitor")
     */
    public function addVisitor(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class,$user);

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
                       $this->getParameter('user_images_directory'),
                       $newFilename
                   );
               } catch (FileException $e) {
                   // handle exception if something happens during file upload
               }
           
               // update the Player entity with the new image path
               $user->setImage($newFilename);
             }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user); //add
            $em->flush();

            return $this->redirectToRoute('app_visitor');
        }
        return $this->render('visitor/createVisitor.html.twig',['f'=>$form->createView()]);
    }
    
    /**
     * @Route("/modVisitor/{id}", name="app_modvisitor")
     */
    public function modVisitorr(Request $request,$id): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);

        $form = $this->createForm(VisitorType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {
            $roles = $form->get('roles')->getData();
            $user->setRoles($roles);
              /** @var UploadedFile $imageFile */
              $imageFile = $form->get('imageFile')->getData();

              if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
            
                try {
                    $imageFile->move(
                        $this->getParameter('user_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }
            
                // update the Player entity with the new image path
                $user->setImage($newFilename);
              }
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_visitor');
        }
        return $this->render('visitor/updateVisitor.html.twig',['f'=>$form->createView()]);
    }
}
