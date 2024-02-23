<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Student;
use Mattsmithdev\FakerSmallEnglish\Factory;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Factory\StudentFactory;

class StudentFixtures extends Fixture
{
    public function getDependencies()
    {
        return [
            CampusFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $campusBlanchardstown = $this->getReference('CAMPUS_BLANCH');
        $campusTallaght = $this->getReference('CAMPUS_TALLAGHT');
        $campusCity = $this->getReference('CAMPUS_CITY');

        // -- make 10 students with Foundry
		StudentFactory::new()->createMany(10, 
			['campus' => $campusBlanchardstown]
		);
    }
}
