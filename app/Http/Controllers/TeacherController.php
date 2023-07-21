<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Kafedra;
class TeacherController extends Controller
{
    public function __invoke($kafedra_id)
    {

        $teacher = Teacher::whereHas('kafedra', function ($query) use ($kafedra_id) {
            $query->where('kafedra_id', $kafedra_id);
        })->get();

        if(!$teacher)
        {
            return response([
                'message' => 'Teacher not found.'
            ], 403);
        }
        return response([
            'teacher' => $teacher
        ], 200);

        dd($teacher);
        // return response(['kafedra' => Kafedra::all()], 200);
    }
}
