<?php

namespace aintreallydown\ContractTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Tenant;
use aintreallydown\ContractTypeBundle\Service\ContractTypeService;

class ContractTypeFormType extends AbstractType
{
    public function __construct(
        private ContractTypeService $contractTypeService,
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $contractChoices = $this->contractTypeService->getContractChoices($options['language']);

        $builder
            ->add('contract', ChoiceType::class, [
                'mapped' => false,
                'label' => false,
                'choices' => $contractChoices,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tenant::class,
            'method' => 'PATCH',
            'language' => null,
            'csrf_token_id' => 'contract_type_form',
        ]);

        $resolver->setRequired(['language']);
        $resolver->setAllowedTypes('language', ['string', 'null']);
    }
}
