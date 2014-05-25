<?php
/**
 * Schema Migration
 * 
 * @package    Com_Connect
 * @subpackage Schema_Migration
 */
class ComConnectSchemaMigration2 extends ComMigratorMigrationVersion
{
    /**
     * Called when migrating up
     */
    public function up()
    {
        dbexec('ALTER TABLE `#__connect_sessions` ADD COLUMN `meta` TEXT');
    }
    
    /**
     * Called when rolling back a migration
     */
    public function down()
    {
        //add your migration here
    }
}
