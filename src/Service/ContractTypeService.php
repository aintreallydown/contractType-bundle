<?php

namespace aintreallydown\ContractTypeBundle\Service;

use aintreallydown\ContractTypeBundle\Entity\ContractType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ContractTypeService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $request,
        private ParameterBagInterface $params,
    ) {}

    public function getContractChoices(): array
    {
        $contractTypes = $this->entityManager->getRepository(ContractType::class)->findBy(
            [
                'local' => $this->request->getCurrentRequest()->getLocale(),
            ]
        );

        if (empty($contractTypes) || !$contractTypes) {

            $contractTypes = $this->entityManager->getRepository(ContractType::class)->findBy(
                [
                    'local' => 'en',
                ]
            );
        }

        if (empty($contractTypes) || !$contractTypes) {

            $contractTypes = $this->entityManager->getRepository(ContractType::class)->findBy(
                [
                    'local' => $this->params->get('default_locale'),
                ]
            );
        }

        $choices = [];

        foreach ($contractTypes as $contractType) {

            $choices[] = [
                'label' => $contractType->getLabel(),
                'value' => $contractType->getValue(),
            ];

        }



        return $choices;
    }
}
