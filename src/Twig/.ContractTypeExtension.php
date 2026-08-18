<?php

namespace aintreallydown\ContractTypeBundle\Twig;

use App\Entity\ContractType;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ContractTypeExtension extends AbstractExtension
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_contract_types', [$this, 'getContractTypes']),
            new TwigFunction('get_contract_type', [$this, 'getContractType']),
        ];
    }

    public function getContractTypes(array $criteria = []): array
    {
        return $this->entityManager->getRepository(ContractType::class)->findBy($criteria);
    }

    public function getContractType(int $id): ?ContractType
    {
        return $this->entityManager->getRepository(ContractType::class)->find($id);
    }
}
