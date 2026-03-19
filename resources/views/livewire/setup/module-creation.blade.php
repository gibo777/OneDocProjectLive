<x-slot name="header">
    {{ __('MODULE CREATION') }}
</x-slot>

<div id="view_modules" class="w-100 p-0">

    <div class="bg-white p-3 shadow m-0">

        {{-- FILTER & BUTTON --}}
        <div class="row mb-2">
            <div class="col-md-2">
                <div class="form-floating w-100">
                    <select wire:model="fNavCategory" name="fNavCategory" id="fNavCategory"
                        class="form-control rounded-md shadow-sm mt-1">
                        <option value="">All Categories</option>
                        @foreach ($mCategory as $category)
                            <option
                                value="{{ is_array($category) ? $category['category_name'] : $category->category_name }}">
                                {{ is_array($category) ? $category['category_name'] : $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    <x-jet-label for="fNavCategory" value="{{ __('NAV CATEGORY') }}" />
                </div>
            </div>

            <div class="col-md-2 d-flex justify-content-center align-items-center my-2">
                <x-jet-button id="createNewModule">
                    {{ __('Add System Item') }}
                </x-jet-button>
            </div>

        </div>

        {{-- PAGE SIZE --}}
        <div class="row mb-2 align-items-center">
            <div class="col-auto">
                <label for="pageSize" class="mr-2">Show:</label>
                <select wire:model="pageSize" id="pageSize" class="form-select d-inline-block w-auto">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="mx-2">entries</span>
            </div>
            <div class="col text-end">
                {{ $moduleList->links('pagination.custom') }}
            </div>
        </div>

        {{-- MODULE TABLE ONLY SCROLLABLE --}}
        <div class="table-responsive-md">
            <table id="dataTimeLogs"
                class="view-detailed-timelogs table table-bordered table-striped table-hover text-sm text-nowrap">
                <thead class="thead">
                    <tr class="align-middle">
                        <th class="p-1 text-nowrap">Order</th>
                        <th class="p-1 text-nowrap">Module Name</th>
                        <th class="p-1 text-nowrap">Parent Module</th>
                        <th class="p-1 text-nowrap">Category</th>
                        <th class="p-1 text-nowrap">Route</th>
                        <th class="p-1 text-nowrap">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($moduleList->isNotEmpty())
                        @foreach ($moduleList as $record)
                            <tr id="{{ $record->id }}" class="view-nav">
                                <td
                                    class="text-left {{ substr_count($record->nav_path, '-') === 0 ? 'fw-semibold' : 'fst-italic' }}">
                                    {{ $record->nav_path }}
                                </td>

                                <td>{{ $record->module_name }}</td>
                                <td>
                                    {{ $record->parent_id ? $moduleList->firstWhere('id', $record->parent_id)->module_name ?? '-' : '-' }}
                                </td>
                                <td>{{ $record->module_category }}</td>
                                <td class="text-nowrap"></td>
                                <td>{{ $record->module_status }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No Matching Records Found</td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>

    </div>
</div>

<script type="text/javascript" src="{{ asset('app-modules/setup/module-creation.js') }}"></script>
