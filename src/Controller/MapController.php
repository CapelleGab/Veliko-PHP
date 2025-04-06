<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;

final class MapController extends AbstractController
{

    #[Route('/api/stations', name: 'api_stations')]
    public function getAllStations(): Response
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://opendata.paris.fr/api/records/1.0/search/?dataset=velib-disponibilite-en-temps-reel&rows=1471');
        return $this->json($response->toArray());
    }

}
