<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\OfferController;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_RECRUITER')"},
 *     collectionOperations={
 *         "post"={"security"="is_granted('ROLE_RECRUITER')", "security_message"="Only Recruiter can add offers."},
 *         "get"={"security"="is_granted('ROLE_RECRUITER')"},
 *     },
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_RECRUITER') and object.getOwner() == user or is_granted('ROLE_USER')", "security_message"="Sorry, but you are not the offer owner."},
 *         "offerValidation" = {
 *              "method" = "GET",
 *              "path" = "/verifyOfferParticipant/{token}",
 *              "controller" = OfferController::class,
 *              "defaults" = {"_api_receive" = false},
 *              "security"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')",
 *              "openapi_context" = {
 *                  "parameters" = {
 *                      {
 *                          "name": "token",
 *                          "in": "path",
 *                          "type": "string",
 *                          "required": true
 *                      }
 *                  }
 *              }
 *          },
 *         "put"={"security_post_denormalize"="is_granted('ROLE_RECRUITER') or (object.getOwner() == user and previous_object.getOwner() == user)", "security_post_denormalize_message"="Sorry, but you are not the actual offer owner."},
 *         "delete"
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 * @ApiFilter(ExistsFilter::class, properties={"owner"})
 * @ApiFilter(SearchFilter::class, properties={"name": "exact", "offerDescription": "ipartial"})
 */
class Offer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $companyDescription;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $offerDescription;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfContract;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $workplace;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposal", mappedBy="offer", orphanRemoval=true)
     * @ApiSubresource
     */
    private $proposals;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    public function __construct()
    {
        $this->proposals = new ArrayCollection();
    }

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

    public function getCompanyDescription(): ?string
    {
        return $this->companyDescription;
    }

    public function setCompanyDescription(string $companyDescription): self
    {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    public function getOfferDescription(): ?string
    {
        return $this->offerDescription;
    }

    public function setOfferDescription(string $offerDescription): self
    {
        $this->offerDescription = $offerDescription;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getTypeOfContract(): ?string
    {
        return $this->typeOfContract;
    }

    public function setTypeOfContract(string $typeOfContract): self
    {
        $this->typeOfContract = $typeOfContract;

        return $this;
    }

    public function getWorkplace(): ?string
    {
        return $this->workplace;
    }

    public function setWorkplace(string $workplace): self
    {
        $this->workplace = $workplace;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Proposal[]
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Proposal $proposal): self
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals[] = $proposal;
            $proposal->setOffer($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): self
    {
        if ($this->proposals->contains($proposal)) {
            $this->proposals->removeElement($proposal);
            // set the owning side to null (unless already changed)
            if ($proposal->getOffer() === $this) {
                $proposal->setOffer(null);
            }
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
