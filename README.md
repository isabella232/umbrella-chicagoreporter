## Notes on setup and configuration

This repository is designed to be set up in accordance with the VVV install instructions in INN/docs, that were introduced with https://github.com/INN/docs/pull/148


```
vv create
```

Prompt | Text to enter 
------------ | -------------
Name of new site directory: | chicagoreporter
Blueprint to use (leave blank for none or use largo): | largo
Domain to use (leave blank for largo-umbrella.dev): | chicagoreporter.vagrant.dev
WordPress version to install (leave blank for latest version or trunk for trunk/nightly version): | *hit [Enter]*
Install as multisite? (y/N): | n
Install as subdomain or subdirectory? : | subdomain
Git repo to clone as wp-content (leave blank to skip): | *hit [Enter]*
Local SQL file to import for database (leave blank to skip): | *This directory must be an absolute path, so the easiest thing to do is to drag your mysql file into your terminal window here and the absolute filepath with fill itself in.*
Remove default themes and plugins? (y/N): | N 
Add sample content to site (y/N): | N 
Enable WP_DEBUG and WP_DEBUG_LOG (y/N): | y

After reviewing the options and creating the new install, partake in the following steps:

1. `cd` to the directory `chicagoreporter/`
2. `git clone --recursive git@github.com:INN/umbrella-chicagoreporter.git`
3. Copy the contents of the new directory `umbrella-chicagoreporter/` into `htdocs/`, including all hidden files whose names start with `.` periods.

## Catalyst export instructions

See [migration-notes.md](./migration-notes.md).
