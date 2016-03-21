<?php

namespace ClassPipe;

use ClassPipe\Contracts\Pipeable;
use ClassPipe\Exceptions\PipeNotRegisteredException;

Class ClassPipe implements Pipeable{

	/**
	 * Pipe signatures
	 * 
	 * @example  'store' => 'message:Message to be stored,context:Context'
	 * @var array
	 */
	protected $pipes = [];

	/**
	 * The subscribers array.
	 *  
	 * @var array
	 */
	protected $subscribers = [];

	/**
	 * Add a new subscriber to specified pipe.
	 *
	 * @param  string    $pipe action pipe
	 * @param  callbable $subscriber
	 * @return void                
	 */
	public function subscriber($pipe, \Closure $subscriber){
		// check if pipe registered
		$this->pipe($pipe);

		// add subscriber to pipe
		$this->subscribers[$pipe][] = $subscriber;
	}

	/**
	 * Broadcast to all subscribers from specifed pipe.
	 *
	 * @param  array $pipe action pipe
	 * @param  array $args arguments to be passed to subscribers
	 * @return void
	 */
	public function broadcast($pipe, array $args){
		// don't broadcast if no subscribers to specified pipe
		if( !isset($this->subscribers[$pipe]) ) return;

		// iterate over all subscribers
		foreach($this->subscribers[$pipe] as $subscriber){
			// call with provided arguments
			$subscriber(...$args);
		}
	}

	/**
	 * List registered pipes and signatures
	 * 
	 * @return void
	 */
	public function pipes(){
		print('--------------------------------' . PHP_EOL);

		print('Registered pipes/arguments' . PHP_EOL . PHP_EOL);

		// calculate the padding
		$lenghts = array_map('strlen', array_keys($this->pipes));
		$pad     = max($lenghts);

		foreach($this->pipes as $key => $signature){
			// print pipe name
			print(str_pad($key, $pad, ' ', STR_PAD_RIGHT) . ' ');

			$signatures = explode(',', $signature);

			// print signatures
			$first = true;
			foreach($signatures as $signature){
				if($first){
					$first = false;
					$spaces = '';
				}
				else{
					$spaces = PHP_EOL . str_pad('', $pad + 1, ' ', STR_PAD_LEFT);
				}
				// print signature
				print($spaces . $signature);
			}

			print(PHP_EOL);
		}
	}

	/**
	 * Check if pipe registered
	 * 
	 * @throws PipeNotRegisteredException
	 * @param  string $pipe
	 * @return void
	 */
	protected function pipe($pipe){
		if( !isset($this->pipes[$pipe]) )
			throw new PipeNotRegisteredException($pipe);
	}
}