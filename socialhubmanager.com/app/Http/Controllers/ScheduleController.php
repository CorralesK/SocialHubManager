<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('schedules.index', ['schedules' => Schedule::forUser()]);
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function store(Request $request)
    {

        $attributes = array_merge($this->validateSchedule(), [
            'user_id' => auth()->user()->id
        ]);

        Schedule::create($attributes);

        return redirect('/schedules')->with('success', 'Schedule successfully created.');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', ['schedule' => $schedule]);
    }

    public function update(Schedule $schedule, Request $request)
    {
        $attributes = $this->validateSchedule($schedule);

        $schedule->update($attributes);

        return redirect('/schedules')->with('success', 'Schedule successfully updated.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Schedule successfully deleted.');
    }

    protected function validateSchedule(?Schedule $schedule = null): array
    {
        $schedule ??= new Schedule();

        return request()->validate([
            'day_of_week' => ['required', Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])],
            'time' 
                => ['required', 
                Rule::unique('schedules')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id)
                                 ->where('day_of_week', request('day_of_week'));
                })->ignore($schedule)],
        ], [
            'time.unique' => 'There is already a schedule for that day and time.'
        ]);
    }
}
