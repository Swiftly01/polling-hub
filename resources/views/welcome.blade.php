
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-lg p-12 mb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Polling Unit Election Results</h1>
        <p class="text-xl text-blue-100 mb-8">Nigeria 2011 Elections - Polling Unit Management System</p>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('polling-unit.lga-results') }}" class="bg-white text-blue-600 font-bold px-8 py-3 rounded-lg hover:bg-blue-50 transition">
                View Results
            </a>
            <a href="{{ route('polling-unit.create') }}" class="bg-blue-800 hover:bg-blue-900 text-white font-bold px-8 py-3 rounded-lg transition">
                Add New Results
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Feature 1 -->
        <div class="bg-white rounded-lg shadow p-8">
            <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2"> View Polling Unit Results</h3>
            <p class="text-gray-600">Display the complete result for any individual polling unit with detailed vote breakdown by party and visual representations.</p>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white rounded-lg shadow p-8">
            <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2"> View LGA Results</h3>
            <p class="text-gray-600">Aggregate and display summed results from all polling units within a selected Local Government Area with comparative analysis.</p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white rounded-lg shadow p-8">
            <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m-6 0h-6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Store New Results</h3>
            <p class="text-gray-600">Add new polling unit results with a user-friendly form. Store results for all parties in a new polling unit easily.</p>
        </div>
    </div>

    <!-- How It Works -->
    <div class="bg-white rounded-lg shadow p-12 mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg mb-4">
                    1
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Select Polling Unit</h3>
                <p class="text-gray-600 text-sm">Choose a polling unit from Delta State to view its election results.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg mb-4">
                    2
                </div>
                <h3 class="font-bold text-gray-800 mb-2">View Results</h3>
                <p class="text-gray-600 text-sm">See detailed vote counts by party with percentages and visual progress bars.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg mb-4">
                    3
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Add New Data</h3>
                <p class="text-gray-600 text-sm">Easily input and store results for new polling units with multi-party support.</p>
            </div>
        </div>
    </div>

    <!-- Key Information -->
    <div class="bg-blue-50 border-l-4 border-blue-600 rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Application Information</h2>
        <ul class="space-y-2 text-gray-700">
            <li><strong>Test Data:</strong> bincom_test.sql - 2011 Nigeria Elections Data</li>
            <li><strong>Coverage:</strong> Polling units, Wards, LGAs across Nigerian States</li>
            <li><strong>Current Filter:</strong> Delta State (State ID: 25) - Only Delta State data is displayed</li>
            <li><strong>Data Structure:</strong> Organized by LGA → Ward → Polling Unit with party-wise vote results</li>
        </ul>
    </div>
</div>
@endsection
