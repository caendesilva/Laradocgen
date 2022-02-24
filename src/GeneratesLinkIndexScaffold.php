<?php

namespace Caendesilva\Docgen;

/**
 * Generate a file scaffold to order the links
 */
class GeneratesLinkIndexScaffold
{
	public static function generate(bool $force = false)
	{
		# Static facade interface
		return new self($force);
	}

	private string $filePath;

	private string $fileContents = "";

	private bool $force = false;

    public function __construct(bool $force = false) {
		$this->force = $force;

		$this->filePath = resource_path() . '/docs/linkIndex.yml';

		if ($this->checkIfScaffoldExists()) {
			echo "\033[33mWarn: Scaffold file already exists. ";
			if ($this->checkIfScaffoldIsLocked()) {
				if ($this->force === true) {
					echo "Force flag is present. Overwriting file.";
				} else {
					throw new \Exception("Scaffolding file is locked. Aborting.", 1);
				}
				echo "\033[0m \n";
			} else {
				echo "Scaffolding file is not locked. Overwriting it.";
			}
			echo "\033[0m \n";
		}
		
		echo $this->generateFileContents();

		return (bool) $this->saveFile();
	}

	private function checkIfScaffoldExists(): bool
	{
		return file_exists($this->filePath);
	}

	private function checkIfScaffoldIsLocked(): bool
	{
		return str_contains(file_get_contents($this->filePath), 'Locked: true');
	}


	private function generateFileContents(): string
	{
        $time_start = microtime(true);

		$this->addLine('# Rearrange the list items below to decide the order of navigation links in the sidebar');
		$this->addLine();
		$this->addLine('Locked: ' . ($this->force ? 'true' : 'false') . ' # Prevents the file from being edited by the scaffold generator unless the force flag is passed.
		');
		$this->addLine('Links:');
		
		foreach (Docgen::getMarkdownFileSlugsArray() as $slug) {
			$this->addLine('  - ' . $slug);
		}

        $time = (float) ((microtime(true) - $time_start) / 60);
		$this->addLine();
		
		return $this->addLine('# Generated in ' . sprintf('%f', $time) . ' seconds');
	}

	private function addLine(string|null $lineContents = null): string
	{
		// Null to add empty line
		return $this->fileContents .= $lineContents . PHP_EOL;
	}

	private function saveFile(): bool
	{
		return (bool) file_put_contents($this->filePath, $this->fileContents); // Returns true if success, else false on failure
	}
}
