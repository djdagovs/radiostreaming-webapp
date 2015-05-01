<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PromotionsService;
use Illuminate\Http\Request;
use App\Promotions;

class PromotionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$promotions = Promotions::paginate(10);
		return view('promotions.list_promotions', ['promotions'=>$promotions]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('promotions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request, PromotionsService $promotions)
	{
		$data = $request->all();
		$validator = $promotions->validate($data);

		if ($validator->fails()){
			return \Redirect::to('promotions/create')->withInput()->withErrors($validator);
		}
		else{	
			$promotions->create($data);
			return \Redirect::to('promotions');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$promotion = Promotions::find($id);
		return view('promotions.edit_promotion', ['promotion'=>$promotion]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request, PromotionsService $promotions)
	{
		$data = $request->all();
		$validator = $promotions->validate($data);

		if ($validator->fails()){
			return \Redirect::to("promotions/$id/edit")->withInput()->withErrors($validator);
		}

		else{	
			$promotion = Promotions::find($id);
			$promotion->title = $data['title'];
			$promotion->address = $data['address'];
			$promotion->date = date('Y-m-d', strtotime($data['date']));
			$promotion->time = date('H:i', strtotime($data['time']));
			$promotion->price = $data['price'];
			$promotion->save();	
			return \Redirect::to("promotions");		
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$promotion = Promotions::find($id);
		$promotion->delete();
	}

}