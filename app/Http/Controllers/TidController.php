<?php

namespace App\Http\Controllers;

use App\Models\Tid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'tid' => 'required|string|unique:tids,tid',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('user.deposit.create') // Replace with your desired route name
                ->withErrors($validator)
                ->withInput();
        }

        // upload screenshto image
        $screenshot = $request->file('screenshot');
        $screenshotPath = $screenshot->store('screenshot', 'public');
        $path = $screenshotPath;


        // adding tid request
        $tid = new Tid();
        $tid->user_id = auth()->user()->id;
        $tid->tid = $request->tid;
        $tid->amount = $request->amount;
        $tid->status = 'pending';
        $tid->screenshot = $path;
        $tid->save();

        return redirect()->route('user.dashboard.index')->with('success', 'TID request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
