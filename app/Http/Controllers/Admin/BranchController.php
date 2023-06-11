<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
class BranchController extends Controller
{

    public function BranchList()
    {
        $data = Branch::orderBy('id','desc')->paginate(10);
        return view('Admins.branch.list',compact('data'));
    }
    public function BranchCreate()
    {
       
        return view('Admins.branch.new');
    }
    public function BranchSubmit(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'adress_line_1' => 'required',
            'pincode' => 'required|numeric|digits:6',
            'district' => 'required',
            'state' => 'required',
            'contact_number' => 'required|numeric|digits:10',
          
        ]);
        $adress = json_encode([
            'adress_line_1' => $request->adress_line_1,
            'adress_line_2' => $request->adress_line_2,
            'pincode' => $request->pincode,
            'district' => $request->district,
            'state' => $request->state,
            'contact_number' => $request->contact_number,
            ]);

            Branch::create([
                'name' => $request->branch_name,
                'address' => $adress,
            ]);
            return redirect(route('BranchList'))->with(['success' => 'Branches Created successfully']);
    }
}
