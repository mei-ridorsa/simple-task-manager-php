<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskTitle;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

#[AsCommand(
    name: 'task-manager:change-title',
    description: 'Changes the title.',
    hidden: false,
)]
final class ChangeTaskTitleCommand extends Command
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
            ->addArgument('id', InputArgument::REQUIRED, 'Task ID')
            ->addArgument('title', InputArgument::REQUIRED, 'Task title')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $task = $this->repository->getById(new TaskId($input->getArgument('id')));

        if (!$task) {
            $output->writeln('Task not found: ' . $input->getArgument('id'));
        }

        $task->setTaskTitle(new TaskTitle($input->getArgument('title')));

        $this->repository->save($task);

        $output->writeln('Task title changed: ' . $input->getArgument('id'));

        return Command::SUCCESS;
    }
}
