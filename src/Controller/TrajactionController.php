<?php

namespace App\Controller;

use App\Entity\Taxi;
use App\Entity\Tarif;
use App\Entity\Compte;
use App\Entity\Trajaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
* @Route("/api")
*/
class TrajactionController extends AbstractController
{


    // private $tokenStorage;
    // public function __construct(TokenStorageInterface $tokenStorage)
    // {
    //         $this->tokenStorage = $tokenStorage;
    // }
    /**
    * @Route("/transaction", name="transaction", methods={"POST"})
    */
    public function faire_transaction(Request $request, EntityManagerInterface $EntityManagerInterface , 
    SerializerInterface $serializer,ValidatorInterface $validator)
    {

    $values = json_decode($request->getContent());

                $frai = $this->getDoctrine()->getRepository(Tarif::class);
                $all = $frai->findAll()[0];
                $repository =$this->getDoctrine()->getRepository(Taxi::class);
                //var_dump($repository);die;
                $recup= $repository->findAll()[0];

                //recuperation des taux

                $f = $this->frais($values->montat);
                $taxeEtat =$f*$recup->getTaxiEtat();
                $taxeSys =$f*$recup->getTaxiSysteme();
                $taxeEmet =$f*$recup->getEmeteur();
                $taxeRecep =$f*$recup->getRecepteur();

                $userconnct= $this->getUser();
                $compte =$this->getDoctrine()->getRepository(Compte::class);

                if(!isset($values->prenom,$values->nom,$values->montat))
                {
                    //les affectation 
                $date = new \DateTime();
                $transfert = new Trajaction();
                //recuperation du compte coserner pour l'envoi
                $RecupCompte = $this->getDoctrine()->getRepository(Compte::class);
                $compte = $RecupCompte->findOneById($values->id);

                $codeEnvoi = $this->nbAleatoire(9);

               $transfert->setuser($userconnct);
                $transfert->setCopmte($compte);
               $transfert->setPrenomE($values->prenomE);
               $transfert->setNomE($values->nomE);
               $transfert->setTypePieceEnvoi($values->typePieceEnvoi);
                $transfert->setNumeroPieceEmetteur($values->numeroPieceEmetteur);
                $transfert->setPrenoR($values->prenoR);
                $transfert->setNomR($values->nomR);
                $transfert->setMontat($values->montat);
                $transfert->setFrais($f);
                $transfert->setTelephoRecepteur($values->telephoRecepteur);
                $transfert->setDateEnvoi($date);
                $transfert->setCommissionEmetteur($taxeEmet);
                $transfert->setCommissionRecepteur($taxeRecep);
                $transfert->setTaxiEtat($taxeEtat);
                $transfert->setCommissionSysteme($taxeSys);
                $transfert->setCode($codeEnvoi);
                $errors = $validator->validate($transfert);
                if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                'Content-Type' => 'application/json'
                ]);
                }
                $EntityManagerInterface->persist($transfert);
                $EntityManagerInterface->flush();


                // mis a joure le solde du compte partenaire 
                
                $NewSolde = ($compte->getSolde()-$values->montat);
                $compte->setSolde($NewSolde);

                $EntityManagerInterface->persist($compte);
                $EntityManagerInterface->flush();
$data = [
                'status' => 201,
                'message' => 'vous avez faire un transfert :'.$values->montat.'dont le code est'.$codeEnvoi
                ];
                return new JsonResponse($data, 201);

                }
                $data = [
                'status' => 500,
                'message' => ' transfert invalide:'
                ];

                return new JsonResponse($data, 500);
                }
                ####### IMPLEMENTATION DU GENERATEUR DU CODE D'ENVOIE ######
                public function nbAleatoire($length)
                {
                $tab_match = [];
                while (count($tab_match) < $length) {
                preg_match_all('#\d#', hash("sha512", openssl_random_pseudo_bytes("128", $cstrong)), $matches);
                $tab_match = array_merge($tab_match, $matches[0]);
                }
                shuffle($tab_match);
                return implode('', array_slice($tab_match, 0, $length));
                }

                public function frais($montant)
                {
                $frai = $this->getDoctrine()->getRepository(Tarif::class);
                $all = $frai->findAll();
                foreach($all as $val)
                {
                if($val->getBorneInf() <= $montant && $val->getBorneSup()>= $montant)
                {
                return $val->getFrais(); 
                }
                }

                }
                //Retrait
                

//femiture
}

