<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kafedra;
class KafedraController extends Controller
{
    public function index($fakultet_id)
    {

        $kafedra = Kafedra::where('fakultet_id', $fakultet_id)->get();

        if(!$kafedra)
        {
            return response([
                'message' => 'Kafedra not found.'
            ], 403);
        }
        return response([
            'kafedra' => $kafedra
        ], 200);
        // return response(['kafedra' => Kafedra::all()], 200);
    }
}

