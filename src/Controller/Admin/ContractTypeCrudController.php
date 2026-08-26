<?php

namespace aintreallydown\ContractTypeBundle\Controller\Admin;


use aintreallydown\ContractTypeBundle\Entity\ContractType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContractTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContractType::class;
    }
}
