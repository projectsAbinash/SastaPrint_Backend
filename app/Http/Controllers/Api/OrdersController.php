<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentsData;
use Illuminate\Support\Facades\Storage;


class OrdersController extends Controller
{
    private function countPages($path)
    {
        $pdftext = file_get_contents($path);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        return $num;
    }
    public function UploadDoc(Request $request)
    {
        $request->validate([
            'doc' => 'required|mimes:pdf',
            'order_id' => 'required|max:14|min:14'
        ]);
        $path = Storage::put('public/Users/Docs', $request->file('doc'));

        $new = DocumentsData::create([
            'user_id' => $request->user()->id,
            'order_id' => $request->order_id,
            'doc_name' => $request->doc->getClientOriginalName(),
            'total_pages' => $this->countPages($request->doc),
            'path' => $path,
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'Doc Uploaded SuccessFully',
            'total_pages' => $this->countPages($request->doc),
            'doc_id' => $new->id,
        ]);
    }

    public function AddNewdoc(Request $request)
    {
        $request->validate([
        'doc_id' => 'required|numeric|exists:documents_data,id',
        'copies_count' => 'required|numeric|min:1',
        'print_config' => 'required|in:black_and_white,color,multicolor',
        'page_config' => 'required|in:two_side,one_side',
        'binding_config' => 'required|in:spiral_binding,stapled,loose_paper',
        
        ]);
        DocumentsData::find($request->doc_id)->update([
         'title' => $request->title,
         'instructions' => $request->instructions,
         'copies_count' => $request->copies_count,
         'print_config' => $request->print_config,
         'page_config' => $request->page_config,
         'binding_config' => $request->binding_config,
        ]);
        return response()->json([
         'status' => 'true',
         'message' => 'doc updated successFully',
        ]);
    }

    public function PlaceOrder(Request $request)
    {

    }
}