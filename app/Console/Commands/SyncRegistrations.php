<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-registrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all existing registrations to Google Sheets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting sync to Google Sheets...');

        $serviceEnabled = config('google.service.enable');
        $jsonFile = config('google.service.file');

        $this->info("Debug Config:");
        $this->info("Service Enabled: " . ($serviceEnabled ? 'YES' : 'NO'));
        $this->info("JSON File Path: " . $jsonFile);
        $this->info("File Exists: " . (file_exists($jsonFile) ? 'YES' : 'NO'));

        $registrations = \App\Models\Registration::all();
        $spreadsheetId = config('google.spreadsheet_id');

        if (!$spreadsheetId) {
            $this->error('Google Spreadsheet ID is not set in .env');
            return;
        }

        $data = [];
        foreach ($registrations as $reg) {
            $data[] = [
                $reg->created_at->format('Y-m-d H:i:s'),
                $reg->name,
                $reg->email,
                "'" . $reg->phone,
                $reg->institution,
                $reg->address,
                $reg->payment_method,
                $reg->payment_url, // URL Bukti Bayar
                $reg->status ?? 'pending'
            ];
        }

        if (empty($data)) {
            $this->info('No registrations found to sync.');
            return;
        }

        try {
            // Append all data in one go (or you can chunk it if too many)
            \Revolution\Google\Sheets\Facades\Sheets::spreadsheet($spreadsheetId)
                ->sheet('Sheet1')
                ->append($data);

            $this->info('Successfully synced ' . count($data) . ' registrations to Google Sheets.');

        } catch (\Exception $e) {
            $this->error('Failed to sync: ' . $e->getMessage());
        }
    }
}
