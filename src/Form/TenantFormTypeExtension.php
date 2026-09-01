<?php

namespace aintreallydown\ContractTypeBundle\Form;

use App\Form\TenantFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use aintreallydown\ContractTypeBundle\Service\ContractTypeService;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TenantFormTypeExtension extends AbstractTypeExtension
{
    public function __construct(
        private ContractTypeService $contractTypeService,
    ) {}

    public static function getExtendedTypes(): iterable
    {
        return [TenantFormType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $contractChoices = $this->contractTypeService->getContractChoices();

        $tenant = $builder->getData();
        $currentContract = $tenant?->getExtrafields()['contract'] ?? null;

        $builder->add('contract', ChoiceType::class, [
            'mapped' => false,
            'label' => false,
            'choices' => $contractChoices,
            'data' => $currentContract,
        ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {

            $form = $event->getForm();
            $tenant = $form->getData();

            $extrafields = $tenant->getExtrafields() ?? [];
            $extrafields['contract'] = $form->get('contract')->getData();


            $tenant->setExtrafields($extrafields);
        });
    }
    

}
