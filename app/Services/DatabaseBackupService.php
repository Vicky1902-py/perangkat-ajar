<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDO;

class DatabaseBackupService
{
    protected string $backupDir;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');
        if (!File::exists($this->backupDir)) {
            File::makeDirectory($this->backupDir, 0755, true);
        }
    }

    /**
     * Membuat file backup database murni menggunakan PHP PDO (Kompatibel 100% dengan cPanel Shared Hosting).
     */
    public function createBackup(): array
    {
        $timestamp = date('Y-m-d_H-i-s');
        $dbName = config('database.connections.mysql.database', 'perangkat_ajar');
        $filename = "backup_{$dbName}_{$timestamp}.sql";
        $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $filename;

        $handle = fopen($filePath, 'w+');
        if (!$handle) {
            throw new \RuntimeException("Gagal membuat file backup di direktori: {$filePath}");
        }

        // Tulis Header SQL
        fwrite($handle, "-- ==========================================================\n");
        fwrite($handle, "-- BACKUP DATABASE: {$dbName}\n");
        fwrite($handle, "-- Tanggal Pembuatan: " . date('d F Y, H:i:s') . "\n");
        fwrite($handle, "-- Sistem: Perangkat Ajar SMK Kurikulum Merdeka (Deep Learning 2026)\n");
        fwrite($handle, "-- Desain & Arsitektur oleh: Vicky Koroh\n");
        fwrite($handle, "-- ==========================================================\n\n");
        fwrite($handle, "SET NAMES utf8mb4;\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 0;\n");
        fwrite($handle, "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n\n");

        $pdo = DB::connection()->getPdo();
        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // Abaikan migrations atau cache jika perlu, namun mencadangkan seluruh tabel memastikan 100% pemulihan utuh
            fwrite($handle, "\n-- ----------------------------------------------------------\n");
            fwrite($handle, "-- Struktur Tabel `{$table}`\n");
            fwrite($handle, "-- ----------------------------------------------------------\n");
            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");

            // Ambil CREATE TABLE
            $createTableStmt = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_NUM);
            fwrite($handle, $createTableStmt[1] . ";\n\n");

            // Ambil Data Baris secara streaming (chunking)
            fwrite($handle, "-- Data untuk Tabel `{$table}`\n");

            $countStmt = $pdo->query("SELECT COUNT(*) FROM `{$table}`");
            $totalRows = (int) $countStmt->fetchColumn();

            if ($totalRows > 0) {
                $batchSize = 250;
                $offset = 0;

                while ($offset < $totalRows) {
                    $rowsStmt = $pdo->query("SELECT * FROM `{$table}` LIMIT {$batchSize} OFFSET {$offset}");
                    $rows = $rowsStmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($rows)) {
                        $columnNames = array_map(fn($col) => "`{$col}`", array_keys($rows[0]));
                        $colsSql = implode(', ', $columnNames);

                        fwrite($handle, "INSERT INTO `{$table}` ({$colsSql}) VALUES\n");

                        $valueRows = [];
                        foreach ($rows as $row) {
                            $escapedValues = array_map(function ($val) use ($pdo) {
                                if ($val === null) {
                                    return 'NULL';
                                }
                                return $pdo->quote($val);
                            }, array_values($row));

                            $valueRows[] = '(' . implode(', ', $escapedValues) . ')';
                        }

                        fwrite($handle, implode(",\n", $valueRows) . ";\n");
                    }

                    $offset += $batchSize;
                }
            }

            fwrite($handle, "\n");
        }

        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 1;\n");
        fwrite($handle, "-- Selesai pada: " . date('Y-m-d H:i:s') . "\n");

        fclose($handle);

        $fileSize = filesize($filePath);

        return [
            'status' => 'success',
            'filename' => $filename,
            'path' => $filePath,
            'size' => $this->formatBytes($fileSize),
            'raw_size' => $fileSize,
            'created_at' => date('d/m/Y H:i:s'),
        ];
    }

    /**
     * Dapatkan daftar seluruh file backup yang tersimpan di server.
     */
    public function listBackups(): array
    {
        if (!File::exists($this->backupDir)) {
            return [];
        }

        $files = File::files($this->backupDir);
        $backups = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'sql') {
                $backups[] = [
                    'filename' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $this->formatBytes($file->getSize()),
                    'raw_size' => $file->getSize(),
                    'created_at' => date('d/m/Y H:i:s', $file->getMTime()),
                    'timestamp' => $file->getMTime(),
                ];
            }
        }

        // Urutkan dari yang paling baru
        usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return $backups;
    }

    /**
     * Path absolut untuk file backup tertentu.
     */
    public function getBackupPath(string $filename): ?string
    {
        // Bersihkan nama file dari directory traversal
        $safeName = basename($filename);
        $fullPath = $this->backupDir . DIRECTORY_SEPARATOR . $safeName;

        if (File::exists($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) === 'sql') {
            return $fullPath;
        }

        return null;
    }

    /**
     * Hapus file backup tertentu.
     */
    public function deleteBackup(string $filename): bool
    {
        $path = $this->getBackupPath($filename);
        if ($path && File::exists($path)) {
            return File::delete($path);
        }

        return false;
    }

    /**
     * Format byte ke ukuran yang mudah dibaca (KB, MB).
     */
    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
