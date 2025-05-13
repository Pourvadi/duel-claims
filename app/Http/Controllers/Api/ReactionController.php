<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store(Request $request, Claim $claim)
    {
        $request->validate([
            'reaction_type' => 'required|string|max:50'
        ]);

        $reaction = new Reaction();
        $reaction->claim_id = $claim->id;
        $reaction->user_id = auth()->id();
        $reaction->reaction_type = $request->reaction_type;
        $reaction->save();

        return response()->json($reaction, 201);
    }

}
