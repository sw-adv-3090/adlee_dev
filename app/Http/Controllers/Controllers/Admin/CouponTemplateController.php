<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TemplateLanguage;
use App\Enums\TemplateType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Models\Template;
use App\Services\UploadContentToViewService;
use App\Traits\FileUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CouponTemplateController extends Controller
{
    use FileUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.templates.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.templates.coupons.create', [
            'adlee_logo' => '{{ $adlee_logo }}',
            'book_number' => '{{ $book_number }}',
            'coupon_number' => '{{ $coupon_number }}',
            'sponsor_logo' => '{{ $sponsor_logo }}',
            'sponsor_name' => '{{ $sponsor_name }}',
            'sponsor_address' => '{{ $sponsor_address }}',
            'sponsor_city' => '{{ $sponsor_city }}',
            'sponsor_zipcode' => '{{ $sponsor_zipcode }}',
            'amount_in_words' => '{{ $amount_in_words }}',
            'amount_in_digits' => '{{ $amount_in_digits }}',
            'sponsor_qr_code' => '{!! $sponsor_qr_code !!}',
            'bbo_qr_code' => '{!! $bbo_qr_code !!}',
            'shorten_url' => '{{ $shorten_url }}',
            'languages' => TemplateLanguage::cases()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TemplateRequest $request)
    {
        try {
            // name of template view in the resorces views folder
            $template_view = 'templates/coupons/' . Str::random(15);

            //    creating new template
            $template = Template::create([
                'type' => TemplateType::COUPON->value,
                'title' => $request->title,
                'active' => true,
                'publish_at' => $request->publish_at ?? now(),
                'view' => $template_view,
                'preview' => $request->preview,
                'language' => $request->language,
                // 'category_id' => $request->category_id,
                // 'sub_category_id' => $request->sub_category_id,
            ]);

            // create and upload content to view file
            (new UploadContentToViewService($template_view))->upload($request->content, $template);

            return back()->with('success', 'New template successfully uploaded!');

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = Template::findOrFail($id);

        return view('admin.templates.coupons.edit', [
            'template' => $template,
            'adlee_logo' => '{{ $adlee_logo }}',
            'book_number' => '{{ $book_number }}',
            'coupon_number' => '{{ $coupon_number }}',
            'sponsor_logo' => '{{ $sponsor_logo }}',
            'sponsor_name' => '{{ $sponsor_name }}',
            'sponsor_address' => '{{ $sponsor_address }}',
            'sponsor_city' => '{{ $sponsor_city }}',
            'sponsor_zipcode' => '{{ $sponsor_zipcode }}',
            'amount_in_words' => '{{ $amount_in_words }}',
            'amount_in_digits' => '{{ $amount_in_digits }}',
            'sponsor_qr_code' => '{!! $sponsor_qr_code !!}',
            'bbo_qr_code' => '{!! $bbo_qr_code !!}',
            'shorten_url' => '{{ $shorten_url }}',
            'languages' => TemplateLanguage::cases()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemplateRequest $request, string $id)
    {
        $template = Template::findOrFail($id);

        try {
            // name of template view in the resorces views folder
            $template_view = $template->view;
            $preview = $template->preview;
            $publish_at = $request->publish_at ?? $template->publish_at;

            // delete old template preview image if uploaded new preview image
            if ($request->preview) {
                $this->deleteFile($template->preview);
                $preview = $request->preview;
            }

            //  update template in database
            $template->update([
                'title' => $request->title,
                'publish_at' => $publish_at,
                'preview' => $preview,
                'language' => $request->language,
                // 'category_id' => $request->category_id,
                // 'sub_category_id' => $request->sub_category_id,
            ]);

            // update and upload content to view file
            if ($request->content) {
                (new UploadContentToViewService($template_view))->upload($request->content, $template);
            }


            return back()->with('success', 'Template successfully updated!');

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = Template::findOrFail($id);
        try {
            $preview = $template->preview;
            $view = $template->view;

            // delete template from database
            $template->delete();

            //    delete preview image file from server
            $this->deleteFile($preview);

            // delete view file from view folder
            Storage::disk('disk_path')->delete('/resources/views/' . $view . '.blade.php');

            return back()->with('success', 'Template successfully deleted!');
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
    }
}
