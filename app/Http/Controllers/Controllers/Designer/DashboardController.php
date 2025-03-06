<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use App\Models\Coupon;
use App\Models\DesignerTemplate;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd('here');
        $templates = DesignerTemplate::where('created_by', Auth::user()->getAuthIdentifier())->with('category')->get();
        return view('designer.dashboard', [
            'templates' => $templates,
        ]);
    }

    public function upload_template_view(Request $request)
    {
        return view('designer.upload-template');
    }

    public function delete_template(Request $request)
    {

        $id = $request->id;
        $coupon = Coupon::where("template_id", $id)->first();
        $booklet = Booklet::where("template_id", $id)->first();
        if (!$coupon && !$booklet) {
            $dt = DesignerTemplate::where('id', $id)->first();
            $dt->delete();
            try {
                if ($dt) {
                    File::delete(public_path($dt->file));
                    File::delete(public_path($dt->preview));
                    return back();
                } else {
                    return response()->json(['success' => false, 'message' => 'Template not found']);
                }
            } catch (\Exception $e) {
                return back();
                // return response()->json(['success' => false, 'message' => 'Error deleting template']);
            }
        } else {
            return back()->withErrors(['msg' => 'You can not delete this template. A coupon has already been generated for it.']);
        }
    }
}
