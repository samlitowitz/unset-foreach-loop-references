<?php

declare(strict_types=1);

namespace SamLitowitz\PHPStan\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

final class ForEachByRefUnsetAfterVisitor extends NodeVisitorAbstract
{
	public const ATTRIBUTE_NAME = 'unsetsRefValueAfter';
	/** @var ?Node\Stmt\Foreach_ */
	private $previous;

	public function beforeTraverse(array $nodes): ?array
	{
		$this->previous = null;
		return null;
	}

	public function enterNode(Node $node): ?Node
	{
		if ($this->previous === null) {
			return null;
		}
		if (!($node instanceof Node\Stmt\Unset_)) {
			$this->previous->setAttribute(self::ATTRIBUTE_NAME, false);
			$this->previous = null;
			return null;
		}

		$forEachVar = $this->previous->valueVar;
		if (!($forEachVar instanceof Node\Expr\Variable)) {
			$this->previous->setAttribute(self::ATTRIBUTE_NAME, false);
			$this->previous = null;
			return null;
		}
		/** @var Node\Stmt\Unset_ $node */
		foreach ($node->vars as $unsetVar) {
			if (!($unsetVar instanceof Node\Expr\Variable)) {
				continue;
			}
			if ($unsetVar->name === $forEachVar->name) {
				$this->previous->setAttribute(self::ATTRIBUTE_NAME, true);
				$this->previous = null;
				return null;
			}
		}
		$this->previous->setAttribute(self::ATTRIBUTE_NAME, false);
		$this->previous = null;
		return null;
	}

	public function leaveNode(Node $node): ?Node
	{
		$this->previous = null;
		if (!($node instanceof Node\Stmt\Foreach_)) {
			return null;
		}
		if (!$node->byRef) {
			return null;
		}
		$this->previous = $node;
		return null;
	}
}
