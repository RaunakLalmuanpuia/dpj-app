<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\User;
use App\Services\UserDriveSetupService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Razorpay\Api\Api;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PaymentVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Mock the Drive Setup Service globally
        $this->mock(UserDriveSetupService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getOrCreateUserFolder')
                ->andReturn('mock-folder-id-123');
        });
    }

    #[Test]
    public function it_verifies_successful_payment_and_updates_status()
    {
        // Use this to see the actual error if the test fails
        $this->withoutExceptionHandling();

        // 1. Arrange
        $user = User::factory()->create();
        Payment::create([
            'user_id' => $user->id,
            'plan_type' => 'pro',
            'razorpay_order_id' => 'order_999',
            'amount' => 499,
            'status' => 'pending'
        ]);

        // 2. Mock Razorpay Api
        // Note: We use instance() to force the container to use this exact object
        $apiMock = \Mockery::mock(Api::class);
        $utilityMock = \Mockery::mock();

        $utilityMock->shouldReceive('verifyPaymentSignature')
            ->once()
            ->andReturn(true);

        // Razorpay API uses a public property 'utility'. We must mock it this way:
        $apiMock->utility = $utilityMock;

        // Bind the mock into the container so app(Api::class) returns it
        $this->app->instance(Api::class, $apiMock);

        // 3. Act
        $response = $this->actingAs($user)->post(route('payment.verify'), [
            'razorpay_order_id' => 'order_999',
            'razorpay_payment_id' => 'pay_abc123',
            'razorpay_signature' => 'valid_sig',
            'plan' => 'pro'
        ]);

        // 4. Assert
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('is_paid', true);
        $response->assertSessionHas('drive_url', "https://drive.google.com/drive/folders/mock-folder-id-123");

        $this->assertDatabaseHas('payments', [
            'razorpay_order_id' => 'order_999',
            'status' => 'completed',
            'folder_id_created' => 'mock-folder-id-123'
        ]);
    }

    #[Test]
    public function it_handles_failed_signature_verification()
    {
        $user = User::factory()->create();
        Payment::create([
            'user_id' => $user->id,
            'plan_type' => 'pro',
            'razorpay_order_id' => 'order_err',
            'amount' => 499,
            'status' => 'pending'
        ]);

        $apiMock = \Mockery::mock(Api::class);
        $utilityMock = \Mockery::mock();
        $utilityMock->shouldReceive('verifyPaymentSignature')
            ->andThrow(new \Exception('Signature verification failed'));

        $apiMock->utility = $utilityMock;
        $this->app->instance(Api::class, $apiMock);

        $response = $this->actingAs($user)->post(route('payment.verify'), [
            'razorpay_order_id' => 'order_err',
            'razorpay_payment_id' => 'pay_fail',
            'razorpay_signature' => 'bad_sig',
            'plan' => 'pro'
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error', 'Payment verification failed.');

        $this->assertDatabaseHas('payments', [
            'razorpay_order_id' => 'order_err',
            'status' => 'failed'
        ]);
    }

    #[Test]
    public function it_processes_webhook_successfully()
    {
        $user = User::factory()->create();
        Payment::create([
            'user_id' => $user->id,
            'plan_type' => 'pro',
            'razorpay_order_id' => 'order_webhook_123',
            'amount' => 499,
            'status' => 'pending'
        ]);

        $payload = [
            'event' => 'payment.captured',
            'payload' => [
                'payment' => [
                    'entity' => [
                        'id' => 'pay_hook_xyz',
                        'order_id' => 'order_webhook_123',
                    ]
                ]
            ]
        ];

        $response = $this->postJson('/webhooks/razorpay', $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'razorpay_order_id' => 'order_webhook_123',
            'status' => 'completed',
            'razorpay_payment_id' => 'pay_hook_xyz'
        ]);
    }
}
