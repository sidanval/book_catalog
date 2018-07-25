<?php

namespace AppBundle\Form;

use AppBundle\Model\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('full_name', null, [
                'label' => 'Имя',
                'translation_domain' => false,
            ])
            ->add('birthday', null, [
                'label' => 'Дата рождения',
                'translation_domain' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Пол',
                'choices' => array_flip(Author::genders()),
                'translation_domain' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Author'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_author';
    }


}
