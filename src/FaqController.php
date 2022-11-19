<?php

namespace Elementcore\Faq;

use DataTables;
use Elementcore\Faq\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ImageUpload;
use App\Traits\MediaImage;

class FaqController extends Controller
{ //--------traits------------
    use ImageUpload;
    use MediaImage;
    //--------------------------

    public $image_source = 'faq'; //the path after storage/images
    public $image_quality = 8; // anumber between 1 - 9
    public $image_path = 'storage/images/faq/'; // storage path
    public $is_watermark = 0; //set to 1 to add watermark to images
    public $image_max_size = 2048;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return  view('elementcore.faq.index_faq');
    }

    public function getFaqList()
    {
        $data = Faq::orderBy('created_at')->get();
        return DataTables::of($data)->make(true);
    }
    public function create()
    {
        $image_upload_settings = ['path' => $this->image_path, 'image_source' => $this->image_source, 'image_quality' =>  $this->image_quality, 'is_watermark' =>  $this->is_watermark];

        return  view('elementcore.faq.create_faq', compact('image_upload_settings'));
    }

    public function store(Request $request)
    {

        $add_faq = new Faq();
        $add_faq->FAQ_Question = $request->FAQ_Question;
        $add_faq->FAQ_Answer = $request->FAQ_Answer;

        if ($add_faq->save()) {
            return $this->sendResponse(__('faq.faq_added'));
        } else {
            return $this->sendError(__('errorMessages.something_went_wrong'));
        }
    }
    public function edit($id)
    {
        $image_upload_settings = ['path' => $this->image_path, 'image_source' => $this->image_source, 'image_quality' =>  $this->image_quality, 'is_watermark' =>  $this->is_watermark];
        $faq = Faq::findorfail($id);
        return  view('elementcore.faq.edit_faq', compact('image_upload_settings', 'faq'));
    }
    public function update(Request $request, $id)
    {
        $data = Faq::findorfail($id);

        if ($data->update($request->all())) {
            return $this->sendResponse(__('faq.faq_updated'));
        } else {
            return $this->sendError(__('errorMessages.something_went_wrong'));
        }
    }

    public function destroy($id)
    {
        return $this->generalDestroy('Elementcore\Faq\Faq', ['Faq_ID' => $id], __('successMessages.faq_deleted'));
    }
}
