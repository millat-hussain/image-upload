<?php 

class Helper 
{

	public function Sorten($text,$limite =300){

		$text= $text."";
		$text= substr($text, 0,$limite);
		$text= substr($text, 0,strrpos($text, " "));
		$text= $text."...";
		return $text;


	
	}
	

}


 ?>