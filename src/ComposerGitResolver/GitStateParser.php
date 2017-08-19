<?php


namespace Fmasa\ComposerGitResolver;


class GitStateParser
{

	public const NORMAL = 0;
	public const REBASE = 1;
	public const MERGE = 2;

	/** @var string */
	private $directory;


	public function __construct(string $directory)
	{
		$this->directory = $directory;
	}

	public function getTreeState(): int
	{
		if(file_exists($this->directory . '/.git/rebase-apply')) {
			return self::REBASE;
		}

		if(file_exists($this->directory . '/.git/MERGE_HEAD')) {
			return self::MERGE;
		}

		return self::NORMAL;
	}


}
