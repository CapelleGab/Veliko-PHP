<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security,
        EntityManagerInterface $entityManager, JWTService $jwt, MailService $mail): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setIsVerified(false);
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt($user->getCreatedAt());

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $header = [
                "typ" => "JWT",
                "alg" => "HS256",
            ];
            $payload = [
                'userID' => $user->getId(),
            ];

            // Puis on génère le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
            
            $mail->send(
                'no-replay@veliko.com',
                $user->getEmail(),
                'Veliko - Confirmation de votre compte',
                'emailVerification.html.twig',
                [
                    'user' => $user,
                    'token' => $token,
                ]
            );
            $this->addFlash('success', 'Un email de confirmation a été envoyé à votre adresse email.');

            return $security->login($user, UsersAuthenticator::class, 'main');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verifUser/{token}', name: 'app_verifUser')]
    public function verifUser(
        string $token, JWTService $jwt, UserRepository $user, EntityManagerInterface $em): Response
    {
        // Verifier si le token est valide (cohérent, pas expiré, signature valide)
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            // Le token est valide, on peut l'utiliser
            $payload = $jwt->getPayload($token);

            // On récupère l'utilisateur correspondant à l'ID dans le payload
            $user = $user->find($payload['userID']);

            // On verifie qu'on a bien un user et qu'il n'est pas déjà vérifié
            if($user && !$user->isVerified()) {
                $user->setIsVerified(true);
                $user->setRoles(['ROLE_USER', 'ROLE_VERIFIED']);
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Votre compte a bien été vérifié !');
                return $this->redirectToRoute('app_home');
            } 
        }
        $this->addFlash('error', 'Le token est invalide ou a expiré.');
        return $this->redirectToRoute('app_login');
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_home');
         }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
