<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Http\Request;
use App\Models\Company;

use App\Mail\NewCompanyNotification;
use Illuminate\Support\Facades\Mail;



use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\Response;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Companies =Company::all();
        return view('companies',['companies' =>$Companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        $logo = null;
        if($request->hasFile('logo'))  {
           $logo = $request->file('logo')->store('', 'public');
        }
   $Companies = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'logo'=>$logo,
            'website'=>$request->website,
        ]);
        Mail::to('gulmuhammad57@gmail.com')->send(new NewCompanyNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
