<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form type for debugging collection type constraints
 */
class FormCollectionConstraintsType extends AbstractType
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

        $this->formAddItems($form);

        $form->add('submit', SubmitType::class, [
            'translation_domain' => false,
        ]);
    }

    public function onPreSubmit(PreSubmitEvent $event): void
    {
        $form = $event->getForm();

        $this->formAddItems($form);
    }

    public function onSubmit(SubmitEvent $event): void
    {
        $form = $event->getForm();

        dump('onSubmit');

        $this->formAddItems($form);
    }

    private function formAddItems(FormInterface $form): void
    {
        $form->add('items', CollectionType::class, [
            'entry_type' => FormCollectionConstraintsItemType::class,
            'translation_domain' => false,
        ]);
    }
}