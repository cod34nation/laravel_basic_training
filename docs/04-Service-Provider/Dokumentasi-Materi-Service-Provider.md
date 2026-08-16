Service Provider
       │
       ├── 1. Apa Masalah yang Diselesaikan Service Provider?
       │
       ├── 2. Konsep & Fungsi Utama Service Provider
       │
       ├── 3. Metode Registrasi Binding (register vs $singletons)
       │
       ├── 4. Deferred Provider (Penghematan Performa)
       │
       └── 5. Rangkuman Praktika & Pengujian (Unit / Feature Test)

# Service Provider

Service Provider adalah tempat terpusat untuk mengonfigurasi dan mendaftarkan (*register*) dependency/binding ke dalam **Service Container** Laravel. Semua proses inisialisasi awal aplikasi (seperti binding service, event listener, middleware, route) dilakukan melalui Service Provider.

---

# 1. Apa Masalah yang Diselesaikan Service Provider?

Tanpa Service Provider, pengelolaan dependency pada aplikasi skala besar akan menimbulkan beberapa masalah utama:

### A. Penumpukan Kode Inisialisasi (Code Pollution)
* **Masalah:** Tanpa Service Provider, semua pendaftaran binding `bind()` atau `singleton()` harus dituliskan di satu tempat global (seperti `routes/web.php` atau `bootstrap/app.php`). Hal ini membuat file konfigurasi menjadi sangat panjang, berantakan, dan sulit dipelihara.
* **Solusi:** Service Provider memungkinkan pengelompokan registrasi dependency berdasarkan modul/domain masing-masing (contoh: `FooBarServiceProvider`, `PaymentServiceProvider`).

### B. Performa & Memory Overhead (Lazy Loading / Deferred Provider)
* **Masalah:** Jika semua service di-instansiasi atau di-register pada awal booting aplikasi (*eager loading*), maka request sederhana sekalipun akan memuat puluhan/ratusan class yang belum tentu digunakan, sehingga memperlambat response time.
* **Solusi:** Laravel menyediakan interface `DeferrableProvider`. Dengan ini, registrasi service baru akan dieksekusi **hanya ketika service tersebut dipanggil/dibutuhkan** (*lazy loading*).

### C. Pemisahan Urutan Inisialisasi (`register` vs `boot`)
* **Masalah:** Saat meng-instansiasi suatu service di awal aplikasi, mungkin ada service pendukung lain yang belum sempat di-register ke Container.
* **Solusi:** Service Provider memisahkan dua siklus hidup (lifecycle) utama:
  1. `register()`: Tempat khusus mendaftarkan binding ke Service Container. Dilarang memanggil service lain di dalam method ini.
  2. `boot()`: Dipanggil setelah **semua** Service Provider selesai di-register. Di sini aman untuk memanggil service lain, mendaftarkan event listener, route, view, dll.

---

# 2. Rangkuman Praktika Implementasi

Berdasarkan praktika yang telah dilakukan pada project `laravel_training_v1`, berikut adalah rangkuman langkah-langkah implementasinya:

### A. Membuat Service Provider
Membuat provider baru menggunakan command Artisan:
```bash
php artisan make:provider FooBarServiceProvider
```

### B. Mendaftarkan Provider (`bootstrap/providers.php`)
Agar provider dapat dikenali oleh Laravel, daftarkan class provider pada file `bootstrap/providers.php`:
```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FooBarServiceProvider::class,
];
```

### C. Implementasi Kode di `FooBarServiceProvider`
Pada file `app/Providers/FooBarServiceProvider.php`, kita menggunakan kombinasi registrasi manual, properti `$singletons`, serta implementasi `DeferrableProvider`:

```php
<?php

namespace App\Providers;

use App\Contracts\HelloService;
use App\Contracts\HelloServicesIndonesia;
use App\Data\Foo;
use App\Data\Bar;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FooBarServiceProvider extends ServiceProvider implements DeferrableProvider
{   
    // 1. Shortcut binding singleton (Interface => Implementation)
    public array $singletons = [
        HelloService::class => HelloServicesIndonesia::class
    ];

    // 2. Registrasi closure binding pada method register()
    public function register(): void
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });
    }

    public function boot(): void
    {
        //
    }

    // 3. Menentukan daftar service yang di-defer (Hanya di-load saat dipanggil)
    public function provides(): array
    {
        return [
            HelloService::class,
            Foo::class,
            Bar::class
        ];
    }
}
```

---

# 3. Poin Penting Fitur & Properti

1. **Properti `$singletons` & `$bindings`**
   - Merupakan cara ringkas (*shortcut*) untuk mendaftarkan binding dari Interface ke Class tanpa harus menulis closure manual di method `register()`.

2. **Interface `DeferrableProvider` & Method `provides()`**
   - Dengan mengimplementasikan `DeferrableProvider`, Service Provider **tidak akan di-load saat booting awal aplikasi**.
   - Method `provides()` mengembalikan array daftar service/interface yang disediakan oleh provider. Laravel baru akan mengeksekusi `register()` ketika salah satu dari class tersebut dipanggil melalui Service Container (`$app->make(...)`).

---

# 4. Pengujian (Feature Test)

Pengujian dilakukan pada `tests/Feature/FooBarServiceProviderTest.php` untuk memastikan seluruh binding yang ada pada Service Provider berjalan dengan benar:

```php
<?php

namespace Tests\Feature;

use App\Contracts\HelloService;
use App\Data\Foo;
use App\Data\Bar;
use Tests\TestCase;

class FooBarServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        // Memastikan instance yang dikembalikan adalah Singleton (sama)
        self::assertSame($foo1, $foo2);
        self::assertSame($bar1, $bar2);
        self::assertSame($foo1, $bar1->foo);
        self::assertSame($foo2, $bar2->foo);
    }

    public function testHelloService()
    {
        $hello1 = $this->app->make(HelloService::class);
        $hello2 = $this->app->make(HelloService::class);

        self::assertSame($hello1, $hello2);
        self::assertEquals("Halo Afrizal", $hello1->hello('Afrizal'));
        self::assertEquals("Halo Afrizal", $hello2->hello('Afrizal'));
    }
}
```
