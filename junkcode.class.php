<?php
include_once 'exceptions.junkcode.class.php';
include_once 'junkcoderandom.class.php';
include_once 'junkcodevariable.class.php';
include_once 'junkcodefunction.class.php';

class JunkCodeClass extends JunkCodeRandom {
	
	private $className='';
	private $classNameSpace='';
	private $classIncludes = array();
	private $classVariables = array("private"=>array(),"protected"=>array(),"public"=>array());
	private $classFunctions = array("private"=>array(),"protected"=>array(),"public"=>array());
	
	/**
	 * Constructor of JunkCodeClass, generating the class content.
	 */
	public function __construct() {
		
		$this->generateClassName();
		
		$this->generateIncludes();
		
		$this->generateClassNameSpace();
		
		$this->generateVariables();
		
		$this->generateFunctions();
	}
	
	/**
	 * Generates a random classname
	 */
	private function generateClassname() {
		$this->className=$this->randomString(7);
	}
	
	/**
	 * Implements the includs of the class
	 */
	private function generateIncludes() {
		array_push($this->classIncludes,"iostream");
		array_push($this->classIncludes,"string");
		array_push($this->classIncludes, "stdio.h");
	}
	
	/**
	 * Implements the namespace used by the class
	 */
	private function generateClassNameSpace() {
		$this->classNameSpace='std';
	}
	
	/**
	 * Generates some random class member variables.
	 */
	private function generateVariables() {
		
		foreach(array("public","protected","private") as $classFunctionsIndex)
			for($i=$this->randomInteger(1, 5);$i>0;$i--)
				$this->classVariables[$classFunctionsIndex][$i]=new JunkCodeVariable();


	}
	
	/**
	 * Generates some random class member functions
	 */
	private function generateFunctions() {
		
		foreach(array("public","protected","private") as $classFunctionsIndex)
			for($i=$this->randomInteger(1, 10);$i>0;$i--)
				$this->classFunctions[$classFunctionsIndex][$i]=new JunkCodeFunction();
		
	}
	
	/**
	 * Gettermethod of the prototype of the constructor
	 * @return string - Prototype of the contructor
	 */
	public function getConstructorPrototype() {
		return $this->className."();";
	}
	
	/**
	 * Generates the Code of the header file of the class with its prototypes.
	 * @return string - Code of the header file
	 */
	public function getHeaderCode() {
		$headerCode='';
		
		for($i=count($this->classIncludes);$i>0;$i--)
			$headerCode.='#include <'.array_pop($this->classIncludes).'>'."\n";
		
		$headerCode.="\n";
		
		$headerCode.='using namespace '.$this->classNameSpace.";\n\n";
		
		$headerCode.="volatile int global_increment;\n\n";
		$headerCode.='class '.$this->className.' {'."\n";
		
		foreach(array("public","protected","private") as $classFunctionsIndex) {
			$headerCode.=$classFunctionsIndex.':'."\n";
			
			//variables
			for($i=count($this->classVariables[$classFunctionsIndex]);$i>0;$i--)
				$headerCode.=$this->classVariables[$classFunctionsIndex][$i]->getVariablePrototype()."\n";
			
			if($classFunctionsIndex=="public")
				$headerCode.=$this->getConstructorPrototype();
			
			$headerCode.="\n";
			
			//functions
			for($i=count($this->classFunctions[$classFunctionsIndex]);$i>0;$i--)
				$headerCode.=$this->classFunctions[$classFunctionsIndex][$i]->getFunctionPrototype()."\n";
			
			$headerCode.="\n";
			
		}
		
		$headerCode.='};'."\n";
		
		return $headerCode;
	}
	
	
	/**
	 * Generates the Code of the code file of the class with its code.
	 * @return string - Code of the code file
	 */
	public function getClassCode() {
		$classCode='';
		
		//loop through all three kinds of functions and append their code to the classCode
		foreach(array("private","protected","public") as $classFunctionsIndex) {
			for($i=count($this->classFunctions[$classFunctionsIndex]);$i>0;$i--)
			{	
				$classCode.="\n#pragma optimize( \"\", off )\n";
				$classCode.=$this->classFunctions[$classFunctionsIndex][$i]->getFunctionRetType()." ".$this->className."::".$this->classFunctions[$classFunctionsIndex][$i]->getFunctionName()."(".$this->classFunctions[$classFunctionsIndex][$i]->getFunctionArgsAsString().") {"."\n";
				$classCode.=$this->classFunctions[$classFunctionsIndex][$i]->getFunctionCode();
				$classCode.="}";	
				$classCode.="\n#pragma optimize( \"\", on )\n";
			}
		}
		
		//Constructor code
		$classCode.="\n#pragma optimize( \"\", off )\n";
		$classCode.=$this->className."::".$this->className."() {\n";
		
		foreach(array("public","protected","private") as $classIndexKey) {
			
			for($i=count($this->classFunctions[$classIndexKey]);$i>0;$i--)
			{
				$classCode.="this->".$this->classFunctions[$classIndexKey][$i]->getFunctionName()."(";
				
					$arglist='';
					foreach ($this->classFunctions[$classIndexKey][$i]->getFunctionArgs() as $arg){
						
						switch($arg->getVariableType()) {
							case JunkCodeVariable::INT:
								$arglist.=$this->randomInteger(0, $this->randomInteger(1000, 10000)).", ";
								break;
							
							case JunkCodeVariable::DOUBLE:
								$arglist.=$this->randomInteger(0, $this->randomInteger(10000, 100000)).", ";
								break;
							
							case JunkCodeVariable::BOOL:
								switch($this->randomInteger(0, 1))
								{
									case 0:
										$arglist.='false'.", ";
										break;
							
									case 1:
										$arglist.='true'.", ";
										break;
								}
								break;
							case JunkCodeVariable::STRING:
								$arglist.='string("'.$this->randomString($this->randomInteger(0, 100)).'")'.", ";
								break;
						}
					}
					
					$classCode.=substr($arglist, 0,strlen($arglist)-2);
						
				$classCode.=");"."\n";
			}
		}
		
		$classCode.="}\n";
		
		$classCode.="#pragma optimize( \"\", on )\n";

		return $classCode;
}
	
}
?>