<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

use AppBundle\Entity\Jugadores;
use AppBundle\Entity\Club;


class ApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/clubes")
     */
    public function getClubes()  
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Club')->findBy( array(), 
                                                                                      array('nombre' => 'ASC') );
        if ($restresult === null) 
        {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }   

    /**
     * @Rest\Get("/clubes/{id}")
     */
    public function getClub($id)
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Club')->find($id);
        if ($restresult === null) 
        {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }   

    /**
     * @Rest\Get("/jugadores")
     */
    public function getJugadores()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Jugadores')->findAll();
        if ($restresult === null) 
        {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }   

    /**
     * @Rest\Get("/jugadores/{vIdclub}")
     */
    public function getJugadoresClub($vIdclub)
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Jugadores')->findBy(array('idclub'=>$vIdclub), 
                                                                                          array('nombre' => 'ASC'));
        if ($restresult === null) 
        {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }   

    /**
     * @Rest\Post("/add/jugador")
     */
    public function postAction(Request $request)
    {
      
        $nombre = $request->get('nombre');
        $dorsal = $request->get('dorsal');
        $idclub = $request->get('idclub');

        if(empty($nombre) || empty($dorsal) || empty($idclub))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        $r="Ok";
        $m="Jugador adicionado satisfactoriamente";
        $rp=Response::HTTP_OK;

        try
        {
          $jugador = new Jugadores($idclub);
          $jugador->setNombre($nombre);
          $jugador->setDorsal($dorsal);
          $jugador->setIdclub($idclub);
          $jugador->setClub($this->getClub($idclub));
            
          $sn = $this->getDoctrine()->getManager();      
          $sn->persist($jugador);
          $sn->flush();
        }
        catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) 
        {
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(409, "Llave única repetida" );
          $r="Ko";
          $m="Llave única repetida"; //, ".$e->getMessage();
          $rp=Response::HTTP_CONFLICT;
        } 
        catch(\Doctrine\DBAL\Exception\ConstraintViolationException $e ) 
        {
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(409, "Error en relaciones" );
          $r="Ko";
          $m="Error en relaciones"; //, ".$e->getMessage();
          $rp=Response::HTTP_CONFLICT;
        } 
        catch(\Doctrine\DBAL\Exception\TableNotFoundException $e ) 
        {
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(409, "Tabla no existe" );
          $r="Ko";
          $m="Tabla no existe"; //, ".$e->getMessage();
          $rp=Response::HTTP_CONFLICT;
        }
        catch (Exception $e)
        {
          $r="Ko";
          $m=$e->getMessage();
          $rp=Response::HTTP_BAD_REQUEST;
        }
        return array("result"=>$r,"mensaje"=>$m, "response"=>$rp);
    }

}
