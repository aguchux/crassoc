<?php


class index{
	
	public $index = '';
	public $form = '';
	public $path = '';
	
	public $css = '';
	public $js = '';
	public $php = '';
	public $png = '';
	public $jpg = '';
	public $phtml = '';
	
	public function index(){}
	
	public function init($index){
		$this->index = $index;
		$this->path = "./index/" . $index . "/" ;
		$this->css = $this->path . $index . ".css";
		$this->js = $this->path . $index . ".js";
		$this->php = $this->path . $index . ".php";
		$this->png = $this->path . $index . ".png";
		$this->jpg = $this->path . $index . ".jpg";
		$this->phtml = $this->path . $index . ".phtml";
	}
	
}




?>