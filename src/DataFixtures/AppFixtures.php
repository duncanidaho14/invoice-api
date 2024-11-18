<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

        private UserPasswordHasherInterface $hasher;

        public function __construct(UserPasswordHasherInterface $hasher)
        {
            $this->hasher = $hasher;
        }
    
        // ...
        public function load(ObjectManager $manager): void
        {
            $faker = Factory::create('fr_FR');
            
            
            for ($u=0; $u < 15; $u++) { 
                $user = new User();
                $chrono = 1;
                $user->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setRoles(['ROLE_USER'])
                    ->setEmail($faker->email())
                    ->setCompany('')
                ;
                    $password = $this->hasher->hashPassword($user, 'pass_1234');
                    $user->setPassword($password);
            
                    

                    for ($i=0; $i < mt_rand(5, 20); $i++) { 
                        $customer = new Customer();
                        $customer->setFirstName($faker->firstName())
                                ->setLastName($faker->lastName())
                                ->setEmail($faker->email())
                                ->setCompany($faker->company())
                                ->setProfile($user)
                        ;
                        $manager->persist($customer);
        
                        for ($j=0; $j < mt_rand(3, 10); $j++) { 
                            $invoice = new Invoice();
                            $invoice->setAmount($faker->randomFloat(2, 250, 5000))
                                    ->setSentAt(\DateTimeImmutable::createFromMutable($faker->datetime('-6 months')))
                                    ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                                    ->setCustomer($customer)
                                    ->setChrono($chrono)
                            ;
                            $chrono++;
                            $manager->persist($invoice);
                        }
                    }
                    $user->addCustomer($customer);
                    $manager->persist($user);
            }

            $user = new User();
            $user->setFirstName('elhadi')
                ->setLastName('beddarem')
                ->setRoles(['ROLE_ADMIN'])
                ->setEmail('elhadibeddarem@gmail.com')
                ->setCompany('')
            ;
    
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setPassword($password);
    
            $manager->persist($user);


            
            $manager->flush();
        }   
}
