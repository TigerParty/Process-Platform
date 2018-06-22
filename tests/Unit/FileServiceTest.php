<?php

namespace Tests\Unit;

use Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Attachment;
use App\Services\FileService;

class FileServiceTest extends TestCase
{
    private $fileService;

    private $testFile;

    public function __construct()
    {
        parent::__construct();
        $this->fileService = new FileService;
        $this->testFile = UploadedFile::fake()->image('test.jpg');
    }

    public function testUpload()
    {
        $attachModel = $this->fileService->upload($this->testFile);

        $this->assertInstanceOf(Attachment::class, $attachModel);
        Storage::assertExists($attachModel->path);
    }

    public function testDownload()
    {
        $attachModel = $this->fileService->upload($this->testFile);
        $response = $this->fileService->download($attachModel->id);

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($attachModel->name, $response->headers->get('Content-Disposition'));
        $this->assertEquals($attachModel->type, $response->headers->get('Content-Type'));
    }
}
