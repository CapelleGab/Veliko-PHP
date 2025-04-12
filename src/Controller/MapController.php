<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use App\Service\FavoriteService;

final class MapController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/api/stations', name: 'api_stations')]
    public function getAllStations(): Response
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://opendata.paris.fr/api/records/1.0/search/?dataset=velib-disponibilite-en-temps-reel&rows=1471');
        return $this->json($response->toArray());
    }

    #[Route('/api/stations/add/{stationId}', name: 'api_newfavorite', methods: ['POST'])]
    public function addStationToUserFavorite(
        Request $request,
        string $stationId,
        FavoriteService $favoriteService
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return $this->json([
                'message' => 'User not authenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $stationData = $request->toArray();
        $message = $favoriteService->addStationToFavorites($user, $stationId, $stationData);

        return $this->json([
            'message' => $message,
        ], $message === 'Station added to favorites' ? Response::HTTP_CREATED : Response::HTTP_OK);
    }

    #[Route('/api/stations/remove/{stationId}', name: 'api_removefavorite', methods: ['POST'])]
    public function removeStationFromUserFavorite(
        string $stationId,
        FavoriteService $favoriteService
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return $this->json([
                'message' => 'User not authenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $message = $favoriteService->removeStationFromFavorites($user, $stationId);

        return $this->json([
            'message' => $message,
        ], $message === 'Station removed from favorites' ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
}