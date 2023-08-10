<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Application\UseCase\Update\MarkTaskAsCompleteHandler;
use TaskManager\Manager\Task\Domain\Exception\TaskNotFoundException;

#[AsCommand(
    name: 'task-manager:mark-completed',
    description: 'Sets a task as completed.',
    hidden: false,
)]
final class MarkTaskAsCompletedCommand extends Command
{
    private MarkTaskAsCompleteHandler $handler;

    public function __construct(MarkTaskAsCompleteHandler $handler)
    {
        $this->handler = $handler;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Task ID')
        ;
    }

    /**
     * @throws TaskNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handler->handle($input->getArgument('id'));

        $output->writeln('Task marked as completed: ' . $input->getArgument('id'));

        return Command::SUCCESS;
    }
}
