<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    

    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $role= new Role();
        $role->setLibelle("SUP_ADMIN");
        $manager->persist($role);

        $role2= new Role();
        $role2->setLibelle("ADMIN");
        $manager->persist($role2);


        $role1= new Role();
        $role1->setLibelle("Caissier");
        $manager->persist($role1);

        $role3= new Role();
        $role3->setLibelle("Partenaire");
        $manager->persist($role3);
      

        $user1 = new User();
        $user1->setPassword($this->encoder->encodePassword($user1, "gainde"));
        $user1->setNomcompl("zeyna");
        $user1->setIsActif(true);
        $user1->setUsername("admin");
        $user1->setRoles($role);
        $manager->persist($user1);

        $manager->flush();
   
    }
}