<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Application\UseCase\Remove\RemoveTaskHandler;

#[AsCommand(
    name: 'task-manager:delete-task',
    description: 'Deletes a task.',
    hidden: false,
)]
final class DeleteTaskCommand extends Command
{
    private RemoveTaskHandler $handler;

    public function __construct(RemoveTaskHandler $handler)
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
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handler->handle($input->getArgument('id'));

        $output->writeln('Task removed: ' . $input->getArgument('id'));

        return Command::SUCCESS;
    }
}
