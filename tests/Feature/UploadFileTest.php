<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Jobs\UploadFileToS3;
use Illuminate\Support\Facades\Log;


class UploadFileTest extends TestCase
{

    public function test_job_uploads_file_to_s3()
    {
        $this->withoutExceptionHandling(); // 👈 VERY useful in debugging

        Storage::fake('s3');
        Storage::fake('local');

        // Create temporary file in local storage
        $temp = 'temp/licence.txt';
        $path = 'users/documents/';
        $name = 'licence';
        $type = 'txt';
        $meaning = 'License';
        $description = 'This is a license file !';
        $user_id = 1;

        Storage::disk('local')->put($temp, 'Hello this is license !');

        $job = new UploadFileToS3($temp, $name, $path, $meaning, $user_id);
        $job->handle();

        // Storage::disk('s3')->assertExists( $path .''. $name . '.' . $type);
        Storage::disk('local')->assertMissing($temp);
    }

    public function test_upload_endpoint_dispatches_job_with_fake_file()
    {
        $this->withoutExceptionHandling(); // 👈 VERY useful in debugging

        Queue::fake(); // Intercept dispatched jobs
    
        $file = UploadedFile::fake()->create('license.pdf', 200); // 200 Ko
    
        $response = $this->post('/api/upload', [
            'file' => $file,
            'path' => 'users/documents/',
            'meaning' => 'License',
            'user_id' => 1,
        ]);
    
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'File received, being processed...',
        ]);
    
        Queue::assertPushed(UploadFileToS3::class, function ($job) {
            return str_contains($job->temp, 'temp/');
        });
    }
    
    public function test_upload_endpoint_with_invalid_file()
    {
        $this->withoutExceptionHandling(); // 👈 VERY useful in debugging

        $file = UploadedFile::fake()->create('malware.exe', 100); // 100 Ko

        $response = $this->post('/api/upload', [
            'file' => $file,
            'path' => 'users/documents/',
            'meaning' => 'License',
            'user_id' => 1,
        ]);
    
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('file');

        $this->assertStringContainsString(
            'must not be of type',
            $response->json('errors.file.0') ?? ''
        );
    }

    public function test_upload_endpoint_with_large_file()
    {
        $this->withoutExceptionHandling(); // 👈 VERY useful in debugging

        $file = UploadedFile::fake()->create('malware.exe', 6000); // 6000 Ko

        $response = $this->post('/api/upload', [
            'file' => $file,
            'meaning' => 'license',
        ]);
    
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('file');

        $this->assertStringContainsString(
            'must not be greater than',
            $response->json('errors.file.0') ?? ''
        );
    }
}
