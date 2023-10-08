<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CsvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private array $data,
        private array $filteredHeader
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();
        try {
            foreach ($this->data as $row) {
                $attributes = [];
                
                // select row field by filetered header
                foreach ($this->filteredHeader as $field => $fieldIndex) {
                    $attributes[$field] = utf8_cleaner($row[$fieldIndex]);
                }

                // handling multiple times upload it will insert or edit
                Product::query()
                    ->updateOrCreate([
                        'unique_key' => $attributes['unique_key']
                    ], $attributes);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage(), $e->getTrace());
        }
    }
}
