<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use App\Models\BillAttachment;
use Illuminate\Http\Request;

class BillAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


    }

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
        $this->validate($request, [

        'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $attachments =  new BillAttachment();
        $attachments->file_name = $file_name;
        $attachments->bill_number = $request->bill_number;
        $attachments->bill_id = $request->bill_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('uploads/'. $request->invoice_number), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Bill::findOrFail($id);
        return view('bill.billdetail')->with('invoices', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillAttachment $billAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillAttachment $billAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillAttachment $billAttachment)
    {
        //
    }
}
