<?php


namespace Shoefony\StoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use StoreBundle\Entity\Brand;
use StoreBundle\Entity\Opinion;
use StoreBundle\Entity\Product;
use StoreBundle\Entity\Image;

class LoadOpinionData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

    }
}

