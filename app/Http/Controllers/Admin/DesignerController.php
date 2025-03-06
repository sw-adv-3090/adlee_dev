<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index(Request $request)
    {
        
        return view('admin.designers.index',  [
            'designers' => User::where('role_id', 4)->get(),
            
        ]);
    }

    public function approve_designer(Request $request) {
        User::where('id', $request->id)->update([
            'is_active' => $request->value, // 1 for approve, 0 for reject
        ]);

        return back()->with('success', 'Template has been updated.');
    }
}   
