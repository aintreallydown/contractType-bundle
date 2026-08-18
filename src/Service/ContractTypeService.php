<?php

namespace Aintreallydown\ContractTypeBundle\Service;

use App\Entity\ContractType;
use Doctrine\ORM\EntityManagerInterface;

class ContractTypeService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function getContractChoices(string $criteria): array
    {
        $contractTypes = $this->entityManager->getRepository(ContractType::class)->findBy([
            'local' => $criteria,
        ]);

        $choices = [];
        foreach ($contractTypes as $contractType) {
            $choices[$contractType->getName()] = $contractType->getId();
        }

        return $choices;
    }
}
