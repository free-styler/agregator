<?php

class Templates {

	private $templateData;
	private $templateDataStatic;

	function __construct($templateFileName) {
		$this->templateData = file_get_contents($templateFileName);
		$this->templateDataStatic = $this->templateData;
	}
	
	function replace($macrosName,$replaceData) {
		$this->templateData = str_replace ( "[*$macrosName*]", $replaceData, $this->templateData );
	}
	
	function reset() {
		$this->templateData = $this->templateDataStatic;
	}
	
	function output() {
		return $this->templateData;
	}
	
}

?>