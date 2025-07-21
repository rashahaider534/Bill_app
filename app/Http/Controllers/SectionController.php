<?php

namespace App\Http\Controllers;

use App\Models\Section;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=Section::all();
        return view('section.sections',compact('sections'));
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

        $request->validate(
            [
                'name' => 'required |unique:sections'
            ],
            [
                'name.required'=>'اسم القسم مطلوب',
                'name.unique'=>'اسم موجود مسبقا',

            ]

        );

        $newsection = new Section();
        $newsection->name = $request->name;
        $newsection->description = $request->description;
        $newsection->save();
        return redirect('/section')->with('success', 'تم حفظ القسم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, section $section)
    {
        $request->validate(
            [
                'name' => 'required |unique:sections'
            ],
            [
                'name.required'=>'اسم القسم مطلوب',
                'name.unique'=>'اسم موجود مسبقا',

            ]

        );
        $section=Section::where('id',$section->id)->first();
        $section-> update(['name'=>$request->name,
          'description'=>$request->description]);
        return redirect('/section');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(section $section)
    {
        $section=Section::where('id',$section->id)->first();
        $section->delete();
        //dd($section);
        return redirect('/section');
    }
}
