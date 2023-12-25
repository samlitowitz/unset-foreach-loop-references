<?php

declare(strict_types=1);

namespace SamLitowitz\Tests\PHPStan\Rules\ForEachLoop;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SamLitowitz\PHPStan\Rules\ForEachLoop\UnsetReferenceValuesAfterUseRule;

class UnsetReferenceValuesAfterUseRuleTest extends RuleTestCase
{
	protected function getRule(): Rule
	{
		return new UnsetReferenceValuesAfterUseRule();
	}

	public static function getAdditionalConfigFiles(): array
	{
		return array_merge(
			parent::getAdditionalConfigFiles(),
			[__DIR__ . '/data/foreach.neon']
		);
	}

	public function testRule(): void
	{
		$this->analyse(
			[
				__DIR__ . '/data/foreach.php',
			],
			[
				[
					'foreach value &$r1 IS A reference and IS NOT `unset` immediately after the loop',
					10,
				],
				[
					'foreach value &$r3 IS A reference and IS NOT `unset` immediately after the loop',
					30,
				],
				[
					'foreach value &$r3 IS A reference and IS NOT `unset` immediately after the loop',
					37,
				],
			]
		);
	}
}
