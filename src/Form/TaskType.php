<?php
    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Validator\Constraints\File;


    
    class TaskType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('title', TextType::class, array(
                'label' => 'Título',
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ))
            ->add('receptor', TextType::class, array(
                'label' => 'Para',
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenido'
            ))  
            ->add('priority', ChoiceType::class, array(
                'label' => 'Prioridad',
                'choices' => array(
                    'Alta' => 'high',
                    'Media' => 'medium',
                    'Baja' => 'low',
                )
            ))
            ->add('hours', TextType::class, array(
                'label' => 'Días estimados'
            ))
            ->add('state', ChoiceType::class, array(
                'label' => 'Estado de la tarea',
                'choices' => array(
                    'Sin terminar' => 'unfinished',
                    'Terminada' => 'finished',
                )
            ))
            ->add('adjunto', FileType::class, [
                'label' => 'Archivo (PDF file)',
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])

                ],
            ])
               

            ->add('submit', SubmitType::class, array(
                'label' => 'Guardar',
                'attr' => [
                    'id' => 'btnSave' 
                ]
            ));
        }
    }
    
    
