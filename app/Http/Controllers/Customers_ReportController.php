<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use App\Models\Section;
class Customers_ReportController extends Controller
{
     public function index(){

      $sections = Section::all();
      return view('reports.customers_report',compact('sections'));

    }


    public function Search_customers(Request $request){


// في حالة البحث بدون التاريخ

     if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {


      $invoices = Bill::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
      $sections = Section::all();
       return view('reports.customers_report',compact('sections'))->withDetails($invoices);


     }


  // في حالة البحث بتاريخ

     else {

       $start_at = date($request->start_at);
       $end_at = date($request->end_at);

      $invoices = Bill::whereBetween('bill_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
       $sections = Section::all();
       return view('reports.customers_report',compact('sections'))->withDetails($invoices);


     }



    }
}
