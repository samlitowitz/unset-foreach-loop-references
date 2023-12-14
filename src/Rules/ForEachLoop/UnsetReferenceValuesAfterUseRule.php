<?php

declare(strict_types=1);

namespace SamLitowitz\PHPStan\Rules\ForEachLoop;

use PhpParser\Node;
use PhpParser\Node\Stmt\Foreach_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use SamLitowitz\PHPStan\Visitors\ForEachByRefUnsetAfterVisitor;

final class UnsetReferenceValuesAfterUseRule implements Rule
{
	public function getNodeType(): string
	{
		return Foreach_::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		/** @var $node Foreach_ */
		if (!$node->byRef) {
			return [];
		}
		if (!$node->hasAttribute(ForEachByRefUnsetAfterVisitor::ATTRIBUTE_NAME)) {
			return [];
		}
		if ($node->getAttribute(ForEachByRefUnsetAfterVisitor::ATTRIBUTE_NAME)) {
			return [];
		}

		return [
			RuleErrorBuilder::message(
					sprintf(
						'foreach value &$%s IS A reference and IS NOT `unset` immediately after the loop',
						$node->valueVar->name
					)
				)
				->identifier('for.unsetReferenceValuesAfterUse')
				->build()
		];
	}
}
