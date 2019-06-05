<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Annotations\AnnotationException;


/**
 * Club
 */
class Club
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $escudo;

    /**
    * @ORM\OneToMany(targetEntity="Jugadores", mappedBy="club")
    */
    private $jugadores;

    /**
    * Blog constructor.
    */
    public function __construct()
    {
       $this->jugadores = new ArrayCollection();
    }


    public function addJugadores(Jugadores $jugador)
    {
        $jugador->setClub($this); 
        $this->jugadores[] = $jugador;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Club
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
     * Set escudo
     *
     * @param string $escudo
     *
     * @return Club
     */
    public function setEscudo($escudo)
    {
        $this->escudo = $escudo;

        return $this;
    }

    /**
     * Get escudo
     *
     * @return string
     */
    public function getEscudo()
    {
        return $this->escudo;
    }
}