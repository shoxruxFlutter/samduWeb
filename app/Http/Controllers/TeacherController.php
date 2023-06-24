<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
class TeacherController extends Controller
{
    public function index($kafedra_id)
    {

        $teacher = Teacher::whereHas('kafedra', function ($query) use ($kafedra_id) {
            $query->where('kafedra_id', $kafedra_id);
        })->first();

        if(!$teacher)
        {
            return response([
                'message' => 'Teacher not found.'
            ], 403);
        }
        return response([
            'teacher' => $teacher
        ], 200);
        // return response(['kafedra' => Kafedra::all()], 200);
    }
}
