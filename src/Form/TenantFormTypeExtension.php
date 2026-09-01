<?php

namespace aintreallydown\ContractTypeBundle\Form;

use App\Form\TenantFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
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

        $builder->add('contract', IntegerType::class, [
            'mapped' => false,
        ]);



        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {

            $form = $event->getForm();
            $tenant = $event->getData();

            $currentContract = $tenant?->getExtrafields()['contract'] ?? null;

            $form->get('contract')->setData($currentContract);
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {

            $form = $event->getForm();
            $tenant = $form->getData();

            $extrafields = $tenant->getExtrafields() ?? [];
            $extrafields['contract'] = $form->get('contract')->getData();


            $tenant->setExtrafields($extrafields);
        });

        
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $contractChoices = $this->contractTypeService->getContractChoices();


        $choices = json_encode($contractChoices, JSON_UNESCAPED_UNICODE);
        $view->vars['choices'] = htmlspecialchars($choices, ENT_QUOTES, 'UTF-8');
        

    }


}
