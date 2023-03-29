

<select name="department" id="department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
    <option value="">Select Department</option>
	@foreach ($request['departments'] as $key=>$department)
    <option value="{{ $department->id }}">{{ $department->department }}</option>
    @endforeach

    <!-- <option value="1">HR/ Admin</option>
    <option value="2">I.T. Department</option>
    <option value="3">Accounting</option>
    <option value="4">Martketing/Purchasing</option>
    <option value="5">Power Solutions</option> -->
    <!-- <option value="6">Admin</option> -->
</select>
