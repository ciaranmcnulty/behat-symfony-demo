<?php

namespace Cjm\Training\Enrolment\Infrastructure\Doctrine;

use Cjm\Training\Enrolment\Model\Course;
use Doctrine\ORM\EntityManager;

class Courses implements \Cjm\Training\Enrolment\Model\Courses
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Course::class);
    }

    public function add(Course $course): void
    {
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }

    public function findByTitle(string $title): ?Course
    {
        return $this->repository->findOneBy(['title' => $title]);
    }

    public function persist(Course $course): void
    {
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }
}
