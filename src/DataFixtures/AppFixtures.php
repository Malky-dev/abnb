<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Image;
use App\Entity\Annonce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();
        
        for ($i=0; $i < 30; $i++) { 
            $annonce = new Annonce();
            $title = $faker->sentence();
            $slug = $title;
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = $faker->paragraph(5);

            $annonce->setTitle($title)
                    ->setSlug(strtolower(str_replace(" ", "-", $slug)) )
                    ->setCoverImage($coverImage)
                    ->setIntroduction($introduction)
                    ->setContent($content)
                    ->setPrice(mt_rand(40,200))
                    ->setRoom(mt_rand(1,5));

			for ($j=0; $j < mt_rand(2,5); $j++) { 
				$image = new Image();
				$image->setUrl($faker->imageUrl())
						->setCaption($faker->sentence())
						->setAnnonce($annonce);
				$manager->persist($image);
			}
			
			$manager->persist($annonce);
        }

        $manager->flush();
    }
}
