<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Jobs\CsvUpload;
use App\Models\LogImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class LogImportsController extends Controller
{
    /**
     * Show the page for listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Display a listing of the resource as json format.
     */
    public function data() 
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * By importing csv files and inserting all the data into the database
     * 
     * @param CsvUploadRequest $request
     */
    public function store(CsvUploadRequest $request)
    {
        DB::beginTransaction();
        try {
            $file   = $request->file('file_path');
            $data   = file($file);
            $chunks = array_chunk($data, 1000);

            $filteredHeader = [];
            $batch  = Bus::batch([])->dispatch();

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);

                if ($key === 0) {
                    $filteredHeader = $this->getFilteredHeader($data[0]);
                    unset($data[0]);
                }

                $batch->add(new CsvUpload($data, $filteredHeader));
            }

            LogImport::create([
                'job_batch_id' => $batch->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => upload_file('uploads', $file, 'csv')
            ]);

            DB::commit();
            return back()->with('success_msg', 'The CSV file import was successful, please wait until the process is complete.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_msg', $e->getMessage());
        }
    }

    /**
     * Get filtered header by columns in the database
     * 
     * @param array $data
     * 
     * @return array
     */
    public function getFilteredHeader($header) 
    {
        $fields = [
            'UNIQUE_KEY',
            'PRODUCT_TITLE',
            'PRODUCT_DESCRIPTION',
            'STYLE#',
            'SANMAR_MAINFRAME_COLOR',
            'SIZE',
            'COLOR_NAME',
            'PIECE_PRICE'
        ];

        $filteredHeader = collect($header)
            ->filter(function ($item) use ($fields) {
                // remove u+feff / zero width no-break space character from the string
                $field = str_replace("\u{FEFF}", '', $item);

                return in_array($field, $fields);
            })
            ->map(function ($item) {
                // remove # character on (style field)
                // remove u+feff / zero width no-break space character from the string
                $field = str_replace([
                    '#',
                    "\u{FEFF}"
                ], '', $item);
                // fields in database and excel are differents 
                // so it needs to convert to lower
                $field = strtolower($field);

                return $field;
            })
            ->flip()
            ->toArray();

        return $filteredHeader;
    }

}
