<?php
include_once 'exceptions.junkcodevariable.class.php';
include_once 'exceptions.junkcoderandom.class.php';
		
class JunkCodeVariable extends JunkCodeRandom {
	
	private $classVariableName='';
	private $classVariableType='';
	private $classVariableValue='';
	
	const INT = 'volatile int';
	const DOUBLE = 'volatile double';
	const BOOL = 'volatile bool';
	const STRING = 'volatile string';
	
	public function __construct() {
		
		$this->generateVariableName();
		
		$this->generateVariableType();
		
		$this->generateVariableValue();
	}
	
	/**
	 * Generates a random variablename
	 */
	private function generateVariableName() {
		$this->classVariableName=$this->randomString($this->randomInteger(5, 15));
	}
	
	/**
	 * Sets the type of the variable randomously
	 */
	private function generateVariableType() {
		switch($this->randomInteger(1, 4))
		{
			case 1:
					$this->classVariableType=JunkCodeVariable::INT;
				break;
				
			case 2:
				$this->classVariableType=JunkCodeVariable::DOUBLE;
				break;
				
			case 3:
				$this->classVariableType=JunkCodeVariable::BOOL;
				break;
				
			case 4:
				$this->classVariableType=JunkCodeVariable::STRING;
				break;
		}
	}
	
	/**
	 * Generates a value for the variable depending on its type.
	 */
	private function generateVariableValue() {
		
		switch($this->classVariableType){
			case JunkCodeVariable::INT:
					$this->classVariableValue=$this->randomInteger(0, $this->randomInteger(1000, 10000));
				break;
				
			case JunkCodeVariable::DOUBLE:
				$this->classVariableValue=$this->randomInteger(0, $this->randomInteger(10000, 100000));
				break;
				
			case JunkCodeVariable::BOOL:
				switch($this->randomInteger(0, 1))
				{
					case 0:
							$this->classVariableValue='false';
						break;
						
					case 1: 
							$this->classVariableValue='true';
						break;
				}
				break;
			case JunkCodeVariable::STRING:
					$this->classVariableValue='"'.$this->randomString($this->randomInteger(0, 100)).'"';
				break;
		}
	}
	
	public function getVariablePrototype() {
		return $this->getVariableType()." ".$this->getVariableName()."{};";
	}
	
	public function getVariableInitiation() {
		return $this->getVariableType()." ".$this->getVariableName()." = ".$this->getVariableValue().";";
	}
	
	/**
	 * Gettermethod for the variables type.
	 * @return string - type of the variable
	 */
	public function getVariableType() 
	{
		return $this->classVariableType;
	}
	
	/**
	 * Gettermethod for the variables name.
	 * @return string - name of the variable
	 */
	public function getVariableName() 
	{
		return $this->classVariableName;
	}
	
	/**
	 * Gettermethod for the variables value.
	 * @return string - value of the variable
	 */
	public function getVariableValue()
	{
		return $this->classVariableValue;
	}
}
?>