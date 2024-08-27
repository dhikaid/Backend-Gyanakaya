<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\Modul;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::factory()->create([
            'role' => 'member'
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'kategori' => 'HTML',
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'kategori' => 'CSS',
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'kategori' => 'Javascript',
        ]);

        $boolean = [true, false];

        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_kategori' => rand(1, 3),
            'deskripsi' => fake()->paragraph(),
            'lanjutan' => array_rand($boolean, 1)
        ]);
        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_kategori' => rand(1, 3),
            'deskripsi' => fake()->paragraph(),
            'lanjutan' => array_rand($boolean, 1)
        ]);
        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_kategori' => rand(1, 3),
            'deskripsi' => fake()->paragraph(),
            'lanjutan' => array_rand($boolean, 1)
        ]);
        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_kategori' => rand(1, 3),
            'deskripsi' => fake()->paragraph(),
            'lanjutan' => array_rand($boolean, 1)
        ]);

        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => 'Pendahuluan HTML',
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_kategori' => 1,
            'deskripsi' => fake()->paragraph(),
            'lanjutan' => false
        ]);

        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'Pengenalan HTML',
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_materi' => 4,
            'detail' => '<p>Berdasarkan Bab 1 dari buku "Pemrograman Web: HTML dan CSS" oleh Dr. Wahyudi, HTML (Hyper Text Markup Languange) adalah sebuah bahasa formatting yang digunakan untuk membuat sebuah halaman website. Dalam dunia pemrograman berbasis website, HTML menjadi pondasi dasar pada halaman website. Sebuah filet HTML disimpan dengan ekstensi .html (dot html). File tersebut dapat di akses menggunakan web browser.</p>
<h4>KEGUNAAN HTML</h4>
<p>HTML berfungsi sebagai pondasi sebuah halaman website. Adapun yang dapat dilakukan dengan HTML adalah sebagai berikut:</p>
<ol>
    <li>Membungkus element-element tertentu sesuai kebutuhan</li>
    <li>Membuat heading atau format judul<br>&nbsp;</li>
</ol>
<p>Berikut adalah struktur dasar dari HTML :</p>
<pre><code class="language-plaintext">&lt;!DOCTYPE html&gt;
 &lt;html&gt;
 &lt;head&gt;
   &lt;title&gt;Hello World&lt;/title&gt;
 &lt;/head&gt;
&lt;body&gt;

&lt;/body&gt;
&lt;/html&gt;</code></pre>
<h4><br>DOCTYPE atau DTD</h4>
<p>DOCTYPE yang merupakan singkatan dari Document Type Declaration dan juga dikenal sebagai DTD adalah deklarasi dokumen yang digunakan untuk menginfokan tipe dokumen dan versi HTML yang digunakan kepada aplikasi web browser. Penulisan DOCTYPE harus berada pada awal dokumen.&nbsp;</p>
<p>&nbsp;</p>
<p>Sesuai pada contoh diatas, penulisan DTD atau DOCTYPE ini berada diawal yaitu sebelum tag &lt;html&gt;. Pada versi HTML sebelumnya, penulisan DTD ini lebih panjang dengan menyebutkan URL dan mode halaman yang digunakan namun hal tersebut tidak berlaku untuk HTML5. Pada HTML5 penulisan lebih disederhanakan menjadi &lt;!DOCTYPE html&gt;.</p>
<h4><br>TAG &lt;html&gt;</h4>
<p>Tag html digunakan untuk menginformasikan pada aplikasi web browser bahwa tipe dokomen tersebut adalah HTML. Tag html juga menjadi wadah untuk semua elemen HTML. Jadi, semua elemen harus berada di dalam tag tersebut kecuali DOCTYPE karena DOCTYPE bukan termasuk elemen melainkan deklarasi dokumen.</p>
<p>&nbsp;</p>
<p>Tag html merupakan tag yang membutuhkan penutup tag. Jadi kita harus menutup tag tersebut di akhir dokumen seperti contoh diatas &lt;html&gt; pada baris ke 2 dan diakhiri dengan &lt;/html&gt; pada baris ke 9 (akhir dokumen).</p>
<h4>TAG &lt;head&gt;</h4>
<p>Tag head merupakan tag yang berisi informasi tentang halaman yang tidak ditampilkan di halaman web browser. Misalnya: source css, js atau lainnya yang berasal dari luar, informasi meta, title, dan lainnya. Namun, khusus untuk tag &lt;title&gt; akan ditampilkan di title bar pada web browser.</p>
<h4>TAG &lt;title&gt;</h4>
<p>Tag &lt;title&gt; adalah tag yang berada di dalam head HTML yang berfungsi untuk menampilkan judul halaman web pada title bar web browser.</p>
<h4>TAG &lt;body&gt;</h4>
<p>Tag body merupakan tag yang berisi elemen-elemen yang ditampilkan di halaman web. Misalnya teks yang berupa paragraph &lt;p&gt;, heading &lt;h1&gt; hingga &lt;h6&gt;, menampilkan gambar &lt;img /&gt;, membuat tabel &lt;table&gt;, dan lainnya. Di dalam tag body inilah konten visual dari halaman web ditempatkan.<br>&nbsp;</p>'
        ]);

        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_materi' => rand(1, 3),
            'detail' => fake()->paragraph()
        ]);
        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_materi' => rand(1, 3),
            'detail' => fake()->paragraph()
        ]);
        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_materi' => rand(1, 3),
            'detail' => fake()->paragraph()
        ]);
        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => fake()->word(10),
            'cover' => 'cover/' . basename(fake()->image(storage_path('app/public/cover'))),
            'id_materi' => rand(1, 3),
            'detail' => fake()->paragraph()
        ]);
    }
}
