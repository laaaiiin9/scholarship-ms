<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class PublicPagesController extends Controller
{
    public function scholarshipsPage()
    {
        return view('public.scholarships');
    }

    public function scholarships(Request $request)
    {
        $query = Scholarship::query();
        $search = trim($request->search);

        if ($request->has('search') && $search != '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $result = $query->paginate(5);

        return response()->json($result);
    }

}
