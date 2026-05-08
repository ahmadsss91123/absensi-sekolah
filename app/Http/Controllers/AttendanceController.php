<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $selectedKelas = $request->query('kelas');
        $classes = Student::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $attendances = Attendance::with('student')
            ->when($selectedKelas, fn ($query) => $query->whereHas('student', fn ($query) => $query->where('kelas', $selectedKelas)))
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('attendances.index', compact('attendances', 'classes', 'selectedKelas'));
    }

    public function create(Request $request)
    {
        $selectedKelas = $request->query('kelas');
        $classes = Student::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $students = Student::when($selectedKelas, fn ($query) => $query->where('kelas', $selectedKelas))
            ->orderBy('nama')
            ->get();

        return view('attendances.create', compact('students', 'classes', 'selectedKelas'));
    }

    public function bulkCreate(Request $request)
    {
        $selectedKelas = $request->query('kelas');
        $selectedTanggal = $request->query('tanggal');
        $classes = Student::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $students = collect();
        if ($selectedKelas) {
            $students = Student::where('kelas', $selectedKelas)
                ->orderBy('nama')
                ->get();
        }

        return view('attendances.bulk', compact('classes', 'selectedKelas', 'selectedTanggal', 'students'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'kelas' => ['required', 'exists:students,kelas'],
            'tanggal' => ['required', 'date'],
            'statuses' => ['required', 'array'],
            'statuses.*' => ['required', Rule::in(['hadir', 'izin', 'sakit', 'alpa'])],
        ]);

        $students = Student::where('kelas', $validated['kelas'])->get();

        foreach ($students as $student) {
            $status = $validated['statuses'][$student->id] ?? null;
            if (! $status) {
                continue;
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'tanggal' => $validated['tanggal'],
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Absensi massal berhasil disimpan.');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'student_id' => ['required', 'exists:students,id'],
        'tanggal' => ['required', 'date'],
        'status' => ['required', Rule::in(['hadir', 'izin', 'sakit', 'alpa'])],
    ]);

    $sudahAbsen = Attendance::where('student_id', $request->student_id)
        ->whereDate('tanggal', $request->tanggal)
        ->exists();

    if ($sudahAbsen) {
        return back()
            ->withErrors([
                'tanggal' => 'Siswa sudah diabsen pada tanggal yang sama.'
            ])
            ->withInput();
    }

    Attendance::create($validated);

    return redirect()
        ->route('attendances.index')
        ->with('success', 'Absensi berhasil disimpan.');
}

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::orderBy('nama')->get();

        return view('attendances.edit', compact('attendance', 'students'));
    }

   public function update(Request $request, Attendance $attendance)
{
    $validated = $request->validate([
        'student_id' => ['required', 'exists:students,id'],
        'tanggal' => ['required', 'date'],
        'status' => ['required', Rule::in(['hadir', 'izin', 'sakit', 'alpa'])],
    ]);

    $sudahAbsen = Attendance::where('student_id', $request->student_id)
        ->whereDate('tanggal', $request->tanggal)
        ->where('id', '!=', $attendance->id)
        ->exists();

    if ($sudahAbsen) {
        return back()
            ->withErrors([
                'tanggal' => 'Siswa sudah diabsen pada tanggal yang sama.'
            ])
            ->withInput();
    }

    $attendance->update($validated);

    return redirect()
        ->route('attendances.index')
        ->with('success', 'Absensi berhasil diperbarui.');
}

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil dihapus.');
    }
}
