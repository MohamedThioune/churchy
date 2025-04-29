<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\File;

class UploadFileToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $temp;
    public $name;
    public $path;  
    public $meaning;  
    public $user_id;  

    /**
     * Create a new job instance.
    */
    public function __construct($temp, $name, $path, $meaning, $user_id)
    {
        $this->temp = $temp;
        $this->name = $name;
        $this->path = $path;
        $this->meaning = $meaning;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
    */
    public function handle(): void
    {
        try {
            DB::transaction(function() {
                $contents = Storage::disk('local')->get($this->temp);
            
                $fileName = $this->name;
                
                Storage::disk('s3')->put($this->path . $fileName, $contents);
        
                // Delete the local file after uploading to S3
                Storage::disk('local')->delete($this->temp);

                //Delete former file if exists
                $file = File::where('meaning', $this->meaning)->where('user_id', $this->user_id)->whereNotNull('deleted_at')->first();

                if (!empty($file)):
                    Storage::disk('s3')->delete($this->path . $file->id);
                    // $file->delete();
                endif;
        
                //Remove status deleted to make it accessible
                File::where('id', $fileName)->update(['deleted_at' => null]);
            });
        } catch (\Exception $e) {
            Log::error('Error uploading file to S3: ' . $e->getMessage());
            return;
        }
        
    }

}
