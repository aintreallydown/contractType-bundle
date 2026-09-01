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

    public function getContractChoices(): string
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

            $choices[$contractType->getLabel()] = $contractType->getValue();
        }

        dump(json_encode($choices, JSON_UNESCAPED_UNICODE));

        return json_encode($choices, JSON_UNESCAPED_UNICODE);

    }
}
