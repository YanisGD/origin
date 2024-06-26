<?php

namespace App\DataFixtures;

use Faker\Generator;
use Faker\Factory;
use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 50; $i++) { 
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word(1))
                ->setPrice(mt_rand(0,100));

            $manager->persist($ingredient);
        }
        // $product = new Product();
        // $manager->persist($product);



        $manager->flush();
    }
}
 