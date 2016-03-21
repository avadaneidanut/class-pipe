<?php

namespace ClassPipe\Examples\Classes;

use ClassPipe\ClassPipe;

class Logger extends ClassPipe{
	
	/**
	 * Pipes signatures
	 * 
	 * @var array
	 */
	protected $pipes = [
		'store' => 'message:Message to be stored,owner:Owner of this message,context:Class Context',
		'show'  => 'context:Class Context'
	];

	/**
	 * Logged messages
	 * 
	 * @var array
	 */
	protected $messages = [];

	/**
	 * Register default pipes
	 */
	public function __construct(){
		// store action
		$this->subscriber('store', function($message, $owner){
			$this->messages[$owner] = $message;
		});

		// list action
		$this->subscriber('show', function(){
			print_r($this->messages);
		});
	}

	/**
	 * Store a new message
	 * 
	 * @param  string $message 
	 * @param  string $owner   
	 * @return void
	 */
	public function store($message, $owner){
		$this->broadcast('store', func_get_args(), $this);
	}

	/**
	 * Lists stored messages
	 * 
	 * @return void
	 */
	public function show(){
		$this->broadcast('show', [$this]);
	}
}