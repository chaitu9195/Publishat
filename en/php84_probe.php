<?php
header("Content-Type: text/plain");
echo "PHP ".PHP_VERSION."\n";
foreach (["curl","intl","mongodb","mysqli","zip","gd","mbstring"] as $e) echo "$e: ".(extension_loaded($e)?"yes":"no")."\n";
