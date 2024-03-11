<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mail\InviteMail;
use App\Models\Employee;
use App\Observers\EmployeeObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use MoonShine\MoonShineAuth;

class RegisterController extends Controller
{
    public function qr(Request $request)
    {
        [$id, $uuid] = str($request->code)->explode('|');
        $employee = Employee::findOrFail($id);
        if($employee->uuid !== $uuid) abort(404);
        if(MoonShineAuth::guard()->check()) {
            $employee->is_passed = true;
            $employee->save();
            return redirect()->route('moonshine.employees.show', ['resourceItem'=> $employee->id]);
        }
        else return redirect()->route('index');
    }

    public function registration(RegistrationRequest $request)
    {
        $sendEmail = false;

        $data = $request->validated();
        app()->setLocale($data['lang']);

        $employee = Employee::findOrFail($data['employee_id']);

        // Если пользователь еще не регистрировался или отсутвует почта в базе
        if(!$employee->is_registered || !$employee->email) {
            $sendEmail = true;
        }

        $employee->is_registered = true;
        if(!$employee->email) {
            $employee->email = $data['email'];
        }
        $employee->save();
        if($sendEmail) {
            if(!file_exists(storage_path('/pdf/'.$employee->uuid.'.pdf'))) {
                (new EmployeeObserver)->created($employee);
            }
            Mail::to($employee->email)->send(new InviteMail($employee->uuid));
        }
        return collect(['route' => route('download', ['employee' => $employee->id,'uuid' => $employee->uuid])]);
    }

    public function download(Employee $employee, string $uuid)
    {
        $path = storage_path('/pdf/'.$uuid.'.pdf');

        if ($employee->uuid === $uuid && file_exists($path)) {
            return response()->download($path);
        }
        return abort(404);
    }
}
