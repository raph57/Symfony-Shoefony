<?php
// src/Shoefony/StoreBundle/DataFixtures/ORM/LoadProductData.php

namespace Shoefony\StoreBundle\DataFixtures\ORM;

use AppBundle\Entity\Slide;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use StoreBundle\Entity\Image;

class LoadSlideData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $image = new Image();
        $image->setUrl("slide-1.jpg");
        $image->setAlt("Slide 1");


        $image2 = new Image();
        $image2->setUrl("slide-2.jpg");
        $image2->setAlt("Slide 2");

        $slide = new Slide();
        $slide->setImage($image);

        $slide2 = new Slide();
        $slide2->setImage($image2);
        // ...
        $manager->persist($slide);
        $manager->persist($slide2);
        // repeat over and over...

        $manager->flush();

    }
}

