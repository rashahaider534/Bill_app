<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Bill;
use App\Models\BillAttachment;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddBill;
use App\Notifications\AddInvoice;

use function Symfony\Component\String\b;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $bills = bill::all();
        return view('bill.bills', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();

         return view('bill.addbill', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Bill::create([
            'bill_number' => $request->bill_number,
            'bill_Date' => $request->bill_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $bill_id = bill::latest()->first()->id;
        BillDetail::create([
            'bill_id' => $bill_id,
            'bill_number' => $request->bill_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $bill_id = bill::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $bill_number = $request->bill_number;

            $attachments = new BillAttachment();
            $attachments->file_name = $file_name;
            $attachments->bill_number = $bill_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->bill_id = $bill_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('uploads/' . $bill_number), $imageName);
        }
       $user = auth()->user();
        $admin=User::first();
       $admin->notify(new AddInvoice($bill_id,$user));
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bill=Bill::where('id',$id)->first();
        return view('bill.statusupdate',compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sections = Section::all();
       $bill = Bill::where('id', $id)->first();
         return view('bill.billedit', compact('sections','bill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $bill = Bill::findOrFail($request->id);
        $bill->update([
            'bill_number' => $request->bill_number,
            'bill_Date' => $request->bill_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->invoice_id;
        $bill=Bill::where('id',$id)->first();
        $bill->delete();
        session()->flash('delete_at');
        return redirect('/bill');
    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("name", "id");
        return json_encode($products);
    }
    public function Status_Update($id, Request $request)
    {
        $bill = Bill::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $bill->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            BillDetail::create([
                'bill_id' => $request->id,
                'bill_number' => $request->bill_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $bill->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            BillDetail::create([
                'bill_id' => $request->id,
                'bill_number' => $request->bill_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/bill');

    }
    public function billpaid()
    {
        $bills=Bill::where('Value_Status',1)->get();
        return view('bill.billpaid',compact('bills'));
    }
     public function billunpaid()
    {
        $bills=Bill::where('Value_Status',2)->get();
        return view('bill.billunpaid',compact('bills'));
    }
      public function billpartpaid()
    {
        $bills=Bill::where('Value_Status',3)->get();
        return view('bill.billunpaid',compact('bills'));
    }
    public function Print_bill($id)
    {
        $invoices = Bill::where('id', $id)->first();
        return view('bill.Print_bill',compact('invoices'));
    }
}
