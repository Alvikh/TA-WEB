<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DevicesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Device::select('name', 'device_id', 'building', 'type', 'status')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Device ID', 'Building', 'Type', 'Status'];
    }
}
