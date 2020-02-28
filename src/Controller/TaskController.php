<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;


class TaskController extends AbstractController
{

    public function index()
    {
        // Prueba de entidades y relaciones

        $em = $this->getDoctrine()->getManager();

        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks= $task_repo->findAll([
                'user' => "2,3",
		
            ],[
                'id' => 'DESC'
            ]);


        $user_repo = $this->getDoctrine()->getManager()->getRepository(User::class);
        $users = $user_repo->findAll();

        // foreach ($users as $user) {
        //     echo "<h1>{$user->getName()} {$user->getSurname()}</h1>";
            
        //     foreach ($user->getTasks() as $task) {
        //         echo $task->getTitle()."<br/>";
        //     } 
        // }

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'users' => $users

        ]);
    }

    public function detail(Task $task)
    {
        if(!$task){ 
            return $this->redirectToRoute('task');
        }
            return $this->render('task/detail.html.twig', [
                'task' => $task
            ]);
        }
    
        
    // ============================================================================================


    public function creation(Request $request, UserInterface $user)
    {

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $task->setCreatedAt(new \Datetime('now'));
            $task->setUser($user);

            $task = $form->get('adjunto')->getData();
            if ($task) {
                $task =
                 pathinfo
                ($task->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $task);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$task->guessExtension();

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', [
                    'id' => $task->getId()
                ])
            );
        }

        return null;
        }}

    // ============================================================================================
    
    public function myTasks(UserInterface $user)
    {
        $tasks = $user->getTasks();
        
        
        return $this->render('task/my-tasks.html.twig', [
            'tasks' => $tasks
            ]);
        }

    // ============================================================================================
    
    public function edit(Request $request, UserInterface $user, Task $task)
    {
        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }
        
        $form = $this->createForm(TaskType::class, $task);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            // $task->setCreatedAt(new \Datetime('now'));
            // $task->setUser($user);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            return $this->redirect(
                $this->generateUrl('task_detail', [
                    'id' => $task->getId()
                    ])
                );
            }
            
            return $this->render('task/creation.html.twig',[
                'edit' => true,
                'form' => $form->createView()
                ]);
            }


    // ============================================================================================
            
            public function delete(UserInterface $user, Task $task)
            {
        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }
        if(!$task){
            return $this->redirectToRoute('tasks', );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('tasks');
    }



}