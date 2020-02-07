<?php
 namespace App\DatePersister;
 
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDatePersister implements DataPersisterInterface
{
    private $userPasswordEncoder;
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
    }
    public function supports($data): bool
    {
        return $data instanceof User;
     }
    /**
     * @param User $data
     */
    public function persist($data)
    {
        
        if ($data->getPassword()) {
            $data->setPassword(

                $this->userPasswordEncoder->encodePassword($data, $data->getPassword())
            );
            $data->eraseCredentials();
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }  
    
    
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();    }

}


?>