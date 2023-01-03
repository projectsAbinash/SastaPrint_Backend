<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DocumentsData;
use App\Models\OrderData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    private function countPages($path)
    {
        $pdftext = file_get_contents($path);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        return $num;
    }
    #uploda docs files
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

    #update docc data
    public function AddNewdoc(Request $request)
    {
        $request->validate([
            'doc_id' => 'required|numeric|exists:documents_data,id',
            'copies_count' => 'required|numeric|min:1',
            'print_config' => 'required|in:black_and_white,color,multicolor',
            'page_config' => 'required|in:two_side,one_side',
            'binding_config' => 'required|in:spiral_binding,stapled,loose_paper',

        ]);
        $main = DocumentsData::find($request->doc_id);


        if ($request->page_config == 'two_side')
            $print_charges = $main->total_pages * 0.50;
        else if ($request->page_config == 'one_side')
            $print_charges = $main->total_pages * 0.70;
        //checking binding charges
        $copies_charge = $print_charges * $request->copies_count;
        if ($request->binding_config == 'spiral_binding')
            $bindidg_charge = ((floor($main->total_pages / 100) + ($main->total_pages % 100 ? 1 : 0)) * 9) * $request->copies_count;
        elseif ($request->binding_config == 'stapled')
            $bindidg_charge = '0';
        elseif ($request->binding_config == 'loose_paper')
            $bindidg_charge = '0';

        $main->update([
            'title' => $request->title,
            'instructions' => $request->instructions,
            'copies_count' => $request->copies_count,
            'print_config' => $request->print_config,
            'page_config' => $request->page_config,
            'binding_config' => $request->binding_config,
            'print_charges' => $print_charges,
            'total_copies_charge' => $copies_charge,
            'binding_charge' => $bindidg_charge,

        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'doc updated successFully',
        ]);
    }
    #for delete

    public function DocRemoved(Request $request)
    {
        $request->validate([
            'doc_id' => 'required|exists:documents_data,id'
        ]);
        $data = DocumentsData::find($request->doc_id);
        Storage::delete($data->path);
        $data->Getorder()->decrement('amount', $data->total_copies_charge + $data->binding_charge);
        $data->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'doc removed successfully'
        ]);
    }


    #for plcae order
    public function PlaceOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:documents_data,order_id|unique:order_data,order_id',
            'address_id' => 'required|numeric|exists:users_address,id'
        ]);
        //calculate delivery charges
        $total = DocumentsData::where('order_id', $request->order_id)->get();
        $tp = '0';
        foreach($total as $dlcharge)
        {
            $tp += ($dlcharge->total_pages * $dlcharge->copies_count);
        }
        if ($tp <= '500') {
            $delivery_charge = '29';
        }
        elseif($tp <= '1000')
        {
            $delivery_charge = '49';
        }elseif($tp <= '1500')
        {
            $delivery_charge = '69';
        }
        else
        {
            $delivery_charge = '69';
        }
        //end of calculate delivery charges
       // return $delivery_charge;
        OrderData::create([
            'user_id' => $request->user()->id,
            'order_id' => $request->order_id,
            'address_id' => $request->address_id,
            'delivery_charge' => $delivery_charge,
            'status' => 'unpaid',
            'amount' => $total->sum('total_copies_charge') + $total->sum('binding_charge') + $delivery_charge,
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Order Placed SuccessFully',

        ]);
    }


    #get single order 
    public function GetOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_data,order_id'
        ]);
        $get = OrderData::where('order_id', $request->order_id)->first();
        $get->Userdocs;
        $get->GetAddress;
        return response()->json([
            'status' => 'true',
            'order_data' => $get,
        ]);
    }

    #get list orders
    public function orderlist(Request $request)
    {
        $data = User::find($request->user()->id)->Getorders()->orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'true',
            'data' => $data,
        ]);
    }
}