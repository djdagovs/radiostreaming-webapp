<?php namespace App\Services;
use App\Radio;


class RadioService extends LaravelDataService{

	public function __construct(){
		
		$this->model = new Radio;

		$this->rules = [
		'name' => 'required|max:60',
		'address' => 'max:60',
		'slogan' => 'max:255',
		'logo' => 'max:500',
		'email' =>'max:255|email|required',
		'phone' => 'max:14',
		'twitter' =>'max:255',
		'facebook' =>'max:255',
		'instagram' => 'max:255',
		'streaming_url' =>'max:255',
		'youtube' =>'max:255'
		];
	}

	public function recordBuilder($data){

		$record = [
		'name' => $data['name'],
		'slogan' => $data['slogan'],
		'address' =>$data['address'],
		'email' => $data['email'],
		'telephone' =>$data['phone'],
		'streaming_url' =>$data['streaming_url']
		];
		
		if($imageUrl = $this->imageProcessor($data)){
			$record['logo_url'] = $imageUrl;
		}
		
		return $record;
	}
}

?>