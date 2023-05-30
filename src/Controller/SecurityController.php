<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\ForgotPasswordType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="app_security")
     */
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
            
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): RedirectResponse
    {
       return $this->redirectToRoute('app_login');
    }
    
    /**
 * @Route("/Login/forgot", name="forgot")
 */
public function forgotPassword(Request $request, UserRepository $userRepository, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator)
{
    $form = $this->createForm(ForgotPasswordType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $email = $data['email'];

        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $this->addFlash('danger', 'This email address does not exist');
            return $this->redirectToRoute('forgot');
        }

        $token = $tokenGenerator->generateToken();
        $user->setResetToken($token);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new Email())
            ->from('mhamdiamenallah666@gmail.com') // Replace with your desired sender email address
            ->to($email)
            ->subject('Password Reset')
            
            ->html("<div style='background-color: #e02a6a; color: #fff; padding: 20px;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                   
                    </div>
                    <div style='text-align: center; margin-bottom: 20px;'>
                    <div style='color: #fff;'>
                    Dear <h1><a style='color: #fff;text-decoration: none;'>{$email}</a></h1>
                    </div>
                    <p>We have received a password reset request for your account. To reset your password, please click the button below:</p>
                    <p><a href='{$url}' style='background-color: #000; color: #fff; padding: 10px 20px; text-decoration: none;'>Reset Password</a></p>
                    <p>If you did not request a password reset, please ignore this email. Your account remains secure.</p>
                    <p>Thank you,</p>
                    <p>The Cool As Code Team</p>
                    </div>
                </div>");

        $mailer->send($email);

        $this->addFlash('message', 'Password reset email sent.');
        return $this->redirectToRoute('app_login');
    }

    return $this->render('security/forgotPassword.html.twig', ['form' => $form->createView()]);
}

    /**
 * @Route("/Login/resetpassword/{token}", name="app_reset_password")
 */
public function resetpassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
{
    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

    if ($user == null) {
        $this->addFlash('danger', 'TOKEN UNKOWN');
        return $this->redirectToRoute("app_login");
    }

    if ($request->isMethod('POST')) {
        $user->setResetToken(null);

        $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
        $entityManger = $this->getDoctrine()->getManager();
        $entityManger->persist($user);
        $entityManger->flush();

        $this->addFlash('message', 'password updated :');
        return $this->redirectToRoute("app_login");
    } else {
        return $this->render("security/resetPassword.html.twig", ['token' => $token]);
    }
}
}
