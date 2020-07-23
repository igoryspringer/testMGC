<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/main/date/{date}", name="main")
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return Response
     */
    public function getByDate(ProductRepository $productRepository, Request $request): Response
    {
        $date = $request->query->get('date');
        if (isset($date)) {

        }

        return $this->render('main/index.html.twig', [
            'products' => $products,
        ]);
    }
}
