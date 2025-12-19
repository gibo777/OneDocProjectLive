<?php

namespace App\Http\Livewire\EForms;

use Livewire\Component;
use Carbon\Carbon;

class WorkFromHome extends Component
{
    public $dateApplied;
    public $newDate;
    public $newTimeFrom;
    public $newTimeTo;
    public $newActivity;
    public $activities = [];

    protected $listeners = ['updateActivity'];

    public function mount()
    {
        $this->dateApplied = Carbon::now()
            ->timezone(config('app.timezone'))
            ->format('m/d/Y');
    }

    public function addActivity()
    {
        $this->validate([
            'newDate' => 'required|date',
            'newTimeFrom' => 'required',
            'newTimeTo' => 'required',
            'newActivity' => 'required|string',
        ]);

        $date = Carbon::parse($this->newDate)->format('Y-m-d');
        $from = Carbon::parse($this->newTimeFrom);
        $to = Carbon::parse($this->newTimeTo);

        if ($to->lessThanOrEqualTo($from)) {
            $this->dispatchBrowserEvent('swal-error', [
                'message' => 'End time must be later than start time.',
            ]);
            return;
        }

        // Check for overlapping with existing activities on the same date
        foreach ($this->activities as $activity) {
            $actDate = Carbon::createFromFormat('m/d/Y', $activity['date'])->format('Y-m-d');
            if ($actDate === $date) {
                $existingFrom = Carbon::createFromFormat('h:i A', $activity['from']);
                $existingTo = Carbon::createFromFormat('h:i A', $activity['to']);
                if ($from->lt($existingTo) && $to->gt($existingFrom)) {
                    $this->dispatchBrowserEvent('swal-error', [
                        'message' => 'Time overlaps with another activity on the same date.',
                    ]);
                    return;
                }
            }
        }

        $this->activities[] = [
            'date' => Carbon::parse($this->newDate)->format('m/d/Y'),
            'from' => $from->format('h:i A'),
            'to' => $to->format('h:i A'),
            'activity' => preg_replace(
                ["/[ \t]+$/m", "/^\s+/m", "/(\r?\n){2,}/"],
                ['', '', "\n"],
                trim($this->newActivity)
            ),
        ];

        // ✅ Proper sorting by date then time
        usort($this->activities, function ($a, $b) {
            $aDateTime = Carbon::createFromFormat('m/d/Y h:i A', $a['date'] . ' ' . $a['from']);
            $bDateTime = Carbon::createFromFormat('m/d/Y h:i A', $b['date'] . ' ' . $b['from']);
            return $aDateTime <=> $bDateTime;
        });

        $this->reset(['newTimeFrom', 'newTimeTo', 'newActivity']);
        $this->dispatchBrowserEvent('activityAdded');
    }



    public function removeActivity($index)
    {
        array_splice($this->activities, $index, 1);
    }

    public function openEdit($index)
    {
        $activity = $this->activities[$index];

        // Convert displayed values (m/d/Y, h:i A) into input-friendly format (Y-m-d, H:i)
        $parsedDate = Carbon::createFromFormat('m/d/Y', $activity['date'])->format('Y-m-d');
        $parsedFrom = Carbon::createFromFormat('h:i A', $activity['from'])->format('H:i');
        $parsedTo = Carbon::createFromFormat('h:i A', $activity['to'])->format('H:i');

        $this->dispatchBrowserEvent('open-edit-modal', [
            'index' => $index,
            'date' => $parsedDate,
            'timeFrom' => $parsedFrom,
            'timeTo' => $parsedTo,
            'activity' => $activity['activity'],
        ]);
    }

    public function updateActivity($index, $date, $from, $to, $activity)
    {
        if (empty($date) || empty($from) || empty($to) || empty(trim($activity))) {
            $this->dispatchBrowserEvent('swal-error', [
                'message' => 'All fields are required to update activity.',
            ]);
            return;
        }

        $parsedDate = Carbon::parse($date)->format('Y-m-d');
        $parsedFrom = Carbon::parse($from);
        $parsedTo = Carbon::parse($to);

        if ($parsedTo->lessThanOrEqualTo($parsedFrom)) {
            $this->dispatchBrowserEvent('swal-error', [
                'message' => 'End time must be later than start time.',
            ]);
            return;
        }

        // ✅ Check for overlapping (exclude current index)
        foreach ($this->activities as $i => $activityData) {
            if ($i === $index) continue;

            $actDate = Carbon::createFromFormat('m/d/Y', $activityData['date'])->format('Y-m-d');
            if ($actDate === $parsedDate) {
                $existingFrom = Carbon::createFromFormat('h:i A', $activityData['from']);
                $existingTo = Carbon::createFromFormat('h:i A', $activityData['to']);

                if ($parsedFrom->lt($existingTo) && $parsedTo->gt($existingFrom)) {
                    $this->dispatchBrowserEvent('swal-error', [
                        'message' => 'Updated time overlaps with another activity on the same date.',
                    ]);
                    return;
                }
            }
        }

        $this->activities[$index] = [
            'date' => Carbon::parse($date)->format('m/d/Y'),
            'from' => $parsedFrom->format('h:i A'),
            'to' => $parsedTo->format('h:i A'),
            'activity' => preg_replace(
                ["/[ \t]+$/m", "/^\s+/m", "/(\r?\n){2,}/", "/^\n+|\n+$/"],
                ['', '', "\n", ''],
                trim($activity)
            ),
        ];

        // ✅ Sort again after update
        usort($this->activities, function ($a, $b) {
            $aDateTime = Carbon::createFromFormat('m/d/Y h:i A', $a['date'] . ' ' . $a['from']);
            $bDateTime = Carbon::createFromFormat('m/d/Y h:i A', $b['date'] . ' ' . $b['from']);
            return $aDateTime <=> $bDateTime;
        });

        $this->dispatchBrowserEvent('swal-success', [
            'message' => 'Activity updated successfully!',
        ]);
    }


    public function submitWFH()
    {
        $this->validate([
            'activities' => 'required|array|min:1',
            'activities.*.date' => 'required|string',
            'activities.*.from' => 'required|string',
            'activities.*.to' => 'required|string',
            'activities.*.activity' => 'required|string',
        ]);

        session()->flash('message', 'WFH Request submitted successfully!');
    }

    public function render()
    {
        return view('livewire.e-forms.work-from-home', [
            'dateApplied' => $this->dateApplied,
        ]);
    }
}
