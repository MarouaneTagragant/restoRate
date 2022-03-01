<?php

namespace App\Fixtures;

use App\Entity\User;
use App\Repository\CityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    private $cityRepository;

    public function __construct(UserPasswordEncoderInterface $encoder, CityRepository $cityRepository)
    {
        $this->encoder = $encoder;
        $this->cityRepository = $cityRepository;
    }

    public function load(ObjectManager $manager)
    {

        $userModerateur = new User();
        $userModerateur->setEmail('moderateur@restorate.com');
        $userModerateur->setPassword($this->encoder->encodePassword($userModerateur, '123456789'));
        $userModerateur->setRoles(['ROLE_ADMIN']);
        $userModerateur->setFirstName('dzadza');
        $userModerateur->setLastName('dzadza');
        $userModerateur->setCity($this->cityRepository->find(rand(1, 200)));
        $manager->persist($userModerateur);

        $userClient = new User();
        $userClient->setEmail('client@restorate.com');
        $userClient->setPassword($this->encoder->encodePassword($userClient, '123456789'));
        $userClient->setRoles(['ROLE_CLIENT']);
        $userClient->setFirstName('dzadza');
        $userClient->setLastName('dzadza');
        $userModerateur->setCity($this->cityRepository->find(rand(1, 200)));
        $manager->persist($userClient);

        $userRestaurateur = new User();
        $userRestaurateur->setEmail('restaurateur@restorate.com');
        $userRestaurateur->setPassword($this->encoder->encodePassword($userRestaurateur, '123456789'));
        $userRestaurateur->setRoles(['ROLE_RESTAURATEUR']);
        $userRestaurateur->setFirstName('dzadza');
        $userRestaurateur->setLastName('dzadza');
        $userModerateur->setCity($this->cityRepository->find(rand(1, 200)));
        $manager->persist($userRestaurateur);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CityFixtures::class,
        );
    }
}