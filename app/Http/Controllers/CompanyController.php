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
      //  return ['message'=>'I am here in the store of company from web route'];

       $image =$request->email;
       //  dd($image);

    
     $validated = $request->validated();


    // $this->validate($request, ['logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
     if($request->hasFile('logo'))  {
       //  dd('i am here in the if');
      
       $file = $request->logo;
       $fileName = time() . '.'.$file->getClientOriginalExtension();
    //   dd($fileName);

     //  $filePath = ('public/app/images/thumbnails');
     //  $filePath = public_path('app/public/images/thumbnails/');


     
      $filename  = time() . '.' . $file->getClientOriginalExtension();
    /* $path = public_path('images/series/' . $filename);
     Image::make($file->getRealPath())->resize(468, 249)->save($path); */

       // $filePath = ('app/public/thumbnails');
     //  $filePath = public_path('images/series/' . $filename);
       $filePath =('images/companies/' . $filename);
      // $img = Image::make($file->path());
       $img = Image::make($file->getRealPath());
       $img->resize(110, 110, function ($const) {
           $const->aspectRatio();
       })->save($filePath);
       //cropped images is going here 
      $cropped = ($filePath);
            //orignal image is going here
       $path = $request->file('logo')->move('app/public/images',$fileName);
         

         $Companies = Company::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'logo'=>$cropped,
                 'website'=>$request->website,
             ]);
             Mail::to('gulmuhammad57@gmail.com')->send(new NewCompanyNotification());
            return ['message'=>'Company Added successfully.'];
     }
     else {
        
        $Companies = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'website'=>$request->website,
        ]);
        Mail::to('gulmuhammad57@gmail.com')->send(new NewCompanyNotification());
         return ['message'=>'Company added successfully.'];
     }

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
