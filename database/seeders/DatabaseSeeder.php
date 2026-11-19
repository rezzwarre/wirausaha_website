<?php

namespace Database\Seeders;

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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::create([
            'name' => 'Admin Wirausahagoo',
            'email' => 'admin@wirausahagoo.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Gedung Pusat Kegiatan Mahasiswa (PKM), Lt. 2, Kampus Terpadu',
            'role' => 'admin',
        ]);

        // 2. Customer Users
        $customer1 = User::create([
            'name' => 'Budi Pratama',
            'email' => 'budi@mahasiswa.ac.id',
            'password' => Hash::make('password'),
            'phone' => '082198765432',
            'address' => 'Jl. Mahasiswa No. 12, Asrama Putra Kampus',
            'role' => 'customer',
        ]);

        // $customer2 = User::create([
        //     'name' => 'Siti Nurhaliza',
        //     'email' => 'siti@mahasiswa.ac.id',
        //     'password' => Hash::make('password'),
        //     'phone' => '085712348899',
        //     'address' => 'Kost Melati Indah No. 5B, Dekat Gerbang Utama Kampus',
        //     'role' => 'customer',
        // ]);

        // $customer3 = User::create([
        //     'name' => 'Andi Wijaya',
        //     'email' => 'andi@mahasiswa.ac.id',
        //     'password' => Hash::make('password'),
        //     'phone' => '087855443322',
        //     'address' => 'Jl. Flamboyan Blok C-3, Perumahan Dosen',
        //     'role' => 'customer',
        // ]);

        // 3. Bank Accounts
        $bankBca = BankAccount::create([
            'bank_name' => 'BCA (Bank Central Asia)',
            'account_number' => '1234567890',
            'account_name' => 'Wirausaha Mahasiswa Pouch Kreatif',
            'is_active' => true,
        ]);

        // $bankMandiri = BankAccount::create([
        //     'bank_name' => 'Bank Mandiri',
        //     'account_number' => '1350098765432',
        //     'account_name' => 'Wirausaha Mahasiswa Pouch Kreatif',
        //     'is_active' => true,
        // ]);

        // $bankBri = BankAccount::create([
        //     'bank_name' => 'BRI (Bank Rakyat Indonesia)',
        //     'account_number' => '002101003456501',
        //     'account_name' => 'Wirausaha Mahasiswa Pouch Kreatif',
        //     'is_active' => true,
        // ]);

        // $bankQris = BankAccount::create([
        //     'bank_name' => 'QRIS / DANA / GoPay / ShopeePay',
        //     'account_number' => '081234567890',
        //     'account_name' => 'Wirausahagoo Official Store',
        //     'is_active' => true,
        // ]);

        // 4. Categories
        $catPouch = Category::create([
            'name' => 'Pouch Pensil',
            'slug' => 'pouch-pensil',
        ]);

        $catTotebag = Category::create([
            'name' => 'Tote Bag',
            'slug' => 'tote-bag',
        ]);

        $catModif = Category::create([
            'name' => 'Kerajinan Modifikasi',
            'slug' => 'kerajinan-modifikasi',
        ]);

        $catAksesoris = Category::create([
            'name' => 'Aksesoris Kampus',
            'slug' => 'aksesoris-kampus',
        ]);

        // 5. Products
        $productsData = [
            // Pouch Pensil
            [
                'category_id' => $catPouch->id,
                'name' => 'Pouch Pensil Kanvas Modifikasi Batik',
                'slug' => 'pouch-pensil-kanvas-modifikasi-batik',
                'description' => 'Tempat pensil berbahan kain kanvas premium dengan modifikasi aksen kain batik tradisional nusantara. Kuat, stylish, berkapasitas muat hingga 25 pulpen/pensil, dan ramah lingkungan.',
                'price' => 25000,
                'stock' => 25,
                'image' => 'template/images/card-item1.jpg',
                'is_active' => true,
            ],
            // [
            //     'category_id' => $catPouch->id,
            //     'name' => 'Pouch Pensil Denim Eco-Friendly',
            //     'slug' => 'pouch-pensil-denim-eco-friendly',
            //     'description' => 'Pouch pensil modifikasi upcycling celana jeans denim yang dipadukan dengan resleting YKK berkualitas tinggi. Cocok untuk mahasiswa yang suka gaya casual and cool.',
            //     'price' => 28000,
            //     'stock' => 18,
            //     'image' => 'template/images/card-item2.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catPouch->id,
            //     'name' => 'Pouch Pensil Transparan Grid Aesthetic',
            //     'slug' => 'pouch-pensil-transparan-grid-aesthetic',
            //     'description' => 'Pouch pensil bahan TPU transparan motif grid minimalis Korea. Mudah dibersihkan, tahan air, dan memudahkan melihat isi alat tulis dengan rapi.',
            //     'price' => 20000,
            //     'stock' => 30,
            //     'image' => 'template/images/card-item3.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catPouch->id,
            //     'name' => 'Pouch Pensil Rajut Handmade Pastel',
            //     'slug' => 'pouch-pensil-rajut-handmade-pastel',
            //     'description' => 'Hasil rajutan tangan (handmade crochet) mahasiswa dengan benang katun susu lembut. Dilengkapi lapisan furing bagian dalam agar awet.',
            //     'price' => 35000,
            //     'stock' => 12,
            //     'image' => 'template/images/card-item4.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catPouch->id,
            //     'name' => 'Pouch Pensil Multi-Kompartemen Kulit Sintetis',
            //     'slug' => 'pouch-pensil-multi-kompartemen-kulit-sintetis',
            //     'description' => 'Tempat pensil elegan modifikasi kulit sintetis dengan 3 kompartemen terpisah. Muat kalkulator ilmiah, penggaris 20cm, dan alat tulis lainnya.',
            //     'price' => 32000,
            //     'stock' => 20,
            //     'image' => 'template/images/card-item5.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catPouch->id,
            //     'name' => 'Pouch Pensil Bordir Custom Inisial Mahasiswa',
            //     'slug' => 'pouch-pensil-bordir-custom-inisial',
            //     'description' => 'Pouch pensil kanvas twill dengan hiasan bordir manual kreatif bertema quotes motivasi kuliah dan doodle lucu.',
            //     'price' => 30000,
            //     'stock' => 15,
            //     'image' => 'template/images/card-item6.jpg',
            //     'is_active' => true,
            // ],

            // // Tote Bag
            // [
            //     'category_id' => $catTotebag->id,
            //     'name' => 'Tote Bag Kanvas Polos Aesthetic Mahasiswa',
            //     'slug' => 'tote-bag-kanvas-polos-aesthetic',
            //     'description' => 'Tote bag kanvas tebal warna broken white dengan resleting dan saku dalam. Muat laptop 14 inch, binder B5, dan botol minum.',
            //     'price' => 35000,
            //     'stock' => 30,
            //     'image' => 'template/images/card-item7.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catTotebag->id,
            //     'name' => 'Tote Bag Lukis Tangan Etnik Nusantara',
            //     'slug' => 'tote-bag-lukis-tangan-etnik-nusantara',
            //     'description' => 'Karya seni modifikasi tote bag kanvas dilukis langsung dengan cat tekstil permanen waterproof bertema flora fauna Indonesia.',
            //     'price' => 45000,
            //     'stock' => 10,
            //     'image' => 'template/images/card-item8.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catTotebag->id,
            //     'name' => 'Tote Bag Modifikasi Perca Tenun Ikat',
            //     'slug' => 'tote-bag-modifikasi-perca-tenun-ikat',
            //     'description' => 'Tas jinjing mahasiswa unik dengan aplikasi potongan kain tenun ikat tradisional pada bagian kantong depan. Etnik dan modern.',
            //     'price' => 48000,
            //     'stock' => 12,
            //     'image' => 'template/images/card-item9.jpg',
            //     'is_active' => true,
            // ],

            // // Kerajinan Modifikasi
            // [
            //     'category_id' => $catModif->id,
            //     'name' => 'Notebook Hardcover Jahit Tangan Kertas Daur Ulang',
            //     'slug' => 'notebook-hardcover-jahit-tangan-daur-ulang',
            //     'description' => 'Buku catatan bersampul kain motif unik dijahit tangan gaya koptik tradisional. Kertas bookpaper nyaman untuk menulis catatan kuliah.',
            //     'price' => 22000,
            //     'stock' => 25,
            //     'image' => 'template/images/card-item10.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catModif->id,
            //     'name' => 'Tempat Tumbler Rajut Macrame Stylish',
            //     'slug' => 'tempat-tumbler-rajut-macrame-stylish',
            //     'description' => 'Holder botol minum tumbler modifikasi tali katun macrame dengan tali selempang. Praktis dibawa ke kampus.',
            //     'price' => 18000,
            //     'stock' => 20,
            //     'image' => 'template/images/card-large-item1.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catModif->id,
            //     'name' => 'Dompet Koin Perca Modifikasi Batik Lurik',
            //     'slug' => 'dompet-koin-perca-modifikasi-batik-lurik',
            //     'description' => 'Dompet mini multifungsi dari bahan sisa perca lurik untuk menyimpan koin, flashdisk, dan earphone.',
            //     'price' => 15000,
            //     'stock' => 35,
            //     'image' => 'template/images/card-large-item2.jpg',
            //     'is_active' => true,
            // ],

            // // Aksesoris Kampus
            // [
            //     'category_id' => $catAksesoris->id,
            //     'name' => 'Lanyard ID Card Kulit Sintetis + Batik Modifikasi',
            //     'slug' => 'lanyard-id-card-kulit-sintetis-batik',
            //     'description' => 'Tali id card mahasiswa bahan kulit sintetis premium dengan aksen kain batik elegan dan pengait besi anti karat.',
            //     'price' => 20000,
            //     'stock' => 45,
            //     'image' => 'template/images/card-large-item3.jpg',
            //     'is_active' => true,
            // ],
            // [
            //     'category_id' => $catAksesoris->id,
            //     'name' => 'Gantungan Kunci Resin Bunga Abadi (Preserved Flower)',
            //     'slug' => 'gantungan-kunci-resin-bunga-abadi',
            //     'description' => 'Gantungan tas dan kunci estetik dari bahan resin bening berisi bunga asli yang diawetkan dan serpihan gold foil.',
            //     'price' => 12000,
            //     'stock' => 40,
            //     'image' => 'template/images/card-large-item4.jpg',
            //     'is_active' => true,
            // ],
        ];

        // $createdProducts = [];
        // foreach ($productsData as $pData) {
        //     $product = Product::create($pData);
        //     $createdProducts[] = $product;

        //     // Catat Stock In awal oleh Admin
        //     StockMovement::create([
        //         'product_id' => $product->id,
        //         'order_id' => null,
        //         'created_by' => $admin->id,
        //         'type' => 'in',
        //         'quantity' => $product->stock,
        //         'note' => 'Stok awal produksi wirausaha mahasiswa (' . $product->name . ')',
        //     ]);
        // }

        // // 6. Buat Sample Cart untuk Customer 1 (Budi)
        // $budiCart = Cart::create([
        //     'user_id' => $customer1->id,
        // ]);

        // CartItem::create([
        //     'cart_id' => $budiCart->id,
        //     'product_id' => $createdProducts[0]->id, // Pouch Pensil Kanvas Modifikasi Batik
        //     'quantity' => 2,
        // ]);

        // CartItem::create([
        //     'cart_id' => $budiCart->id,
        //     'product_id' => $createdProducts[6]->id, // Tote Bag Kanvas Polos
        //     'quantity' => 1,
        // ]);

        // // 7. Sample Orders & Payments
        // // Order 1: Confirmed (sudah bayar, disetujui admin, memicu stock out)
        // $order1 = Order::create([
        //     'user_id' => $customer1->id,
        //     'order_code' => 'ORD-' . strtoupper(Str::random(8)),
        //     'total_price' => 85000,
        //     'shipping_address' => 'Jl. Mahasiswa No. 12, Asrama Putra Kampus, Kamar 204',
        //     'status' => 'confirmed',
        //     'created_at' => now()->subDays(2),
        // ]);

        // OrderItem::create([
        //     'order_id' => $order1->id,
        //     'product_id' => $createdProducts[0]->id,
        //     'price' => 25000,
        //     'quantity' => 2,
        //     'subtotal' => 50000,
        // ]);

        // OrderItem::create([
        //     'order_id' => $order1->id,
        //     'product_id' => $createdProducts[6]->id,
        //     'price' => 35000,
        //     'quantity' => 1,
        //     'subtotal' => 35000,
        // ]);

        // Payment::create([
        //     'order_id' => $order1->id,
        //     'bank_account_id' => $bankBca->id,
        //     'proof_image' => 'template/images/card-item1.jpg',
        //     'status' => 'approved',
        //     'admin_note' => 'Pembayaran lunas via transfer BCA. Terima kasih!',
        //     'verified_by' => $admin->id,
        //     'verified_at' => now()->subDays(2)->addHours(1),
        // ]);

        // // Memicu riwayat stock out
        // StockMovement::create([
        //     'product_id' => $createdProducts[0]->id,
        //     'order_id' => $order1->id,
        //     'created_by' => $admin->id,
        //     'type' => 'out',
        //     'quantity' => 2,
        //     'note' => 'Pengurangan stok untuk pesanan ' . $order1->order_code,
        //     'created_at' => now()->subDays(2)->addHours(1),
        // ]);

        // StockMovement::create([
        //     'product_id' => $createdProducts[6]->id,
        //     'order_id' => $order1->id,
        //     'created_by' => $admin->id,
        //     'type' => 'out',
        //     'quantity' => 1,
        //     'note' => 'Pengurangan stok untuk pesanan ' . $order1->order_code,
        //     'created_at' => now()->subDays(2)->addHours(1),
        // ]);

        // // Order 2: Waiting confirmation (Customer 2 Siti sudah upload bukti bayar)
        // $order2 = Order::create([
        //     'user_id' => $customer2->id,
        //     'order_code' => 'ORD-' . strtoupper(Str::random(8)),
        //     'total_price' => 45000,
        //     'shipping_address' => 'Kost Melati Indah No. 5B, Dekat Gerbang Utama Kampus',
        //     'status' => 'waiting_confirmation',
        //     'created_at' => now()->subHours(5),
        // ]);

        // OrderItem::create([
        //     'order_id' => $order2->id,
        //     'product_id' => $createdProducts[7]->id, // Tote Bag Lukis
        //     'price' => 45000,
        //     'quantity' => 1,
        //     'subtotal' => 45000,
        // ]);

        // Payment::create([
        //     'order_id' => $order2->id,
        //     'bank_account_id' => $bankMandiri->id,
        //     'proof_image' => 'template/images/card-item8.jpg',
        //     'status' => 'pending',
        //     'admin_note' => null,
        //     'verified_by' => null,
        //     'verified_at' => null,
        //     'created_at' => now()->subHours(4),
        // ]);

        // // Order 3: Pending (Customer 3 Andi baru checkout, belum bayar)
        // $order3 = Order::create([
        //     'user_id' => $customer3->id,
        //     'order_code' => 'ORD-' . strtoupper(Str::random(8)),
        //     'total_price' => 56000,
        //     'shipping_address' => 'Jl. Flamboyan Blok C-3, Perumahan Dosen',
        //     'status' => 'pending',
        //     'created_at' => now()->subHours(2),
        // ]);

        // OrderItem::create([
        //     'order_id' => $order3->id,
        //     'product_id' => $createdProducts[1]->id, // Pouch Denim
        //     'price' => 28000,
        //     'quantity' => 2,
        //     'subtotal' => 56000,
        // ]);

        // // Order 4: Rejected (Customer 1 Budi transfer bukti buram / nominal tidak sesuai)
        // $order4 = Order::create([
        //     'user_id' => $customer1->id,
        //     'order_code' => 'ORD-' . strtoupper(Str::random(8)),
        //     'total_price' => 32000,
        //     'shipping_address' => 'Jl. Mahasiswa No. 12, Asrama Putra Kampus',
        //     'status' => 'rejected',
        //     'created_at' => now()->subDays(1),
        // ]);

        // OrderItem::create([
        //     'order_id' => $order4->id,
        //     'product_id' => $createdProducts[4]->id, // Pouch Kulit Sintetis
        //     'price' => 32000,
        //     'quantity' => 1,
        //     'subtotal' => 32000,
        // ]);

        // Payment::create([
        //     'order_id' => $order4->id,
        //     'bank_account_id' => $bankBri->id,
        //     'proof_image' => 'template/images/card-item5.jpg',
        //     'status' => 'rejected',
        //     'admin_note' => 'Bukti transfer tidak terbaca dan nominal tidak sesuai. Silakan upload ulang atau hubungi admin via WhatsApp.',
        //     'verified_by' => $admin->id,
        //     'verified_at' => now()->subHours(12),
        // ]);
    }
}
