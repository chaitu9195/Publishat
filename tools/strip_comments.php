<?php
/**
 * Token-based comment remover.
 *
 * Strips T_COMMENT and T_DOC_COMMENT tokens while preserving line structure,
 * PHP attributes (#[...] are T_ATTRIBUTE, not comments), and inline HTML
 * (T_INLINE_HTML is left untouched, so template markup and HTML comments stay).
 *
 * Usage: php strip_comments.php <file> [<file> ...]
 */

$files = array_slice($argv, 1);
$total = 0;

foreach ($files as $file) {
    $src = file_get_contents($file);
    if ($src === false) {
        fwrite(STDERR, "skip (unreadable): $file\n");
        continue;
    }

    $out = '';
    foreach (token_get_all($src) as $tok) {
        if (is_array($tok)) {
            if ($tok[0] === T_COMMENT || $tok[0] === T_DOC_COMMENT) {
                // Single-line // and # comments include their trailing newline;
                // keep it so we don't merge the next line onto this one.
                if (substr($tok[1], -1) === "\n") {
                    $out .= "\n";
                }
                $total++;
                continue;
            }
            $out .= $tok[1];
        } else {
            $out .= $tok;
        }
    }

    file_put_contents($file, $out);
}

fwrite(STDERR, "Removed {$total} comment token(s) from " . count($files) . " file(s)\n");
