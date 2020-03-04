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
     * @ORM\OneToMany(targetEntity="App\Entity\BillLine",  mappedBy="bill", orphanRemoval=true, cascade={"persist"})
     */
    private $billLines;

    /**
     * @ORM\Column(type="float")
     */
    private $amountIVA;

    /**
     * @ORM\Column(type="float")
     */
    private $amountWithoutIVA;

    /**
     * @ORM\Column(type="float")
     */
    private $totalInvoiceAmount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="bills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     */
    private $client;

    public function __construct()
    {
        $this->billLines = new ArrayCollection();
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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|BillLine[]
     */
    public function getBillLines(): Collection
    {
        return $this->billLines;
    }

    public function addBillLine(BillLine $billLine): self
    {
        if (!$this->billLines->contains($billLine)) {
            $this->billLines[] = $billLine;
            $billLine->setBill($this);
        }

        return $this;
    }

    public function removeBillLine(BillLine $billLine): self
    {
        if ($this->billLines->contains($billLine)) {
            $this->billLines->removeElement($billLine);
            // set the owning side to null (unless already changed)
            if ($billLine->getBill() === $this) {
                $billLine->setBill(null);
            }
        }

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function __toString(){
        return $this->descriptionBill;
    }

    public function getAmountIVA(): ?float
    {
        return $this->amountIVA;
    }

    public function setAmountIVA(float $amountIVA): self
    {
        $this->amountIVA = $amountIVA;

        return $this;
    }

    public function getAmountWithoutIVA(): ?float
    {
        return $this->amountWithoutIVA;
    }

    public function setAmountWithoutIVA(float $amountWithoutIVA): self
    {
        $this->amountWithoutIVA = $amountWithoutIVA;

        return $this;
    }

    public function getTotalInvoiceAmount(): ?float
    {
        return $this->totalInvoiceAmount;
    }

    public function setTotalInvoiceAmount(float $totalInvoiceAmount): self
    {
        $this->totalInvoiceAmount = $totalInvoiceAmount;

        return $this;
    }
}
