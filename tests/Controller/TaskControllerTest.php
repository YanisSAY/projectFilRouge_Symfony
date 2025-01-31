<?php

namespace App\Test\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/task/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Task::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Task index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'task[nameTask]' => 'Testing',
            'task[statusTask]' => 'Testing',
            'task[beginDate]' => 'Testing',
            'task[endDate]' => 'Testing',
            'task[isFinishedTask]' => 'Testing',
            'task[isSuccessTask]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Task();
        $fixture->setNameTask('My Title');
        $fixture->setStatusTask('My Title');
        $fixture->setBeginDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setIsFinishedTask('My Title');
        $fixture->setIsSuccessTask('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Task');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Task();
        $fixture->setNameTask('Value');
        $fixture->setStatusTask('Value');
        $fixture->setBeginDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setIsFinishedTask('Value');
        $fixture->setIsSuccessTask('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'task[nameTask]' => 'Something New',
            'task[statusTask]' => 'Something New',
            'task[beginDate]' => 'Something New',
            'task[endDate]' => 'Something New',
            'task[isFinishedTask]' => 'Something New',
            'task[isSuccessTask]' => 'Something New',
        ]);

        self::assertResponseRedirects('/task/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNameTask());
        self::assertSame('Something New', $fixture[0]->getStatusTask());
        self::assertSame('Something New', $fixture[0]->getBeginDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getIsFinishedTask());
        self::assertSame('Something New', $fixture[0]->getIsSuccessTask());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Task();
        $fixture->setNameTask('Value');
        $fixture->setStatusTask('Value');
        $fixture->setBeginDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setIsFinishedTask('Value');
        $fixture->setIsSuccessTask('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/task/');
        self::assertSame(0, $this->repository->count([]));
    }
}
