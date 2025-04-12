<?php
namespace App\Service;

use App\Entity\Station;
use App\Entity\User;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;

class FavoriteService
{
    public function __construct(
        private StationRepository $stationRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function addStationToFavorites(User $user, string $stationId, array $stationData): string
    {
        // Vérifier si la station existe déjà
        $station = $this->stationRepository->findOneBy(['stationCode' => $stationId]);
        if (!$station) {
            $station = (new Station())
                ->setStationCode($stationId)
                ->setName($stationData['name'] ?? 'Unknown')
                ->setLongitude($stationData['coordonnees_geo'][0] ?? 0.0)
                ->setLatitude($stationData['coordonnees_geo'][1] ?? 0.0)
                ->setNumDockAvailable($stationData['numdocksavailable'] ?? null)
                ->setNumBikesAvailable($stationData['numbikesavailable'] ?? null)
                ->setNbMechanicalBike($stationData['mechanical'] ?? null)
                ->setNbEBikes($stationData['ebike'] ?? null)
                ->setDueDate($stationData['duedate'] ?? null);

            $this->entityManager->persist($station);
        }

        if ($user->getFavoriteStations()->contains($station)) {
            return 'Station already in favorites';
        }

        $user->addFavoriteStation($station);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return 'Station added to favorites';
    }

    public function removeStationFromFavorites(User $user, string $stationId): string
    {
        $station = $this->stationRepository->findOneBy(['stationCode' => $stationId]);

        if (!$station || !$user->getFavoriteStations()->contains($station)) {
            return 'Station not found in favorites';
        }

        $user->removeFavoriteStation($station);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return 'Station removed from favorites';
    }
}