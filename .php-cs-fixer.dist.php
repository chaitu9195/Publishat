<?php
/**
 * PHP CS Fixer configuration.
 *
 * Scope: our own application logic only (controllers, models, libraries,
 * helpers, hooks). Stock CodeIgniter config files, HTML-heavy views, and
 * third-party/vendor code are intentionally excluded.
 *
 * Risky rules are disabled: this pass only reformats — it never changes
 * runtime behavior.
 */

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/en/application')
    ->name('*.php')
    ->notPath('third_party')
    ->notPath('config')
    ->notPath('views')
    ->notPath('controllers/trash');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setRules([
        '@PSR12'                            => true,
        'array_syntax'                      => ['syntax' => 'short'],
        'single_quote'                      => true,
        'no_unused_imports'                 => true,
        'ordered_imports'                   => true,
        'object_operator_without_whitespace' => true,
        'binary_operator_spaces'            => ['default' => 'single_space'],
        'no_trailing_whitespace'            => true,
        'no_whitespace_in_blank_line'       => true,
        'no_extra_blank_lines'              => true,
        'trailing_comma_in_multiline'       => true,
        'no_empty_statement'                => true,
        'blank_line_after_opening_tag'      => true,
        'concat_space'                      => ['spacing' => 'one'],
    ])
    ->setFinder($finder);
