# Schedule Jobs & Event Driven Workflows

This repository demonstrates an example implementation of scheduled jobs and event-driven workflows in a WordPress application.

## How to run 

1. `docker compose up`
2. Open [http://localhost:8080](http://localhost:8080) and complete the WordPress setup.
3. Go to **Plugin**
4. Activate the **Project Automation** plugin

## What's implemented

The basic requirement for this proof-of-concept is the same that we have for a
project. Run a scheduled job every week OR run the same method when a user is
registered

## How to validate implementation

There's two ways to validate this implementation:

**A. Manual trigger** 

1. Visit `http://localhost:8080/wp-admin/?run_my_job=1`
2. The console should print: `[My Plugin] Running job, context: manual_trigger at 2025-10-08 13:02:19`

**B. User registration**
1. Create a new user
2. The console should print: `[My Plugin] Running job, context: new_user_2 at 2025-10-08 13:03:17, referer: http://localhost:8080/wp-admin/user-new.php`

## :warning: Important consideration :warning: 

Apparently, [WP-Cron](https://developer.wordpress.org/plugins/cron/) is not very
reliable. It also adds extra workload to every page load by checking if there
are any scheduled jobs to run (see the warning on the WP-Cron documentation
page).

The common solution on Unix systems is to set up a system cron job via `crontab`
to periodically call `wp-cron.php`. For example:

``` shell
$ crontab -e 

*/15 * * * * curl -s https://localhost:8080/wp-cron.php > /dev/null 2>&1
```


## Possible improvements

Since this is just a simple proof of concept, the code here is far from
production-ready. There’s minimal error logging and limited observability for
the scheduled job specifically.

Also, I’m a beginner with PHP and WordPress, so if there are alternative
approaches that reduce the upfront development cost or ongoing maintenance
burden, please open an issue describing your approach or reach out directly.
