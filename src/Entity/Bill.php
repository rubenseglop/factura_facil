<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BillRepository")
 */
class Bill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberBill;

    /**
     * @ORM\Column(type="date")
     */
    private $dateBill;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionBill;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalBillIva;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BillLine", inversedBy="bills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $BillLine;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $totalImportBill;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Company", mappedBy="BillsCompany", orphanRemoval=true)
     */
    private $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberBill(): ?int
    {
        return $this->numberBill;
    }

    public function setNumberBill(int $numberBill): self
    {
        $this->numberBill = $numberBill;

        return $this;
    }

    public function getDateBill(): ?\DateTimeInterface
    {
        return $this->dateBill;
    }

    public function setDateBill(\DateTimeInterface $dateBill): self
    {
        $this->dateBill = $dateBill;

        return $this;
    }

    public function getDescriptionBill(): ?string
    {
        return $this->descriptionBill;
    }

    public function setDescriptionBill(string $descriptionBill): self
    {
        $this->descriptionBill = $descriptionBill;

        return $this;
    }

    public function getTotalBillIva(): ?int
    {
        return $this->totalBillIva;
    }

    public function setTotalBillIva(int $totalBillIva): self
    {
        $this->totalBillIva = $totalBillIva;

        return $this;
    }

    public function getBillLine(): ?BillLine
    {
        return $this->BillLine;
    }

    public function setBillLine(?BillLine $BillLine): self
    {
        $this->BillLine = $BillLine;

        return $this;
    }

    public function getTotalImportBill(): ?string
    {
        return $this->totalImportBill;
    }

    public function setTotalImportBill(string $totalImportBill): self
    {
        $this->totalImportBill = $totalImportBill;

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setBillsCompany($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getBillsCompany() === $this) {
                $company->setBillsCompany(null);
            }
        }

        return $this;
    }


    public function __toString(){
        return $this->descriptionBill;
    }
}
