<?php

namespace UnsetReferenceValuesAfterUse;

final class A
{
	public function doesNotUnsetAfterUse(): void
	{
		$a = [1, 2, 3];
		foreach ($a as &$r1) {
		}
		foreach ($a as $v) {
			print_r($a);
		}
	}

	public function unsetsAfterUse(): void
	{
		$a = [1, 2, 3];
		foreach ($a as &$r2) {
		}
		unset($r2);
		foreach ($a as $v) {
			print_r($a);
		}
	}
}

$a = [1, 2, 3];
foreach ($a as &$r3) {
}
foreach ($a as $v) {
	print_r($a);
}

$a = [1, 2, 3];
foreach ($a as &$r3) {
}
foreach ($a as $v) {
	print_r($a);
}
unset($r3);

$a = [1, 2, 3];
foreach ($a as &$r4) {
}
unset($r4);
foreach ($a as $v) {
	print_r($a);
}
