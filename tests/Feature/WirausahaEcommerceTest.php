<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WirausahaEcommerceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;
    protected Category $category;
    protected Product $product;
    protected BankAccount $bank;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Admin
        $this->admin = User::create([
            'name' => 'Admin Wirausahagoo',
            'email' => 'admin@wirausahagoo.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Gedung PKM Kampus',
            'role' => 'admin',
        ]);

        // Create Customer
        $this->customer = User::create([
            'name' => 'Budi Pratama',
            'email' => 'budi@mahasiswa.ac.id',
            'password' => Hash::make('password'),
            'phone' => '082198765432',
            'address' => 'Asrama Mahasiswa No. 12',
            'role' => 'customer',
        ]);

        // Create Category
        $this->category = Category::create([
            'name' => 'Pouch Pensil',
            'slug' => 'pouch-pensil',
        ]);

        // Create Product
        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Pouch Pensil Kanvas Modifikasi Batik',
            'slug' => 'pouch-pensil-kanvas-modifikasi-batik',
            'description' => 'Tempat pensil berbahan kain kanvas dengan modifikasi aksen batik.',
            'price' => 25000,
            'stock' => 15,
            'is_active' => true,
        ]);

        // Create Bank
        $this->bank = BankAccount::create([
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_name' => 'Wirausaha Mahasiswa',
            'is_active' => true,
        ]);
    }

    public function test_homepage_loads_and_displays_products()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('WIRAUSAHA');
        $response->assertSee('Pouch Pensil Kanvas Modifikasi Batik');
    }

    public function test_search_product_by_keyword()
    {
        $response = $this->get('/?q=Batik');
        $response->assertStatus(200);
        $response->assertSee('Pouch Pensil Kanvas Modifikasi Batik');
    }

    public function test_customer_can_add_to_cart_and_view_cart()
    {
        $response = $this->actingAs($this->customer)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect('/cart');

        $cartResponse = $this->actingAs($this->customer)->get('/cart');
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee($this->product->name);
        $cartResponse->assertSee('Rp 50.000');
    }

    public function test_customer_can_checkout_order()
    {
        $cart = Cart::create(['user_id' => $this->customer->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->customer)->post('/checkout', [
            'shipping_address' => 'Gedung Rektorat Kampus Lantai 3',
            'bank_account_id' => $this->bank->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->customer->id,
            'total_price' => 50000,
            'shipping_address' => 'Gedung Rektorat Kampus Lantai 3',
        ]);
    }

    public function test_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Wirausaha');
    }

    public function test_payment_approval_confirms_order_and_triggers_stock_movement()
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_code' => 'ORD-TEST-001',
            'total_price' => 50000,
            'shipping_address' => 'Alamat Mahasiswa',
            'status' => 'waiting_confirmation',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'price' => 25000,
            'quantity' => 2,
            'subtotal' => 50000,
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'bank_account_id' => $this->bank->id,
            'proof_image' => 'template/images/card-item1.jpg',
            'status' => 'pending',
        ]);

        $initialStock = $this->product->stock; // 15

        // Admin approves payment
        $response = $this->actingAs($this->admin)->post("/admin/payments/{$payment->id}/verify", [
            'status' => 'approved',
            'admin_note' => 'Pembayaran transfer valid & terkonfirmasi.',
        ]);

        $response->assertRedirect();

        // 1. Payment status approved
        $this->assertEquals('approved', $payment->fresh()->status);

        // 2. Order status confirmed
        $this->assertEquals('confirmed', $order->fresh()->status);

        // 3. Stock decremented (15 - 2 = 13)
        $this->assertEquals($initialStock - 2, $this->product->fresh()->stock);

        // 4. Stock movement type 'out' logged
        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $this->product->id,
            'order_id' => $order->id,
            'type' => 'out',
            'quantity' => 2,
        ]);
    }
}
