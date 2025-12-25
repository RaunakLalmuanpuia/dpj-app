<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\UserGoogleDrive;
use App\Services\Google\GoogleClientFactory;
use App\Services\Google\GoogleDriveService;
use App\Services\UserDriveSetupService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use PHPUnit\Framework\Attributes\Test;

class UserDriveSetupServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $factoryMock;
    protected $userDriveMock;
    protected $adminDriveMock;
    protected $setupService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factoryMock = Mockery::mock(GoogleClientFactory::class);
        $this->userDriveMock = Mockery::mock(GoogleDriveService::class);
        $this->adminDriveMock = Mockery::mock(GoogleDriveService::class);

        $this->setupService = new UserDriveSetupService($this->factoryMock);
    }

    #[Test]
    public function it_returns_existing_folder_id_if_valid()
    {
        $user = User::factory()->create();
        $folderId = 'existing-123';

        UserGoogleDrive::create([
            'user_id' => $user->id,
            'plan_type' => 'essential',
            'folder_id' => $folderId,
            'sheet_ids' => json_encode([])
        ]);

        $this->factoryMock->shouldReceive('createUserDriveService')
            ->with($user)
            ->andReturn($this->userDriveMock);

        $this->userDriveMock->shouldReceive('isFolderValid')
            ->with($folderId)
            ->andReturn(true);

        $result = $this->setupService->getOrCreateUserFolder($user, 'essential');

        $this->assertEquals($folderId, $result);
    }

    #[Test]
    public function it_creates_new_folder_and_copies_templates_for_new_user()
    {
        $user = User::factory()->create(['name' => 'Jane Doe', 'email' => 'jane@example.com']);
        $newFolderId = 'new-folder-789';

        // 1. Factory returns our mocked services
        $this->factoryMock->shouldReceive('createUserDriveService')->andReturn($this->userDriveMock);
        $this->factoryMock->shouldReceive('createAdminDriveService')->andReturn($this->adminDriveMock);

        // 2. Expectations for User Drive (Folder creation & copying)
        $this->userDriveMock->shouldReceive('createFolder')
            ->with("DPJ (Essential) - Jane Doe")
            ->once()
            ->andReturn($newFolderId);

        $this->userDriveMock->shouldReceive('copyFile')
            ->times(2) // Essential plan has 2 templates
            ->andReturn('new-sheet-id');

        // 3. Expectations for Admin Drive (Permissions)
        $this->adminDriveMock->shouldReceive('shareWithReadAccess')->times(2);
        $this->adminDriveMock->shouldReceive('revokeAccess')->times(2);

        $result = $this->setupService->getOrCreateUserFolder($user, 'essential');

        $this->assertEquals($newFolderId, $result);
        $this->assertDatabaseHas('user_google_drives', [
            'user_id' => $user->id,
            'folder_id' => $newFolderId
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
