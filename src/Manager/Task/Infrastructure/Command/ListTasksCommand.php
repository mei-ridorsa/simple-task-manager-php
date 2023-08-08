<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Infrastructure\Persistence\TaskCsvRepository;

#[AsCommand(
    name: 'task-manager:list-tasks',
    description: 'Lists all tasks.',
    hidden: false,
)]

final class ListTasksCommand extends Command
{

    private TaskCsvRepository $repository;

    public function __construct(TaskCsvRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);

        $table
            ->setHeaders(['ID', 'Title', 'Description', 'Due Date', 'Status'])
        ;

        foreach ($this->repository->getAll() as $task) {
            $table->addRow(
                [
                    $task->getId()->value(),
                    $task->getTaskTitle()->value(),
                    $task->getTaskDescription()->value(),
                    (string)$task->getTaskDueDate(),
                    $task->getTaskStatus()->value(),
                ]
            );
        }

        $table->render();

        return Command::SUCCESS;
    }
}
