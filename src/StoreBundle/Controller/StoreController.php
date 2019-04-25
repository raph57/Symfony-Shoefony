<?php

namespace StoreBundle\Controller;

use StoreBundle\Entity\Opinion;
use StoreBundle\Form\OpinionType;
use StoreBundle\Form\ProductSearchType;
use StoreBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use StoreBundle\Entity\Product;

class StoreController extends Controller
{

    /**
     * @Route("/products", name="store_products")
     * @Route("/products/brand/{id}/{slug}", name="store_products_by_brand")
     * @param null $id
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productsAction($id = null, $slug = null, $page = 1, Request $request, $col = null)
    {

        /**
         * pagination pour afficher dès que l'on clique sur nos produits
         */

        $em = $this->getDoctrine()->getManager();
        if ($id == null) {

            $dql = "SELECT p FROM StoreBundle:Product p";
            $products = $em->createQuery($dql);
            $brandName = "Toutes les marques";

            $pagination = $this->paginate($page, $products, $request, 'store_products_page');


        } else {
            $repository = $em->getRepository("StoreBundle:Brand");
            $brand = $repository->findOneById($id);
            $brandName = $brand->getTitle();
            $products = $brand->getProducts();

            $pagination = $this->paginate($page, $products, $request, 'store_products_by_brand_page');


        }

        return $this->render('store/products.html.twig', array(
            'products' => $pagination,
            'brandName' => $brandName,

            //  'id' => $id,


        ));
    }


    /**
     * @Route("/products/page/{page}", name="store_products_page")
     * @Route("/products/brand/{id}/{slug}/page/{page}", name="store_products_by_brand_page", defaults={"page":1})
     * @param null $id
     * @param null $slug
     * @param null $page
     * @param null $col
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paginationAction($id = null, $slug = null, $page, $col = null, Request $request)
    {

        /* méthode qui est appelée quand on clique sur une des pages (1 2 3  etc ) au chargement de la route */
        $em = $this->getDoctrine()->getManager();

        if ($id == null) {

            $dql = "SELECT p FROM StoreBundle:Product p";
            $products = $em->createQuery($dql);

            $brandName = "Toutes les marques";

            $pagination = $this->paginate($page, $products, $request, 'store_products_page');


        } else {
            $repository = $em->getRepository("StoreBundle:Brand");
            $brand = $repository->findOneById($id);
            $brandName = $brand->getTitle();
            $products = $brand->getProducts();

            $pagination = $this->paginate($page, $products, $request, 'store_products_by_brand_page');
        }

        return $this->render('store/products.html.twig', array(
            'products' => $pagination,
            'col' => $col,
            'brandName' => $brandName
        ));

    }


    /**
     * @Route("/product/{id}/details/{slug}", requirements={"id" = "\d+"}, name="store_product")
     */
    public function productAction($id, $slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('StoreBundle:Product')->find($id);

        if (null === $product) {
            throw $this->createNotFoundException("Le produit d'id " . $id . " n'existe pas.");
        }


        $comm = new Opinion();
        //$comm->setProducts($product);
        $form = $this->createForm(new OpinionType(), $comm);

        if (null === $product) {
            throw $this->createNotFoundException("Le produit d'id " . $id . " n'existe pas.");
        }
        /** cas du formulaire */
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $this->get('session')->getFlashBag()->add('notice', "Merci, votre commentaire a bien été pris en compte !");
                $comm->setProducts($product);
                $em->persist($product);
                $em->persist($comm);
                $em->flush();
                // Redirection afin d'éviter le "re-posting"
                return $this->redirect($this->generateUrl('store_product',
                    array(
                        'id' => $id,
                        'slug' => $slug

                    )
                )
                );
            }
        }
        // fin form
        // On récupère la liste
        $opinions = $em
            ->getRepository('StoreBundle:Opinion')
            ->findBy(array('products' => $product));

        //  $form = $this->createForm(new OpinionType(), $opinions);
        return $this->render('store/product.html.twig', array(
            'product' => $product,
            /* 'form' => $form->createView()*/
            'comments' => $opinions,
            'form' => $form->createView()
        ));
    }

    public function brandsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $brands = $em->getRepository('StoreBundle:Brand')->findAll();
        $url = explode("/", $_SERVER['REQUEST_URI']);

        return $this->render('store/partial/_brands.html.twig', array(
            'brands' => $brands,
            'url' => end($url)
        ));
    }

    /**
     * @param $page
     * @param $entite
     * @param $request
     * @param $route
     * @return mixed
     */
    public function paginate($page, $entite, $request, $route)
    {

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entite,
            $request->query->get('page', $page),
            3
        );
        $pagination->setUsedRoute($route);

        return $pagination;
    }

}
