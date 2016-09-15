## Catalyst export instructions

This assumes:
- familiarity with INN's deploy tools
- a running VVV install of this repository
- access to INN's production databases
- Familiarity with WPEngine support

1. Set up the Reporter database
	1. Follow the instructions from https://github.com/INN/migration-scripts/blob/master/sql-utils/prepare_for_export.sql.md to export the Chicago Reporter database and convert it to a single-site install.
	2. Install the Reporter database on your local vagrant machine by uploading the `migration.sql` dumped database:`fab vagrant.reload_db:migration.sql`
	3. Using Sequel Pro or another database editor, in the `wp_options` table change the option_values of the option_names `siteurl` and `home` to `http://chicagoreporter.vagrant.dev/`

3. Run the migration
	1. tktk wp-cli command

4. Export the database for chicagoreporte.wpengine.com
	1. Using Sequel Pro or another database editor, in the `wp_options` table change the option_values of the optn_names `siteurl` and `home` to `http://chicagoreporte.wpengine.com/`
	2. `fab vagrant.dump_db:ready_for_import.sql`
	3. Use SFTP to push `ready_for_import.sql` to `chicagoreporte/_wpeprivate/`
	4. Ask WPE Support to load that database on the chicagoreporte install
