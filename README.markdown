# A PHPStan rule to enforce the unsetting of foreach value references immediately after use

# Usage
To use these rules, require it via [Composer](https://getcomposer.org/)
```
composer require samlitowitz/unset-foreach-loop-references --dev
```

Include rules.neon in your project's PHPStan config
```
includes:
    - vendor/samlitowitz/unset-foreach-loop-references/rules.neon
```

# Examples

## Not Allowed

```php
$a = [1, 2, 3];
foreach ($a as &$r1) {
}
foreach ($a as $v) {
	print_r($a);
}
```

```php
$a = [1, 2, 3];
foreach ($a as &$r1) {
}
foreach ($a as $v) {
	print_r($a);
}
unset($r1);
```

## Allowed

```php
$a = [1, 2, 3];
foreach ($a as &$r2) {
}
unset($r2);
```
