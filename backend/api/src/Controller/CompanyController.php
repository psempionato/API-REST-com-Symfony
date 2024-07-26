<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompanyController extends AbstractController
{

    public function __construct(
        protected EntityManagerInterface $em,
        protected CompanyRepository $companyRepository,
        protected PartnerRepository $partnerRepository,
        protected SerializerInterface $serializer
    )
    {}

    #[Route('/api/companies', name: 'create_company', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        try {

            $company = new Company();
            $company->setLegalName($data['legal_name']);
            $company->setTradeName($data['trade_name']);
            $company->setCnpj($data['cnpj']);
            $company->setAddress($data['address']);
            $company->setPhone($data['phone']);
            $company->setEmail($data['email']);

            $partner = $this->partnerRepository->getById((int)$data['partner']);

            if($partner){
                $company->addPartner($partner);
            }
            
            $this->em->persist($company);
            $this->em->flush();

            return new JsonResponse(['success' => 'Compnay created successfuly!'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/companies', name: 'get_all_companies', methods: 'GET')]
    public function getAll(): JsonResponse
    {
        $companies = $this->companyRepository->getAll();
        if($companies){
            $data = [];

            foreach ($companies as $company) {
                $partners = [];

                foreach($company->getPartners() as $partner){
                    $partners[] = [
                        "id" => $partner->getId(),
                        "name" => $partner->getName(),
                        "cpf" => $partner->getCpf()
                    ];
                }

                $data[] = [
                    'id' => $company->getId(),
                    'legal_name' => $company->getLegalName(),
                    'trade_name' => $company->getTradeName(),
                    'cnpj' => $company->getCnpj(),
                    'address' => $company->getAddress(),
                    'phone' => $company->getPhone(),
                    'email' => $company->getEmail(),
                    'partners' => $partners
                ];
            }
            return new JsonResponse(['message' => 'success', 'data' => $data], Response::HTTP_OK);
        }
        return new JsonResponse(['message' => 'There are no registered companies'], Response::HTTP_OK);
    }

    #[Route('/api/companies/{id}', name: 'get_company', methods: 'GET')]
    public function getById(int $id): JsonResponse
    {
        $company = $this->companyRepository->getById($id);
        if($company){
            $company = (object)$company;
                $partners = [];

                foreach($company->getPartners() as $partner){
                    $partners[] = [
                        "id" => $partner->getId(),
                        "name" => $partner->getName(),
                        "cpf" => $partner->getCpf()
                    ];
                }

                $data = [
                    'id' => $company->getId(),
                    'legal_name' => $company->getLegalName(),
                    'trade_name' => $company->getTradeName(),
                    'cnpj' => $company->getCnpj(),
                    'address' => $company->getAddress(),
                    'phone' => $company->getPhone(),
                    'email' => $company->getEmail(),
                    'partners' => $partners
                ];
            return new JsonResponse(['message' => 'success', 'data' => $data], Response::HTTP_OK);
        }
        return new JsonResponse(['message' => 'Company not found'], Response::HTTP_OK);
    }
    
    #[Route('/api/companies/{id}', name: 'update_company', methods: 'PUT')]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!$data) {
                return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
            }

            $company = $this->companyRepository->getById($id);
            if(!$company){
                return new JsonResponse(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
            }
            $company = (object)$company;
            $company->setLegalName($data['legal_name'] ?? $company->getLegalName());
            $company->setTradeName($data['trade_name'] ?? $company->getTradeName());
            $company->setCnpj($data['cnpj'] ?? $company->getCnpj());
            $company->setAddress($data['address'] ?? $company->getAddress());
            $company->setPhone($data['phone'] ?? $company->getPhone());
            $company->setEmail($data['email'] ?? $company->getEmail());

            $this->em->flush();

            return new JsonResponse(['success' => 'Company updated successfully!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/companies/{id}', name: 'delete_company', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $company = $this->companyRepository->getById($id);

        if(!$company){
            return new JsonResponse(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }
        try {
            $company = (object)$company;  
            $this->em->remove($company);
            $this->em->flush();

            return new JsonResponse(['success' => 'Company deleted successfully!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
