<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class RepeatTasks extends Command
{
    protected $signature = 'tasks:repeat';
    protected $description = 'Cria novas tarefas baseadas na repetição configurada';

    public function handle(): int
    {
        $now = Carbon::now();

        $tasks = Task::whereIn('repeat_interval', ['daily', 'biweekly', 'monthly'])
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<=', $now->toDateString()) // ADICIONE ISSO
            ->get();

        foreach ($tasks as $task) {
            $nextDueDate = match ($task->repeat_interval) {
                'daily'     => Carbon::parse($task->due_date)->addDay(),
                'biweekly'  => Carbon::parse($task->due_date)->addDays(15),
                'monthly'   => Carbon::parse($task->due_date)->addMonth(),
                default     => null,
            };

            if ($nextDueDate && $now->isSameDay($nextDueDate)) {
                Task::create([
                    'flow_id'         => $task->flow_id,
                    'title'           => $task->title,
                    'description'     => $task->description,
                    'priority'        => $task->priority,
                    'due_date'        => $nextDueDate,
                    'type'            => $task->type,
                    'repeat_interval' => $task->repeat_interval,
                ]);

                $this->info("Tarefa repetida: {$task->title}");
            }
        }

        return Command::SUCCESS;
    }
}
