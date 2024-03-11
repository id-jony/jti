<?php

namespace App\Observers;

use App\Models\Department;
use App\Models\Employee;
use Ramsey\Uuid\Uuid;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use MoonShine\MoonShineUI;

class EmployeeObserver
{
    public function creating(Employee $employee)
    {
        $employee->uuid = Uuid::uuid4()->toString();

        if($employee->email && Employee::where('email', $employee->email)->first()) {
            return false;
        }
        if(!is_numeric($employee->department_id)) {
            $employee->department_id = Department::firstOrCreate(
                ['name' => str($employee->department_id)->trim()]
            )->id;
        }
    }

    public function created(Employee $employee)
    {
        $qr_code = base64_encode(
            QrCode::format('svg')
                ->size(230)
                ->errorCorrection('H')
                ->generate(route('qr', ['code' => $employee->id.'|'.$employee->uuid]))
            );
        $data = [
            'qrcode' => $qr_code
        ];
        $pdf = PDF::loadView('pdf', $data);
        $pdf->getDomPDF()->getCanvas()->image(public_path('pdf.png'), 0, 0, 595, 842);
        $pdf->save(storage_path('/pdf/'.$employee->uuid.'.pdf'));
    }

    public function updating(Employee $employee)
    {
        $original = $employee->getOriginal();
        $changes = $employee->getDirty();
        foreach ($changes as $attribute => $newValue) {
            if($attribute === 'is_passed') {
                if($original['is_passed'] != $newValue) {
                    $employee->passed = $newValue ? now() : null;
                } else {
                    MoonShineUi::toast('QR-код ранее уже отсканирован', 'error');
                }
            } else if($attribute === 'is_registered' && $original['is_registered'] != $newValue) {
                $employee->registered = $newValue ? now() : null;
            }
        }
    }

    public function deleting(Employee $employee)
    {
        if($employee->is_passed) {
            return false;
        }
    }
}
