# Dokumentasi Materi: Laravel Facades

Dokumentasi ini merangkum konsep dasar **Facade** pada Laravel serta alur pembelajaran yang telah dipraktikkan melalui pengujian fitur di `tests/Feature/FacadesTest.php`.

---

## 1. Konsep Dasar Facade

### Apa itu Facade?
Dalam software engineering (khususnya *Design Pattern* GoF), **Facade Pattern** adalah pola desain struktur yang menyediakan antarmuka (*interface*) sederhana dan bersatu di atas sekumpulan class/sistem yang lebih kompleks.

Dalam ekosistem **Laravel**:
> **Facade** menyediakan antarmuka berorientasi **`static`** untuk mengakses class/service yang terdaftar di dalam **Service Container**.

### Bagaimana Cara Kerja Facade di Balik Layar?
Meskipun kita memanggil method secara statis (contoh: `Config::get(...)`), di belakang layar class tersebut **bukanlah class statis biasa**.

1. **`getFacadeAccessor()`**: Setiap Facade di Laravel meng-extend class `Illuminate\Support\Facades\Facade` dan mengimplementasikan method `getFacadeAccessor()`. Method ini mengembalikan string nama binding/key di Service Container (misalnya `'config'`).
2. **Magic Method `__callStatic()`**: Ketika kita memanggil `Config::get()`, PHP mengeksekusi magic method `__callStatic()`.
3. **Resolusi dari Container**: Facade menggunakan `app()->make('config')` untuk mengambil instance objek nyata dari Service Container, lalu memanggil method `get()` pada objek tersebut secara non-statis.

---

## 2. Rangkuman Proses Belajar & Praktik Kode

Berdasarkan praktikum yang telah dibuat di [`FacadesTest.php`](file:///Users/afrizalwibisono/AppsProject/Experiment/laravel_training_v1/tests/Feature/FacadesTest.php), berikut adalah poin-poin pembelajaran yang berhasil diuji:

### A. Persamaan 3 Cara Mengakses Service di Laravel (`testConfig` & `testConfigDepedency`)
Laravel menyediakan beberapa cara untuk mengakses service/fitur aplikasi. Ketiga cara di bawah ini mengakses objek dan data yang **sama**:

```php
// 1. Menggunakan Helper Function
$firstName1 = config('contoh.author.first');

// 2. Menggunakan Facade
$firstName2 = Config::get('contoh.author.first');

// 3. Menggunakan Service Container secara langsung
$config = $this->app->make('config');
$firstName3 = $config->get('contoh.author.first');

// Hasilnya identik:
self::assertEquals($firstName1, $firstName3);
self::assertEquals($firstName2, $firstName3);
```

### B. Kemudahan Testing & Mocking (`testFacadeMock`)
Salah satu keunggulan utama Facade dibandingkan class statis tradisional adalah **Testability**. Karena Facade terhubung ke Service Container, Facade dapat di-*mock* menggunakan Mockery dengan sangat mudah tanpa perlu mengganti kode utama.

```php
public function testFacadeMock()
{
    // Mengatur perkiraan (expectation) pada Facade
    Config::shouldReceive('get')
        ->with('contoh.author.first')
        ->andReturn('Afrizal Okay');

    // Pengujian saat Facade dipanggil
    $firstName = Config::get('contoh.author.first');
    self::assertEquals('Afrizal Okay', $firstName);
}
```

---

## 3. Catatan Troubleshooting (Problem Resolution)

### Masalah `Undefined type 'Tests\Feature\tests\Feature\Config'`
Saat melakukan pengujian, sempat terjadi kendala static analysis/Linter:
> `Undefined type 'Tests\Feature\tests\Feature\Config'`

#### Penyebab:
1. **Typo Namespace**: Terdapat duplikasi namespace pada header file test: `namespace Tests\Feature\tests\Feature;`.
2. **Relative Class Resolution**: Karena PHP mengevaluasi class `Config` relatif terhadap namespace saat ini (dan belum ada `use Illuminate\Support\Facades\Config;`), PHP mencari class `Config` di dalam namespace `Tests\Feature\tests\Feature\Config`.

#### Solusi:
1. Pastikan namespace diperbaiki menjadi `namespace Tests\Feature;`.
2. Impor class Facade secara eksplisit: `use Illuminate\Support\Facades\Config;`.

---

## 4. Kesimpulan Ringkas

| Fitur | Helper Function `config()` | Facade `Config::get()` | Service Container `$app->make()` |
| :--- | :--- | :--- | :--- |
| **Sintaks** | Fungsi global ringkas | Statis & ekspresif | Berbasis objek / Dependency Injection |
| **Kemudahan Pemanggilan** | Sangat Mudah | Sangat Mudah | Butuh akses ke `$app` atau DI |
| **Mocking dalam Test** | Didukung (melalui Facade di balik layar) | Sangat Mudah (`shouldReceive`) | Sangat Mudah (`$this->app->bind/instance`) |

Facade memberikan keseimbangan terbaik antara **sintaksis yang bersih (clean syntax)** dan **kemudahan pengujian (testability)** di aplikasi Laravel.
