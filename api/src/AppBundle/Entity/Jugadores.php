<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Annotations\AnnotationException;
use AppBundle\Entity\Club;

/**
 * Jugadores
 */
class Jugadores
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $idclub;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var int
     */
    private $dorsal;

    /**
    * @ORM\ManyToOne(targetEntity="Club", inversedBy="jugadores")
    * @ORM\JoinColumn(name="idclub", referencedColumnName="id", nullable=false)
    */
    private $club;



    public function __construct($vIdClub)
    {
        $this->idclub=$vIdClub;
        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idclub
     *
     * @param integer $idclub
     *
     * @return Jugadores
     */
    public function setIdclub($idclub)
    {

        $this->idclub = $idclub;

        return $this;
    }

    /**
     * Get idclub
     *
     * @return int
     */
    public function getIdclub()
    {
        return $this->idclub;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Jugadores
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set dorsal
     *
     * @param integer $dorsal
     *
     * @return Jugadores
     */
    public function setDorsal($dorsal)
    {
        $this->dorsal = $dorsal;

        return $this;
    }

    /**
     * Get dorsal
     *
     * @return int
     */
    public function getDorsal()
    {
        return $this->dorsal;
    }


}

