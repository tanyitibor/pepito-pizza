<?php 
namespace App;

use Illuminate\Http\UploadedFile;

class ImageStore
{
	const IMAGE_FOLDER = 'img/';
	const THUMB_FOLDER = 'img/thumb/';
	const THUMB_WIDTH = 300;

	public static function storeImageWithThumb($file, $name)
	{
		//needed for test
		if(\App::runningUnitTests()) {
			$file = new UploadedFile($file, $name, null, null, null, true);
		}

		//Get resource and color transparent parts of image white (php colors it black by default)
		$resource = self::resourceFromFile($file);
		$resource = self::colorTransparentWhite($resource);

		//save image
		$imagePath = self::IMAGE_FOLDER . $name . '.jpg';
		imagejpeg($resource, public_path($imagePath));

		//save thumb
		$resource = imagescale($resource, self::THUMB_WIDTH);
		$thumbPath = self::THUMB_FOLDER . $name . '.jpg';
		imagejpeg($resource, public_path($thumbPath));

		return [
			'image'			=> $imagePath,
			'thumb_image'	=> $thumbPath,
		];
	}

	private static function resourceFromFile($file)
	{
		$ext = $file->extension();

		switch($ext) {
			case 'jpg':
				return imagecreatefromjpeg($file);
			case 'jpeg':
				return imagecreatefromjpeg($file);
			case 'png':
				return imagecreatefrompng($file);
		}

		return null;
	}

	private static function colorTransparentWhite($resource)
	{
		$width = imagesx($resource);
		$height = imagesy($resource);
		$output = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($output,  255, 255, 255);
		imagefilledrectangle($output, 0, 0, $width, $height, $white);
		imagecopy($output, $resource, 0, 0, 0, 0, $width, $height);

		return $output;
	}
}