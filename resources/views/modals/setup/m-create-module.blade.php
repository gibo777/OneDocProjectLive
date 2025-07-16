
<div id="createModuleForm" class="mx-3">
    <div class="row">
        <div class="banner-blue text-sm font-weight-bold py-1">{{ __('CREATE MENU') }}</div>
    </div>

            <div class="row my-1">
                <div class="form-floating col-md-6 p-1">
                    <x-jet-input id="moduleName" name="moduleName" type="text" value="" class="form-control" placeholder="Module Name"/>
                        <x-jet-label for="moduleName" value="{{ __('Module Name') }}" class="w-full" />
                </div>
                <div class="form-floating col-md-6 p-1">
                    <select wire:model="parentModule" name="parentModule" id="parentModule" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                        <option value="">-</option>
                        @if($parentModules->isNotEmpty())
                        @foreach ($parentModules as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->module_name }}</option>
                        @endforeach
                        @endif
                    </select>
                    <x-jet-label for="parentModule" value="{{ __('Parent Module') }}" />
                </div>
            </div>
            <div class="row">
                <div class="form-floating col-md-4 p-1">
                    <x-jet-input id="navOrder" name="navOrder" type="number" value="" class="form-control" />
                        <x-jet-label for="navOrder" value="{{ __('Order #') }}" class="w-full" />
                </div>
                <div class="form-floating col-md-8 p-1">
                    <select wire:model="moduleCategory" name="moduleCategory" id="moduleCategory" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                        <option value="">-</option>
                        @foreach ($moduleCategories as $category)
                            <option>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    <x-jet-label for="moduleCategory" value="{{ __('Category') }}" />
                </div>
            </div>

            <div class="w-full relative my-2 h-10">
                <div class="flex justify-center h-full items-center">
                    <x-jet-button id="saveModule">Create</x-jet-button>
                </div>
            </div>

</div>

