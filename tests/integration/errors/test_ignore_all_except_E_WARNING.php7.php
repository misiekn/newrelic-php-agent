<?php
/*
 * Copyright 2020 New Relic Corporation. All rights reserved.
 * SPDX-License-Identifier: Apache-2.0
 */

/*DESCRIPTION
The agent should capture and report errors NOT configured via the
newrelic.error_collector.ignore_errors setting.
*/

/*SKIPIF
<?php
if (version_compare(PHP_VERSION, "7.0", "<")) {
  die("skip: PHP 5 not supported\n");
}
if (version_compare(PHP_VERSION, "7.4", ">")) {
  die("skip: PHP > 7.4.0 not supported\n");
}
*/

/*INI
error_reporting = E_ALL | E_STRICT
newrelic.error_collector.ignore_errors = E_ALL & ~E_WARNING
display_errors=1
log_errors=0
*/

/*EXPECT_REGEX
^\s*(PHP )?Warning:\s*Division by zero in .*? on line [0-9]+\s*$
*/

/*EXPECT_TRACED_ERRORS
[
  "?? agent run id",
  [
    [
      "?? when",
      "OtherTransaction/php__FILE__",
      "Division by zero",
      "E_WARNING",
      {
        "stack_trace": [
          " in run_test called at __FILE__ (??)"
        ],
        "agentAttributes": "??",
        "intrinsics": "??"
      }
    ]
  ]
]
*/

/*EXPECT_ERROR_EVENTS
[
  "?? agent run id",
  {
    "reservoir_size": "??",
    "events_seen": 1
  },
  [
    [
      {
        "type": "TransactionError",
        "timestamp": "??",
        "error.class": "E_WARNING",
        "error.message": "Division by zero",
        "transactionName": "OtherTransaction\/php__FILE__",
        "duration": "??",
        "nr.transactionGuid": "??",
        "guid": "??",
        "sampled": true,
        "priority": "??",
        "traceId": "??",
        "spanId": "??"
      },
      {},
      {}
    ]
  ]
]
*/

function run_test() {
  $x = 8 / 0;
}

run_test();
