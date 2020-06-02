<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 *@ApiResource(
 *      normalizationContext={"groups"={"lead_read"}},
 *      denormalizationContext={"groups"={"lead_write"}},
 *      itemOperations={
 *          "get",
 *          "patch"={
 *              "normalization_context"={"groups"={"lead_patch_read"}},
 *              "denormalization_context"={"groups"={"lead_patch_write"}}
 *          },
 *          "delete"
 *      },
 *      collectionOperations={
 *          "get",
 *          "post"
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\LeadRepository")
 */
class Lead
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"lead_read", "lead_patch_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $motivation;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $salaryClaim;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LeadStatus", inversedBy="leads")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="leads")
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    private $applicant;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    public $image;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"lead_read", "lead_write", "lead_patch_read", "lead_patch_write"})
     */
    public $cv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(?string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getSalaryClaim(): ?float
    {
        return $this->salaryClaim;
    }

    public function setSalaryClaim(?float $salaryClaim): self
    {
        $this->salaryClaim = $salaryClaim;

        return $this;
    }

    public function getStatus(): ?LeadStatus
    {
        return $this->status;
    }

    public function setStatus(?LeadStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getApplicant(): ?User
    {
        return $this->applicant;
    }

    public function setApplicant(?User $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }

    /**
     * @return MediaObject|null
     */
    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    /**
     * @param MediaObject|null $image
     */
    public function setImage(?MediaObject $image): void
    {
        $this->image = $image;
    }

    /**
     * @return MediaObject|null
     */
    public function getCv(): ?MediaObject
    {
        return $this->cv;
    }

    /**
     * @param MediaObject|null $cv
     */
    public function setCv(?MediaObject $cv): void
    {
        $this->cv = $cv;
    }




}
