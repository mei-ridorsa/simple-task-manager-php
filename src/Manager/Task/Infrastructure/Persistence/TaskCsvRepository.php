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
        //This is assuming that the CSV is well-formed and the first colum is the ID. One improvement would be to check
        //it first.
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
        //This is not the most efficient way to update things, but that's all the Standard library allows
        $this->remove($aggregateRoot);
        $this->add($aggregateRoot);
    }

    public function remove(Task $aggregateRoot): void
    {
        //This creates a new file with all tasks but the one being removed. It's not very efficient but, again,
        //it's all the Standard library allows
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
