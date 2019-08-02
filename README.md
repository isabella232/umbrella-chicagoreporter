# Chicago Reporter

## Notes on setup and configuration

This repository is designed to be set up in accordance with INN's umbrella repo process, as described in https://github.com/INN/docs/blob/master/projects/largo/umbrella-setup.md

Prompt | Text to enter
------------ | -------------
Name of new site directory: | chicagoreporter
Domain to use (leave blank for largo-umbrella.dev): | chicagoreporter.test
Install as multisite? (y/N): | n
Enable WP_DEBUG and WP_DEBUG_LOG (y/N): | y

After reviewing the options and creating the new install, partake in the following steps:

1. `git clone --recursive git@github.com:INN/umbrella-chicagoreporter.git`
2. `git submodule init --recursive`
3. `cd wp-content/themes/chicagoreporter/`
4. `npm i`

## Catalyst export instructions

See [migration-notes.md](./migration-notes.md).
