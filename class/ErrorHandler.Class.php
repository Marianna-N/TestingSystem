<?php

// Minor adjustments since the last task!

declare(strict_types=1);


// While development stage leave it intact.
// At production stage it should redirect user
// to some kind of 'we are so sorry' page and inform
// support group about existing problem.
class ErrorHandler
{
	public static function errorErrorHandler($errno, $errstr, $errfile, $errline) : void
	{
		throw new Exception($errstr . ' in ' . $errfile . ' at line ' . $errline);
	}
	
	public static function exceptionErrorHandler($exception) : void
	{
		exit($exception->getMessage() . ' in ' . $exception->getFile() . ' at line ' . $exception->getLine());
	}
}