<?php

return [
  /**
   * Remove the Base Sqlite file. The basefile is cloned to the active Sqlite file on
   * `RefreshDatabase` trait instead of running migrations and seeders.
   */

  'delete_basefile' => env('PHP_UNITTEST_SQLITE_DELETE_BASEFILE', true),

];
