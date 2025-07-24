<?php

namespace App\Http\Controllers;

use App\Models\OfficialReseller;
use App\Models\Province;
use Illuminate\Http\Request; // ✅ Benar


class ResellerController extends Controller
{
    public function index(Request $request)
    {
        $provinces = Province::all();

        if ($request->ajax()) {
            return response()->json([
                'resellers' => view('pages.reseller', compact('resellers'))->render()
            ]);
        }

        // Ini untuk load awal
        $resellers = OfficialReseller::all();

        return view('pages.reseller', compact('resellers', 'provinces'));
    }
}
