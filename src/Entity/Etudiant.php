<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"etudiant:read"}},
 * denormalizationContext={"groups"={"etudiant:write"}}
 * )
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("etudiant:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("etudiant:write")
     * @Groups("etudiant:read")
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     * @Groups("etudiant:write")
     * @Groups("etudiant:read")
     */
    private $moyenne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(float $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }
}
