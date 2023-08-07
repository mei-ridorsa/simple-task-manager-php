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

        $headers = [];
        while (($data = fgetcsv($handle)) !== false) {
            if (!$headers) {
                $headers = $data;
                continue;
            }
            /**
             * @var array{id: string, title: string, description: string, due_date:string, status: string} $combined
             */
            $combined = array_combine($headers, $data);
            yield Task::fromArray($combined);
        }

        fclose($handle);
    }

    /**
     * @throws Exception
     */
    public function getById(TaskId $id): ?Task
    {
        $handle = fopen(implode(DIRECTORY_SEPARATOR, [self::CSV_FILE]), 'rb');

        $headers = [];
        while (($data = fgetcsv($handle)) !== false) {
            if (!$headers) {
                $headers = $data;
                continue;
            }

            /**
             * @var array{id: string, title: string, description: string, due_date:string, status: string} $combined
             */
            $combined = array_combine($headers, $data);

            if ($combined['id'] === $id->value()) {
                return Task::fromArray($combined);
            }
        }

        fclose($handle);

        return null;
    }

    public function add(Task $aggregateRoot): void
    {
        $handle = fopen(implode(DIRECTORY_SEPARATOR, [self::CSV_FILE]), 'wb');

        fputcsv($handle, $aggregateRoot->toArray());

        fclose($handle);
    }

    public function remove(Task $aggregateRoot): void
    {
        $handle = fopen(implode(DIRECTORY_SEPARATOR, [self::CSV_FILE]), 'rwb');
        $tmp_handle = fopen(implode(DIRECTORY_SEPARATOR, [self::TMP_CSV_FILE]), 'wb');

        $headers = [];
        while (($data = fgetcsv($handle)) !== false) {
            if (!$headers) {
                $headers = $data;
                continue;
            }

            /**
             * @var array{id: string, title: string, description: string, due_date:string, status: string} $combined
             */
            $combined = array_combine($headers, $data);

            if ($combined['id'] !== $aggregateRoot->id()->value()) {
                fputcsv($tmp_handle, $data);
            }
        }

        fclose($handle);
        fclose($tmp_handle);
        rename(self::TMP_CSV_FILE, self::CSV_FILE);
    }
}
