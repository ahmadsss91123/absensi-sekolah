<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedKelas = $request->query('kelas');
        $classes = Student::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $students = Student::orderBy('created_at', 'desc')
            ->when($selectedKelas, fn ($query) => $query->where('kelas', $selectedKelas))
            ->get();

        return view('students.index', compact('students', 'classes', 'selectedKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis'],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis,' . $student->id],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Display attendance recap for all students.
     */
    public function recap()
    {
        $recaps = Student::select([
                'students.id',
                'students.nama',
                'students.kelas',
                DB::raw('COUNT(CASE WHEN attendances.status = "hadir" THEN 1 END) as total_hadir'),
                DB::raw('COUNT(CASE WHEN attendances.status = "izin" THEN 1 END) as total_izin'),
                DB::raw('COUNT(CASE WHEN attendances.status = "sakit" THEN 1 END) as total_sakit'),
                DB::raw('COUNT(CASE WHEN attendances.status = "alpa" THEN 1 END) as total_alpa'),
                DB::raw('COUNT(attendances.id) as total_kehadiran')
            ])
            ->leftJoin('attendances', 'students.id', '=', 'attendances.student_id')
            ->groupBy('students.id', 'students.nama', 'students.kelas')
            ->orderBy('students.nama')
            ->get();

        return view('students.recap', compact('recaps'));
    }
}
