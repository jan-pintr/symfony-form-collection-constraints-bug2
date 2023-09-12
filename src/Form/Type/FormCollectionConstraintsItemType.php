<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Form item type for debugging collection type constraints
 */
class FormCollectionConstraintsItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    /**
     * {@inheritdoc}
     */
    //phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
        $builder->addEventListener(FormEvents::SUBMIT, [$this, 'onSubmit']);
    }

    public function onPreSetData(PreSetDataEvent $event): void
    {
        $form = $event->getForm();

        $this->formAddValue($form);
    }

    public function onPreSubmit(PreSubmitEvent $event): void
    {
        $form = $event->getForm();

        $this->formAddValue($form);
    }

    public function onSubmit(SubmitEvent $event): void
    {
        $form = $event->getForm();

        $this->formAddValue($form);
    }

    private function formAddValue(FormInterface $form): void
    {
        $form->add('value', TextType::class, [
            'required' => false,
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Callback([
                    'callback' => [$this, 'validateValue'],
                ]),
            ],
        ]);
    }

    public function validateValue(): void
    {
        dump('validateValue');
    }
}