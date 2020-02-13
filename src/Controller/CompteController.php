<?php


namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
     * @Route("/api")
     */
    class CompteController extends AbstractController
    {
         
        /**
         * @Route("/nouveauCompte", name="creation_compte_nouveauPartenaire", methods={"POST"})
         */
        public function nouveau_compte(Request $request, EntityManagerInterface $entityManager,
         UserPasswordEncoderInterface $PasswordEncoderInterface)
        {
        
            $userCreateur = $this->getUser();
            
            // var_dump($userCreateur);die;
            $values = json_decode($request->getContent());
            if(isset($values->ninea))
            {
                    //les class 
                    $dateCreation = new \DateTime();
                   // var_dump($dateCreation);die;
                    $depot = new Depot();
                    $compte = new Compte();                     
                    $user = new User();
                    $partenaire = new Partenaire(); 
    
                    //pour le compte USER  
                    $roleRepository = $this->getDoctrine()->getRepository(Role::class);
                $role=$roleRepository->find($values->role);
                //partenaire
                $partenaire->setNinea($values->ninea);
                $partenaire->setRC($values->rc); 
                

                $entityManager->persist($partenaire);
                $entityManager->flush();

                //les information d'user
                $user->setNomcompl($values->nomcompl);
                $user->setUsername($values->username);
                $user->setPassword($PasswordEncoderInterface->encodePassword($user, $values->password));
                $user->setRole($role);
                $user->setParte($partenaire);

                
                $entityManager->persist($user);
                $entityManager->flush();
                        //GENERATION DU COMPTE  
                        $annee = Date('y');
                        $nb = $this->getLastCompte();
                        $long = strlen($nb);
                        $nin = substr($partenaire->getNinea() , -2);
                        $NumCompte = str_pad("NG".$annee.$nin, 11-$long, "0").$nb;

                        //pour le compte   
                        // recuperer de l'utilisateur qui cree le compte et faire  un depot initial

                        $userCreateur = $this->getUser();
                        $compte->setNumero($NumCompte);

                        $compte->setSolde($values->solde);
                        $compte->setDateCreation($dateCreation);
                        $compte->setUser($user);
                        $compte->setPartenire($partenaire); 

                        $entityManager->persist($compte);
                        //var_dump($Compte);die;
                        $entityManager->flush();

                        //pour le depot

                        $depot->setDateDepot($dateCreation);
                        $depot->setMontant($values->montant);
                       
                        $depot->setUser($user);
                        $depot->setCompte($compte);

                            $entityManager->persist($depot);
                            $entityManager->flush(); 


                            // mis a joure le solde du compte partenaire 
                            $NewSolde = ($values->montant+$compte->getSolde());
                            $compte->setSolde($NewSolde);

                            $entityManager->persist($compte);
                            $entityManager->flush();

                                            $data = [
                    'status' => 201,
                    'message' => 'Le compte du partenaire est bien cree avec un depot de:'.$values->montant
                    ];
                    return new JsonResponse($data, 201);
                    }

                    $data = [
                    'status' => 500,
                    'message' => 'Vous devez renseigner un login et un passwordet un ninea pour le partenaire, le numero de compte ainsi que le montant a deposer'
                    ];
                    return new JsonResponse($data, 500);

                        

         }
                    /**
                    * @Route("/compteExistent", name="creation_compte_PartenaireExistent", methods={"POST"})
                    */
                        public function creation_compte_PartenaireExistent(Request $request, EntityManagerInterface $entityManager)
                        {
                            $values = json_decode($request->getContent());
                            if(isset($values->ninea))
                        {
                                // controle l'utilisateur si il a le droit de creer un compte (appel CompteVoter)
                                // $this->denyAccessUnlessGranted('POST_EDIT',$this->getUser());

                                $ReposPropcompte = $this->getDoctrine()->getRepository(Partenaire::class);
                                    // recuperer le proprietaire du compte
                                    $propcompte = $ReposPropcompte->findOneByNinea($values->ninea);
                                if ($propcompte) 
                                {
                                        //les class 
                                        $dateJours = new \DateTime();
                                        $depot = new Depot();
                                                $compte = new Compte();

                                                //pour le compte 
                                            
                                                // recuperer de l'utilisateur qui cree le compte et fair un depot initial
                                                $userCreateur = $this->getUser();

                                            //generation du comptes
                                            $annee = Date('y');
                                            $nb = $this->getLastCompte();
                                            $long = strlen($nb);
                                            $nin = substr($propcompte->getNinea() , -2);
                                            $NumCompte = str_pad("NG".$annee.$nin, 11-$long, "0").$nb;
                                            
                                            $compte->setNumero($NumCompte);
                                            $compte->setSolde(0);
                                            $compte->setDateCreation($dateJours);
                                            $compte->setUser($userCreateur);
                                            $compte->setPartenire($propcompte);
                            //var_dump($NumCompte);die;
                                                $entityManager->persist($compte);
                                                $entityManager->flush();

                            //depot

                            $ReposCompte = $this->getDoctrine()->getRepository(Compte::class);
                            $compteDepose = $ReposCompte->findOneByNumero($compte->$NumCompte);
                            $depot->setDateDepot($dateJours);
                            $depot->setMontant($values->montant);
                            $depot->setUser($userCreateur);
                            $depot->setCompte($compteDepose);
                            

                        $entityManager->persist($depot);
                            $entityManager->flush();

                            // mis a joure le solde du compte partenaire 
                            $NewSolde = ($values->montant+$compte->getSolde());
                                $compte->setSolde($NewSolde);
                                    $entityManager->persist($compte);
                                                $entityManager->flush();
                                    $data = [
                                        'status' => 201,
                                                'message' => 'Le compte du partenaire est bien cree avec un depot initia de: '.$values->montant
                                                ];
                                            return new JsonResponse($data, 201);
                                        
                                        $data = [
                                            'status' => 500,
                                            'message' => 'Veuillez saisir un montant de depot valide'
                                            ];
                                            return new JsonResponse($data, 500);
                                    }
                                    $data = [
                                        'status' => 500,
                                        'message' => 'Desole le NINEA n existe psa' 
                                        ];
                                        return new JsonResponse($data, 500);
                                }
                                $data = [
                                'status' => 500,
                                'message' => 'Vous devez renseigner le ninea du partenaire, le numero de compte ainsi que le montant a deposer'
                                    ];
                                    return new JsonResponse($data, 500);
                            }    

                            public function getLastCompte(){
                                $ripo = $this->getDoctrine()->getRepository(Compte::class);
                                $compte = $ripo->findBy([], ['id'=>'DESC']);
                                if(!$compte){
                                    $c = 1;
                                }else{
                                    $c= ($compte[0]->getId()+1);
                                }
                                return $c;
                            }
            
                                //faire depot
                                            /**
                                             * @Route("/fairedepot", name="fairre depot", methods={"POST"})
                                            */

                    public function faireDepot(Request $request, EntityManagerInterface $entityManager)
                    {   
                        $userCreateur = $this->getUser();

                        $values = json_decode($request->getContent());

                            if($values->montant>0){
                                //les class 
                        $dateJours = new \DateTime();
                        $depot = new Depot();

                                            $ReposCompte = $this->getDoctrine()->getRepository(Compte::class);
                                            $compteDepose = $ReposCompte->findOneById($values->id);
                                            $depot->setDateDepot($dateJours);
                                            $depot->setMontant($values->montant);
                                            $depot->setUser($userCreateur);
                                            $depot->setCompte($compteDepose);
                                            
                                            $entityManager->persist($depot);
                                            $entityManager->flush();

                                // mis a joure le solde du compte partenaire 
                                    $NewSolde = ($values->montant+$compteDepose->getSolde());
                                    $compteDepose->setSolde($NewSolde);

                                    $entityManager->persist($compteDepose);
                                    $entityManager->flush();
                                    
                                    $data = [
                                        'status' => 201,
                                            'message' => 'Merci vous avez faire  un depot de:'.$values->montant
                                            ];
                                            return new JsonResponse($data, 201);
                                            }

                                            $data = [
                                            'status' => 500,
                                            'message' => 'Vous devez renseigner un login et un passwordet un ninea pour 
                                            
                                            le partenaire, le numero de compte ainsi que le montant a deposer'
                                            ];
                                            return new JsonResponse($data, 500);
                                }
        }