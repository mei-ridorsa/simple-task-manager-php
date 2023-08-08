<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Domain\Exception\InvalidTaskDueDateValue;
use TaskManager\Manager\Task\Domain\Task;
use TaskManager\Manager\Task\Domain\TaskDescription;
use TaskManager\Manager\Task\Domain\TaskDueDate;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskStatus;
use TaskManager\Manager\Task\Domain\TaskTitle;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

#[AsCommand(
    name: 'task-manager:create-task',
    description: 'Creates a task.',
    hidden: false,
)]
final class CreateTaskCommand extends Command
{
    private TaskCsvRepository $repository;

    public function __construct(TaskCsvRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Task title')
            ->addArgument('description', InputArgument::REQUIRED, 'Task description')
            ->addArgument('due_date', InputArgument::REQUIRED, 'Task due date. Format dd/mm/yyyy')
        ;
    }

    /**
     * @throws InvalidTaskDueDateValue
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $task = new Task(
            TaskId::generate(),
            new TaskTitle($input->getArgument('title')),
            new TaskDescription($input->getArgument('description')),
            TaskDueDate::createFromString($input->getArgument('due_date')),
            new TaskStatus('Pending'),
        );

        $this->repository->add($task);

        $output->writeln('Task created ');

        return Command::SUCCESS;
    }
}
