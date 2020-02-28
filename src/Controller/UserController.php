<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Entity\Task;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $enconder )
    {
        // Crear formulario
        $user = new user();
        $form = $this->createForm(RegisterType::class, $user);


        // Rellenar el objeto con los datos del form
        $form->handleRequest($request);

        
        // comprobar si el form se ha enviado
        if($form->isSubmitted() && $form->isValid()){


            // Modificando el objeto para guardarlo
            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new \Datetime('now'));

            // Cifrar contraseña
            $enconded = $enconder->encodePassword($user, $user->getPassword());
            $user->setPassword($enconded);

            // Guardar Usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $autenticationUtils)
    {
        $error = $autenticationUtils->getLastAuthenticationError();

        $lastUsername = $autenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername
        ));
    }
    
    public function contact( \Swift_Mailer $mailer) : Response
    {
        $em = $this->getDoctrine()->getManager();

        $task_repo = $this->getDoctrine()->getRepository(Task::class);

        $tasks= $task_repo->findAll([
            'user' => '2'
            ], [
            'id' => 'DESC'
            ]);

            $tarea = $_POST['tarea'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $asunto = $_POST['asunto'];
            $telefono = $_POST['telefono'];
            $mensaje = $_POST['mensaje'];
            $file_name = $_FILES['archivo']['name'];
            move_uploaded_file( $_FILES['archivo']['tmp_name'], $file_name);
    
            // Datos para el correo
            // $emisor = "tareasgenin@gmail.com";
            // $destinatario = "tareasgenin@gmail.com";


            $carta = "<h2>Nombre de la tarea:</h2> <p> <a href='http://10.10.30.177'> $tarea </a> ";
            $carta .= "<h2>De parte de:</h2> <p> $nombre ";
            $carta .= "<h2>Correo eletrónico:</h2> <p> $correo ";
            $carta .= "<h2>Celular de contacto:</h2> <p> $telefono";
            $carta .= "<h3>$mensaje</h3>";
            

        $transport = (new \Swift_SmtpTransport)
            ->setHost('smtp.gmail.com')
            ->setPort('587')
            ->setEncryption('tls')
            ->setUsername('tareasgenin@gmail.com')
            ->setPassword('tareagen123')
        ;

        $mailer = (new \Swift_Mailer($transport));
        
        
        
        $message = (new \Swift_Message())
        ->setPriority(2)
        ->setSubject($asunto)
        ->setFrom('tareasgenin@gmail.com', 'tareas gen')
        ->setTo(['elizabeth.molina@me.com'])
        ->setBody($carta, 'text/html')
        ->setCharset('UTF-8');
        
        if ($file_name != null) {
           $message ->attach(\Swift_Attachment::fromPath($file_name)); 
        }else {
            $message->attach(\Swift_Attachment::fromPath('D:\Escritorio\logogen.png')); //Ruta del computador
        }
            

        // $send = echo ('<script language="javascript">alert("El mensaje se ha enviado exitosamente");</script>');

        // Send the message
        if( $result = $mailer->send($message)){
            echo '<script language="javascript">alert("El mensaje se ha enviado exitosamente");</script>';

        } else  {
            echo `<script language="javascript">alert({$result->ErrorInfo});</script>,`;
        }
        
        return $this->redirectToRoute('tasks', [], 302);

    }
}
