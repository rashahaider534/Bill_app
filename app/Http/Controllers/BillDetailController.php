<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillAttachment;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\fileExists;

class BillDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bill = bill::where('id', $id)->first();
        $billdetails = BillDetail::where('bill_id', $id)->get();
        $attachments = BillAttachment::where('bill_id', $id)->get();
        return view('bill.billdetail', compact('bill', 'billdetails', 'attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = Bill::where('id', $id)->first();
        $details  = BillDetail::where('bill_id', $id)->get();
        $attachments  = BillAttachment::where('bill_id', $id)->get();

        return view('bill.details_invoice', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillDetail $billDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $billatt=BillAttachment::findOrFail($request->id);
         $billatt->delete();
          Storage::disk('public_uploads')->delete($request->bill_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }
    public function get_file($bill_number, $file_name)
    {
        $contents = public_path("uploads/$bill_number/$file_name");
        return response()->download($contents);
    }
    public function open_file($bill_number, $file_name)
    {
        $file = public_path("uploads/$bill_number/$file_name");
        return response()->file($file);
    }
}
