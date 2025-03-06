<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DesignerTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DesignerTemplateController extends Controller
{
    public function index(Request $request)
    {
        // $d= DesignerTemplate::where('id',26)->delete();
        // $t= DesignerTemplate::with('category', 'creator')->get();
        // echo "<pre>";
        // print_r($t);die;
        return view('admin.designer-templates.index',  [
            'templates' => DesignerTemplate::with('category', 'creator')->get(),
            'categories' => Category::get()
        ]);
    }

    public function approve_template(Request $request) {
        // Validate the request (either category_id or new_category should be present)
        $request->validate([
            'template_id' => 'required|exists:designer_templates,id',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
        ]);

        // Check if a new category was entered
        if ($request->new_category) {
            // Create the new category in the database
            $newCategory = Category::create([
                'name' => $request->new_category,
            ]);

            // Use the new category's ID for the template
            $categoryId = $newCategory->id;
        } else {
            // Use the selected category's ID
            $categoryId = $request->category_id;
        }

        // Update the template with the approval status and category ID
        DesignerTemplate::where('id', $request->template_id)->update([
            'approve' => $request->approve, // 1 for approve, 0 for reject
            'category_id' => $categoryId,
            'publish_at' => now()
        ]);

        return back()->with('success', 'Template has been updated.');
    }

    public function unapprove_template(Request $request){
        DesignerTemplate::where('id', $request->id)->update([
            'approve' => $request->value, // 1 for approve, 0 for reject
        ]);

        return back()->with('success', 'Template has been updated.');
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
