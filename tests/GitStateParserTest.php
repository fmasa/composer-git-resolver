<?php


namespace Fmasa\ComposerGitResolver;

use GitWrapper\GitException;
use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;
use Nette\IOException;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\TestCase;

class GitStateParserTest extends TestCase
{

	private const REPOSITORY = __DIR__ . '/test_repo';

	/** @var GitWorkingCopy */
	private $git;

	/** @var GitStateParser */
	private $parser;



	public function setUp()
	{
		$this->cleanupTestRepository();
		$this->git = (new GitWrapper())->init(self::REPOSITORY);
		$this->parser = new GitStateParser(self::REPOSITORY);
	}

	public function testIdentifyNormalState()
	{
		$this->assertSame(
			GitStateParser::NORMAL,
			$this->parser->getTreeState()
		);
	}

	public function testIdentifyRebase()
	{
		$this->createDivergingBranch('my-branch');

		try {
			$this->git->rebase('my-branch');
		} catch (GitException $e) {
			// It's ok, rebase failed because of conflicts
		}

		$this->assertSame(
			GitStateParser::REBASE,
			$this->parser->getTreeState()
		);
	}

	public function testIdentifyMerge()
	{
		$this->createDivergingBranch('my-branch');

		try {
			$this->git->merge('my-branch');
		} catch (GitException $e) {
			// It's ok, merge failed because of conflicts
		}

		$this->assertSame(
			GitStateParser::MERGE,
			$this->parser->getTreeState()
		);
	}

	private function createDivergingBranch(string $branchName)
	{
		$testFile = self::REPOSITORY . '/testfile';

		file_put_contents($testFile, '1');
		$this->git->add('.');
		$this->git->commit('Commit 1');

		$this->git->checkoutNewBranch($branchName);
		file_put_contents($testFile, '2');
		$this->git->commit('Commit 2');

		$this->git->checkout('-');
		file_put_contents($testFile, '3');
		$this->git->commit('Commit 3');
	}

	public function tearDown()
	{
		$this->cleanupTestRepository();
	}

	private function cleanupTestRepository()
	{
		try {
			FileSystem::delete(self::REPOSITORY . '/.git');
			FileSystem::delete(self::REPOSITORY . '/testfile');
		} catch (IOException $e) {
			// It's ok, directory may be already empty
		}

	}

}
