<?php

namespace App\Http\Controllers;

use App\party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$parties=party::all();
		 
		return view('contracts.parties')->with([
			'parties'=>$parties
		]);
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //return view('parties.create'); 
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
				'party_name'=>'required',
		 ]);
		 
		
		$party=new party;
		
		$party->party_name=$request->input('party_name');
		$party->address=$request->input('address');
		$party->telephone=$request->input('telephone');
		$party->email=$request->input('email');
		$party->created_by=Auth::user()->id;
	    $party->updated_by=Auth::user()->id;
		
		$party->save(); 
		
		return redirect('party')->with('success','Record Successfully saved!');	
			 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, party $party)
    {
          $this->validate($request,[
				'party_name'=>'required',
		 ]);
		 
		
		$party->party_name=$request->input('party_name');
		$party->address=$request->input('address');
		$party->telephone=$request->input('telephone');
		$party->email=$request->input('email');
		//$party->created_by=Auth::user()->id;
	    $party->updated_by=Auth::user()->id;
		
		$party->save(); 
		
		return redirect('party')->with('success','Record Successfully saved');	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(party $party)
    {
        $party->delete();
		return redirect('party')->with('success','Record Successfully Deleted');	
    }
	
	
	
	public function get_party(Request $request){
		 	$search_term=$request->input('q');
            $search_term = '%'.$search_term.'%';
			
			$data=DB::table('parties')
  			  ->select(
					 DB::raw('party_name as text'),
					 DB::raw('party_id as id')	
				)
			  ->where('party_name','like',$search_term)
			  ->get()->take(10);
			  
			  echo json_encode($data);
			  exit;
	}
}
