<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="years", type="integer")
     */
    private $years;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/[0-9 ]+$/",
     *     message="veuillez rentrer un chiffre"
     * )
     *
     * @ORM\Column(name="miles", type="string")
     */
    private $miles;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="energy", type="text")
     */
    private $energy;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/[0-9 \,]+$/",
     *     message="veuillez rentrer un chiffre"
     * )
     *
     * @ORM\Column(name="price", type="string")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="mainPicture", type="string", length=255,nullable=true)
     */
    private $mainPicture;

    /**
     * @var array
     *
     * @ORM\Column(name="galleryPicture", type="array", nullable=true)
     */
    private $galleryPicture;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set years.
     *
     * @param int $years
     *
     * @return Article
     */
    public function setYears($years)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Get years.
     *
     * @return int
     */
    public function getYears()
    {
        return $this->years;
    }

    /**
     * Set miles.
     *
     * @param string $miles
     *
     * @return Article
     */
    public function setMiles($miles)
    {
        $this->miles = $miles;

        return $this;
    }

    /**
     * Get miles.
     *
     * @return string
     */
    public function getMiles()
    {
        return $this->miles;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set energy.
     *
     * @param string $energy
     *
     * @return Article
     */
    public function setEnergy($energy)
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * Get energy.
     *
     * @return string
     */
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set mainPicture.
     *
     * @param string|null $mainPicture
     *
     * @return Article
     */
    public function setMainPicture($mainPicture = null)
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    /**
     * Get mainPicture.
     *
     * @return string|null
     */
    public function getMainPicture()
    {
        return $this->mainPicture;
    }

    /**
     * Set galleryPicture.
     *
     * @param array|null $galleryPicture
     *
     * @return Article
     */
    public function setGalleryPicture($galleryPicture = null)
    {
        $this->galleryPicture = $galleryPicture;

        return $this;
    }

    /**
     * Get galleryPicture.
     *
     * @return array|null
     */
    public function getGalleryPicture()
    {
        return $this->galleryPicture;
    }
}
