<?php


namespace Fmasa\ComposerGitResolver;


use PHPUnit\Framework\TestCase;

class DiffGeneratorTest extends TestCase
{

	public function testNewDependencyIsInDiff()
	{
		$previous = [];

		$new = [
			'new-package/package' => '2.1',
		];

		$diff = DiffGenerator::diff($previous, $new);

		$this->assertCount(1, $diff);

		$this->assertSame('new-package/package', $diff[0]->getPackageName());
		$this->assertNull($diff[0]->getPreviousVersion());
		$this->assertSame('2.1', $diff[0]->getNewVersion());
	}

	public function testNotChangedDependencyIsNotInDiff()
	{
		$unchanged = [
			'new-package/package' => '2.1',
		];

		$diff = DiffGenerator::diff($unchanged, $unchanged);

		$this->assertEmpty($diff);
	}

	public function testDependencyWithChangedVersionIsInDiff()
	{
		$previous = [
			'package/package' => '2.0',
		];

		$new = [
			'package/package' => '2.1',
		];

		$diff = DiffGenerator::diff($previous, $new);

		$this->assertCount(1, $diff);

		$this->assertSame('package/package', $diff[0]->getPackageName());
		$this->assertSame('2.0', $diff[0]->getPreviousVersion());
		$this->assertSame('2.1', $diff[0]->getNewVersion());
	}

	public function testRemovedDependencyIsInDiff()
	{
		$previous = [
			'old-package/package' => '2.1',
		];

		$new = [];

		$diff = DiffGenerator::diff($previous, $new);

		$this->assertCount(1, $diff);

		$this->assertSame('old-package/package', $diff[0]->getPackageName());
		$this->assertSame('2.1', $diff[0]->getPreviousVersion());
		$this->assertNull($diff[0]->getNewVersion());
	}

}
