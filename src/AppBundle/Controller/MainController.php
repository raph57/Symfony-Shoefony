<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;

use StoreBundle\Entity\Product;
use StoreBundle\Form\SearchType;

class MainController extends Controller
{
    /**
     * @Route("/", name="cms_homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lastProducts = $em->getRepository('StoreBundle:Product')->findLastProducts(4);

        return $this->render('app/index.html.twig', array(
            'products' => $lastProducts
        ));
    }

    /**
     * @Route("/search", name="cms_search")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $search = null;
        $productSearch = null;

        if ($request->getMethod() == 'POST') {

            $productName = $request->get('searchProducts');
            $search = $em->getRepository('StoreBundle:Product')->findByWord($productName);
            $productSearch = $this->paginate(1, $search, $request, 'store_products_page');

        }

        return $this->render('store/products.html.twig', array(
            'products' => $productSearch
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


    public function productsFamousDisplayAction($col)
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("StoreBundle:Product")->findFamousProducts(4);

        return $this->render('store/partial/_famousProducts.html.twig', array(
            'famousProducts' => $products,
            'col' => $col
        ));
    }

    public function slidesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $slides = $em->getRepository("AppBundle:Slide")->findAll();


        return $this->render('app/partial/_slide.html.twig', array(
            'slides' => $slides,
        ));

    }


    /**
     * @Route("/presentation", name="cms_presentation")
     */
    public function presentationAction(Request $request)
    {
        return $this->render('app/presentation.html.twig');
    }

    /**
     * @Route("/contact", name="cms_contact")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

                // Actions à effectuer après validation du formulaire
                $this->get('session')->getFlashBag()->add('notice', "Merci, votre message a bien été pris en compte !");

                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Nouvelle demande de contact')
                    ->setFrom('contact@shoefony.fr')
                    ->setTo('administrateur@shoefony.fr')
                    ->setContentType("text/html")
                    ->setBody($this->renderView('app/mail/contact.html.twig', array('contact' => $contact)));
                $this->get('mailer')->send($message);

                // Redirection afin d'éviter le "re-posting"
                return $this->redirect($this->generateUrl('cms_contact'));
            }
        }

        return $this->render('app/contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
