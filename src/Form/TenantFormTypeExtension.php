<?php

namespace Aintreallydown\ContractTypeBundle\Form;

use App\Form\TenantFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Aintreallydown\ContractTypeBundle\Service\ContractTypeService;

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
        $contractChoices = $this->contractTypeService->getContractChoices($options['language'] ?? null);

        $builder->add('contract', ChoiceType::class, [
            'mapped' => false,
            'label' => false,
            'choices' => $contractChoices,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'language' => null,
        ]);
        $resolver->setAllowedTypes('language', ['string', 'null']);
    }
}
