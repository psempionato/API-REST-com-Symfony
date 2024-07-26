<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartnerController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected PartnerRepository $partnerRepository
    ){}

    #[Route('/api/partners', name: 'create_partner', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        try {

            $partner = new Partner();
            $partner->setName($data['name']);
            $partner->setCpf($data['cpf']);

            $this->em->persist($partner);
            $this->em->flush();

            return new JsonResponse(['success' => 'Partner created successfuly!'], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse();
    }

    #[Route('/api/partners', name: 'get_all_partners', methods: 'GET')]
    public function getAll(): JsonResponse
    {
        $partners = $this->partnerRepository->getAll();
        if($partners){
            $data = [];

            foreach ($partners as $partner) {
                $partners = [];

                $data[] = [
                    'id' => $partner->getId(),
                    'name' => $partner->getName(),
                    'cpf' => $partner->getCpf(),
                ];
            }
            return new JsonResponse(['message' => 'success', 'data' => $data], Response::HTTP_OK);
        }
        return new JsonResponse(['message' => 'There are no registered partners'], Response::HTTP_OK);
    }

    #[Route('/api/partners/{id}', name: 'get_partner', methods: 'GET')]
    public function getById(int $id): JsonResponse
    {
        $partner = $this->partnerRepository->getById($id);
        if($partner){
            $partner = (object)$partner;

            $data = [
                'id' => $partner->getId(),
                'name' => $partner->getName(),
                'cpf' => $partner->getCpf(),
            ];
            return new JsonResponse(['message' => 'success', 'data' => $data], Response::HTTP_OK);
        }
        return new JsonResponse(['message' => 'Partner not found'], Response::HTTP_OK);
    }

    #[Route('/api/partners/{id}', name: 'update_partner', methods: 'PUT')]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!$data) {
                return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
            }

            $partner = $this->partnerRepository->getById($id);
            if(!$partner){
                return new JsonResponse(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
            }
            $partner = (object)$partner;
            $partner->setName($data['name'] ?? $partner->getName());
            $partner->setCpf($data['cpf'] ?? $partner->getCpf());

            $this->em->flush();

            return new JsonResponse(['success' => 'Partner updated successfully!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/partners/{id}', name: 'delete_partner', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $partner = $this->partnerRepository->getById($id);

        if(!$partner){
            return new JsonResponse(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        try {
            $partner = (object)$partner;
            $this->em->remove($partner);
            $this->em->flush();

            return new JsonResponse(['success' => 'Partner deleted successfully!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
