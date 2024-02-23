<?php

namespace App\DataFixtures;

use App\Factory\CampusFactory;
use App\Factory\StudentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CampusFactory::createOne(['name' => 'Blanchardstown']);
        CampusFactory::createOne(['name' => 'Tallaght']);
        CampusFactory::createOne(['name' => 'City']);

        StudentFactory::new()->createMany(10,
            function() {
                return ['campus' => CampusFactory::random()];
            }
        );
    }
}