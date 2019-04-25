<?php

namespace StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="StoreBundle\Entity\Repository\ProductRepository")
 * @ORM\Table(name="product")
 */
class Product
{   
   
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;
    
    /**
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;
    
    /**
     * @ORM\Column(name="long_description", type="text")
     */
    private $longDescription;
    
    /**
     * @ORM\Column(name="price", type="decimal", scale=2, nullable=false)
     */
    private $price;
    
    /**
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;
    
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    
     /**
     * @ORM\OneToOne(targetEntity="StoreBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="StoreBundle\Entity\Brand", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;


    /**
     *
     * @ORM\OneToMany(targetEntity="StoreBundle\Entity\Opinion", mappedBy="products")
     */
    private $comments;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function setCommentaire(Opinion $commentaire)
    {
        $this->comments[] = $commentaire;
    }

    public function getComments()
    {
        return $this->comments;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
        self::setSlug($title);
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    
    function getCreatedAt() {
        return $this->createdAt;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * Set longDescription
     *
     * @param string $longDescription
     *
     * @return Product
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Get longDescription
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = self::slugify($slug, '-');

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
    
    /**
     * Set image
     *
     * @param \StoreBundle\Entity\Image $image
     *
     * @return Product
     */
    public function setImage(\StoreBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \StoreBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set brand
     *
     * @param \StoreBundle\Entity\Brand $brand
     *
     * @return Product
     */
    public function setBrand(\StoreBundle\Entity\Brand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \StoreBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

}
