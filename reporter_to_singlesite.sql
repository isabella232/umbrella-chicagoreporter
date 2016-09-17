-- WARNING: THIS SCRIPT IS DESRTUCTIVE. DO NOT RUN AGAINST ANY PRODUCTION DATABASES (OR ANY
-- OTHER DATABASE YOU CARE ABOUT PRESERVING).
--
-- This script is meant to prepare a blog's tables to be moved to a
-- standalone WP install. It requires on the blogs tables and the network
-- tables (wp_users and wp_usermeta) be present in the database.
--
-- It does one thing:
--
-- 1. Renames all of the blog tables to standard WordPress blog tables (e.g., wp_16_posts to wp_posts)
--    which is being prepped for export.
--
-- Set the @blogID variable and away you go!
SET @blogID = '44';

-- Rename all the wp_##_* tables to wp_ tables
-- Depending on the site, you may need to rename other tables (e.g., redirection tables, other
-- plugin tables, etc.)
SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_commentmeta TO wp_commentmeta;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_comments TO wp_comments;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_links TO wp_links;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_options TO wp_options;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_postmeta TO wp_postmeta;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_posts TO wp_posts;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_redirection_404 TO wp_redirection_404;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_redirection_groups TO wp_redirection_groups;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_redirection_items TO wp_redirection_items;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_redirection_logs TO wp_redirection_logs;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_term_relationships TO wp_term_relationships;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_term_taxonomy TO wp_term_taxonomy;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_termmeta TO wp_termmeta;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;

SET @renameTablesStatement = CONCAT('RENAME TABLE wp_', @blogID, '_terms TO wp_terms;');
PREPARE renameTablesStatement FROM @renameTablesStatement;
EXECUTE renameTablesStatement;
DEALLOCATE PREPARE renameTablesStatement;
