<x-inputs.form-input type="text" id="form.name" label="Name" placeholder="Enter name" extra="wire:model='form.name'"
    required />

<x-inputs.form-select id="form.department" label="Department" extra="wire:model='form.department'" required>
    <option class="text-gray-400" value="">Select department</option>
    @foreach ($departments as $department)
        <option value="{{ $department->id }}">{{ $department->name }}</option>
    @endforeach
</x-inputs.form-select>

<x-inputs.form-input type="email" id="form.email" label="Email" placeholder="Enter email address"
    extra="wire:model='form.email'" required />
