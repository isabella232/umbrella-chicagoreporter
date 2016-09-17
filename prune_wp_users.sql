-- WARNING: THIS SCRIPT IS DESRTUCTIVE. DO NOT RUN AGAINST ANY PRODUCTION DATABASES (OR ANY
-- OTHER DATABASE YOU CARE ABOUT PRESERVING).
--
-- This script is meant to prepare a blog's tables to be moved to a
-- standalone WP install. It requires on the blogs tables and the network
-- tables (wp_users and wp_usermeta) be present in the database.
--
-- It does one thing:
--
-- 1. Deletes all user data from wp_users and wp_usermeta that are not added to the multisite blog
--
-- Set the @reporterID variable and away you go!
SET @reporterID = '44';
SET @catalystID = '57';

-- Change the wp_##_user_roles key in wp_options
update wp_options set option_name = 'wp_user_roles' where option_name like 'wp_%_user_roles';

-- Drop users that don't belong to this blog
drop temporary table if exists blog_user_ids;
SET @blogUserIDTable = CONCAT(
  'create temporary table if not exists blog_user_ids select user_id from wp_usermeta where meta_key = "wp_', @reporterID, '_capabilities"');
PREPARE blogUserIDTable FROM @blogUserIDTable;
EXECUTE blogUserIDTable;
DEALLOCATE PREPARE blogUserIDTable;

-- now add the other users
SET @blogUserIDTable = CONCAT(
  'INSERT INTO blog_user_ids SELECT user_id FROM wp_usermeta WHERE meta_key = "wp_', @catalystID, '_capabilities"');
PREPARE blogUserIDTable FROM @blogUserIDTable;
EXECUTE blogUserIDTable;
DEALLOCATE PREPARE blogUserIDTable;

delete wp_users from wp_users
  left outer join blog_user_ids
  on wp_users.ID = blog_user_ids.user_id
  where blog_user_ids.user_id is null;

delete wp_usermeta from wp_usermeta
  left outer join blog_user_ids
  on wp_usermeta.user_id = blog_user_ids.user_id
  where blog_user_ids.user_id is null;
