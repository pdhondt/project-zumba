<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    #[Route('/lesson_create', name: 'lesson_create')]
    public function createLesson(Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonFormType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lesson);
            $entityManager->flush();

            return $this->redirectToRoute('lesson_overview');
        }

        return $this->render('lesson/create.html.twig', [
            'lessonForm' => $form->createView(),
        ]);
    }

    #[Route('/lesson_overview', name: 'lesson_overview')]
    public function lessonOverview(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Lesson::class);
        $lessons = $repository->findAll();

        return $this->render('lesson/overview.html.twig', [
            'lessons' => $lessons,
        ]);
    }
}
