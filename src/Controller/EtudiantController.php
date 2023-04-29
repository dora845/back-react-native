<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="app_etudiant_show", methods={"GET"})
     */
    public function show(EtudiantRepository $etudiants)
    {
        return $this->json($etudiants->findAll(), 200, []);
    }

    /**
     * @Route("/etudiant", name="app_etudiant_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $normalizerInterface, EntityManagerInterface $em)
    {
        $jsonRecu = $request->getContent();
        $etudiant = $normalizerInterface->deserialize($jsonRecu, Etudiant::class, 'json');

        $em->persist($etudiant);
        $em->flush();
        return $this->json($etudiant, 201, []);
    }
    /**
     * @Route("/etudiant/{id}", name="app_etudiant_update", methods={"PUT"})
     */
    public function update($id, Request $request, EtudiantRepository $etudiantRepository, EntityManagerInterface $em, SerializerInterface $serializerInterface)
    {
        $etudiant = $etudiantRepository->findOneBy(['id' => $id]);
        $jsonRecu = $request->getContent();

        $etudiant_new = $serializerInterface->deserialize($jsonRecu, Etudiant::class, 'json');

        $etudiant->setNom($etudiant_new->getNom());
        $etudiant->setMoyenne($etudiant_new->getMoyenne());

        $em->persist($etudiant);
        $em->flush();
        $message = "Etudiant modifier";
        return $this->json($message, 203, []);
    }

    /**
     * @Route("/etudiant/{id}", name="app_etudiant_delete", methods={"DELETE"})
     */
    public function delete($id, EtudiantRepository $etudiantRepository, EntityManagerInterface $em)
    {
        $etudiant = $etudiantRepository->findOneBy(['id' => $id]);
        $em->remove($etudiant);
        $em->flush();
        return $this->json("Etudiant supprimer", Response::HTTP_NO_CONTENT);
    }
}
