<?php

namespace AppBundle\Form;

use AppBundle\Entity\Author;
use AppBundle\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Название',
                'translation_domain' => false,
            ])
            ->add('released_at', null, [
                'label' => 'Опубликована',
                'translation_domain' => false,
            ])
            ->add('rating', null, [
                'label' => 'Рейтинг',
                'translation_domain' => false,
            ])
            ->add('genre',EntityType::class, [
                'label' => 'Жанр',
                'class' => Genre::class,
                'choice_label' => 'name',
                'placeholder' => 'Не выбрано',
                'translation_domain' => false,
            ])
            ->add('author', EntityType::class, [
                'label' => 'Автор',
                'class' => Author::class,
                'choice_label' => 'full_name',
                'placeholder' => 'Не выбрано',
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
            'data_class' => 'AppBundle\Entity\Book'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_book';
    }


}
