<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Form\UserDataFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    #[IsGranted('ROLE_USER')]
    public function index(UserRepository $userRepository): Response
    {
        $identifier = $this->getUser()->getUserIdentifier();
        $user = $userRepository->findOneBy(['email' => $identifier]);

        return $this->render('profil/informations.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profil/update', name: 'app_update', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function update(Request $request, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $identifier = $this->getUser()->getUserIdentifier();
        $user = $userRepository->findOneBy(['email' => $identifier]);

        $user->setUsername($request->request->get('username'));
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setEmail($request->request->get('email'));
        $user->setPhonenumber($request->request->get('phonenumber'));
    
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_profil');
    }

    #[Route('/profil/delete', name: 'app_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        try {
            $identifier = $this->getUser()->getUserIdentifier();
            $user = $userRepository->findOneBy(['email' => $identifier]);

            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ]);
            }

            // Supprimer les références à l'utilisateur dans SecurityToken
            $this->container->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();

            $em->remove($user);
            $em->flush();
            $this->addFlash('Success', "Votre compte à bien été supprimer");
            return new JsonResponse([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }

    #[Route('/profil/favorites', name: 'app_favorites')]
    #[IsGranted('ROLE_USER')]
    public function favorites(UserRepository $userRepository): Response
    {
        $identifier = $this->getUser()->getUserIdentifier();
        $user = $userRepository->findOneBy(['email' => $identifier]);

        $stations = $user->getFavoriteStations()->toArray();

        return $this->render('profil/favorites.html.twig', [
            'stations' => $stations,
        ]);
    }
}
