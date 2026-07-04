<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Backup extends Controller
{
  public function __construct()
  {
    helper(['url', 'form', 'backup']); // Load our custom backup helper
    ensure_backup_dir_exists(); // Ensure backup directory is ready
  }

  public function index()
  {
    $data = [
      'pageTitle' => 'Database Backup',
      'backups' => list_backup_files(),
      'last_backup' => get_last_backup_info(),
      'db_type' => 'MySQL', // Hardcoded for this version
    ];

    return view('admin/dashboard/backup', $data);
  }

  public function create()
  {
    if (!$this->request->is('post')) {
      return redirect()->to('/backup')->with('error', 'Invalid request method.');
    }

    $result = create_mysql_backup();

    if ($result['success']) {
      session()->setFlashdata('message', $result['message']);
      session()->setFlashdata('status', 'success');
    } else {
      session()->setFlashdata('message', 'Backup creation failed: ' . $result['message']);
      session()->setFlashdata('status', 'error');
    }

    return redirect()->to('/backup');
  }

  public function download(string $filename)
  {
    if (empty($filename)) {
      session()->setFlashdata('message', 'No filename provided for download.');
      session()->setFlashdata('status', 'error');
      return redirect()->to('/backup');
    }

    // Security: Basic check to prevent path traversal.
    // Ensure filename only contains safe characters and does not try to navigate directories.
    if (strpos($filename, '..') !== false || strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
      session()->setFlashdata('message', 'Invalid filename.');
      session()->setFlashdata('status', 'error');
      return redirect()->to('/backup');
    }

    $config = get_backup_config();
    $filePath = $config['backup_dir'] . $filename;

    if (file_exists($filePath) && is_file($filePath)) {
      return $this->response->download($filePath, null)->setFileName($filename);
    } else {
      log_message('error', "Backup file not found for download: {$filePath}");
      session()->setFlashdata('message', "File '{$filename}' not found in backup directory.");
      session()->setFlashdata('status', 'error');
      return redirect()->to('/backup');
    }
  }

  public function delete(string $filename)
  {
    helper('backup_helper'); // If you have a helper for backup logic

    $backupDir = WRITEPATH . 'backups/';
    $filePath = $backupDir . basename($filename);

    if (is_file($filePath)) {
      if (unlink($filePath)) {
        return redirect()->back()->with('status', 'success')->with('message', 'Backup deleted.');
      } else {
        return redirect()->back()->with('status', 'error')->with('message', 'Could not delete backup.');
      }
    } else {
      return redirect()->back()->with('status', 'error')->with('message', 'Backup file not found.');
    }
  }
}
