<?php

namespace App\Actions;

use DeSilva\Laradocgen\Laradocgen;

/**
 * Reset resource files so the tests can run with a fresh slate.
 * 
 * @todo add option to disable debug output and/or log to file instead.
 */
class ResetResourceFiles
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
		out("Resetting resource files.");
        out();

		warn("Existing files in the resource/docs folder will be deleted.");

		$resourceDirectory = Laradocgen::getSourcePath();

		/**
		 * Security check. Generally we want people to be able to customize resource paths,
		 * but in this kind of test we do not need that so instead we have this check to
		 * prevent accidental deletions. We could also move the the files to a temp dir.
		 */
		$s = DIRECTORY_SEPARATOR;
		if (substr($resourceDirectory, -16) !== "{$s}resources{$s}docs{$s}") {
			throw new \Exception("Aborting due to potentially unsafe directory. Please use the recommended path.", 1);
		}

		debug("Resource directory path is $resourceDirectory");

		if (!file_exists($resourceDirectory)) {
			out("Resource path does not exist. Has it already been removed? Returning");
			return;
		}

		$size = array_sum(array_map('filesize', glob("{$resourceDirectory}/*.*")));
		debug("Filesize of directory is ~" . number_format(($size / 1024), 2) . " kilobytes.");

        foreach (glob($resourceDirectory . "*.{md,yml}", GLOB_BRACE) as $filepath) {
			debug("Removing file $filepath");
			unlink($filepath);
        }

		foreach (glob($resourceDirectory . "media/*.{png,svg,jpg,jpeg,gif,ico,css,js}", GLOB_BRACE) as $filepath) {
			debug("Removing media file $filepath");
			unlink($filepath);
        }

		try {
			debug("Removing directory {$resourceDirectory}media");
			rmdir("{$resourceDirectory}media");
		} catch (\Exception $ex) {
			out("Could not remove directory {$resourceDirectory}media.");
			debug($ex->getMessage());
		}

		try {
			debug("Removing directory $resourceDirectory");
			rmdir($resourceDirectory);
		} catch (\Exception $ex) {
			out("Could not remove directory $resourceDirectory.");
			debug($ex->getMessage());
		}

		
	}
}
