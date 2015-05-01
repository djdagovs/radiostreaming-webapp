<?php
namespace App\Services;
use App\Promotions;
use Validator;

class PromotionsService {

	public function validate(array $data){
		return Validator::make($data, [
			'title' => 'required|max:255',
			'address' => 'required|max:255',
			'image_url' => 'max:255',
			'date' => 'required|date',
			'time' => array('regex:/[0-9]:[0-5][0-9]\s?(AM|PM|am|pm)|[0-1][0-2]:[0-5][0-9]\s?(AM|am|pm|PM)/', 'required'),
			'price' => 'numeric|min:0'
		]);
	}
	public function create(array $data){
		if(isset($data['image'])){
			$file = $data['image'];
			// If the image is valid...
			if($this->isValidImage($file)){
				// If the File upload successfully...
				if($this->upload($file)){
					$data['image_url'] = $file->getClientOriginalName();
					$this->save($data);	
				}
			}
		}
		$this->save($data);
	}

	public function upload($file){
		$path = public_path() . '/uploads';
		$filename= $file->getClientOriginalName();
		$newFile = $file->move($path, $filename);
		return $newFile;
	}

	public function create($data){
		$readyData = $this->recordBuilder($data);
		return Promotion::create($readyData);
	}

	public function update($id,$data){
		$promotion = Promotion::find($id);
		$readyData = $this->recordBuilder($data);
		$promotion->save($readyData);
		return $promotion;
	}

	private function recordBuilder($data){
		$promotionReadyData = [
			'title' => $data['title'],
			'address' => $data['address'],
			'image_url' => $data['image_url'],
			'date' => date('Y-m-d', strtotime($data['date'])),
			'time' => date('H:i', strtotime($data['time'])),
			'price' => $data['price']
		];
		return $promotionReadyData;
	}

	/*Main method for image validation - NO RETUNING ERROR MESSAGE YET*/
	public function isValidImage($file){
		$validImageMime = $this->isValidMimeType($file);
		$validImageSize = $this->isValidImageSize($file);
		
		if($validImageMime && $validImageSize){
			return $file;
		}
	}
    /*Check if the image is of a valid file size*/
	private function isValidImageSize($file){
		$validImageSize = 500000;
		$fileSize = $file->getClientSize();
		if ($fileSize <= $validImageSize && $fileSize > 0){
			return $fileSize;
		}
	}
	/*Check if the image is of a valid Mime Type*/

	private function isValidMimeType($file){
		$fileMimeType = $file->getMimeType();
		$validMimeTypes = ['image/jpeg', 'image/png'];
		foreach($validMimeTypes as $mime){
			if ($fileMimeType==$mime){
				return $fileMimeType;
			}
		}
	}

}

 ?>