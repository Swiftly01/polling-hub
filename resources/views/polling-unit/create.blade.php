
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Add New Polling Unit Results</h1>
        <p class="text-gray-600 mt-2">Store results for all parties in a new polling unit</p>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <h3 class="font-semibold text-red-800 mb-2">Please correct the following errors:</h3>
        <ul class="list-disc list-inside space-y-1 text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-green-800">
        <p class="font-semibold">✓ {{ session('success') }}</p>
    </div>
    @endif

    <form method="POST" action="{{ route('polling-unit.store') }}" class="bg-white shadow rounded-lg p-8">
        @csrf

        <!-- Step 1: Basic Information -->
        <div class="mb-8 pb-8 border-b">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Step 1: Polling Unit Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Polling Unit Number -->
                <div class="md:col-span-2">
                    <label for="polling_unit_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Polling Unit Number <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="polling_unit_number" 
                        id="polling_unit_number"
                        value="{{ old('polling_unit_number') }}"
                        placeholder="e.g., PU-001, PU-002"
                        class="w-full px-4 py-2 border @error('polling_unit_number') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('polling_unit_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- LGA Selection -->
                <div>
                    <label for="lga_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Local Government Area <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="lga_id" 
                        id="lga_id"
                        class="w-full px-4 py-2 border @error('lga_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                        onchange="loadWards()">
                        <option value="">-- Select LGA --</option>
                        @foreach ($lgas as $lga)
                            <option value="{{ $lga->lga_id }}" @if(old('lga_id') == $lga->lga_id) selected @endif>
                                {{ $lga->lga_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lga_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ward Selection -->
                <div>
                    <label for="ward_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Ward <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="ward_id" 
                        id="ward_id"
                        class="w-full px-4 py-2 border @error('lga_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        <option value="">-- Select Ward --</option>
                    </select>
                    @error('ward_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Step 2: Party Results -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Step 2: Party Results</h2>
                <button 
                    type="button" 
                    onclick="addPartyResult()"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
                    + Add Party
                </button>
            </div>

            <div id="party_results_container" class="space-y-4">
                <div class="party-result-row grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Party Abbreviation <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="party_results[0][party_abbreviation]"
                            placeholder="e.g., PDP, APC"
                            maxlength="10"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Votes Secured <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="party_results[0][party_score]"
                            placeholder="0"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                    </div>
                    <button 
                        type="button" 
                        onclick="removePartyResult(this)"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition h-10">
                        Remove
                    </button>
                </div>
            </div>

            @error('party_results')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4 pt-6 border-t">
            <button 
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                Save Polling Unit & Results
            </button>
            <a 
                href="{{ route('polling-unit.lga-results') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
let partyResultCount = 1;

function addPartyResult() {
    const container = document.getElementById('party_results_container');
    const newRow = document.createElement('div');
    newRow.className = 'party-result-row grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-lg';
    newRow.innerHTML = `
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Party Abbreviation <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="party_results[${partyResultCount}][party_abbreviation]"
                placeholder="e.g., PDP, APC"
                maxlength="10"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Votes Secured <span class="text-red-500">*</span>
            </label>
            <input 
                type="number" 
                name="party_results[${partyResultCount}][party_score]"
                placeholder="0"
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required>
        </div>
        <button 
            type="button" 
            onclick="removePartyResult(this)"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition h-10">
            Remove
        </button>
    `;
    container.appendChild(newRow);
    partyResultCount++;
}

function removePartyResult(button) {
    const container = document.getElementById('party_results_container');
    if (container.querySelectorAll('.party-result-row').length > 1) {
        button.closest('.party-result-row').remove();
    } else {
        alert('You must have at least one party result.');
    }
}

function loadWards() {
    const lgaId = document.getElementById('lga_id').value;
    const wardSelect = document.getElementById('ward_id');
    
    wardSelect.innerHTML = '<option value="">Loading...</option>';

    if (!lgaId) {
        wardSelect.innerHTML = '<option value="">-- Select Ward --</option>';
        return;
    }

    fetch(`{{ url('polling/wards') }}/${lgaId}`)
        .then(response => response.json())
        .then(data => {
            wardSelect.innerHTML = '<option value="">-- Select Ward --</option>';
            data.forEach(ward => {
                const option = document.createElement('option');
                option.value = ward.ward_id;
                option.textContent = ward.ward_name;
                wardSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading wards:', error);
            wardSelect.innerHTML = '<option value="">Error loading wards</option>';
        });
}
</script>
@endsection
