<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Address;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/customers', name: 'api_customers')]
class ApiController extends AbstractController
{
    #[Route('/', name: 'all_customers')]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $customers = $doctrine->getRepository(Customer::class)->findAll();

        // $data = [];
        // foreach ($products as $product) {
        //    $data[] = [
        //        'id' => $product->getId(),
        //        'name' => $product->getName(),
        //        'price' => $product->getPrice(),
        //        'description' => $product->getDescription(),
        //    ];
        // }
 
        return $this->json($customers);
    }

    #[Route('/add', name: 'add_customer', methods: ["POST"])]
    public function createProduct(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();

        $address = $doctrine->getRepository(Address::class)->find($data["address"]);
        if (!$address) {
            return new JsonResponse(
                ['status' => 'error', 'message' => 'No address found for id '.$data["address"]], 
                Response::HTTP_NOT_FOUND
            );
        }

        $customer = new Customer();
        $customer->setName($data["name"]);
        $customer->setSurname($data["surname"]);
        $customer->setEmail($data["email"]);
        $customer->setPhone($data["phone"]);
        $customer->setAddress($address);

        $entityManager->persist($customer);
        $entityManager->flush();

        return new JsonResponse(
            ['status' => 'success', 'message' => 'Customer created!'], 
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'customer_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $customer = $doctrine->getRepository(Customer::class)->find($id);

        if (!$customer) {
            return new JsonResponse(
                ['status' => 'error', 'message' => 'No customer found for id '.$id], 
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json($customer);
    }

    #[Route('/edit/{id}', name: 'customer_edit', methods: ["POST"])]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();
        $customer = $entityManager->getRepository(Customer::class)->find($id);

        if (!$customer) {
            return new JsonResponse(
                ['status' => 'error', 'message' => 'No customer found for id '.$id], 
                Response::HTTP_NOT_FOUND
            );
        }

        $address = $doctrine->getRepository(Address::class)->find($data["address"]);
        if (!$address) {
            return new JsonResponse(
                ['status' => 'error', 'message' => 'No address found for id '.$data["address"]], 
                Response::HTTP_NOT_FOUND
            );
        }

        $customer->setName($data["name"]);
        $customer->setSurname($data["surname"]);
        $customer->setEmail($data["email"]);
        $customer->setPhone($data["phone"]);
        $customer->setAddress($address);

        $entityManager->flush();

        return $this->redirectToRoute('api_customerscustomer_show', [
            'id' => $customer->getId()
        ]);
    }
    
    #[Route('/del/{id}', name: 'customer_delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $customer = $entityManager->getRepository(Customer::class)->find($id);

        if (!$customer) {
            return new JsonResponse(
                ['status' => 'error', 'message' => 'No customer found for id '.$id], 
                Response::HTTP_NOT_FOUND
            );
        }

        $entityManager->remove($customer);
        $entityManager->flush();

        return new JsonResponse(
            ['status' => 'success', 'message' => 'Customer deleted!'], 
            Response::HTTP_CREATED
        );
    }
}
