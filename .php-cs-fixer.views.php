<?php
/**
 * PHP CS Fixer configuration for view templates.
 *
 * Only PHP tokens inside <?php ?> are rewritten; inline HTML is left byte-for-byte
 * untouched, so rendered output is unchanged. Stock CodeIgniter error templates are
 * excluded. Risky rules disabled.
 */

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/en/application/views')
    ->name('*.php')
    ->notPath('errors');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setRules([
        'array_syntax'                        => ['syntax' => 'short'],
        'single_quote'                        => true,
        'object_operator_without_whitespace'  => true,
        'binary_operator_spaces'              => ['default' => 'single_space'],
        'no_trailing_whitespace'              => true,
        'no_whitespace_in_blank_line'         => true,
        'ternary_operator_spaces'             => true,
        'concat_space'                        => ['spacing' => 'one'],
        'no_empty_statement'                  => true,
        'switch_case_semicolon_to_colon'      => true,
    ])
    ->setFinder($finder);
