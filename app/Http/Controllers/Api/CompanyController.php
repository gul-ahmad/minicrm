<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;



class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Company::latest()->paginate(10);


       // return $companieslist;
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
    public function store(Request $request)
    {
        //
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

  //  dd('I m here');
      //  return ['message'=>'Company update area'];
      
        
      $id =$request->id;
      $series =Company::findOrFail($id);
      $seriesCurentPhoto= $series->logo;
    //  dd($seriesCurentPhoto);
    //  dd($request->all());
      $image =$request->logo;
      $email =$request->email;
      $website =$request->website;
    //  dd($seriesCurentPhoto,$image);
      $title =$request->name;
      $description =$request->website;
     
    // $currentPhoto = $request->oldlogo;
  // dd($seriesCurentPhoto,$image);
//I have used the validation here for update becuase it was not working using Form Request validtion way like 
//it was working in create

   $this->validate($request, [ 
         'name' =>'required|string|max:255',
          'email' => 'nullable|string|email|max:255|unique:companies,email,' . $id,
          'website' => 'nullable|string|max:50'
       // 'logo' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
  ]);  

 // $validated = $request->validated();

 //  if($request->logo)  {
     //Taking this $seriesCurentPhoto from database to compare the current/database value 
     //of photo with the coming new photo from form 
     //If user is changing the photo then IF condtion will work with image validation 
     // IF the user is not changing the logo/image then else conditon will work without image validation 
  if($request->logo != $seriesCurentPhoto){
//  dd('I am here in the if conditon in api');
     $logo =$request->logo;
     $this->validate($request, [ 
        'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|dimensions:min_width=100,min_height=100',
      ]);  
    //  $validated = $request->validated();
    $logo = $request->file('logo')->store('', 'public');
       $Series = Company::where('id', $id)
              ->update([
                  'name' => $request->name,
                  'email' => $request->email,
                  'logo'=>$logo,
                  'website'=>$request->website,
                  ]);  
               //   dd($Series);

          return ['message'=>'Company Updated successfully'];
   }
   else {

    
      $Company = Company::where('id', $id)
      ->update([
          'name' => $request->name,
          'email' => $request->email,
          'website'=>$request->website,
          ]);  

       return ['message'=>'Company Updated successfully'];
   }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company =Company::findOrFail($id);
        $company->delete();

    }
}
