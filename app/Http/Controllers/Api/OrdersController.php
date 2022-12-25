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
        ]);
        $path = Storage::put('public/Users/Docs', $request->file('doc'));

        $new = DocumentsData::create([
            'user_id' => $request->user()->id,
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

    public function PlaceOrder(Request $request)
    {
        
    } 
}
