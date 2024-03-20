<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RegisterController;
use App\Observers\EmployeeObserver;
use App\Models\Employee;
use Ramsey\Uuid\Uuid;

class GeneratePdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = Employee::All();
        foreach ($employees as $employee) {
            $employee->uuid = Uuid::uuid4()->toString();
            $employee->save();
            
            (new EmployeeObserver)->created($employee);
            // break;
        }
    }
}
