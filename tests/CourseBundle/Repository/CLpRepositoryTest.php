<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\Tests\CourseBundle\Repository;

use Chamilo\CourseBundle\Entity\CLp;
use Chamilo\CourseBundle\Repository\CLpRepository;
use Chamilo\Tests\AbstractApiTest;
use Chamilo\Tests\ChamiloTestTrait;

class CLpRepositoryTest extends AbstractApiTest
{
    use ChamiloTestTrait;

    public function testCreate(): void
    {
        self::bootKernel();

        $repo = self::getContainer()->get(CLpRepository::class);

        $course = $this->createCourse('new');
        $teacher = $this->createUser('teacher');

        $lp = (new CLp())
            ->setName('lp')
            ->setParent($course)
            ->setCreator($teacher)
            ->setLpType(CLp::LP_TYPE)
        ;
        $this->assertHasNoEntityViolations($lp);
        $repo->createLp($lp);

        $this->assertNotNull($lp->getResourceNode());
        $this->assertSame(1, $lp->getItems()->count());
        $this->assertSame('lp', (string) $lp);
        $this->assertSame(1, $repo->count([]));
    }
}