<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskDescription;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

#[AsCommand(
    name: 'task-manager:change-description',
    description: 'Changes the description.',
    hidden: false,
)]
final class ChangeTaskDescriptionCommand extends Command
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
            ->addArgument('description', InputArgument::REQUIRED, 'Task description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $task = $this->repository->getById(new TaskId($input->getArgument('id')));

        if (!$task) {
            $output->writeln('Task not found: ' . $input->getArgument('id'));
        }

        $task->setTaskDescription(new TaskDescription($input->getArgument('description')));

        $this->repository->save($task);

        $output->writeln('Task description changed: ' . $input->getArgument('id'));

        return Command::SUCCESS;
    }
}
