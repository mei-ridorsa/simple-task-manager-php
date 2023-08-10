<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskManager\Manager\Task\Application\UseCase\Update\ChangeTaskDescriptionHandler;

#[AsCommand(
    name: 'task-manager:change-description',
    description: 'Changes the description.',
    hidden: false,
)]
final class ChangeTaskDescriptionCommand extends Command
{
    private ChangeTaskDescriptionHandler $handler;

    public function __construct(ChangeTaskDescriptionHandler $handler)
    {
        $this->handler = $handler;

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
        $this->handler->handle(
            $input->getArgument('id'),
            $input->getArgument('description'),
        );

        $output->writeln('Task description changed: ' . $input->getArgument('id'));

        return Command::SUCCESS;
    }
}
