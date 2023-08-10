<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Application\UseCase\Update\ChangeTaskDueDateHandler;

#[AsCommand(
    name: 'task-manager:change-duedate',
    description: 'Changes the due date.',
    hidden: false,
)]
final class ChangeTaskDueDateCommand extends Command
{
    private ChangeTaskDueDateHandler $handler;

    public function __construct(ChangeTaskDueDateHandler $handler)
    {
        $this->handler = $handler;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Task ID')
            ->addArgument('due_date', InputArgument::REQUIRED, 'Task due date')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handler->handle(
            $input->getArgument('id'),
            $input->getArgument('due_date'),
        );

        $output->writeln('Task due date changed: ' . $input->getArgument('id'));

        return Command::SUCCESS;
    }
}
