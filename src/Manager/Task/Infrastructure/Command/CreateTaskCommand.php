<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Application\UseCase\Create\CreateTaskHandler;
use TaskManager\Manager\Task\Domain\Exception\InvalidTaskDueDateValue;

#[AsCommand(
    name: 'task-manager:create-task',
    description: 'Creates a task.',
    hidden: false,
)]
final class CreateTaskCommand extends Command
{
    private CreateTaskHandler $handler;

    public function __construct(CreateTaskHandler $handler)
    {
        $this->handler = $handler;

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

        $this->handler->handle(
            $input->getArgument('title'),
            $input->getArgument('description'),
            $input->getArgument('due_date'),
        );

        $output->writeln('Task created ');

        return Command::SUCCESS;
    }
}
