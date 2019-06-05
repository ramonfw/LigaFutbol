<?php
// src/DataFixtures/ORM/LoadDataLiga.php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Club;
use AppBundle\Entity\Jugadores;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
use Doctrine\*;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
*/

class LoadDataLiga implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $sql ="ALTER TABLE club MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";  // Read file contents
        $manager->getConnection()->exec($sql);  // Execute native SQL
        $manager->flush();
        
        $clubes=file_get_contents("clubes.txt");
        $arrClubes=array();

        $arrImplode=explode("#",$clubes);
        foreach($arrImplode as $linea)
        {
            $arrImplode2=explode(";",$linea);
            $arrClubes[]=$arrImplode2;
        }

        // create 20 products! Bam!
        foreach ($arrClubes as $lclub) 
        {
            $club = new Club();
            $club->setNombre($lclub[0]);
            $club->setEscudo($lclub[1]);
            $manager->persist($club);
        }
        $manager->flush();

        $sql ="ALTER TABLE jugadores MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";  // Read file contents
        $manager->getConnection()->exec($sql);  // Execute native SQL
        $manager->flush();
        
        $jugadores=file_get_contents("jugadores.txt");
        $arrJugadores=array();

        $arrImplode=explode(" #",$jugadores);
        foreach($arrImplode as $linea)
        {
            $arrImplode2=explode(";",$linea);
            $arrJugadores[]=$arrImplode2;
        }
//        file_put_contents("ggggg.txt",print_r($arrJugadores,true));
/*        $sql ="ALTER TABLE `jugadores` DROP FOREIGN KEY `FK_1`;";  // Read file contents
        $manager->getConnection()->exec($sql);  // Execute native SQL
        $manager->flush();*/
        

        foreach ($arrJugadores as $ljugador) 
        {
            if (isset($ljugador[1]))
            {
                $ljugador[0]= $ljugador[0]==0 ? 1 : $ljugador[0];
                $setIdclub=trim($ljugador[0]);
                $setNombre=trim($ljugador[1]);
                $setDorsal=trim($ljugador[2]);

                $sql  = "INSERT INTO jugadores (nombre, dorsal, idclub) values ('".$setNombre."','".$setDorsal."','".$setIdclub."')";        
                $manager->getConnection()->exec($sql);  // Execute native SQL
                $manager->flush();
            }
        }
/*        $sql ="ALTER TABLE `jugadores` ADD CONSTRAINT `FK_1` FOREIGN KEY (`idclub`) REFERENCES `club` (`id`);";  */ // Read file contents
//        $manager->getConnection()->exec($sql);  // Execute native SQL
//        $manager->flush();
        
  
    }
}
