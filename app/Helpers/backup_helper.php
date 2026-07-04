<?php

if (!function_exists('get_backup_config')) {
  /**
   * Retrieves backup configuration.
   * For now, just the backup directory.
   */
  function get_backup_config()
  {
    return [
      'backup_dir' => WRITEPATH . 'backups' . DIRECTORY_SEPARATOR,
    ];
  }
}

if (!function_exists('ensure_backup_dir_exists')) {
  /**
   * Ensures the backup directory exists.
   */
  function ensure_backup_dir_exists()
  {
    $config = get_backup_config();
    if (!is_dir($config['backup_dir'])) {
      mkdir($config['backup_dir'], 0775, true);
      log_message('info', 'Created backup directory: ' . $config['backup_dir']);
    }
  }
}

if (!function_exists('generate_backup_filename')) {
  /**
   * Generates a backup filename with a timestamp for MySQL.
   * @param string $dbName
   * @return string
   */
  function generate_backup_filename(string $dbName): string
  {
    $timestamp = date('Ymd_His');
    return "{$dbName}_backup_{$timestamp}.sql.gz";
  }
}

if (!function_exists('create_mysql_backup')) {
  /**
   * Creates a backup of a MySQL database using PHP and MySQLi (structure, data, views, triggers, routines, events).
   * @return array ['success' => bool, 'message' => string, 'filepath' => string|null]
   */
  function create_mysql_backup(): array
  {
    set_time_limit(3000);

    ensure_backup_dir_exists();
    $config = get_backup_config();

    $db = \Config\Database::connect();
    $name = $db->database;
    $db2 = \Config\Database::connect();
    $mysqli = $db2->connID;
    $mysqli->select_db($name);
    $mysqli->query("SET CHARACTER SET 'UTF8'");

    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\n";
    $content .= "SET time_zone = \"+00:00\";\r\n";
    $content .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n";
    $content .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n";
    $content .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n";
    $content .= "/*!40101 SET NAMES utf8 */;\r\n";
    $content .= "--\r\n-- Database: `" . $name . "`\r\n--\r\n";

    // 1. Backup Tables (Structure + Data)
    $queryTables = $mysqli->query('SHOW FULL TABLES WHERE Table_type = "BASE TABLE"');
    $tables = [];
    while ($row = $queryTables->fetch_row()) {
      $tables[] = $row[0];
    }
    // Exclude tables if needed (define $excludeTables as array in your config or here)
    $excludeTables = []; // Example: ['sessions']
    $tables = array_diff($tables, $excludeTables);

    foreach ($tables as $table) {
      // Structure
      $res = $mysqli->query('SHOW CREATE TABLE `' . $table . '`');
      $TableMLine = $res->fetch_row();
      $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
      $content .= "\n\n" . $TableMLine[1] . ";\n\n";

      // Data
      $result = $mysqli->query('SELECT * FROM `' . $table . '`');
      $fields_amount = $result->field_count;
      $rows_num = $result->num_rows;
      $st_counter = 0;
      while ($row = $result->fetch_row()) {
        if ($st_counter % 100 == 0) {
          $content .= "\nINSERT INTO `$table` VALUES";
        }
        $content .= "\n(";
        for ($j = 0; $j < $fields_amount; $j++) {
          $row[$j] = isset($row[$j]) ? $mysqli->real_escape_string($row[$j]) : 'NULL';
          $content .= ($row[$j] !== 'NULL') ? '"' . $row[$j] . '"' : 'NULL';
          if ($j < ($fields_amount - 1)) {
            $content .= ',';
          }
        }
        $content .= ")";
        $st_counter++;
        if (($st_counter % 100 == 0) || ($st_counter == $rows_num)) {
          $content .= ";";
        } else {
          $content .= ",";
        }
      }
      $content .= "\n\n";
    }

    // 2. Backup Views
    $queryViews = $mysqli->query('SHOW FULL TABLES WHERE Table_type = "VIEW"');
    while ($row = $queryViews->fetch_row()) {
      $view = $row[0];
      $res = $mysqli->query('SHOW CREATE VIEW `' . $view . '`');
      $ViewMLine = $res->fetch_assoc();
      $content .= "\n\n--\n-- View structure for view `$view`\n--\n";
      $content .= "DROP VIEW IF EXISTS `$view`;\n";
      $content .= $ViewMLine['Create View'] . ";\n";
    }

    // 3. Backup Triggers
    $triggers = $mysqli->query("SHOW TRIGGERS FROM `$name`");
    while ($trigger = $triggers->fetch_assoc()) {
      $triggerName = $trigger['Trigger'];
      $res = $mysqli->query("SHOW CREATE TRIGGER `$triggerName`");
      $row = $res->fetch_assoc();
      $content .= "\n\n--\n-- Trigger structure for trigger `$triggerName`\n--\n";
      $content .= "DROP TRIGGER IF EXISTS `$triggerName`;\n";
      $content .= $row['SQL Original Statement'] . ";\n";
    }

    // 4. Backup Procedures & Functions
    $routines = $mysqli->query("SELECT ROUTINE_TYPE, ROUTINE_NAME FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = '$name'");
    while ($routine = $routines->fetch_assoc()) {
      $routineType = $routine['ROUTINE_TYPE'];
      $routineName = $routine['ROUTINE_NAME'];
      $res = $mysqli->query("SHOW CREATE $routineType `$routineName`");
      $row = $res->fetch_assoc();
      $key = "Create $routineType";
      $content .= "\n\n--\n-- $routineType structure for $routineType `$routineName`\n--\n";
      $content .= "DROP $routineType IF EXISTS `$routineName`;\n";
      $content .= $row[$key] . ";\n";
    }

    // 5. Backup Events
    $events = $mysqli->query("SHOW EVENTS FROM `$name`");
    while ($event = $events->fetch_assoc()) {
      $eventName = $event['Name'];
      $res = $mysqli->query("SHOW CREATE EVENT `$eventName`");
      $row = $res->fetch_assoc();
      $content .= "\n\n--\n-- Event structure for event `$eventName`\n--\n";
      $content .= "DROP EVENT IF EXISTS `$eventName`;\n";
      $content .= $row['Create Event'] . ";\n";
    }

    $content .= "\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n";
    $content .= "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n";
    $content .= "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\r\n";

    $backup_name = $name . "_" . date("Y-m-d_H-i-s") . '.sql.gz';
    $backup_path = $config['backup_dir'] . $backup_name;

    // Save as gzipped file
    $gz = gzopen($backup_path, 'w9');
    gzwrite($gz, $content);
    gzclose($gz);

    if (file_exists($backup_path)) {
      return [
        'success' => true,
        'message' => 'Database backup successful. Backup stored as ' . $backup_name,
        'filepath' => $backup_path
      ];
    } else {
      return [
        'success' => false,
        'message' => 'Failed to create backup file.',
        'filepath' => null
      ];
    }
  }
}

if (!function_exists('format_file_size')) {
  /**
   * Formats a size in bytes to a human-readable string.
   * @param int $bytes
   * @return string
   */
  function format_file_size(int $bytes): string
  {
    if ($bytes == 0) return "0B";
    $sizeName = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    $i = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $sizeName[$i];
  }
}

if (!function_exists('list_backup_files')) {
  /**
   * Lists all backup files in the backup directory.
   * @return array
   */
  function list_backup_files(): array
  {
    ensure_backup_dir_exists();
    $config = get_backup_config();
    $backupDir = $config['backup_dir'];
    $files = @scandir($backupDir, SCANDIR_SORT_DESCENDING); // Newest first by name (timestamp)
    $backups = [];

    if ($files) {
      foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $filePath = $backupDir . $file;
        if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'gz') { // Basic check
          $backups[] = [
            'name' => $file,
            'time' => date("Y-m-d H:i:s", filemtime($filePath)),
            'size_bytes' => filesize($filePath),
            'size_readable' => format_file_size(filesize($filePath)),
          ];
        }
      }
    }
    // To sort by actual modification time (more robust if filenames don't guarantee order)
    // usort($backups, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));
    return $backups;
  }
}

if (!function_exists('get_last_backup_info')) {
  /**
   * Gets the details of the most recent backup.
   * @return array|null
   */
  function get_last_backup_info(): ?array
  {
    $backups = list_backup_files();
    return $backups[0] ?? null;
  }
}

if (!function_exists('delete_backup_file')) {
  function delete_backup_file($filename)
  {
    $backupDir = WRITEPATH . 'backups/';
    $filePath = $backupDir . basename($filename);
    return is_file($filePath) ? unlink($filePath) : false;
  }
}