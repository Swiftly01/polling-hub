
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Polling Unit Result</h1>
        <p class="text-gray-600 mt-2">{{ $pollingUnit->polling_unit_number }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Location Information</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-600">Polling Unit Number:</dt>
                    <dd class="text-gray-900">{{ $pollingUnit->polling_unit_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Ward:</dt>
                    <dd class="text-gray-900">{{ $pollingUnit->ward->ward_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">LGA:</dt>
                    <dd class="text-gray-900">{{ $pollingUnit->lga->lga_name }}</dd>
                </div>
                {{-- <div>
                    <dt class="text-sm font-medium text-gray-600">State:</dt>
                    <dd class="text-gray-900">{{ $pollingUnit->lga->State }}</dd>
                </div> --}}
                <div>
                    <dt class="text-sm font-medium text-gray-600">Total Votes:</dt>
                    <dd class="text-2xl font-bold text-blue-600">{{ $totalVotes }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Vote Summary</h2>
            <div class="text-center text-gray-600">
                @if ($results->isEmpty())
                    <p class="text-lg">No results recorded for this polling unit yet.</p>
                @else
                    <p class="text-sm mb-4">{{ $results->count() }} parties have submitted results</p>
                    <div class="space-y-2">
                        @foreach ($results as $result)
                            <div class="text-sm">
                                <span class="font-medium">{{ $result->party_abbreviation }}:</span>
                                <span class="text-gray-700">{{ $result->party_score }} votes</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (!$results->isEmpty())
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <h2 class="text-lg font-semibold text-gray-800 p-6 border-b">Detailed Results by Party</h2>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Party</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Votes</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Percentage</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Progress</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($results as $result)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $result->party_abbreviation }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $result->party_score }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ round(($result->party_score / $totalVotes) * 100, 2) }}%
                    </td>
                    <td class="px-6 py-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div 
                                class="bg-blue-600 h-2 rounded-full" 
                                style="width: {{ ($result->party_score / $totalVotes) * 100 }}%">
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('polling-unit.lga-results') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to LGA Results
        </a>
    </div>
</div>
@endsection
