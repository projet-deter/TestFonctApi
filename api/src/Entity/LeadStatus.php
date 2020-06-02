<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"lead_status_read"}},
 *      denormalizationContext={"groups"={"lead_status_write"}},
 *      itemOperations={
 *          "get",
 *          "patch"={
 *              "normalization_context"={"groups"={"lead_status_patch_read"}},
 *              "denormalization_context"={"groups"={"lead_status_patch_write"}}
 *          },
 *          "delete"
 *      },
 *      collectionOperations={
 *          "get",
 *          "post"
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\LeadStatusRepository")
 */
class LeadStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"lead_status_read", "lead_status_patch_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"lead_status_read", "lead_status_write", "lead_status_patch_read", "lead_status_patch_write"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lead", mappedBy="status")
     * @Groups({"lead_status_read", "lead_status_write", "lead_status_patch_read", "lead_status_patch_write"})
     * @ApiSubresource
     */
    private $leads;

    public function __construct()
    {
        $this->leads = new ArrayCollection();
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

    /**
     * @return Collection|Lead[]
     */
    public function getLeads(): Collection
    {
        return $this->leads;
    }

    public function addLead(Lead $lead): self
    {
        if (!$this->leads->contains($lead)) {
            $this->leads[] = $lead;
            $lead->setStatus($this);
        }

        return $this;
    }

    public function removeLead(Lead $lead): self
    {
        if ($this->leads->contains($lead)) {
            $this->leads->removeElement($lead);
            // set the owning side to null (unless already changed)
            if ($lead->getStatus() === $this) {
                $lead->setStatus(null);
            }
        }

        return $this;
    }
}
