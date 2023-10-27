<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: FileRepository::class)]
#[ApiResource(
//    normalizationContext: [
//        'groups' => ['file:list'],
//    ],
)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
//    #[Groups(['file:list', 'file:item'])]
    private ?int $id = null;

//    #[Groups(['file:list', 'file:item'])]
    #[ORM\Column(length: 255)]
    private ?string $url = null;

    private ?UploadedFile $file = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $fileName = null;

    #[ORM\Column(length: 255)]
    private ?string $fileSize = null;

    #[ORM\Column]
    private ?bool $starred = null;

    #[ORM\ManyToMany(targetEntity: Vehicle::class, mappedBy: 'files')]
    private Collection $vehicles;

    #[ORM\ManyToMany(targetEntity: Employee::class, mappedBy: 'files')]
    private Collection $employees;

    #[ORM\ManyToMany(targetEntity: Company::class, mappedBy: 'files')]
    private Collection $companies;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'privateFiles')]
    private Collection $privateUsers;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->employees = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->privateUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl($url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileSize(): ?string
    {
        return $this->fileSize;
    }

    public function setFileSize(string $fileSize): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function isStarred(): ?bool
    {
        return $this->starred;
    }

    public function setStarred(bool $starred): static
    {
        $this->starred = $starred;

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->addFile($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            $vehicle->removeFile($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->addFile($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->employees->removeElement($employee)) {
            $employee->removeFile($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->fileName ?? 'je sais pas';
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->addFile($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        if ($this->companies->removeElement($company)) {
            $company->removeFile($this);
        }

        return $this;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPrivateUsers(): Collection
    {
        return $this->privateUsers;
    }

    public function addPrivateUser(User $privateUser): static
    {
        if (!$this->privateUsers->contains($privateUser)) {
            $this->privateUsers->add($privateUser);
            $privateUser->addPrivateFile($this);
        }

        return $this;
    }

    public function removePrivateUser(User $privateUser): static
    {
        if ($this->privateUsers->removeElement($privateUser)) {
            $privateUser->removePrivateFile($this);
        }

        return $this;
    }


}
