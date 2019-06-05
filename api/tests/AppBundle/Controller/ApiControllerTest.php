<?php
namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testgetClubes()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'http://localhost:8000/clubes');

        echo "\n\nTestea que el código de respuesta es OK\n\n";
        $this->assertTrue($client->getResponse()->isOk());

        echo "nTestea que el código de estado es exactamente 200\n\n";
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );

        echo "nTestea que la cabecera 'Content-Type' es 'application/json'\n\n";
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $contenido = json_decode($client->getResponse()->getContent());
        echo "nTestea que la respuesta no sea vacía (contiene ".count($contenido)." elementos)\n\n";
        $this->assertTrue(count($contenido)>0);

    }


/*
class ApiControllerTest extends TestCase
{

    public function testgetClubes()
    {
        $apiControlador = new ApiController();
        $restresult = $apiControlador->getClubes();

        $this->assertEquals(3,count($restresult));
        return $restresult;

    }
*/
    /**
     * @Rest\Get("/clubes")
     
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

    **
     * @Rest\Get("/clubes/{id}")
     *
    public function getClub($id)
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Club')->find($id);
        if ($restresult === null) 
        {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }   

    **
     * @Rest\Get("/jugadores")
     *
    public function getJugadores()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Jugadores')->findAll();
        if ($restresult === null) 
        {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }   

    **
     * @Rest\Get("/jugadores/{vIdclub}")
     *
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

    **
     * @Rest\Post("/add/jugador")
     *
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
          $em = $this->getDoctrine()->getManager();
          $RAW_QUERY = "INSERT INTO jugadores (nombre, dorsal, idclub) values (:nombre, :dorsal, :idclub)";        
          $statement = $em->getConnection()->prepare($RAW_QUERY);
          // Set parameters 
          $statement->bindValue('nombre', $nombre);
          $statement->bindValue('dorsal', $dorsal);
          $statement->bindValue('idclub', $idclub);
          $resu = $statement->execute();
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
    */

}
