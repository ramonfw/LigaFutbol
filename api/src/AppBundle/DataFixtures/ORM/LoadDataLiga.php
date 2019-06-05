<?php
// src/DataFixtures/ORM/LoadDataLiga.php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Club;
use AppBundle\Entity\Jugadores;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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

        $sql ="SET FOREIGN_KEY_CHECKS=0";  
        $manager->getConnection()->exec($sql);
        $manager->flush();
        

        foreach ($arrJugadores as $ljugador) 
        {
            if (isset($ljugador[1]))
            {
                $ljugador[0]= $ljugador[0]==0 ? 1 : $ljugador[0];
                $setIdclub=trim($ljugador[0]);
                $setNombre=trim($ljugador[1]);
                $setDorsal=trim($ljugador[2]);

                $sql  = "INSERT INTO jugadores (nombre, dorsal, idclub) values ('".$setNombre."','".$setDorsal."','".$setIdclub."')";        
                $manager->getConnection()->exec($sql);  
                $manager->flush();
            }
        }
        $sql ="SET FOREIGN_KEY_CHECKS=1;";   
        $manager->getConnection()->exec($sql); 
        $manager->flush();
        
  
    }
}
