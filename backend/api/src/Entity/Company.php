<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $legal_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $trade_name = null;

    #[ORM\Column(length: 14, unique: true)]
    private ?string $cnpj = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $email = null;

    
    #[ORM\ManyToMany(targetEntity: Partner::class, inversedBy: "companies")]
    #[ORM\JoinTable(name: "company_partners")]
    private Collection $partners;

    public function __construct()
    {
        $this->partners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegalName(): ?string
    {
        return $this->legal_name;
    }

    public function setLegalName(string $legal_name): static
    {
        $this->legal_name = $legal_name;

        return $this;
    }

    public function getTradeName(): ?string
    {
        return $this->trade_name;
    }

    public function setTradeName(?string $trade_name): static
    {
        $this->trade_name = $trade_name;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): static
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

     /**
     * @return Collection<int, Partner>
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partner $partner): self
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->addCompany($this);
        }
        return $this;
    }

    public function removePartner(Partner $partner): self
    {
        if ($this->partners->removeElement($partner)) {
            $partner->removeCompany($this);
        }
        return $this;
    }
}
