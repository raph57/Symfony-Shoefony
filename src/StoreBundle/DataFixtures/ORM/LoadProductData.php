<?php
// src/Shoefony/StoreBundle/DataFixtures/ORM/LoadProductData.php

namespace Shoefony\StoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use StoreBundle\Entity\Brand;
use StoreBundle\Entity\Product;
use StoreBundle\Entity\Image;

class LoadProductData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {       
        $brand1 = new Brand();
        $brand1->setTitle("Adidas");
        
        $brand2 = new Brand();
        $brand2->setTitle("Nike");
        
        $brand3 = new Brand();
        $brand3->setTitle("Puma");
        
        $manager->persist($brand1);
        $manager->persist($brand2);
        $manager->persist($brand3);
        
        $manager->flush();
        
        for ($i = 1; $i <= 14; $i++) {
            $product = new Product();
            $product->setTitle('Produit '.$i);
            $product->setDescription('Ceci est la description de mon produit '.$i.'.');
            $product->setLongDescription('Ceci est la description longue de mon produit '.$i.'.');
            $product->setPrice(mt_rand(70, 150));
            
            $image = new Image();
            $image->setUrl("shoe-" . $i . ".jpg");
            $image->setAlt($product->getTitle());
            
            $product->setImage($image);
            
            if ($i >= 1 && $i < 5) {
                $product->setBrand($brand1);
            } elseif ($i >= 5 && $i < 10) {
                $product->setBrand($brand2);
            } else {
                $product->setBrand($brand3);
            }

            $manager->persist($image);
            $manager->persist($product);
        }
        
        $manager->flush();
    }
}

