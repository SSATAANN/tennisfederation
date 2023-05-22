<?php

namespace App\Controller;

use App\Form\PlayerType;
use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PlayerController extends AbstractController
{
    /**
     * @Route("/Admin/Player", name="app_player")
     */
    public function index(): Response
    {
        $players = $this->getDoctrine()->getManager()->getRepository(Player::class)->findAll();
        return $this->render('player/index.html.twig', [
          'p'=>$players
        ]);
    }

     /**
     * @Route("/addPlayer", name="app_addplayer")
     */
    public function addPlayer(Request $request): Response
    {
        $player = new Player();

        $form = $this->createForm(PlayerType::class,$player);

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
                       $this->getParameter('player_images_directory'),
                       $newFilename
                   );
               } catch (FileException $e) {
                   // handle exception if something happens during file upload
               }
           
               // update the Player entity with the new image path
               $player->setImage($newFilename);
             }
            $em = $this->getDoctrine()->getManager();
            $em->persist($player); //add
            $em->flush();

            return $this->redirectToRoute('app_player');
        }
        return $this->render('player/createPlayer.html.twig',['f'=>$form->createView()]);
    }

    /**
     * @Route("/supPlayer/{id}", name="app_supplayer")
     */
    public function suppressionPlayer(Player $player): Response
{
    $em = $this->getDoctrine()->getManager();
    $imageFilename = $player->getImageFilename();

    if ($imageFilename) {
        $imagePath = $this->getParameter('uploads/player_images').'/'.$imageFilename;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $em->remove($player);
    $em->flush();

    return $this->redirectToRoute('app_player');
}

    

    /**
     * @Route("/modPlayer/{id}", name="app_modplayer")
     */
    public function modPlayer(Request $request,$id): Response
    {
        $player = $this->getDoctrine()->getManager()->getRepository(Player::class)->find($id);

        $form = $this->createForm(PlayerType::class,$player);

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
                        $this->getParameter('player_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }
            
                // update the Player entity with the new image path
                $player->setImage($newFilename);
              }
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_player');
        }
        return $this->render('player/updatePlayer.html.twig',['f'=>$form->createView()]);
    }


     
}
