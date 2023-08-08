<?php

declare(strict_types=1);

namespace TaskManager\Manager\Task\Infrastructure\Persistence;

use Exception;
use Generator;
use TaskManager\Manager\Task\Domain\Task;
use TaskManager\Manager\Task\Domain\TaskId;
use TaskManager\Manager\Task\Domain\TaskRepository;

final class TaskCsvRepository implements TaskRepository
{
    //This should actually be located in a config file
    protected const CSV_FILE = 'input.csv';
    protected const TMP_CSV_FILE = 'tmp_input';

    /**
     * @throws Exception
     */
    public function getAll(): Generator
    {
        $handle = fopen(implode(DIRECTORY_SEPARATOR, [self::CSV_FILE]), 'rb');

        while (($data = fgetcsv($handle)) !== false) {
            yield Task::fromArray($data);
        }

        fclose($handle);
    }

    /**
     * @throws Exception
     */
    public function getById(TaskId $id): ?Task
    {
        $handle = fopen(implode(DIRECTORY_SEPARATOR, [self::CSV_FILE]), 'rb');

        while (($data = fgetcsv($handle)) !== false) {
            if ($data['0'] === $id->value()) {
                return Task::fromArray($data);
            }
        }

        fclose($handle);

        return null;
    }

    public function add(Task $aggregateRoot): void
    {
        $handle = fopen(implode(DIRECTORY_SEPARATOR, [self::CSV_FILE]), 'ab');

        fputcsv($handle, $aggregateRoot->toArray());

        fclose($handle);
    }

    public function save(Task $aggregateRoot): void
    {
        $this->remove($aggregateRoot);
        $this->add($aggregateRoot);
    }

    public function remove(Task $aggregateRoot): void
    {
        $handle = fopen(implode(DIRECTORY_SEPARATOR, [self::CSV_FILE]), 'rwb');
        $tmp_handle = fopen(implode(DIRECTORY_SEPARATOR, [self::TMP_CSV_FILE]), 'wb');

        while (($data = fgetcsv($handle)) !== false) {
            if ($data['0'] !== $aggregateRoot->getId()->value()) {
                fputcsv($tmp_handle, $data);
            }
        }

        fclose($handle);
        fclose($tmp_handle);
        rename(self::TMP_CSV_FILE, self::CSV_FILE);
    }
}
