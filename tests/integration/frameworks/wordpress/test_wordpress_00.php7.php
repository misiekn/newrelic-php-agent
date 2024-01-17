<?php
/*
 * Copyright 2020 New Relic Corporation. All rights reserved.
 * SPDX-License-Identifier: Apache-2.0
 */

/*DESCRIPTION
Test WordPress default instrumentation. The agent should:
 - detect WordPress framework
 - name the web transaction as an 'Action' named after the template used to generate the page
 - detect custom plugins and themes
 - generate hooks metrics but only when hook executes functions from custom
   plugin or theme; the agent must not generate hooks metrics when hook executes
   functions from wordpress core
No errors should be generated.
*/

/*SKIPIF
*/

/*ENVIRONMENT
REQUEST_METHOD=GET
*/

/*EXPECT_METRICS_EXIST
Supportability/framework/WordPress/detected
WebTransaction/Action/page-template
Supportability/InstrumentedFunction/apply_filters
Supportability/InstrumentedFunction/do_action
Framework/WordPress/Hook/wp_loaded
Framework/WordPress/Hook/template_include
Framework/WordPress/Plugin/mock-plugin1
Framework/WordPress/Plugin/mock-plugin2
Framework/WordPress/Plugin/mock-theme1
Framework/WordPress/Plugin/mock-theme2
*/

/*EXPECT_METRICS_DONT_EXIST
Framework/WordPress/Hook/wp_init
Framework/WordPress/Hook/the_content
*/

/*EXPECT_ERROR_EVENTS null */

/* WordPress mock app */
require_once __DIR__.'/mock-wordpress-app.php';
