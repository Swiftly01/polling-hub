<?php

namespace App\Http\Controllers;

use App\Models\PollingUnit;
use App\Models\LGA;
use App\Models\AnnouncedPUResult;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollingUnitController extends Controller
{
    /**
     * Display result for an individual polling unit
     */
   public function showPollingUnitResult($polling_unit_id): View
{
    $pollingUnit = PollingUnit::with(['announcedResults', 'ward', 'lga'])
        ->where('polling_unit_id', $polling_unit_id)
        ->firstOrFail();

       // dd($pollingUnit);

    $results = $pollingUnit->announcedResults;
    $totalVotes = $results->sum('party_score'); // 

    return view('polling-unit.result', compact('pollingUnit', 'results', 'totalVotes'));
}

    /**
     * QUESTION 2:
     * Sum total result of all polling units under an LGA
     */
    public function showLGAResults(Request $request): View
    {
        // Get all LGAs in Delta State
        $lgas = LGA::where('state_id', 25)->get();

        $selectedLGA = null;
        $results = collect();
        $totalVotes = 0;

        if ($request->filled('lga_id')) {

            $selectedLGA = LGA::where('lga_id', $request->lga_id)->firstOrFail();

           // dd($selectedLGA);

            // (result aggregation)
            $results = DB::table('announced_pu_results')
                ->join('polling_unit', 'announced_pu_results.polling_unit_uniqueid', '=', 'polling_unit.uniqueid')
                ->where('polling_unit.lga_id', $selectedLGA->lga_id)
                ->select(
                    'announced_pu_results.party_abbreviation',
                    DB::raw('SUM(announced_pu_results.party_score) as total_votes')
                )
                ->groupBy('announced_pu_results.party_abbreviation')
                ->orderByDesc('total_votes')
                ->get();

            

            $totalVotes = $results->sum('total_votes');
        }

        return view('polling-unit.lga-results', compact(
            'lgas',
            'selectedLGA',
            'results',
            'totalVotes'
        ));
    }

    /**
     * Store results for a new polling unit
     */
    public function storePollingUnitResults(Request $request)
    {
        $validated = $request->validate([
            'polling_unit_number' => 'required|string|unique:polling_unit,polling_unit_number',
            'ward_id' => 'required|exists:ward,ward_id',
            'lga_id' => 'required|exists:lga,lga_id',
            'party_results' => 'required|array',
            'party_results.*.party_abbreviation' => 'required|string|max:10',
            'party_results.*.party_score' => 'required|integer|min:0',
        ]);

        // Create polling unit
        $pollingUnit = PollingUnit::create([
            'polling_unit_id' => rand(1000, 9999),
            'polling_unit_number' => $validated['polling_unit_number'],
            'ward_id' => $validated['ward_id'],
            'lga_id' => $validated['lga_id'],
            
        ]);

        // Insert party results 
        foreach ($validated['party_results'] as $result) {
            AnnouncedPUResult::create([
                'polling_unit_uniqueid' => $pollingUnit->uniqueid,
                'party_abbreviation' => $result['party_abbreviation'],
                'party_score' => $result['party_score'],
                'entered_by_user' => 'admin',
                'date_entered' => now(),
                'user_ip_address' => $request->ip(),
            ]);
        }

        return redirect()->route('polling-unit.create')
            ->with('success', 'Polling unit and results stored successfully!');
    }

    /**
     * Show form
     */
    public function createPollingUnit(): View
    {
        $lgas = LGA::where('state_id', 25)->get();

        return view('polling-unit.create', compact('lgas'));
    }

    /**
     *  Get wards by LGA
     */
    public function getWardsByLGA($lga_id)
    {
        $wards = DB::table('ward')
            ->where('lga_id', $lga_id)
            ->get();

        return response()->json($wards);
    }
}
