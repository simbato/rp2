<?php 

class IndexController
{
	public function index() 
	{
		// Samo preusmjeri na channel index
		header( 'Location: index.php?rt=channel' );
	}
}; 

?>