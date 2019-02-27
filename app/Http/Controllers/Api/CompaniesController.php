<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\updateCompany;
use App\Models\Company;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompaniesController extends Controller
{


   /* public function __construct()
    {
        return $this->middleware('auth');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Auth::user()->companies()->get();

           return response()->json($companies);

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
           'name' => 'required',
           'description' => 'required'
        ]);

        $user = Auth::user();

        $company = new Company();
        $company->user_id = $user->id;
        $company->name = $request->input('name');
        $company->description = $request->input('description');
        $company->save();

          //  \Log::info($request->all());

        return response()->json(['data' => $company], 200, [], JSON_NUMERIC_CHECK);

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\AppModelsCompany  $appModelsCompany
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        /*$company = Company::find($company->id);*/
        $company = Company::where('id', $company->id)->with('projects')->first();
        if(count($company) > 0)
            return response()->json($company);

        return response()->json(['error' => 'Company not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AppModelsCompany  $appModelsCompany
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AppModelsCompany  $appModelsCompany
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company = Company::find($company->id);
        $company->update($request->all());

        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AppModelsCompany  $appModelsCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            Company::destroy($company->id);
            return response([], 204);
        }catch (\Exception $exception){
            return response(['Problem deleting the company'], 500);
        }
    }



}
