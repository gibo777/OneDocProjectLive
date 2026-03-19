<div>
    <div id="createModuleForm" class="mx-3">
        <div class="row">
            <div class="banner-blue text-sm font-weight-bold py-1">
                {{ __('ADD SYSTEM ITEM') }}
            </div>
        </div>

        <div class="row my-1">
            <div class="form-floating col-md-6 p-1">
                <select wire:model.defer="createNavCategory" name="createNavCategory" id="createNavCategory"
                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                    <option value="">-</option>
                    @foreach ($moduleCategories as $category)
                        <option value="{{ $category->category_name }}">
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                <x-jet-label for="createNavCategory">
                    {{ __('Category') }} <span class="text-danger">*</span>
                </x-jet-label>
            </div>

            <div class="form-floating col-md-6 p-1">
                <select wire:model.defer="createNavParent" name="createNavParent" id="createNavParent"
                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                    <option value="">-</option>
                </select>
                <x-jet-label for="createNavParent" value="{{ __('Parent Module') }}" />
            </div>
        </div>

        <div class="row">
            <div class="form-floating col-md-9 p-1">
                <x-jet-input wire:model.defer="createModuleName" id="createModuleName" type="text"
                    class="form-control" />
                <x-jet-label for="createModuleName">
                    {{ __('Module Name') }} <span class="text-danger">*</span>
                </x-jet-label>
            </div>

            <div class="form-floating col-md-3 p-1">
                <x-jet-input wire:model.defer="createNavOrder" id="createNavOrder" type="number"
                    class="form-control" />
                <x-jet-label for="createNavOrder" value="{{ __('Order #') }}" />
            </div>
        </div>

        <div id="moduleFormError" class="text-center text-sm text-red-600 mt-1"></div>

        <div class="w-full relative my-2 h-10">
            <div class="flex justify-center h-full items-center">
                <x-jet-button id="saveModule">
                    {{ __('Create System Item') }}
                </x-jet-button>
            </div>
        </div>
    </div>
</div>
