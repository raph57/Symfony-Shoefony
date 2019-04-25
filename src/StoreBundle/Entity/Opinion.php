<?php

namespace StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Opinion
 *
 * @ORM\Table(name="opinion")
 * @ORM\Entity(repositoryClass="StoreBundle\Repository\OpinionRepository")
 */
class Opinion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Votre message doit être composé d'au moins {{ limit }} caractères",
     * )
     */
    private $comment;

    /**
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="StoreBundle\Entity\Product", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $products;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->products = new ArrayCollection();

    }


    /**
     * Add products
     *
     * @param \StoreBundle\Entity\Product $products
     * @return Opinion
     */
    public function addProduct(Product $products)
    {
        $this->products[] = $products;

        return $this;
    }


    public function setProducts(Product $products)
    {
        $this->products = $products;

        return $this;
    }


    public function getProducts()
    {
        return $this->products;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Opinion
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }


    public function getDate()
    {
        return $this->date;
    }

    public function setDate()
    {
        return $this->date;
    }


    /**
     * Set comment
     *
     * @param string $comment
     * @return Opinion
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
