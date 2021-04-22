<?php


namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class PostFixtures
 * @package App\DataFixtures
 */


class PostFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<= 100; $i++) {
            $Blog = new Blog();
            $Blog->setTitle("Article N°" . $i);
            $Blog->setDescription("Contenu N°" . $i);
            $Blog->setImage("http://via.placeholder.com/400x300");
            $manager->persist($Blog);

        for ($j = 1; $j <= rand(5, 15); $j++){

            $Commentaire = new Commentaire();
            $Commentaire->setidUser("Auteur " . $i);
            $Commentaire->setText("Text N°" . $j);
            $Commentaire->setBlog($Blog);
            $manager->persist($Commentaire);
        }
        }

        $manager->flush();
    }

}
