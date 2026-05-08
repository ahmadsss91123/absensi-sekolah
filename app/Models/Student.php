<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

class Student extends Model
{
    protected $fillable = [
        'nama',
        'nis',
        'kelas',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
