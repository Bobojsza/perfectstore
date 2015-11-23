<?php

use Illuminate\Database\Seeder;

use App\SurveyImage;

class SurveyImageTableSeeder extends Seeder
{
    public function run()
    {
    	$directory = 'storage/surveyimages';
        $files = File::allFiles($directory);
		foreach ($files as $file)
		{
			$filename = explode("/", $file);
		    // echo (string)$filename[2], "\n";
		    SurveyImage::firstOrCreate(array('images' => $filename[2]));
		}

    }
}
