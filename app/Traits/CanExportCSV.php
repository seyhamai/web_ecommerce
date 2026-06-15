<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait CanExportCSV
{
    /**
     * Reusable CSV Generator
     *
     * @param string $fileName Custom name for the file (e.g., 'users_export')
     * @param array $columns The header rows for the CSV (e.g., ['ID', 'Name'])
     * @param iterable $data The collection or cursor of records to loop through
     * @param callable $rowCallback A function defining how to map each record to a row
     * @return StreamedResponse
     */
    public function streamCSV(string $fileName, array $columns, iterable $data, callable $rowCallback): StreamedResponse
    {
        $fullFileName = $fileName . '_' . date('Y-m-d_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fullFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        // Inside your CanExportCSV.php trait, update the callback function:

        $callback = function () use ($columns, $data, $rowCallback) {
            $file = fopen('php://output', 'w');

            // ADD THIS LINE: It forces Excel to recognize the encoding
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $columns);

            foreach ($data as $record) {
                fputcsv($file, $rowCallback($record));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
