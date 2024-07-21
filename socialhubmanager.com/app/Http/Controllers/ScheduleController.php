<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    public function index()
    {
        // Es esto: auth()->user()->schedules->groupBy('day_of_week')

        return view('schedules.index', [
            'schedules' => Schedule::all()->groupBy('day_of_week')
        ]);
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function store(Request $request)
    {

        $attributes = array_merge($this->validateSchedule(), [
            'user_id' => $request->user()->id
        ]);

        Schedule::create($attributes);

        return redirect('schedules.index')->with('success', 'Horario creado exitosamente.');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', ['$schedule' => $schedule]);
    }

    public function update(Schedule $schedule, Request $request)
    {
        $attributes = $this->validateSchedule($schedule);

        $schedule->update($attributes);

        return redirect('schedules.index')->with('success', 'Horario actualizado exitosamente.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Horario eliminado exitosamente.');
    }

    protected function validateSchedule(?Schedule $schedule = null): array
    {
        $schedule ??= new Schedule();

        return request()->validate([
            'day_of_week' => ['required', Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])],
            'time' 
                => ['required', 'date_format:H:i', 
                Rule::unique('schedules')->where(function ($query) {
                    return $query->where('user_id', request()->user()->id)
                                 ->where('day_of_week', request('day_of_week'));
                })->ignore($schedule)],
        ], [
            'time.unique' => 'Ya existe un horario para ese día y hora.'
        ]);
    }
}
