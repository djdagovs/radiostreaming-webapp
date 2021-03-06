<?php

namespace App\Services;

use App\Radio;
use App\Contracts\FileUploaderContract;

class RadioService extends LaravelDataService
{

	protected $fileUploader;

	public function __construct(FileUploaderContract $fileUploader, Radio $radio)
	{

		$this->fileUploader = $fileUploader;

		$this->model = $radio;

		$this->rules = [
		'name' => 'required|max:60',
		'address' => 'max:60',
		'slogan' => 'max:255',
		'logo' => 'max:500',
		'email' =>'max:255|email',
		'phone' => 'max:14',
		'twitter' =>'max:255',
		'facebook' =>'max:255',
		'instagram' => 'max:255',
		'streaming_url' =>'max:255',
		'youtube' =>'max:255'
		];
	}

	public function recordBuilder($data)
	{

		$record = [
		'name' => $data['name'],
		'slogan' => $data['slogan'],
		'address' =>$data['address'],
		'email' => $data['email'],
		'telephone' =>$data['phone'],
		'streaming_url' =>$data['streaming_url'],
		'facebook' =>$data['facebook'],
		'twitter' =>$data['twitter'],
		'instagram' =>$data['instagram'],
		'youtube' =>$data['youtube']
		];

		if (isset($data["image"]))
        {
        	$file = $data["image"];
        	if($imageUrl = $this->fileUploader->upload($file))
        	{
				$record['logo_url'] = $imageUrl;
			}
		}

		return $record;
	}
}
?>