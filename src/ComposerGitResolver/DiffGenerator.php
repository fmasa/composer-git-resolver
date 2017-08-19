<?php


namespace Fmasa\ComposerGitResolver;


class DiffGenerator
{

	/**
	 * @return DependencyDiff[]
	 */
	public static function diff(array $previousDependencies, array $newDependencies): array
	{
		$diff = [];

		foreach($newDependencies as $name => $newVersion) {
			$previousVersion = NULL;
			if(isset($previousDependencies[$name])) {
				$previousVersion = $previousDependencies[$name];
				unset($previousDependencies[$name]);
			}

			if($previousVersion === $newVersion) {
				continue;
			}

			$diff[] = new DependencyDiff($name, $previousVersion, $newVersion);
		}

		foreach($previousDependencies as $name => $previousVersion) {
			$diff[] = new DependencyDiff($name, $previousVersion, NULL);
		}

		return $diff;
	}

}
