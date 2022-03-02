<?php

/**
 * Global Helper Functions
 */

if (!function_exists('out')) {
	/**
	 * Output a standard string to the terminal.
	 * 
	 * @param string|null $output if null an empty line will be printed
	 * @param bool $space should a vertical padding be added?
	 * @return void
	 */
	function out(?string $output = "", bool $space = false) {
		$out = new \Symfony\Component\Console\Output\ConsoleOutput();
		if ($space) {
			$out->writeln(PHP_EOL . ($output ?? "") . PHP_EOL);
		} else {
			$out->writeln($output ?? "");
		}
	}
}

if (!function_exists('debug')) {
	/**
	 * Output a debug level string to the terminal.
	 * 
	 * @param string|null $output if null an empty line will be printed
	 * @return void
	 */
	function debug(?string $output = "") {
		$out = new \Symfony\Component\Console\Output\ConsoleOutput();
		$out->writeln("  > \033[37m" . $output . "\033[0m");
	}
}

if (!function_exists('warn')) {
	/**
	 * Output a warn level string to the terminal.
	 * 
	 * @param string|null $output if null an empty line will be printed
	 * @return void
	 */
	function warn(?string $output = "") {
		$out = new \Symfony\Component\Console\Output\ConsoleOutput();
		$out->writeln("[\033[33mWARN\033[0m]:" . $output ?? "");
	}
}


if (!function_exists('error')) {
	/**
	 * Output a error level string to the terminal.
	 * 
	 * @param string|null $output if null an empty line will be printed
	 * @return void
	 */
	function error(?string $output = "") {
		$out = new \Symfony\Component\Console\Output\ConsoleOutput();
		$out->writeln("[\033[31mERROR\033[0m]:" . $output ?? "");
	}
}
