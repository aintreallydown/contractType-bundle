<?php

namespace aintreallydown\ContractTypeBundle\Service;

use aintreallydown\ContractTypeBundle\Entity\ContractType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ContractTypeService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $request
    ) {}

    public function getContractChoices(): array
    {
        $contractTypes = $this->entityManager->getRepository(ContractType::class)->findBy(
            [
                'local' => $this->request->getCurrentRequest()->getLocale(),
            ]
        );


        $choices = [];

        foreach ($contractTypes as $contractType) {

            $choices[$contractType->getLabel()] = $contractType->getValue();
        }

        return $choices;
    }
}
