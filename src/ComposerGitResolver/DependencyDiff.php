<?php


namespace Fmasa\ComposerGitResolver;


class DependencyDiff
{

	/** @var string */
	private $packageName;

	/** @var string|null */
	private $previousVersion;

	/** @var string|null */
	private $newVersion;

	public function __construct(string $packageName, ?string $previousVersion, ?string $newVersion)
	{
		$this->packageName = $packageName;
		$this->previousVersion = $previousVersion;
		$this->newVersion = $newVersion;
	}

	public function getPackageName(): string
	{
		return $this->packageName;
	}

	public function getPreviousVersion(): ?string
	{
		return $this->previousVersion;
	}

	public function getNewVersion(): ?string
	{
		return $this->newVersion;
	}

}
