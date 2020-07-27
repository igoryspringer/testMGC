<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use DateTime;
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

        $date = date('Y-m-d');
        $from = $date.' 00:00:00';
        $to = $date.' 23:59:59';
        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'products' => $productRepository->findByTimeInterval($from, $to),
            'date' => DateTime::createFromFormat('Y-m-d H:i:s', $from)->format('d M, Y'),
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
                $monday = strtotime('monday');
                $sunday = $monday + 3600*24*6;
                $from = date('Y-m-d', $monday).' 00:00:00';
                $to = date('Y-m-d', $sunday).' 23:59:59';

            } else {
                $date = date('Y-m-d', strtotime($date));
                $from = $date.' 00:00:00';
                $to = $date.' 23:59:59';
            }

            return $this->render('main/_data.html.twig', [
                'products' => $productRepository->findByTimeInterval($from, $to),
                'date' => DateTime::createFromFormat('Y-m-d H:i:s', $from)->format('d M, Y..'),
            ]);
        }

        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/del", name="products_delete", methods={"POST", "DELETE"})
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return Response
     */
    public function delete(ProductRepository $productRepository, Request $request): Response
    {
        $id = $request->request->get('delete');
        $date = $request->request->get('date');

        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();

        $newdate = DateTime::createFromFormat('d M, Y', $date)->format('Y-m-d');
        $from = $newdate.' 00:00:00';
        $to = $newdate.' 23:59:59';
        return $this->render('main/_data.html.twig', [
            'products' => $productRepository->findByTimeInterval($from, $to),
            'date' => $date,
        ]);
    }
}
