<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fiscalAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NIF;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SocialNetworks", mappedBy="company", orphanRemoval=true)
     */
    private $socialNetWorks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="company", orphanRemoval=true)
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="company", orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bill", mappedBy="company", orphanRemoval=true)
     */
    private $bills;

    /**
     * @ORM\Column(type="integer")
     */
    private $invoiceNumber;

    public function __construct()
    {
        $this->socialNetWorks = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->bills = new ArrayCollection();
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

    public function getFiscalAddress(): ?string
    {
        return $this->fiscalAddress;
    }

    public function setFiscalAddress(string $fiscalAddress): self
    {
        $this->fiscalAddress = $fiscalAddress;

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

    public function getNIF(): ?string
    {
        return $this->NIF;
    }

    public function setNIF(string $NIF): self
    {
        $this->NIF = $NIF;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|SocialNetworks[]
     */
    public function getSocialNetworks(): Collection
    {
        return $this->socialNetWorks;
    }

    public function addSocialNetwork(SocialNetworks $socialNetwork): self
    {
        if (!$this->socialNetWorks->contains($socialNetwork)) {
            $this->socialNetWorks[] = $socialNetwork;
            $socialNetwork->setCompany($this);
        }

        return $this;
    }

    public function removeSocialNetwork(SocialNetworks $socialNetwork): self
    {
        if ($this->socialNetWorks->contains($socialNetwork)) {
            $this->socialNetWorks->removeElement($socialNetwork);
            // set the owning side to null (unless already changed)
            if ($socialNetwork->getCompany() === $this) {
                $socialNetwork->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setCompany($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getCompany() === $this) {
                $client->setStatus(false);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCompany($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCompany() === $this) {
                $product->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bill[]
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): self
    {
        if (!$this->bills->contains($bill)) {
            $this->bills[] = $bill;
            $bill->setCompany($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->contains($bill)) {
            $this->bills->removeElement($bill);
            // set the owning side to null (unless already changed)
            if ($bill->getCompany() === $this) {
                $bill->setCompany(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->name;
    }

    public function getInvoiceNumber(): ?int
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(int $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

}
