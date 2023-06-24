<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultet;

class FakultetController extends Controller
{
    public function index()
    {
        $fakultet = Fakultet::all();

        return response(['fakultet' => Fakultet::all()], 200);
    }
}
