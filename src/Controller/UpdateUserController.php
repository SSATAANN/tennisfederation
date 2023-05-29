<?php
namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UpdateUserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/update/user", name="app_update_user")
     */
    public function index(): Response
    {
        return $this->render('update_user/index.html.twig', [
            'controller_name' => 'UpdateUserController',
        ]);
    }

    /**
     * @Route("/profile/update", name="profile_update")
     */
    public function updateProfileFan(Request $request): Response
    {
        $user = $this->getUser();

        // Create the form and handle the request
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle the image upload if a new image was selected
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('user_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle the exception if the file cannot be moved
                }

                $user->setImage($newFilename);
            }

            // Encode the new user's password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_VISITOR']);

            // Exclude the UploadedFile from serialization
            $user->setImageFile(null);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('Client');
        }

        return $this->render('update_user/update_profile.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    /**
 * @Route("/profile/update/referee", name="profile_update_referee")
 */
public function updateProfileReferee(Request $request): Response
{
    $user = $this->getUser();

    // Create the form and handle the request
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle the image upload if a new image was selected
        /** @var UploadedFile $imageFile */
        $imageFile = $form->get('imageFile')->getData();
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('user_images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle the exception if the file cannot be moved
            }

            $user->setImage($newFilename);
        }

        // Encode the new user's password
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setRoles(['ROLE_REFEREE']);

        // Exclude the UploadedFile from serialization
        $user->setImageFile(null);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('app_referee_client');
    }

    return $this->render('update_user/update_profile.html.twig', [
        'f' => $form->createView(),
    ]);
}
 /**
 * @Route("/profile/update/player", name="profile_update_player")
 */
public function updateProfilePlayer(Request $request): Response
{
    $user = $this->getUser();

    // Create the form and handle the request
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle the image upload if a new image was selected
        /** @var UploadedFile $imageFile */
        $imageFile = $form->get('imageFile')->getData();
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('user_images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle the exception if the file cannot be moved
            }

            $user->setImage($newFilename);
        }

        // Encode the new user's password
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setRoles(['ROLE_PLAYER']);

        // Exclude the UploadedFile from serialization
        $user->setImageFile(null);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('app_player_client');
    }

    return $this->render('update_user/update_profile.html.twig', [
        'f' => $form->createView(),
    ]);
}

}
