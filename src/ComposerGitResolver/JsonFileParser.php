<?php


namespace Fmasa\ComposerGitResolver;


use Nette\Utils\Json;
use Nette\Utils\JsonException;

class JsonFileParser
{

	/** @var string */
	private $file;

	public function __construct(string $file)
	{
		$this->file = $file;
	}

	/**
	 * @return string[] string(dependency name) => string(version constraint)
	 * @throws JsonException
	 */
	public function getDependencies(): array
	{
		return $this->getJson()['require'] ?? [];
	}

	/**
	 * @return string[] string(dependency name) => string(version constraint)
	 * @throws JsonException
	 */
	public function getDevDependencies(): array
	{
		return $this->getJson()['require-dev'] ?? [];
	}

	/**
	 * @throws JsonException
	 */
	private function getJson(): array
	{
		return Json::decode(file_get_contents($this->file), JSON_OBJECT_AS_ARRAY);
	}

}
