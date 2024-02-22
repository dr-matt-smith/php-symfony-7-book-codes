<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Student;
use Mattsmithdev\FakerSmallEnglish\Factory;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;



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

        // create and persist our 3 Student objects
        $s1 = new Student();
        $s1->setFirstName('matt');
        $s1->setSurname('smith');
        $s2 = new Student();
        $s2->setFirstName('joe');
        $s2->setSurname('bloggs');
        $s3 = new Student();
        $s3->setFirstName('joelle');
        $s3->setSurname('murph');

        // set the campus for the students
        $s1->setCampus($campusBlanchardstown);
        $s2->setCampus($campusBlanchardstown);
        $s3->setCampus($campusTallaght);

        $manager->persist($s1);
        $manager->persist($s2);
        $manager->persist($s3);

        $manager->flush();
    }
}
