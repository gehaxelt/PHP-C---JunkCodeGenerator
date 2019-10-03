<?php
include_once 'exceptions.junkcodefunction.class.php';
include_once 'junkcodevariable.class.php';
include_once 'junkcoderandom.class.php';

class JunkCodeFunction extends JunkCodeRandom{
	
	private $classFunctionName ='';
	private $classFunctionRetType ='';
	private $classFunctionArgs= array();
	private $classFunctionVariables=array();
	
	const RET_INT = 'int';
	const RET_BOOL = 'bool';
	const RET_DOUBLE = 'double';
	const RET_STRING = 'string';
	const RET_VOID = 'void';
	
	
	/**
	 * Constructor for JunkCodeFunction
	 */
	public function __construct() {
		
		$this->generateFunctionName();
		
		$this->generateFunctionRetType();
		
		$this->generateFunctionArgs();
		
		$this->generateFunctionVariables();
		
	}
	
	/**
	 * Generates a random name for the function
	 */
	private function generateFunctionName() {
		$this->classFunctionName=$this->randomString($this->randomInteger(10, 25));
	}
	
	/**
	 * Sets the ret type of the function
	 */
	private function generateFunctionRetType() {
		switch($this->randomInteger(1, 5)){
			case 1:
					$this->classFunctionRetType=JunkCodeFunction::RET_INT;
				break;
				
			case 2:
					$this->classFunctionRetType=JunkCodeFunction::RET_DOUBLE;
				break;
				
			case 3:
					$this->classFunctionRetType=JunkCodeFunction::RET_BOOL;
				break;
				
			case 4:
					$this->classFunctionRetType=JunkCodeFunction::RET_STRING;
				break;
				
			case 5:
					$this->classFunctionRetType=JunkCodeFunction::RET_VOID;
				break;
		}
	}
	
	/**
	 * Generates random parameters for the function
	 */
	private function generateFunctionArgs() {
		for($i=$this->randomInteger(0, 10);$i>0;$i--)
			$this->classFunctionArgs[$i]=new JunkCodeVariable();
	}
	
	/**
	 * Generates random local variables for the function
	 */
	private function generateFunctionVariables() {
		for($i=$this->randomInteger(0, 10);$i>0;$i--)
			$this->classFunctionVariables[$i]=new JunkCodeVariable();
	}
	
	/**
	 * Gettermethod of the functions name.
	 * @return string - name of the function
	 */
	public function getFunctionName() {
		return $this->classFunctionName;
	}
	
	/**
	 * Gettermethod of the functions ret type.
	 * @return string - type of the function
	 */
	public function getFunctionRetType() {
		return $this->classFunctionRetType;
	}
	
	/**
	 * Gettermethod of the functions parameters.
	 * @return array - array of JunkCodeVariables
	 */
	public function getFunctionArgs() {
		return $this->classFunctionArgs;
	}
	
	public function getFunctionArgsAsString() {
		$argstring='';
		
		for($i=count($this->classFunctionArgs);$i>0;$i--)
			$argstring.=$this->classFunctionArgs[$i]->getVariableType()." ".$this->classFunctionArgs[$i]->getVariableName().", ";
		
		$argstring=substr($argstring, 0,strlen($argstring)-2); //remove the comma from the end

		return $argstring;
	}
	
	/**
	 * Gettermethod of the functions local variables.
	 * @return array - array of JunkCodeVariables
	 */
	public function getFunctionVariables() {
		return $this->classFunctionVariables;
	}
	
	
	/**
	 * Generates the code of the function.
	 * @return string - code of the function
	 */
	public function getFunctionCode() {
		$functionCode='';
		
		//local variables
		for($i=count($this->classFunctionVariables);$i>0;$i--)
			$functionCode.=$this->classFunctionVariables[$i]->getVariableInitiation()."\n";
		
		//If-statements
		for($i=$this->randomInteger(0, 5);$i>0;$i--)
		{
			if(count($this->classFunctionVariables)==0){
				continue;
			}
			
			$randVar=$this->randomInteger(0, count($this->classFunctionVariables)-1)+1;
			$randVar2=$this->randomInteger(0, count($this->classFunctionVariables)-1)+1;
			$condition='';
			
			switch($this->randomInteger(0, 1)) 
			{
				case 0:
						$condition='==';
					break;
				case 1:
						$condition='==';
						break;
							// case 2:
						// $condition='<=';
								// break;
								// case 3:
						// $condition='>';
						// break;
						// case 4:
						// $condition='<';
					// break;
			}
			
			//Variabletype is string
			if($this->classFunctionVariables[$randVar]->getVariableType()=='volatile string') {
				$functionCode.='if (string('.$this->classFunctionVariables[$randVar]->getVariableValue().') '.$condition.' string('.$this->classFunctionVariables[$randVar]->getVariableValue().')) {'."\n";
			
			} else { //variabletype is not a string
				$functionCode.='if ('.$this->classFunctionVariables[$randVar]->getVariableValue().' '.$condition.' '.$this->classFunctionVariables[$randVar]->getVariableValue().') {'."\n";	
			}
			
			$forloopvar= $this->randomString($this->randomInteger(2, 10));
			
			$functionCode.='volatile int '.$forloopvar.';'."\n";
			$functionCode.='for ('.$forloopvar.'='.$this->randomInteger(0, 100).'; '.$forloopvar.' > 0; '.$forloopvar.'--) {'."\n";
				$functionCode.='global_increment++;';
			$functionCode.="\n} \n";
			
			$functionCode.="}\n";
		}
		
		//returnstatement
		$retstring='return ';
		switch($this->getFunctionRetType()) {
			case JunkCodeFunction::RET_INT:
					$retstring.=$this->randomInteger(0, 100000).';';
				break;
				
			case JunkCodeFunction::RET_DOUBLE:
					$retstring.=$this->randomInteger(0, 100000).';';
				break;
				
			case JunkCodeFunction::RET_BOOL:
				switch($this->randomInteger(0, 1)) {
					case 0:
						$retstring.='false;';
						break;
					case 1:
						$retstring.='true;';
						break;
				}
				break;
				
			case JunkCodeFunction::RET_STRING:
					$retstring.='string("'.$this->randomString($this->randomInteger(0, 20)).'");';
				break;
				
			case JunkCodeFunction::RET_VOID:
				$retstring='';
				break;
			
		}
		$functionCode.=$retstring;
	
		$functionCode.="\n";
		return $functionCode;
	}
	
	/**
	 * Generates the prototype of the function.
	 * @return string - code of the function.
	 */
	public function getFunctionPrototype() {
		return "static ".$this->getFunctionRetType()." ".$this->getFunctionName()."(".$this->getFunctionArgsAsString().");";
	}
}

?>