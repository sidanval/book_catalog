<?php

namespace AppBundle\Form\Search;


use AppBundle\Entity\Author;
use AppBundle\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('get')
            ->add('genre',EntityType::class, [
                'label' => 'Жанр',
                'class' => Genre::class,
                'placeholder' => 'Не выбрано',
                'choice_label' => 'name',
                'required' => false,
                'translation_domain' => false
            ])
            ->add('author', EntityType::class, [
                'label' => 'Автор',
                'class' => Author::class,
                'placeholder' => 'Не выбрано',
                'choice_label' => 'full_name',
                'required' => false,
                'translation_domain' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Book',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}