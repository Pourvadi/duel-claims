<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Claim::with('reactions')->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:text,image,video,voice',
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:10240|mimes:jpeg,jpg,png,mp4,mp3,ogg',
        ]);
    
        $claim = new Claim();
        $claim->user_id = auth()->id();
        $claim->type = $request->type;
        $claim->content = $request->content;
    
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store("claims/" . auth()->id(), 'public');
            $claim->file_path = $path;
        }
    
        $claim->save();
    
        return response()->json($claim, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Claim $claim)
    {
        return $claim->load('reactions');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Claim $claim)
    {
        if ($claim->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:10240|mimes:jpeg,jpg,png,mp4,mp3,ogg',
        ]);
    
        $claim->content = $request->content ?? $claim->content;
    
        if ($request->hasFile('file')) {
            if ($claim->file_path) {
                Storage::disk('public')->delete($claim->file_path);
            }
            $path = $request->file('file')->store("claims/" . auth()->id(), 'public');
            $claim->file_path = $path;
        }
    
        $claim->save();
    
        return response()->json($claim);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Claim $claim)
    {
        if ($claim->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        if ($claim->file_path) {
            Storage::disk('public')->delete($claim->file_path);
        }
    
        $claim->delete();
    
        return response()->json(['message' => 'Deleted']);
    }
}
