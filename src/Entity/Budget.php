<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetRepository")
 */
class Budget
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
    private $budgetNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=600)
     */
    private $description;

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
    private $totalAmount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="budgets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="budgets")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $contractClause;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $visits;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $budgetKey;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetLine", mappedBy="budget", orphanRemoval=true)
     */
    private $budgetLines;

    public function __construct()
    {
        $this->budgetLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBudgetNumber(): ?int
    {
        return $this->budgetNumber;
    }

    public function setBudgetNumber(int $budgetNumber): self
    {
        $this->budgetNumber = $budgetNumber;

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

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

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

    public function getContractClause(): ?string
    {
        return $this->contractClause;
    }

    public function setContractClause(string $contractClause): self
    {
        $this->contractClause = $contractClause;

        return $this;
    }

    public function getVisits(): ?int
    {
        return $this->visits;
    }

    public function setVisits(?int $visits): self
    {
        $this->visits = $visits;

        return $this;
    }

    public function getBudgetKey(): ?string
    {
        return $this->budgetKey;
    }

    public function setBudgetKey(string $budgetKey): self
    {
        $this->budgetKey = $budgetKey;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * @return Collection|BudgetLine[]
     */
    public function getBudgetLines(): Collection
    {
        return $this->budgetLines;
    }

    public function addBudgetLine(BudgetLine $budgetLine): self
    {
        if (!$this->budgetLines->contains($budgetLine)) {
            $this->budgetLines[] = $budgetLine;
            $budgetLine->setBudget($this);
        }

        return $this;
    }

    public function removeBudgetLine(BudgetLine $budgetLine): self
    {
        if ($this->budgetLines->contains($budgetLine)) {
            $this->budgetLines->removeElement($budgetLine);
            // set the owning side to null (unless already changed)
            if ($budgetLine->getBudget() === $this) {
                $budgetLine->setBudget(null);
            }
        }

        return $this;
    }
}
