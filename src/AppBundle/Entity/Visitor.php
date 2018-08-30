<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visitor
 *
 * @ORM\Table(name="visitor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitorRepository")
 */
class Visitor
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
     * @ORM\Column(name="hashIp", type="string", length=255)
     */
    private $hashIp;


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
     * Set hashIp.
     *
     * @param string $hashIp
     *
     * @return Visitor
     */
    public function setHashIp($hashIp)
    {
        $this->hashIp = $hashIp;

        return $this;
    }

    /**
     * Get hashIp.
     *
     * @return string
     */
    public function getHashIp()
    {
        return $this->hashIp;
    }
}
