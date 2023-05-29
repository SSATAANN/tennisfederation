<?php

namespace App\Controller;

use App\Form\PlayerType;
use App\Entity\Player;
use App\Entity\User; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class PlayerController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
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
     * @Route("/Admin/addPlayer", name="app_addplayer")
     */
    public function addPlayer(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $player = new Player();

        $form = $this->createForm(PlayerType::class, $player);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            //add user with player 
            $playerUser = new User();
            $playerUser->setEmail($player->getEmail());
            $playerUser->setRoles(['ROLE_PLAYER']);
            $playerUser->setName($player->getFirstName()); 
            $playerUser->setGender($player->getGender()); 
            $playerUser->setPassword(
                $passwordEncoder->encodePassword($playerUser, $player-> getPassword())
            );
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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($playerUser);
            $entityManager->flush();

            $player->setUser($playerUser);

            $entityManager->persist($player); // Add the player to the player table
            $entityManager->flush();
    

            return $this->redirectToRoute('app_player');
        }

        return $this->render('player/createPlayer.html.twig', ['f' => $form->createView()]);
    }

    /**
     * @Route("/Admin/supPlayer/{id}", name="app_supplayer")
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
 * @Route("/Admin/modPlayer/{id}", name="app_modplayer")
 */
public function modPlayer(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder): Response
{
    $player = $this->getDoctrine()->getManager()->getRepository(Player::class)->find($id);

    $form = $this->createForm(PlayerType::class, $player);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Update the player's email and password
        $user = $player->getUser();
        $user->setEmail($form->get('email')->getData());

        $plainPassword = $form->get('password')->getData();
        if (!empty($plainPassword)) {
            // Encrypt the new password
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
        }

        // Handle the uploaded image file
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

            // Update the Player entity with the new image path
            $player->setImage($newFilename);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('app_player');
    }

    return $this->render('player/updatePlayer.html.twig', ['f' => $form->createView()]);
}



     
}
