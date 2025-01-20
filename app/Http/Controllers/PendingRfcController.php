<?php

namespace App\Http\Controllers;

use App\Models\PendingRfc;
use Illuminate\Http\Request;

class PendingRfcController extends Controller
{
    public function index()
    {
        return PendingRfc::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
        ]);

        return PendingRfc::create($request->validated());
    }

    public function show(PendingRfc $pendingRfc)
    {
        return $pendingRfc;
    }

    public function update(Request $request, PendingRfc $pendingRfc)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $pendingRfc->update($request->validated());

        return $pendingRfc;
    }

    public function destroy(PendingRfc $pendingRfc)
    {
        $pendingRfc->delete();

        return response()->json();
    }
}
