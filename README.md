# impersonate

Paket dimpersonate (login as other user) untuk rakit framework


### Instalasi

Jalankan perintah ini via rakit console:

```sh
php rakit package:install notyf
```


### Mendaftarkan paket

Tambahkan kode berikut ke file application/packages.php:

```php
'impersonate' => ['autoboot' => true],
```

### Cara pengunaan

Contoh penggunaan pada controller anda:

```php
defined('DS') or exit('No direct script access.');

// Impor kelas
use Esyede\Impersonate;

class Impersonate_Controller extends Base_Controller
{
    public function action_impersonate()
    {
        // Proteksi dengan middleware
        $this->middleware('before', ['auth', 'is_admin']);

        $target_id = 2; // Ubah sesuai kebutuhan
        $impersonated = Impersonate::login($target_id);

        if (! $impersonated) {
            return Redirect::back()
                ->with('error', 'Gagal login ke akun user');
        }

        // dd($impersonated);

        // Berhasil login ke user pemilik id '2'
        return Redirect::to('member/dashboard')
            ->with('success', 'Anda sedang login sebagai user');
    }

    public function action_leave()
    {
        // Proteksi dengan middleware
        $this->middleware('before', ['auth', 'is_admin']);

        $leave = Impersonate::leave();

        if (! $leave) {
            return Redirect::back()
                ->with('error', 'Gagal kembali ke admin');
        }

        // dd($leave);

        // Berhasil login ke user pemilik id '2'
        return Redirect::to('admin/dashboard')
            ->with('success', 'Anda kembali login sebagai admin');
    }
}
```


### Catatan

  - Method `Impersonate::login()` dan `Impersonate::leave()` akan mereturn `NULL`
    jika dieksekusi dalam keadaan belum login.
  - Method `Impersonate::login()` dan `Impersonate::leave()` akan mereturn object dari `Auth::user()`
    jika operasi login/leave berhasil dilakukan.
  - Pastikan untuk menerapkan middleware sebagai proteksi route anda
    sebelum menggunakan paket ini.


