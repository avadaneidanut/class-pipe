<?php

namespace ClassPipe\Contracts;

interface Pipeable{

	/**
	 * List registered pipes and signatures
	 * 
	 * @return void
	 */
	public function pipes();

	/**
	 * Add a new subscriber to specified pipe.
	 *
	 * @param  string    $pipe action pipe
	 * @param  callbable $subscriber
	 * @return void                
	 */
	public function subscriber($pipe, \Closure $subscriber);

	/**
	 * Broadcast to all subscribers from specifed pipe.
	 *
	 * @param  array $pipe action pipe
	 * @param  array $args arguments to be passed to subscribers
	 * @return void
	 */
	public function broadcast($pipe, array $args);
}