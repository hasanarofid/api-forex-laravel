<?php
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Ratio;

class FetchAndSaveRatios extends Command
{
    protected $signature = 'fetch:ratios';

    protected $description = 'Fetch and save ratios from API';

    public function handle()
    {
        $response = Http::get('https://c.fxssi.com/api/current-ratios');

        if ($response->successful()) {
            $data = $response->json();
            
            foreach ($data as $item) {
                Ratio::updateOrCreate(
                    ['pair' => $item['pair']],
                    ['long' => $item['long'], 'short' => $item['short']]
                );
            }

            $this->info('Ratios fetched and saved successfully!');
        } else {
            $this->error('Failed to fetch ratios from API');
        }
    }
}
