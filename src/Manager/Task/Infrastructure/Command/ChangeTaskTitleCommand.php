<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Application\UseCase\Update\ChangeTaskTitleHandler;

#[AsCommand(
    name: 'task-manager:change-title',
    description: 'Changes the title.',
    hidden: false,
)]
final class ChangeTaskTitleCommand extends Command
{
    private ChangeTaskTitleHandler $handler;

    public function __construct(ChangeTaskTitleHandler $handler)
    {
        $this->handler = $handler;

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
        $this->handler->handle(
            $input->getArgument('id'),
            $input->getArgument('title'),
        );

        $output->writeln('Task title changed: ' . $input->getArgument('id'));

        return Command::SUCCESS;
    }
}
