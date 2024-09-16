<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{
    #[Route('/customers', name: 'customers.index', methods: ['GET'])]
    public function index(CustomerRepository $repository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $customers = $repository->paginateCustomers($page);
        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
        ]);
    }

    #[Route('customers/create', name: 'customers.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $em->persist($customer);
            $em->flush();
            $this->addFlash('success', 'Customer created.');
            return $this->redirectToRoute('customers.index');
        }
        return $this->render('customer/create.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/customers/{id}/edit', name: 'customers.edit', methods: ['GET', 'POST'])]
    public function edit(Customer $customer, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Customer updated.');
            return $this->redirectToRoute('customers.index');
        }
        return $this->render('customer/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/customers/{id}', name: 'customers.delete', methods: ['DELETE'])]
    public function delete(string $id, EntityManagerInterface $em): Response
    {
        $customer = $em->getRepository(Customer::class)->find($id);
        if($customer){
            $em->remove($customer);
            $em->flush();

            $this->addFlash('success', 'Customer deleted.');
//        return $this->redirectToRoute('customers.index');
            return new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);


    }

}
