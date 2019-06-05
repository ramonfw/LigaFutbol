<?php
    namespace AppBundle\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;

class DefaultController extends Controller
{ 
    private $listado=null;
    private $api_clubes_url = "/clubes";
    private $api_jugadores_url = "/jugadores";
    private $api_add_jugador_url = "/add/jugador";

     /**
     * @Route("/nuevojugador/{vIdclub}", name="nuevojugador")  
     */
    public function addJugadorAction(Request $request, $vIdclub)
    {
        $response='';

        $nombre = $request->get('nombre');
        $dorsal = $request->get('dorsal');
    //    $idclub = $request->get('idclub');
        $idclub = $vIdclub;

        if($nombre !="" && $dorsal !="")
        {

            try
            {
                $this->client = new Client();
                $url = $this->getParameter('api_url').$this->api_add_jugador_url;
                $data = ['nombre' => $nombre,'dorsal' => $dorsal,'idclub' => $idclub];
                $response = $this->client->post($url, array('query' => $data));
                $respuesta1=json_decode($response->getBody()->getContents());

                if ($respuesta1->result=='Ok')
                {
                    $this->addFlash(
                        'notice',
                        'Jugador agregado',
                        $respuesta1
                    );
                    return $this->redirectToRoute('jugadores',array('vIdclub'=>$idclub));
                }          
                else
                {
                    $response=$respuesta1->mensaje."(Err: ".$respuesta1->response.")";
                }      
            }
            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);
                print_r($response);
                die();
            }
        } 

        return $this->render('default/homeview.html.twig', array(
            'vista'=>'default/formjugador.html.twig',
            'titulo'=>'Agregar usuario del club ',
            'urlget'=>'list/jugadores/',
            'urlpost'=>'',
            'idclub'=>$vIdclub,
            'api_add_jugador_url'=>$this->getParameter('api_url').$this->api_add_jugador_url,
            'respuesta' => $response)
        );

    }
    

    public function StatusCodeHandling($e)
    {
        if ($e->getResponse()->getStatusCode() == '400')
        {
            $this->prepare_access_token();
        }
        elseif ($e->getResponse()->getStatusCode() == '422')
        {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        }
        elseif ($e->getResponse()->getStatusCode() == '500')
        {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        }
        elseif ($e->getResponse()->getStatusCode() == '401')
        {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        }
        elseif ($e->getResponse()->getStatusCode() == '403')
        {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        }
        else
        {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        }
    }


     /**
     * @Route("/", name="homeroute")
     * @Route("/list/clubes", name="clubes")
     */
    public function listClubesAction()
    {
        $this->client = new Client();
        $url = $this->getParameter('api_url').$this->api_clubes_url;

        $response = $this->client->get($url);
        $result = $response->getBody()->getContents();

        $resultado=json_decode($result);

        return $this->render('default/homeview.html.twig', array(
            'vista'=>'default/showclubes.html.twig',
            'titulo'=>'Listado de clubes registrados',
            'urlget'=>'',
            'urlpost'=>'',
            'idclub'=>'0',
            'respuesta' => $resultado)
        );

    }
    
     /**
     * @Route("/list/jugadores/{vIdclub}", name="jugadores")
     */
    public function listJugadoresAction($vIdclub)
    {
        $this->client = new Client();
        $url = $this->getParameter('api_url').$this->api_jugadores_url.'/'.$vIdclub;

        $response = $this->client->get($url);
        $result = $response->getBody()->getContents();
        $nombreClub="";

        $resultado=json_decode($result);
        if(count($resultado)>0)
        {
            $objClub=$resultado[0];   //["club"][0]["nombre"];
            $nombreClub=$objClub->club->nombre;
        }

        return $this->render('default/homeview.html.twig', array(
            'vista'=>'default/showplayers.html.twig',
            'titulo'=>'Listado de jugadores registrados del club '.$nombreClub,
            'urlget'=>'',
            'urlpost'=>'nuevojugador/',
            'idclub'=>$vIdclub,
            'nombreclub'=>$nombreClub,
            'respuesta' => $resultado)
        );

    }

}
