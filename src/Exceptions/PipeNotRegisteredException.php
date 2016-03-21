<?php

namespace ClassPipe\Exceptions;

class PipeNotRegisteredException extends \Exception{
	
	/**
	 * @param string $pipe Pipe that isn't registered
	 */
	public function __construct($pipe){
		parent::__construct($pipe . ' not registered.', 0);
	}
}