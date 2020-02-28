<?php
    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    
    class RegisterType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('name', TextType::class, array(
                'label' => 'Nombre',
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Apellidos',
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Contraseña',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Registrarse'
            )) ;


        }
    }
    
    
