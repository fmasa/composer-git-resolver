<?php


namespace Fmasa\ComposerGitResolver;


use PHPUnit\Framework\TestCase;

class JsonFileParserTest extends TestCase
{

	public function testGetDependencies()
	{
		$parser = new JsonFileParser(__DIR__ . '/test_composer.json');

		$this->assertSame([
			"php" => ">=7.1",
    		"package1/package2" => "~3.0",
		],
			$parser->getDependencies()
		);
	}

	public function testGetDependenciesWithNoRequire()
	{
		$parser = new JsonFileParser(__DIR__ . '/test_composer_without_require.json');

		$this->assertSame([], $parser->getDependencies());
	}

	public function testGetDevDependencies()
	{
		$parser = new JsonFileParser(__DIR__ . '/test_composer.json');

		$this->assertSame([
			"phpunit/phpunit" => "^6.3",
    		"cpliakas/git-wrapper" => "^1.7",
    		"nette/utils" => "^2.4",
		],
			$parser->getDevDependencies()
		);
	}

	public function testGetDevDependenciesWithNoRequire()
	{
		$parser = new JsonFileParser(__DIR__ . '/test_composer_without_require.json');

		$this->assertSame([], $parser->getDevDependencies());
	}

}
