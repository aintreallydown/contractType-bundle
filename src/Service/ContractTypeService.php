<?php

namespace aintreallydown\ContractTypeBundle\Service;

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
            $choices[$contractType->getLabel()] = $contractType->getValue();
        }

        return $choices;
    }
}
