## Catalyst export instructions

This assumes:
- familiarity with INN's deploy tools
- a running VVV install of this repository
- access to INN's production databases
- Familiarity with WPEngine support

1. Set up the Reporter database
	1. Follow the instructions from https://github.com/INN/migration-scripts/blob/master/sql-utils/prepare_for_export.sql.md to export the Chicago Reporter database and convert it to a single-site install. Use the `reporter_to_singlesite.sql` script provided in this repository.
		- Reporter is 44
		- Catalyst is 57
	2. Install the Reporter database on your local vagrant machine by uploading the `migration.sql` dumped database:`fab vagrant.reload_db:migration.sql`
	3. Using Sequel Pro or another database editor, in the `wp_options` table change the option_values of the option_names `siteurl` and `home` to `http://chicagoreporter.vagrant.dev/`
	4. Following the same procedure, dump the database from catalystexport.wpengine.com
		0. This is a single-site install, but the Chicago Reporter `wp cr` migration commands expect it to be a multisite. To change the names of these tables, do the following:
		1. `fab vagrant.create_db:catalyst_temp`
		2. `fab vagrant.load_db:catalystexport.sql,catalyst_temp`
		3. Open Sequel Pro or another tool of your choice and rename the tables from `wp_` to `wp_57_`
		4. `fab vagrant.dump_db:catalyst_57.sql,datalyst_temp`
		5. `fab vagrant.destroy_db:catalyst_temp`
	5. Upload the `catalyst_57.sql` database to your vagrant
		1. `vagrant ssh`
		2. `cd /srv/www/chicago-reporter/htdocs/`
		3. `mysql -u root -proot chicagoreporter < catalyst_57.sql`
		4. `exit`
	6. Make a backup with `vagrant snapshot take default`
	4. Run the migration
		1. `vagrant ssh`
		2. `cd /srv/www/chicago-reporter/htdocs/`
		3. `wp cr perform_all_migrations `
	5. Prune the site's wp_users table using the `prune_wp_users.sql` script provided in this repository.

4. Export the database for chicagoreporte.wpengine.com
	1. Using Sequel Pro or another database editor, in the `wp_options` table change the option_values of the optino_names `siteurl` and `home` to `http://chicagoreporte.wpengine.com/`, and in the wp_options table, set the option_name 'upload_path' to option_value 'wp-content/uploads'
	2. `fab vagrant.dump_db:ready_for_import.sql`
	3. Use SFTP to push `ready_for_import.sql` to `chicagoreporte/_wpeprivate/`
	4. Ask WPE Support to load that database on the chicagoreporte install

5. Log in and reset permalinks


## Notes for future devs

Want to copy this procedure? Hhere are some considerations and pain points:

- With 44 as 44 and 57 as a singlesite, this written assuming 44 as singlesite and 57 as 57. If you're importing 57 from a review standalone instance, consider rewriting the CLI commands from `wp cr` to have those actions be performed on the standalone tables, and then importing 44 from the multisite instance into them.
- With 44 and 57, this takes ~80 minutes.

