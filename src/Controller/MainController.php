<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main", methods={"GET", "POST"})
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return Response
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/date", name="get_date", methods={"POST"})
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return Response
     */
    public function getByDate(ProductRepository $productRepository, Request $request): Response
    {
        $date = $request->request->get('date');
        if (!empty($date)) {
            if ($date == 'today' || $date == 'yesterday') {
                $date = date('Y-m-d', strtotime($date));
                $from = $date.' 00:00:00';
                $to = $date.' 23:59:59';
            } else if ($date == 'week') {
                $monday = strtotime('last monday') - 3600*24*7;
                $sunday = $monday + 3600*24*6;
                $from = date('Y-m-d', $monday).' 00:00:00';
                $to = date('Y-m-d', $sunday).' 23:59:59';
            }

            $date = $productRepository->findByTimeInterval($from, $to);

            return $this->render('main/_form.html.twig', [
                'products' => $date,
            ]);
        }

        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('main');
    }
}
