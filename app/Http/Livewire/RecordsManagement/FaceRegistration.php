<?php

namespace App\Http\Livewire\RecordsManagement;

use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class FaceRegistration extends Component
{
    use WithPagination;

    public $pageSize = 15;
    public $offices;
    public $departments;
    public $search = '';
    public $fTLOffice = '';
    public $fTLDept = '';
    public $fTLdtFrom = '';
    public $fTLdtTo = '';

    protected $listeners = ['pageSizeChanged'];

    public function mount()
    {
        $this->loadDropdowns();
    }

    public function render()
    {
        $timeLogs = $this->fetchUsersList();

        return view('livewire.records-management.face-registration', [
            'timeLogs' => $timeLogs,
            'offices' => $this->offices,
            'departments' => $this->departments,
        ]);
    }

    private function loadDropdowns()
    {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
    }

    public function clearDateFilters()
    {
        $this->fTLdtFrom = null;
        $this->fTLdtTo = null;
    }

    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }

    /* private function fetchUsersList()
    {
        $apiKey = config('services.compreface.recognition_api_key');
        $apiUrl = rtrim(config('services.compreface.url'), '/');

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->get("{$apiUrl}/api/v1/recognition/faces");

        // ✅ Fix: use paginator resolver
        $currentPage = Paginator::resolveCurrentPage() ?: 1;

        if (!$response->ok()) {
            return new LengthAwarePaginator([], 0, $this->pageSize, $currentPage, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
        }

        $faces = collect($response->json('faces') ?? []);

        $grouped = $faces->groupBy('subject')->map(function ($items, $subject) {
            return [
                'subject' => $subject,
                'images' => $items->pluck('image_id')->toArray(),
            ];
        })->values();

        if ($this->search) {
            $grouped = $grouped->filter(
                fn($face) =>
                stripos($face['subject'], $this->search) !== false
            );
        }

        $sorted = $grouped->sortBy('subject', SORT_NATURAL | SORT_FLAG_CASE);

        $items = $sorted->forPage($currentPage, $this->pageSize);

        return new LengthAwarePaginator(
            $items,
            $sorted->count(),
            $this->pageSize,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    } */


    private function fetchUsersList()
    {
        $users = DB::table('users as u')
            ->leftJoin('offices as o', 'u.office', 'o.id')
            ->leftJoin('departments as d', 'u.department', 'd.department_code')
            ->leftJoin('users_face_registration as uf', 'uf.user_id', 'u.id')
            ->select(
                'u.id',
                'u.name',
                'u.employee_id',
                'o.company_name as office',
                'd.department',
                'uf.api_image_count as image_count'
            )
            ->where('u.employment_status', '!=', 'NO LONGER CONNECTED');

        if (!empty($this->search)) {
            $searchTerms = explode(' ', $this->search);

            $users->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where('u.name', 'like', '%' . $term . '%');
                }
            })->orWhere(function ($q) {
                $q->where('u.employee_id', 'like', '%' . $this->search . '%');
            });
        }

        $users = $users->orderBy('u.name')
            ->paginate($this->pageSize);

        return $users;


        // ### Face Recognition API ###
        // $apiKey = config('services.compreface.recognition_api_key');
        // $apiUrl = rtrim(config('services.compreface.url'), '/');

        // $response = Http::withHeaders([
        //     'x-api-key' => $apiKey,
        // ])->get("{$apiUrl}/api/v1/recognition/faces");

        // ### paginator resolver ###
        // $currentPage = Paginator::resolveCurrentPage() ?: 1;

        // if (!$response->ok()) {
        //     return new LengthAwarePaginator([], 0, $this->pageSize, $currentPage, [
        //         'path' => request()->url(),
        //         'query' => request()->query(),
        //     ]);
        // }

        // $faces = collect($response->json('faces') ?? []);

        // $grouped = $faces->groupBy('subject')->map(function ($items, $subject) {
        //     return [
        //         'subject' => $subject,
        //         'images' => $items->pluck('image_id')->toArray(),
        //     ];
        // })->values();

        // if ($this->search) {
        //     $grouped = $grouped->filter(
        //         fn($face) =>
        //         stripos($face['subject'], $this->search) !== false
        //     );
        // }

        // $sorted = $grouped->sortBy('subject', SORT_NATURAL | SORT_FLAG_CASE);

        // $items = $sorted->forPage($currentPage, $this->pageSize);

        // return new LengthAwarePaginator(
        //     $items,
        //     $sorted->count(),
        //     $this->pageSize,
        //     $currentPage,
        //     ['path' => request()->url(), 'query' => request()->query()]
        // );
    }

    public function userFaceRegistration(Request $request)
    {
        $user = DB::table('users as u')
            ->leftJoin('offices as o', 'u.office', 'o.id')
            ->leftJoin('departments as d', 'u.department', 'd.department_code')
            ->leftJoin('users as s', 'u.supervisor', 's.employee_id')
            ->select(
                'u.id',
                'u.name',
                'u.employee_id',
                'o.company_name as office',
                'd.department',
                's.name as supervisor'
            )
            ->where('u.id', $request->uID)
            ->first();




        ### Getting Images from API ###
        $id = (int) $request->uID;

        $apiUrl = rtrim(config('services.compreface.url'), '/');
        $apiKey = config('services.compreface.recognition_api_key');

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->get("{$apiUrl}/api/v1/recognition/faces");

        $faces = $response->json()['faces'] ?? [];

        ### Filter faces by subject ID ###
        $matchedFaces = collect($faces)->filter(function ($face) use ($id) {
            $subject = $face['subject'] ?? null;
            $subjectId = (int) explode('_', $subject)[0];
            return $subjectId === $id;
        });

        ### Get image IDs ###
        $imageIDs = $matchedFaces->pluck('image_id')->values();

        ### Fetch each image by ID ###
        $images = collect();
        $subject = null;
        $responses = [];

        foreach ($imageIDs as $imageId) {
            $subject = $matchedFaces->first()['subject'] ?? null;

            $imgResponse = Http::withHeaders([
                'x-api-key' => $apiKey,
            ])->get("{$apiUrl}/api/v1/recognition/subjects/{$subject}/images/{$imageId}/download");

            $responses[] = [
                'image_id' => $imageId,
                'status'   => $imgResponse->status(),
                'headers'  => $imgResponse->headers(),
                'body'     => substr($imgResponse->body(), 0, 100) . '...', // truncate to preview
            ];

            if ($imgResponse->successful()) {
                $mime = $imgResponse->header('Content-Type') ?? 'image/jpeg';
                $images->push("data:$mime;base64," . base64_encode($imgResponse->body()));
            }
        }

        return view('modals.records-management.m-face-registration', [
            'user'     => $user,
            'images'   => $images,
            'imageIDs' => $imageIDs,
            'subject'  => $subject,
            'response' => $responses,
        ]);
    }
}
