<?php
/*
 * Copyright 2020 New Relic Corporation. All rights reserved.
 * SPDX-License-Identifier: Apache-2.0
 */

/*DESCRIPTION
On PHP 5.3, the agent should only emit a Real User Monitoring (RUM)
footer if the output buffer is
cleaned after the header has been injected.
*/

/*SKIPIF
<?php
if (version_compare(PHP_VERSION, '5.4', '>=')) {
  die("skip: requires PHP < 5.4\n");
}
*/

/*
 * We need output_buffering to be a non-zero value, but the exact value doesn't
 * matter, as nr_php_install_output_buffer_handler() hardcodes 40960 as the
 * internal buffer size. 4096 has been chosen simply because it matches most
 * default distro configurations.
 */

/*INI
output_buffering = 4096
*/

/*ENVIRONMENT
REQUEST_METHOD=GET
*/

/* 
 * Match a partial HTML document that consists of an opening body
 * tag, an opening script tag, script content starting with window.NREUM, then
 * closing script, body and html tags.
 */

/*EXPECT_REGEX
((?s)^\s*<body>\s*<script(.*?)>\(?window\.NREUM(.*?)</script></body>\s*</html>\s*$)
*/

?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <?php ob_clean() ?>
  <body>
  </body>
</html>
