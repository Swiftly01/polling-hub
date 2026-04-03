@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">LGA Election Results</h1>
        <p class="text-gray-600 mt-2">View summed results from all polling units in an LGA</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <form method="GET" action="{{ route('polling-unit.lga-results') }}" class="flex gap-4 items-end">
            <div class="flex-1">
                <label for="lga_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Select Local Government Area (Delta State)
                </label>
                <select name="lga_id" id="lga_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-black focus:ring-2 focus:ring-blue-500"
                    onchange="this.form.submit()">

                    <option value="">-- Choose an LGA --</option>

                    @foreach ($lgas as $lga)
                        <option value="{{ $lga->lga_id }}"
                            @if($selectedLGA && $selectedLGA->lga_id == $lga->lga_id) selected @endif>
                            {{ $lga->lga_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if ($selectedLGA)
    <div class="mb-8">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-2">{{ $selectedLGA->lga_name }}</h2>
            <p class="text-blue-100">Delta State</p>
            <p class="text-3xl font-bold mt-4">Total Votes: {{ number_format($totalVotes) }}</p>
        </div>

        @if ($results->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <p class="text-gray-700 text-lg">No results available for this LGA yet.</p>
        </div>
        @else

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Results Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <h3 class="text-lg font-semibold text-gray-800 p-6 border-b bg-gray-50">
                    Party Results Breakdown
                </h3>

                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Party</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Votes</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Share</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($results as $result)
                        @php
                            $percentage = $totalVotes > 0 ? ($result->total_votes / $totalVotes) * 100 : 0;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                {{ $result->party_abbreviation }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                {{ number_format($result->total_votes) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ round($percentage, 2) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="bg-gray-50 border-t-2 border-gray-300 font-bold">
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">TOTAL</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($totalVotes) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Chart -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Vote Distribution</h3>

                <div class="space-y-4">
                    @foreach ($results as $result)
                    @php
                        $percentage = $totalVotes > 0 ? ($result->total_votes / $totalVotes) * 100 : 0;

                        $colors = [
                            'bg-blue-500',
                            'bg-red-500',
                            'bg-green-500',
                            'bg-yellow-500',
                            'bg-purple-500',
                            'bg-pink-500'
                        ];

                        $colorClass = $colors[$loop->index % count($colors)];
                    @endphp

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">
                                {{ $result->party_abbreviation }}
                            </span>
                            <span class="text-sm font-bold text-gray-900">
                                {{ round($percentage, 1) }}%
                            </span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full transition-all duration-300 {{ $colorClass }}"
                                style="width: {{ $percentage }}%">
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ number_format($result->total_votes) }} votes
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Leading Party</p>
                <p class="text-2xl font-bold text-blue-600">
                    {{ optional($results->first())->party_abbreviation }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ number_format(optional($results->first())->total_votes ?? 0) }} votes
                </p>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Number of Parties</p>
                <p class="text-2xl font-bold text-gray-800">{{ $results->count() }}</p>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Total Polling Units</p>
                <p class="text-2xl font-bold text-green-600">
                    {{ \DB::table('polling_unit')->where('lga_id', $selectedLGA->lga_id)->count() }}
                </p>
            </div>
        </div>

        @endif
    </div>

    @else
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
        <p class="text-gray-700 text-lg">
            Select an LGA from the dropdown above to view results.
        </p>
    </div>
    @endif

    <div class="mt-6 pt-6 border-t">
        <a href="{{ route('polling-unit.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            → Add New Polling Unit Results
        </a>
    </div>
</div>
@endsection