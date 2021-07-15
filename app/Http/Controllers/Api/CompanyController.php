<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyRequest;


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
       // dd($email,$website);
        $title =$request->name;
        $description =$request->website;
       
      // $currentPhoto = $request->oldlogo;
    // dd($seriesCurentPhoto,$image);
//I have used the validation here for update becuase it was not working using Form Request validtion way like 
//it was working in create

     $this->validate($request, [ 
            'name' => 'required', 'string', 'max:255',
            'email' => 'nullable','string', 'email', 'max:255', 'unique:companies',
            'website' => 'nullable','string', 'max:50',
         // 'logo' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]); 

    

   //  if($request->logo)  {
       //Taking this $seriesCurentPhoto from database to compare the current/database value 
       //of photo with the coming new photo from form 
       //If user is changing the photo then IF condtion will work with image validation 
       // IF the user is not changing the logo/image then else conditon will work without image validation 
    if($request->logo != $seriesCurentPhoto){
 //  dd('I am here in the if conditon in api');
         $this->validate($request, [ 
              'logo' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]); 
      //  $validated = $request->validated();
   
        

         $file = $request->logo;
       
    
        $filename  = time() . '.' . $file->getClientOriginalExtension();
      
         $filePath =('images/companies/' . $filename);
        // $img = Image::make($file->path());
         $img = Image::make($file->getRealPath());
         $img->resize(100, 100, function ($const) {
             $const->aspectRatio();
         })->save($filePath);
         //cropped images is going here 
        $cropped = ($filePath);
              //orignal image is going here
         $path = $request->file('logo')->move('app/public/images',$filename); 
        

             $Series = Company::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'logo'=>$cropped,
                    'website'=>$request->website,
                    ]);  
                 //   dd($Series);

            return ['message'=>'Company Updated successfully'];
     }
     else {

      // dd('I am here in the else conditon in api');
        


        $Company = Company::where('id', $id)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
            'website'=>$request->website,
            ]);  

           // dd($Company);
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
