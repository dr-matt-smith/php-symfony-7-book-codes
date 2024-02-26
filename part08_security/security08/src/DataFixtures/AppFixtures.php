<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        UserFactory::createOne([
            'email' => 'matt@matt.com',
            'password' => 'pass',
            'roles' => [
                'ROLE_SUPER_ADMIN'
            ]
        ]);

        UserFactory::createOne([
            'email' => 'user@user.com',
            'password' => 'pass',
            'roles' => ['ROLE_USER']
        ]);

        UserFactory::createOne([
            'email' => 'admin@admin.com',
            'password' => 'pass',
            'roles' => ['ROLE_ADMIN']
        ]);
    }
}
