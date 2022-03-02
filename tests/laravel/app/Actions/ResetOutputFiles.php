<?php

namespace App\Actions;

use DeSilva\Laradocgen\Laradocgen;

/**
 * Reset output files so the tests can run with a fresh slate.
 * 
 * @todo add option to disable debug output and/or log to file instead.
 */
class ResetOutputFiles
{
	/**
	 * Create the action.
	 *
	 * @return void
	 */
	public function __construct()
	{
		return $this->__invoke();
	}

	/**
	 * Execute the action.
	 *
	 * @return void
	 */
	public function __invoke()
	{
		out("Resetting build files.");
        out();

		warn("Existing files in the docs folder will be deleted.");

		$buildDirectory = Laradocgen::getBuildPath();

		/**
		 * Security check. Generally we want people to be able to customize output paths,
		 * but in this kind of test we do not need that so instead we have this check to
		 * prevent accidental deletions. We could also move the the files to a temp dir.
		 */
		$s = DIRECTORY_SEPARATOR;
		if (substr($buildDirectory, -13) !== "{$s}public{$s}docs{$s}") {
			throw new \Exception("Aborting due to potentially unsafe directory. Please use the recommended path.", 1);
		}

		debug("build directory path is $buildDirectory");

		if (!file_exists($buildDirectory)) {
			out("build path does not exist. Has it already been removed? Returning");
			return;
		}

		$size = array_sum(array_map('filesize', glob("{$buildDirectory}/*.*")));
		debug("Filesize of directory is ~" . number_format(($size / 1024), 2) . " kilobytes.");

        foreach (glob($buildDirectory . "*.{html}", GLOB_BRACE) as $filepath) {
			debug("Removing file $filepath");
			unlink($filepath);
        }

		foreach (glob($buildDirectory . "media/*.{png,svg,jpg,jpeg,gif,ico,css,js}", GLOB_BRACE) as $filepath) {
			debug("Removing media file $filepath");
			unlink($filepath);
        }

		try {
			debug("Removing directory {$buildDirectory}media");
			rmdir("{$buildDirectory}media");
		} catch (\Exception $ex) {
			out("Could not remove directory {$buildDirectory}media.");
			debug($ex->getMessage());
		}

		try {
			debug("Removing directory $buildDirectory");
			rmdir($buildDirectory);
		} catch (\Exception $ex) {
			out("Could not remove directory $buildDirectory.");
			debug($ex->getMessage());
		}

	}
}
