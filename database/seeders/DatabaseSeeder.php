<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Modul;
use App\Models\Materi;
use App\Models\Reviews;
use App\Models\Kategori;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use function PHPSTORM_META\map;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    private function randomPhoto($folder)
    {
        $images = File::files(public_path('assets/' . $folder));

        // Filter gambar dengan ekstensi .jpg
        $jpgImages = array_filter($images, function ($file) {
            return strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'jpg';
        });

        // Pilih gambar secara acak dari hasil filter
        if (empty($jpgImages)) {
            return null; // Tidak ada gambar dengan ekstensi .jpg
        }

        $randomImage = $jpgImages[array_rand($jpgImages)];

        $imageName = $folder . '/' . uniqid() . '_' . basename($randomImage);

        // Salin gambar ke folder 'cover' di storage/public dengan nama acak
        Storage::put($imageName, File::get($randomImage));

        return $imageName;
    }


    private function storePhoto($folder, $searchName)
    {
        $images = File::files(public_path('assets/' . $folder));

        // Filter gambar dengan nama yang sesuai dengan $searchName dan ekstensi .png
        $filteredImages = array_filter($images, function ($file) use ($searchName) {
            return strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'png' &&
                stripos(basename($file), $searchName) !== false;
        });

        if (empty($filteredImages)) {
            // Jika tidak ada gambar yang sesuai dengan pencarian
            return null;
        }

        // Ambil gambar pertama dari hasil filter (bukan acak)
        $selectedImage = reset($filteredImages);

        // Tentukan nama file baru yang akan disimpan di folder 'cover'
        $imageName = $folder . '/' . uniqid() . '_' . basename($selectedImage);

        // Salin gambar ke folder yang ditentukan di storage/public dengan nama acak
        Storage::put($imageName, File::get($selectedImage));

        return $imageName;
    }

    public function run(): void
    {
        Role::factory()->create([
            'role' => 'member'
        ]);

        Role::factory()->create([
            'role' => 'admin'
        ]);


        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'cover' => $this->storePhoto('cover', 'html'),
            'kategori' => 'HTML',
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'cover' => $this->storePhoto('cover', 'css'),
            'kategori' => 'CSS',
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'cover' => $this->storePhoto('cover', 'js'),
            'kategori' => 'Javascript',
        ]);


        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => "HTML Dasar #1",
            'cover' => $this->randomPhoto('cover'),
            'id_kategori' => 1,
            'deskripsi' => 'Kelas HTML dasar ini mengajarkan dasar-dasar pembuatan halaman web, meliputi struktur tag, elemen, atribut, serta praktik terbaik untuk mengembangkan situs web yang responsif dan mudah diakses.',
            'lanjutan' => false,
            'waktu' => 150,
        ]);

        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => "HTML Lanjutan #1",
            'cover' => $this->randomPhoto('cover'),
            'id_kategori' => 1,
            'deskripsi' => 'Kelas HTML lanjutan ini membahas teknik pengembangan web modern, seperti penggunaan elemen semantik, optimasi aksesibilitas, integrasi API, dan penerapan HTML5 untuk membangun web yang interaktif.',
            'lanjutan' => true,
            'waktu' => 120,
        ]);

        // MODUL
        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'Pengenalan HTML',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 1,
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
<p>Sesuai pada contoh diatas, penulisan DTD atau DOCTYPE ini berada diawal yaitu sebelum tag &lt;html&gt;. Pada versi HTML sebelumnya, penulisan DTD ini lebih panjang dengan menyebutkan URL dan mode halaman yang digunakan namun hal tersebut tidak berlaku untuk HTML5. Pada HTML5 penulisan lebih disederhanakan menjadi &lt;!DOCTYPE html&gt;.</p>
<h4><br>TAG &lt;html&gt;</h4>
<p>Tag html digunakan untuk menginformasikan pada aplikasi web browser bahwa tipe dokomen tersebut adalah HTML. Tag html juga menjadi wadah untuk semua elemen HTML. Jadi, semua elemen harus berada di dalam tag tersebut kecuali DOCTYPE karena DOCTYPE bukan termasuk elemen melainkan deklarasi dokumen.</p>
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
            'modul' => 'HTML Dengan teks',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 1,
            'detail' => '<p>Di sini, kita akan belajar tentang beberapa elemen dasar HTML yang sangat penting untuk membuat halaman web yang keren. HTML (HyperText Markup Language) adalah bahasa markup yang digunakan untuk membuat dan menyusun halaman web. Dengan HTML, kita bisa mengatur teks, gambar, dan elemen lainnya di halaman web.&nbsp;</p>
<p>Mari kita mulai dengan memahami beberapa tag HTML yang sering digunakan, dan bagaimana cara kerjanya!</p>
<hr>
<h3>1. Heading</h3>
<p>Heading digunakan untuk membuat judul di halaman web. Ada enam tingkat heading, dari yang paling besar hingga yang paling kecil. Heading membantu mengatur konten dan membuat halaman web lebih mudah dibaca.</p>
<ul>
    <li><code><strong>&lt;h1&gt;</strong></code>: Heading level 1, ukuran font 200% dari ukuran dasar.</li>
    <li><code><strong>&lt;h2&gt;</strong></code>: Heading level 2, ukuran font 150% dari ukuran dasar.</li>
    <li><code><strong>&lt;h3&gt;</strong></code>: Heading level 3, ukuran font 117% dari ukuran dasar.</li>
    <li><code><strong>&lt;h4&gt;</strong></code>: Heading level 4, ukuran font 100% dari ukuran dasar.</li>
    <li><code><strong>&lt;h5&gt;</strong></code>: Heading level 5, ukuran font 83% dari ukuran dasar.</li>
    <li><code><strong>&lt;h6&gt;</strong></code>: Heading level 6, ukuran font 67% dari ukuran dasar.</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut ke editor HTML-mu dan lihat hasilnya!</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Ini adalah Heading Level 1<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>Ini adalah Heading Level 2<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span>Ini adalah Heading Level 3<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h4</span><span class="hljs-tag">&gt;</span>Ini adalah Heading Level 4<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h4</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h5</span><span class="hljs-tag">&gt;</span>Ini adalah Heading Level 5<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h5</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h6</span><span class="hljs-tag">&gt;</span>Ini adalah Heading Level 6<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h6</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>2. Paragraf</h3>
<p>Paragraf membantu memisahkan teks menjadi blok yang lebih mudah dibaca. Untuk membuat paragraf, gunakan tag <code>&lt;p&gt;</code>.</p>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut dan lihat bagaimana paragraf terpisah dengan rapi!</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah contoh paragraf. Teks di dalam tag <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">code</span><span class="hljs-tag">&gt;</span><span class="hljs-symbol">&amp;lt;</span>p<span class="hljs-symbol">&amp;gt;</span><span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">code</span><span class="hljs-tag">&gt;</span> akan dipisahkan dari teks lainnya.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>3. Teks Tebal</h3>
<p>Untuk membuat teks menjadi tebal, kamu bisa menggunakan:</p>
<ul>
    <li><code><strong>&lt;b&gt;</strong></code>: Menebalkan teks tanpa makna tambahan.</li>
    <li><code><strong>&lt;strong&gt;</strong></code>: Menebalkan teks dengan penekanan ekstra.</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Gunakan kode berikut untuk melihat perbedaan antara <code>&lt;b&gt;</code> dan <code>&lt;strong&gt;</code>:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">b</span><span class="hljs-tag">&gt;</span>teks tebal<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">b</span><span class="hljs-tag">&gt;</span> menggunakan tag <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">code</span><span class="hljs-tag">&gt;</span><span class="hljs-symbol">&amp;lt;</span>b<span class="hljs-symbol">&amp;gt;</span><span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">code</span><span class="hljs-tag">&gt;</span> dan ini adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">strong</span><span class="hljs-tag">&gt;</span>teks tebal<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">strong</span><span class="hljs-tag">&gt;</span> menggunakan tag <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">code</span><span class="hljs-tag">&gt;</span><span class="hljs-symbol">&amp;lt;</span>strong<span class="hljs-symbol">&amp;gt;</span><span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">code</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>4. Teks Miring</h3>
<p>Untuk membuat teks menjadi miring, kamu bisa menggunakan:</p>
<ul>
    <li><code><strong>&lt;i&gt;</strong></code>: Untuk teks miring biasa.</li>
    <li><code><strong>&lt;em&gt;</strong></code>: Untuk teks miring dengan penekanan.</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Coba kode berikut untuk melihat bagaimana teks miring bekerja:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Teks miring <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">i</span><span class="hljs-tag">&gt;</span>bisa<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">i</span><span class="hljs-tag">&gt;</span> digunakan untuk <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">em</span><span class="hljs-tag">&gt;</span>penekanan<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">em</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>5. Teks Garis Bawah</h3>
<p>Untuk memberi garis bawah pada teks, gunakan:</p>
<ul>
    <li><code><strong>&lt;u&gt;</strong></code>: Untuk garis bawah.</li>
    <li><code><strong>&lt;ins&gt;</strong></code>: Untuk teks yang diinsert atau baru.</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Gunakan kode berikut untuk melihat bagaimana garis bawah diterapkan:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">u</span><span class="hljs-tag">&gt;</span>teks dengan garis bawah<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">u</span><span class="hljs-tag">&gt;</span> dan ini adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">ins</span><span class="hljs-tag">&gt;</span>teks yang diinsert<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">ins</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>6. Teks Dicoret</h3>
<p>Untuk mencoret teks, gunakan:</p>
<ul>
    <li><code><strong>&lt;s&gt;</strong></code>: Untuk teks yang dicoret.</li>
    <li><code><strong>&lt;del&gt;</strong></code>: Untuk teks yang dihapus.</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut dan lihat bagaimana teks dicoret:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Terkadang kita butuh untuk mencoret <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">s</span><span class="hljs-tag">&gt;</span>sesuatu<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">s</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Contoh teks dicoret: <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">del</span><span class="hljs-tag">&gt;</span>tembok rumah<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">del</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>7. Teks Stabilo (Marker)</h3>
<p>Untuk menandai teks dengan cara yang mirip dengan stabilo, gunakan tag <code>&lt;mark&gt;</code>.</p>
<p><strong>Coba Praktikkan:</strong></p>
<p>Gunakan kode berikut untuk melihat bagaimana teks diberi marker:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Penggunaan <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">mark</span><span class="hljs-tag">&gt;</span>stabilo<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">mark</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">mark</span><span class="hljs-tag">&gt;</span>teks penting yang diberi marker<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">mark</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>8. Teks Kecil</h3>
<p>Untuk membuat teks lebih kecil dari ukuran normal, gunakan tag <code>&lt;small&gt;</code>.</p>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut dan lihat bagaimana teks kecil ditampilkan:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>Aku adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;</span>sebuah judul kecil<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;</span>contoh teks kecil<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;</span> dalam paragraf.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>9. Daftar</h3>
<p>Ada dua jenis daftar di HTML:</p>
<ul>
    <li><code><strong>&lt;ul&gt;</strong></code>: Daftar tidak terurut (bullet points).</li>
    <li><code><strong>&lt;ol&gt;</strong></code>: Daftar terurut (nomor).</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut untuk membuat daftar terurut dan tidak terurut:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span>Daftar Tidak Terurut<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span> &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Item pertama<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span> &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Item kedua<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span>Daftar Terurut<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">ol</span><span class="hljs-tag">&gt;</span> &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Langkah pertama<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span> &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Langkah kedua<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span> <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">ol</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<h3>10. Link</h3>
<p>Untuk membuat hyperlink yang menghubungkan ke halaman atau sumber daya eksternal, gunakan tag <code>&lt;a&gt;</code> dengan atribut <code>href</code>.</p>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut untuk membuat link:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"https://www.contoh.com"</span><span class="hljs-tag">&gt;</span>Kunjungi Situs Web<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span></code></div>
</div>
<hr>
<p>Sekian materi HTML Dasar kita kali ini. Praktikkan setiap tag yang telah kita bahas dan lihat bagaimana tampilan halaman webmu berubah. Jangan ragu untuk bereksperimen dan menjelajahi lebih banyak tentang HTML! 🚀💻</p>'
        ]);



        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'HTML dengan Gambar dan Video',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 1,
            'detail' => '<p>Kali ini kita akan membahas cara menampilkan gambar dan video di halaman web. Menambahkan gambar dan video ke halaman web adalah cara yang bagus untuk membuat kontenmu lebih menarik dan informatif. Yuk, kita pelajari cara melakukannya!</p>
<hr>
<h3>1. Menambahkan Gambar</h3>
<p>Untuk menampilkan gambar di halaman web, kita menggunakan elemen <code>&lt;img&gt;</code>. Ini adalah elemen yang sangat penting karena memungkinkan kita untuk menyematkan gambar tanpa memerlukan tag penutup. Ada dua atribut utama yang perlu kamu ketahui:</p>
<ul>
    <li><code><strong>src</strong></code>: Atribut ini berisi URL gambar yang ingin kamu tampilkan. URL ini bisa berupa URL relatif (misalnya, gambar yang ada di folder yang sama dengan file HTML) atau URL absolut (link langsung ke gambar di internet).</li>
    <li><code><strong>alt</strong></code>: Atribut ini berisi deskripsi teks gambar. Deskripsi ini muncul jika gambar tidak bisa ditampilkan atau saat gambar sedang dimuat. Ini juga membantu dalam aksesibilitas bagi pengguna dengan gangguan penglihatan.</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut ke editor HTML-mu untuk menampilkan gambar:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar/Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar Budi"</span><span class="hljs-tag"> /&gt;</span>
        </code></div>
</div>
<p>Jika gambar berada di direktori yang sama dengan halaman HTML kamu, cukup gunakan nama file-nya:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar Budi"</span><span class="hljs-tag"> /&gt;</span>
        </code></div>
</div>
<p>Untuk gambar dari internet, gunakan URL lengkapnya:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"https://www.contoh.com/gambar/Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar Budi"</span><span class="hljs-tag"> /&gt;</span>
        </code></div>
</div>
<p>Jika gambar tidak bisa dimuat, teks yang ada di atribut <code>alt</code> akan muncul sebagai alternatif:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"gambar/Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar tidak tersedia"</span><span class="hljs-tag"> /&gt;</span>
        </code></div>
</div>
<hr>
<h3>2. Menambahkan Video</h3>
<p>Elemen <code>&lt;video&gt;</code> memungkinkan kamu untuk menyematkan video dengan mudah di halaman web. Ada beberapa fitur penting yang perlu diperhatikan:</p>
<ul>
    <li><code><strong>src</strong></code>: Atribut ini berisi jalur menuju file video yang ingin kamu tampilkan, mirip dengan atribut <code>src</code> pada elemen <code>&lt;img&gt;</code>.</li>
    <li><code><strong>controls</strong></code>: Menambahkan atribut ini akan menampilkan kontrol bawaan untuk pemutaran video, seperti tombol play, pause, dan volume. Ini penting untuk memberikan kontrol kepada pengguna.</li>
</ul>
<p><strong>Coba Praktikkan:</strong></p>
<p>Salin kode berikut untuk menambahkan video ke halaman web:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"rabbit320.webm"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">controls</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Browser Anda tidak mendukung video HTML. Berikut adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"rabbit320.webm"</span><span class="hljs-tag">&gt;</span>tautan ke video<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span> sebagai gantinya.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<p>Jika browser tidak mendukung elemen <code>&lt;video&gt;</code>, konten di dalam tag <code>&lt;video&gt;</code> akan ditampilkan sebagai alternatif. Dalam contoh ini, kita memberikan tautan langsung ke file video.</p>
<hr>
<h3>3. Sumber Belajar Tambahan</h3>
<p>Untuk memperdalam pemahaman kamu tentang gambar dan video di HTML, berikut adalah beberapa video yang bisa membantu:</p>
<ul>
    <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=Hh_se2Zqsdk"><a rel="noopener" target="_new"><strong>Video Tutorial Gambar di HTML</strong></a></a></li>
    <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=Ki_0iES2cGI"><a rel="noopener" target="_new"><strong>Video Tutorial Video di HTML</strong></a></a></li>
</ul>
<hr>
<p>Sekian materi tentang pengaplikasian gambar dan video di HTML. Dengan pengetahuan ini, kamu bisa menambahkan elemen visual yang menarik ke halaman webmu. Jangan ragu untuk bereksperimen dengan berbagai gambar dan video untuk memperindah kontenmu! 🚀📷📹</p>'
        ]);



        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'HTML semantik',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 1,
            'detail' => '<p>Halo teman-teman! Di sesi kali ini, kita akan membahas tentang "Semantic Web Structure" dalam HTML. Apa sih artinya? Semantik dalam web adalah cara untuk memberikan makna atau arti pada elemen-elemen di halaman web kita, sehingga tidak hanya tampak bagus, tapi juga terstruktur dengan baik dan mudah dipahami oleh mesin pencari dan teknologi bantu. Mari kita lihat mengapa hal ini penting dan bagaimana cara mengaplikasikannya!</p>
<hr>
<h3>Mengapa Semantik Itu Penting?</h3>
<p>Semantik web adalah pendekatan yang fokus pada pemberian makna pada elemen-elemen HTML. Dengan menggunakan tag semantik, kita dapat membuat halaman web yang lebih mudah dipahami oleh mesin pencari dan teknologi bantu, seperti pembaca layar. Ini juga membuat kode HTML kita lebih bersih dan terstruktur dengan baik.</p>
<p><strong>Perbandingan Kode:</strong></p>
<p>Tanpa Elemen Semantik:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"header"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"section"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"article"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"figure"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"figcaption"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"footer"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<p>Dengan Elemen Semantik:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<p>Menggunakan elemen semantik membuat kode lebih mudah dibaca dan dipahami. Sekarang, mari kita pelajari kegunaan dari masing-masing tag semantik ini!</p>
<hr>
<h3>1. <code><strong>&lt;header&gt;</strong></code></h3>
<p><strong>Apa itu?</strong><br>Tag <code>&lt;header&gt;</code> mendefinisikan bagian header dari sebuah dokumen atau bagian dari halaman. Biasanya berisi konten pengantar atau tautan navigasi.</p>
<p><strong>Contoh Penggunaan:</strong></p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Selamat Datang di Website Saya<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Tempat terbaik untuk belajar pengembangan web<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>2. <code><strong>&lt;nav&gt;</strong></code></h3>
<p><strong>Apa itu?</strong><br>Tag <code>&lt;nav&gt;</code> digunakan untuk membuat bagian navigasi di halaman web. Ini berisi tautan-tautan yang membantu pengunjung untuk menjelajahi situs.</p>
<p><strong>Contoh Penggunaan:</strong></p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">nav</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#home"</span><span class="hljs-tag">&gt;</span>Beranda<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#about"</span><span class="hljs-tag">&gt;</span>Tentang<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#services"</span><span class="hljs-tag">&gt;</span>Layanan<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#contact"</span><span class="hljs-tag">&gt;</span>Kontak<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">nav</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>3. <code><strong>&lt;section&gt;</strong></code></h3>
<p><strong>Apa itu?</strong><br>Tag <code>&lt;section&gt;</code> menandai bagian dari konten yang berkaitan satu sama lain. Ini digunakan untuk mengelompokkan konten yang memiliki tema atau topik yang sama.</p>
<p><strong>Contoh Penggunaan:</strong></p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"home"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>Beranda<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Selamat datang di beranda kami. Di sini Anda akan menemukan pembaruan terbaru dan konten unggulan.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>4. <code><strong>&lt;article&gt;</strong></code></h3>
<p><strong>Apa itu?</strong><br>Tag <code>&lt;article&gt;</code> merepresentasikan sebuah komposisi yang berdiri sendiri dan dapat didistribusikan secara independen. Ini bisa berupa artikel berita, posting blog, atau informasi lain yang bisa berdiri sendiri.</p>
<p><strong>Contoh Penggunaan:</strong></p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"about"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>Tentang Kami<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span>Misi Kami<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Misi kami adalah menyediakan tutorial pengembangan web berkualitas tinggi untuk semua tingkat keahlian.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span>Tim Kami<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h3</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Kami adalah sekelompok pengembang yang bersemangat untuk berbagi pengetahuan.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>5. <code><strong>&lt;footer&gt;</strong></code></h3>
<p><strong>Apa itu?</strong><br>Tag <code>&lt;footer&gt;</code> menandai bagian footer dari dokumen atau bagian halaman. Biasanya berisi informasi tentang penulis, hak cipta, atau tautan ke dokumen terkait.</p>
<p><strong>Contoh Penggunaan:</strong></p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span><span class="hljs-symbol">&amp;copy;</span> 2024 Situs Web Saya. Semua hak dilindungi.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ikuti kami di <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#"</span><span class="hljs-tag">&gt;</span>Twitter<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span> dan <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#"</span><span class="hljs-tag">&gt;</span>Facebook<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>Sumber Belajar Tambahan</h3>
<p>Untuk memperdalam pengetahuan kamu tentang penggunaan elemen semantik di HTML, cek video tutorial berikut:</p>
<ul>
    <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=o3m15BWi2HM"><a rel="noopener" target="_new"><strong>Video Tutorial Semantik Web Struktur</strong></a></a></li>
</ul>
<hr>
<p>Sekian materi tentang struktur semantik dalam HTML! Dengan memahami dan menerapkan elemen-elemen semantik, kamu akan membuat halaman web yang lebih terstruktur dan mudah diakses. Selamat mencoba! 🚀📚</p>'
        ]);





        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'HTML Lanjutan Pendahuluan',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 2,
            'detail' => '<p>Selamat datang kembali! 🎉 Bagi kalian yang sudah mempelajari materi HTML pendahuluan, kini saatnya kita memasuki dunia yang lebih mendalam dan canggih dari HTML. Di sesi ini, kita akan menjelajahi berbagai topik lanjutan yang akan membantu Anda membangun halaman web yang lebih kompleks, dinamis, dan responsif.</p>
<p>Apa yang akan kita bahas kali ini? Pertama-tama, kita akan mempelajari cara bekerja dengan elemen-elemen form yang lebih canggih. Selanjutnya, kita akan memahami berbagai HTML5 APIs yang dapat memperkaya interaksi pengguna di situs web Anda. Selain itu, kita juga akan mengoptimalkan kinerja situs web Anda agar lebih cepat dan efisien. Tak ketinggalan, kita akan membahas penggunaan Semantic HTML yang lebih mendalam untuk menciptakan struktur halaman yang tidak hanya lebih bermakna, tetapi juga lebih mudah diakses oleh semua pengguna.</p>
<p>Mari kita mulai perjalanan kita ke dunia <strong>Advanced HTML</strong>!</p>
<hr>
<h3>1. <strong>Formulir Lanjutan</strong></h3>
<p>Formulir (forms) adalah salah satu elemen penting dalam halaman web interaktif. Dengan elemen form, kita bisa mengumpulkan data dari pengguna, tetapi ada banyak elemen dan atribut lanjutan yang dapat kita gunakan untuk meningkatkan fungsionalitas formulir kita.</p>
<p><strong>Contoh Penggunaan:</strong></p>
<ul>
    <li>
        <p><strong>Elemen </strong><code><strong>&lt;input&gt;</strong></code><strong> dengan Tipe Berbeda:</strong></p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">form</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag">&gt;</span>Email:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>

                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag">&gt;</span>Usia:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"number"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">min</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"1"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">max</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"120"</span><span class="hljs-tag">&gt;</span>

                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag">&gt;</span>Kata Sandi:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">minlength</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"6"</span><span class="hljs-tag">&gt;</span>

                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"submit"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Kirim"</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">form</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Elemen </strong><code><strong>&lt;select&gt;</strong></code><strong> dan </strong><code><strong>&lt;datalist&gt;</strong></code><strong>:</strong></p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"country"</span><span class="hljs-tag">&gt;</span>Negara:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">select</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"country"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"country"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"us"</span><span class="hljs-tag">&gt;</span>Amerika Serikat<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"id"</span><span class="hljs-tag">&gt;</span>Indonesia<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"jp"</span><span class="hljs-tag">&gt;</span>Jepang<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">select</span><span class="hljs-tag">&gt;</span>

                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruit"</span><span class="hljs-tag">&gt;</span>Buah:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">list</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruits"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruit"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruit"</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">datalist</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruits"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Apple"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Banana"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Cherry"</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">datalist</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3>2. <strong>HTML5 APIs</strong></h3>
<p>HTML5 menyediakan berbagai API yang dapat digunakan untuk menambahkan fungsionalitas canggih ke situs web Anda. Beberapa API yang sering digunakan meliputi:</p>
<ul>
    <li>
        <p><strong>Geolocation API:</strong> Memungkinkan Anda untuk mendapatkan lokasi pengguna.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">button</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">onclick</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"getLocation()"</span><span class="hljs-tag">&gt;</span>Dapatkan Lokasi Saya<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">button</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"demo"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>

                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">script</span><span class="hljs-tag">&gt;</span><span class="javascript">
                    </span><span class="javascript hljs-keyword">function</span><span class="javascript"> </span><span class="javascript hljs-title function_">getLocation</span><span class="javascript">(</span><span class="javascript hljs-params"></span><span class="javascript">) {
                        &nbsp; &nbsp;</span><span class="javascript hljs-keyword">if</span><span class="javascript"> (navigator.</span><span class="javascript hljs-property">geolocation</span><span class="javascript">) {
                        &nbsp; &nbsp; &nbsp; &nbsp;navigator.</span><span class="javascript hljs-property">geolocation</span><span class="javascript">.</span><span class="javascript hljs-title function_">getCurrentPosition</span><span class="javascript">(showPosition);
                        &nbsp; &nbsp;} </span><span class="javascript hljs-keyword">else</span><span class="javascript"> {
                        &nbsp; &nbsp; &nbsp; &nbsp;</span><span class="javascript hljs-variable language_">document</span><span class="javascript">.</span><span class="javascript hljs-title function_">getElementById</span><span class="javascript">(</span><span class="javascript hljs-string">"demo"</span><span class="javascript">).</span><span class="javascript hljs-property">innerHTML</span><span class="javascript"> = </span><span class="javascript hljs-string">"Geolocation tidak didukung oleh browser ini."</span><span class="javascript">;
                        &nbsp; &nbsp;}
                        }

                    </span><span class="javascript hljs-keyword">function</span><span class="javascript"> </span><span class="javascript hljs-title function_">showPosition</span><span class="javascript">(</span><span class="javascript hljs-params">position</span><span class="javascript">) {
                        &nbsp; &nbsp;</span><span class="javascript hljs-variable language_">document</span><span class="javascript">.</span><span class="javascript hljs-title function_">getElementById</span><span class="javascript">(</span><span class="javascript hljs-string">"demo"</span><span class="javascript">).</span><span class="javascript hljs-property">innerHTML</span><span class="javascript"> = </span><span class="javascript hljs-string">"Latitude: "</span><span class="javascript"> + position.</span><span class="javascript hljs-property">coords</span><span class="javascript">.</span><span class="javascript hljs-property">latitude</span><span class="javascript"> +
                        &nbsp; &nbsp;</span><span class="javascript hljs-string">"&lt;br&gt;Longitude: "</span><span class="javascript"> + position.</span><span class="javascript hljs-property">coords</span><span class="javascript">.</span><span class="javascript hljs-property">longitude</span><span class="javascript">;
                        }
                    </span><span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">script</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Canvas API:</strong> Untuk menggambar grafik dan visualisasi lainnya di halaman web.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">canvas</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"myCanvas"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">width</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"200"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">height</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"100"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">style</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"border:1px solid #000000;"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">canvas</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">script</span><span class="hljs-tag">&gt;</span><span class="javascript">
                    </span><span class="javascript hljs-keyword">var</span><span class="javascript"> canvas = </span><span class="javascript hljs-variable language_">document</span><span class="javascript">.</span><span class="javascript hljs-title function_">getElementById</span><span class="javascript">(</span><span class="javascript hljs-string">"myCanvas"</span><span class="javascript">);
                    </span><span class="javascript hljs-keyword">var</span><span class="javascript"> ctx = canvas.</span><span class="javascript hljs-title function_">getContext</span><span class="javascript">(</span><span class="javascript hljs-string">"2d"</span><span class="javascript">);
                        ctx.</span><span class="javascript hljs-title function_">beginPath</span><span class="javascript">();
                        ctx.</span><span class="javascript hljs-title function_">moveTo</span><span class="javascript">(</span><span class="javascript hljs-number">0</span><span class="javascript">, </span><span class="javascript hljs-number">0</span><span class="javascript">);
                        ctx.</span><span class="javascript hljs-title function_">lineTo</span><span class="javascript">(</span><span class="javascript hljs-number">200</span><span class="javascript">, </span><span class="javascript hljs-number">100</span><span class="javascript">);
                        ctx.</span><span class="javascript hljs-title function_">stroke</span><span class="javascript">();
                    </span><span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">script</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3>3. <strong>Optimasi Kinerja Situs Web</strong></h3>
<p>Mengoptimalkan kinerja situs web Anda adalah kunci untuk memberikan pengalaman pengguna yang lebih baik. Beberapa teknik yang dapat Anda gunakan meliputi:</p>
<ul>
    <li><strong>Minifikasi CSS dan JavaScript:</strong> Mengurangi ukuran file CSS dan JavaScript dengan menghapus spasi dan komentar.</li>
    <li><strong>Penggunaan Caching:</strong> Menggunakan caching untuk menyimpan file di browser pengguna sehingga halaman tidak perlu dimuat ulang setiap kali.</li>
    <li>
        <p><strong>Lazy Loading:</strong> Memuat gambar dan elemen lain hanya saat diperlukan.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"placeholder.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">data-src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"real-image.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"lazyload"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Deskripsi"</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">script</span><span class="hljs-tag">&gt;</span><span class="javascript">
                    </span><span class="javascript hljs-variable language_">document</span><span class="javascript">.</span><span class="javascript hljs-title function_">addEventListener</span><span class="javascript">(</span><span class="javascript hljs-string">"DOMContentLoaded"</span><span class="javascript">, </span><span class="javascript hljs-keyword">function</span><span class="javascript">(</span><span class="javascript hljs-params"></span><span class="javascript">) {
                        &nbsp; &nbsp;</span><span class="javascript hljs-keyword">var</span><span class="javascript"> lazyImages = [].</span><span class="javascript hljs-property">slice</span><span class="javascript">.</span><span class="javascript hljs-title function_">call</span><span class="javascript">(</span><span class="javascript hljs-variable language_">document</span><span class="javascript">.</span><span class="javascript hljs-title function_">querySelectorAll</span><span class="javascript">(</span><span class="javascript hljs-string">"img.lazyload"</span><span class="javascript">));
                        &nbsp; &nbsp;</span><span class="javascript hljs-keyword">var</span><span class="javascript"> lazyLoad = </span><span class="javascript hljs-keyword">function</span><span class="javascript">(</span><span class="javascript hljs-params"></span><span class="javascript">) {
                        &nbsp; &nbsp; &nbsp; &nbsp;lazyImages.</span><span class="javascript hljs-title function_">forEach</span><span class="javascript">(</span><span class="javascript hljs-keyword">function</span><span class="javascript">(</span><span class="javascript hljs-params">img</span><span class="javascript">) {
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span class="javascript hljs-keyword">if</span><span class="javascript"> (img.</span><span class="javascript hljs-title function_">getBoundingClientRect</span><span class="javascript">().</span><span class="javascript hljs-property">top</span><span class="javascript"> &lt; </span><span class="javascript hljs-variable language_">window</span><span class="javascript">.</span><span class="javascript hljs-property">innerHeight</span><span class="javascript"> &amp;&amp; img.</span><span class="javascript hljs-title function_">getBoundingClientRect</span><span class="javascript">().</span><span class="javascript hljs-property">bottom</span><span class="javascript"> &gt; </span><span class="javascript hljs-number">0</span><span class="javascript">) {
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;img.</span><span class="javascript hljs-property">src</span><span class="javascript"> = img.</span><span class="javascript hljs-property">dataset</span><span class="javascript">.</span><span class="javascript hljs-property">src</span><span class="javascript">;
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;img.</span><span class="javascript hljs-property">classList</span><span class="javascript">.</span><span class="javascript hljs-title function_">remove</span><span class="javascript">(</span><span class="javascript hljs-string">"lazyload"</span><span class="javascript">);
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;}
                        &nbsp; &nbsp; &nbsp; &nbsp;});
                        &nbsp; &nbsp;};
                        &nbsp; &nbsp;</span><span class="javascript hljs-title function_">lazyLoad</span><span class="javascript">();
                        &nbsp; &nbsp;</span><span class="javascript hljs-variable language_">window</span><span class="javascript">.</span><span class="javascript hljs-title function_">addEventListener</span><span class="javascript">(</span><span class="javascript hljs-string">"scroll"</span><span class="javascript">, lazyLoad);
                        });
                    </span><span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">script</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3>4. <strong>Semantic HTML yang Lebih Mendalam</strong></h3>
<p>Menggunakan elemen semantik dengan lebih cermat membantu dalam membuat struktur halaman yang lebih jelas dan dapat diakses. Mari kita lihat beberapa contoh lanjutan:</p>
<ul>
    <li>
        <p><code><strong>&lt;figure&gt;</strong></code><strong> dan </strong><code><strong>&lt;figcaption&gt;</strong></code><strong>:</strong> Untuk mengelompokkan gambar dan keterangan gambar.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"example.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Contoh Gambar"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;</span>Gambar ini adalah contoh penggunaan tag <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span> dan <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>&lt;main&gt;</strong></code><strong>:</strong> Menandai konten utama dari halaman.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">main</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Konten Utama<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah bagian utama dari halaman yang berisi konten penting.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">main</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3>Sumber Belajar Tambahan</h3>
<p>Untuk lebih memahami dan mendalami topik-topik ini, Anda bisa mengeksplorasi tutorial dan sumber belajar tambahan berikut:</p>
<ul>
    <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=example"><a rel="noopener" target="_new"><strong>Video Tutorial Advanced HTML</strong></a></a></li>
</ul>
<hr>
<p>Sekian untuk pembahasan tentang <strong>Advanced HTML</strong>! Dengan pengetahuan ini, Anda akan dapat menciptakan halaman web yang lebih dinamis, responsif, dan terstruktur dengan baik. Selamat mencoba dan semoga sukses dalam pengembangan web Anda! 🚀💻</p>'
        ]);



        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'Formulir Lanjutan',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 2,
            'detail' => '<p>Selamat datang di bab kedua dari kursus HTML lanjutan! Di sini, kita akan menjelajahi cara menggunakan elemen formulir yang lebih canggih dan menerapkan teknik validasi menggunakan HTML5. Tujuannya adalah untuk membuat formulir web yang lebih efektif, interaktif, dan mudah diakses hanya dengan menggunakan HTML.</p>
<hr>
<h3>1. <strong>Elemen Formulir Lanjutan</strong></h3>
<p>HTML5 memperkenalkan beberapa elemen dan atribut baru yang memungkinkan Anda untuk membuat formulir dengan fungsionalitas yang lebih kaya dan spesifik.</p>
<h4><strong>1.1. Elemen </strong><code><strong>&lt;input&gt;</strong></code><strong> dengan Tipe Lanjutan</strong></h4>
<ul>
    <li>
        <p><code><strong>&lt;input type="date"&gt;</strong></code>: Memungkinkan pengguna memilih tanggal dari kalender.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"birthdate"</span><span class="hljs-tag">&gt;</span>Tanggal Lahir:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"date"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"birthdate"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"birthdate"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>&lt;input type="range"&gt;</strong></code>: Menyediakan slider untuk memilih nilai dalam rentang tertentu.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"volume"</span><span class="hljs-tag">&gt;</span>Volume:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"range"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"volume"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"volume"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">min</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"0"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">max</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"100"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">step</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"1"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>&lt;input type="color"&gt;</strong></code>: Memungkinkan pengguna memilih warna dari palet warna.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"favcolor"</span><span class="hljs-tag">&gt;</span>Warna Favorit:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"color"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"favcolor"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"favcolor"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#ff0000"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<h4><strong>1.2. Elemen </strong><code><strong>&lt;select&gt;</strong></code><strong> dan </strong><code><strong>&lt;datalist&gt;</strong></code></h4>
<ul>
    <li>
        <p><code><strong>&lt;select&gt;</strong></code>: Digunakan untuk membuat menu dropdown dengan beberapa opsi.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"car"</span><span class="hljs-tag">&gt;</span>Mobil:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">select</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"car"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"car"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"audi"</span><span class="hljs-tag">&gt;</span>Audi<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"bmw"</span><span class="hljs-tag">&gt;</span>BMW<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"ford"</span><span class="hljs-tag">&gt;</span>Ford<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">select</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>&lt;datalist&gt;</strong></code>: Memberikan daftar opsi untuk input teks, mendukung autocompletion.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruit"</span><span class="hljs-tag">&gt;</span>Buah:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">list</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruits"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruit"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruit"</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">datalist</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fruits"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Apple"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Banana"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Cherry"</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">datalist</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<h4><strong>1.3. Elemen </strong><code><strong>&lt;textarea&gt;</strong></code><strong> dan </strong><code><strong>&lt;button&gt;</strong></code></h4>
<ul>
    <li>
        <p><code><strong>&lt;textarea&gt;</strong></code>: Untuk input teks yang memungkinkan baris dan kolom lebih banyak.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"message"</span><span class="hljs-tag">&gt;</span>Pesan:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">textarea</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"message"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"message"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">rows</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"4"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">cols</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"50"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">textarea</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>&lt;button&gt;</strong></code>: Untuk membuat tombol yang dapat dikustomisasi.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">button</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"button"</span><span class="hljs-tag">&gt;</span>Klik Saya<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">button</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3>2. <strong>Validasi Formulir</strong></h3>
<p>HTML5 memperkenalkan berbagai atribut untuk melakukan validasi formulir di sisi klien tanpa memerlukan JavaScript.</p>
<h4><strong>2.1. Validasi dengan Atribut HTML5</strong></h4>
<ul>
    <li>
        <p><code><strong>required</strong></code>: Menandai input yang wajib diisi.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"username"</span><span class="hljs-tag">&gt;</span>Nama Pengguna:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"text"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"username"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"username"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>minlength</strong></code><strong> dan </strong><code><strong>maxlength</strong></code>: Menentukan panjang minimum dan maksimum untuk input teks.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag">&gt;</span>Kata Sandi:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">minlength</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"6"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">maxlength</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"20"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>pattern</strong></code>: Memastikan input sesuai dengan pola reguler tertentu.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag">&gt;</span>Email:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">pattern</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>min</strong></code><strong> dan </strong><code><strong>max</strong></code>: Untuk elemen numerik seperti <code>number</code>, <code>range</code>, dan <code>date</code>.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag">&gt;</span>Usia:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"number"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">min</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"1"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">max</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"120"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<h4><strong>2.2. Penggunaan Atribut Validasi Lainnya</strong></h4>
<ul>
    <li>
        <p><code><strong>type="email"</strong></code>: Memastikan bahwa input memenuhi format email yang valid.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"useremail"</span><span class="hljs-tag">&gt;</span>Email Pengguna:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"useremail"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"useremail"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>type="url"</strong></code>: Memastikan bahwa input adalah URL yang valid.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"website"</span><span class="hljs-tag">&gt;</span>Website:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"url"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"website"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"website"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3>3. <strong>Praktik Terbaik dalam Mendesain Formulir</strong></h3>
<p>Meskipun HTML5 memungkinkan banyak kontrol dan validasi di sisi klien, penting untuk mendesain formulir dengan mempertimbangkan aksesibilitas dan pengalaman pengguna.</p>
<h4><strong>3.1. Label yang Jelas</strong></h4>
<p>Setiap elemen input harus memiliki label yang jelas untuk membantu pengguna memahami informasi apa yang perlu dimasukkan.</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"phone"</span><span class="hljs-tag">&gt;</span>Nomor Telepon:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"tel"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"phone"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"phone"</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<h4><strong>3.2. Petunjuk dan Umpan Balik Visual</strong></h4>
<p>Memberikan petunjuk dan umpan balik visual untuk membantu pengguna mengisi formulir dengan benar.</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag">&gt;</span>Usia:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"number"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">min</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"1"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">max</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"120"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;</span>Masukkan usia Anda dalam rentang 1 hingga 120.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3><strong>Latihan</strong></h3>
<p>Cobalah untuk membuat formulir dengan berbagai elemen dan atribut yang telah dibahas di atas. Pastikan untuk menggunakan atribut validasi yang tepat dan mendesain formulir agar mudah diakses oleh semua pengguna.</p>
<hr>
<h3>Sumber Belajar Tambahan</h3>
<ul>
    <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=example"><a rel="noopener" target="_new"><strong>Tutorial Formulir HTML5 Lanjutan</strong></a></a></li>
</ul>
<hr>
<p>Dengan memahami elemen dan teknik validasi HTML ini, Anda akan dapat membuat formulir web yang lebih efektif dan ramah pengguna. Selamat mencoba! 🚀📋</p>'
        ]);


        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'Media dan Grafik di HTML',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 2,
            'detail' => '<p>Selamat datang di Bab 3! Kali ini, kita akan membahas cara menggunakan media dan grafik dalam HTML untuk membuat halaman web Anda lebih interaktif dan menarik. Kita akan melihat cara menyematkan gambar, video, dan audio, serta bagaimana menggunakan elemen HTML5 untuk bekerja dengan berbagai jenis media.</p>
<hr>
<h3>1. <strong>Menambahkan Gambar</strong></h3>
<p>Gambar adalah elemen penting dalam halaman web, membantu memperjelas dan mempercantik konten. Berikut adalah cara menggunakan elemen <code>&lt;img&gt;</code> untuk menampilkan gambar.</p>
<h4><strong>1.1. Elemen </strong><code><strong>&lt;img&gt;</strong></code></h4>
<p>Elemen <code>&lt;img&gt;</code> digunakan untuk menampilkan gambar di halaman web. Anda perlu menyediakan dua atribut utama: <code>src</code> (sumber) dan <code>alt</code> (teks alternatif).</p>
<ul>
    <li><strong>Atribut </strong><code><strong>src</strong></code>: Menentukan URL atau jalur menuju gambar.</li>
    <li><strong>Atribut </strong><code><strong>alt</strong></code>: Memberikan deskripsi gambar untuk aksesibilitas dan jika gambar tidak dapat ditampilkan.</li>
</ul>
<p>Contoh:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"gambar/budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar Budi"</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<h4><strong>1.2. Menentukan Ukuran Gambar</strong></h4>
<p>Anda dapat mengatur ukuran gambar menggunakan atribut <code>width</code> dan <code>height</code>.</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"gambar/budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar Budi"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">width</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"300"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">height</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"200"</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<h4><strong>1.3. Menyematkan Gambar dari URL</strong></h4>
<p>Anda juga bisa menggunakan URL langsung untuk gambar dari internet.</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"https://www.example.com/gambar/budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar Budi"</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>2. <strong>Menambahkan Video</strong></h3>
<p>HTML5 memungkinkan Anda menyematkan video secara langsung ke halaman web menggunakan elemen <code>&lt;video&gt;</code>.</p>
<h4><strong>2.1. Elemen </strong><code><strong>&lt;video&gt;</strong></code></h4>
<p>Elemen <code>&lt;video&gt;</code> digunakan untuk menampilkan video di halaman web. Anda dapat menentukan sumber video dan memberikan kontrol pemutaran kepada pengguna.</p>
<ul>
    <li><strong>Atribut </strong><code><strong>src</strong></code>: Menentukan jalur atau URL video.</li>
    <li><strong>Atribut </strong><code><strong>controls</strong></code>: Menambahkan kontrol pemutaran video seperti play, pause, dan volume.</li>
</ul>
<p>Contoh:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"video/sample.mp4"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">controls</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Browser Anda tidak mendukung elemen video. Anda dapat menonton video ini di <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"video/sample.mp4"</span><span class="hljs-tag">&gt;</span>tautan ini<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<h4><strong>2.2. Menambahkan Subtitle</strong></h4>
<p>Jika video Anda memiliki subtitle, Anda dapat menambahkannya dengan elemen <code>&lt;track&gt;</code>.</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"video/sample.mp4"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">controls</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">track</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"subtitles/english.vtt"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">kind</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"subtitles"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">srclang</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"en"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">label</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"English"</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Browser Anda tidak mendukung elemen video.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>3. <strong>Menambahkan Audio</strong></h3>
<p>Elemen <code>&lt;audio&gt;</code> digunakan untuk menyematkan file audio ke dalam halaman web.</p>
<h4><strong>3.1. Elemen </strong><code><strong>&lt;audio&gt;</strong></code></h4>
<p>Seperti elemen <code>&lt;video&gt;</code>, elemen <code>&lt;audio&gt;</code> dapat menyediakan kontrol pemutaran audio kepada pengguna.</p>
<ul>
    <li><strong>Atribut </strong><code><strong>src</strong></code>: Menentukan jalur atau URL file audio.</li>
    <li><strong>Atribut </strong><code><strong>controls</strong></code>: Menambahkan kontrol pemutaran audio.</li>
</ul>
<p>Contoh:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">audio</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"audio/sample.mp3"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">controls</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Browser Anda tidak mendukung elemen audio. Anda dapat mendengarkan audio ini di <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"audio/sample.mp3"</span><span class="hljs-tag">&gt;</span>tautan ini<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">audio</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>4. <strong>Menggunakan Elemen </strong><code><strong>&lt;figure&gt;</strong></code><strong> dan </strong><code><strong>&lt;figcaption&gt;</strong></code></h3>
<p>Elemen <code>&lt;figure&gt;</code> digunakan untuk membungkus gambar atau media lain bersama dengan keterangan. Elemen <code>&lt;figcaption&gt;</code> memberikan keterangan atau deskripsi untuk konten di dalam <code>&lt;figure&gt;</code>.</p>
<h4><strong>4.1. Elemen </strong><code><strong>&lt;figure&gt;</strong></code><strong> dan </strong><code><strong>&lt;figcaption&gt;</strong></code></h4>
<p>Contoh penggunaan:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"gambar/sample.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Contoh Gambar"</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;</span>Ini adalah keterangan untuk gambar.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3><strong>Latihan</strong></h3>
<p>Cobalah untuk menambahkan berbagai jenis media ke halaman web Anda menggunakan elemen yang telah dibahas di atas. Sertakan gambar, video, dan audio, dan pastikan untuk menggunakan atribut yang tepat untuk mengoptimalkan aksesibilitas dan pengalaman pengguna.</p>
<hr>
<h3>Sumber Belajar Tambahan</h3>
<ul>
    <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=example"><a rel="noopener" target="_new"><strong>Tutorial Media HTML5</strong></a></a></li>
</ul>
<hr>
<p>Dengan memahami cara menambahkan dan mengelola media di HTML, Anda dapat membuat halaman web yang lebih menarik dan informatif. Selamat bereksperimen dengan media di halaman web Anda! 🎥🎵📸</p>'
        ]);


        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'Formulir dan Validasi di HTML',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 2,
            'detail' => '<p>Selamat datang di Bab 4! Di bab ini, kita akan membahas elemen formulir HTML yang memungkinkan pengguna untuk memasukkan data, serta cara melakukan validasi input untuk memastikan data yang dikirimkan sesuai dengan yang diharapkan. Formulir adalah bagian penting dari banyak aplikasi web, dan memahami cara kerjanya akan membantu Anda membangun antarmuka pengguna yang efektif.</p>
<hr>
<h3>1. <strong>Membuat Formulir</strong></h3>
<p>Formulir di HTML digunakan untuk mengumpulkan data dari pengguna. Elemen utama dalam formulir adalah elemen <code>&lt;form&gt;</code>, yang berisi berbagai elemen input seperti <code>&lt;input&gt;</code>, <code>&lt;select&gt;</code>, dan <code>&lt;textarea&gt;</code>.</p>
<h4><strong>1.1. Elemen </strong><code><strong>&lt;form&gt;</strong></code></h4>
<p>Elemen <code>&lt;form&gt;</code> mendefinisikan awal dan akhir formulir. Anda perlu menentukan atribut <code>action</code> (URL ke mana data formulir dikirim) dan <code>method</code> (metode HTTP yang digunakan, seperti <code>GET</code> atau <code>POST</code>).</p>
<p>Contoh:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">form</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">action</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"/submit"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">method</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"post"</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-comment">&lt;!-- Elemen input akan ditempatkan di sini --&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">form</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>2. <strong>Elemen Input</strong></h3>
<p>Elemen <code>&lt;input&gt;</code> adalah elemen dasar dalam formulir HTML yang dapat digunakan untuk berbagai jenis data.</p>
<h4><strong>2.1. Jenis Input</strong></h4>
<p>Berikut adalah beberapa tipe input yang sering digunakan:</p>
<ul>
    <li>
        <p><strong>Text</strong>: Untuk teks biasa.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"name"</span><span class="hljs-tag">&gt;</span>Nama:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"text"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"name"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"name"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Password</strong>: Untuk kata sandi, menampilkan teks sebagai titik-titik.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag">&gt;</span>Kata Sandi:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"password"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Email</strong>: Untuk input email, dengan validasi format email.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag">&gt;</span>Email:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Number</strong>: Untuk input angka dengan validasi batas.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag">&gt;</span>Umur:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"number"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">min</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"0"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">max</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"120"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Checkbox</strong>: Untuk pilihan biner.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"subscribe"</span><span class="hljs-tag">&gt;</span>Langganan Newsletter:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"checkbox"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"subscribe"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"subscribe"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"yes"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Radio</strong>: Untuk pilihan eksklusif.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Jenis Kelamin:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"male"</span><span class="hljs-tag">&gt;</span>Pria:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"radio"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"male"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"gender"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"male"</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"female"</span><span class="hljs-tag">&gt;</span>Wanita:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"radio"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"female"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"gender"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"female"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Submit</strong>: Tombol untuk mengirim formulir.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"submit"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Kirim"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Reset</strong>: Tombol untuk mengatur ulang formulir.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"reset"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Reset"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3>3. <strong>Menambahkan Label</strong></h3>
<p>Label penting untuk aksesibilitas. Gunakan elemen <code>&lt;label&gt;</code> untuk menghubungkan label dengan elemen input menggunakan atribut <code>for</code> yang cocok dengan <code>id</code> elemen input.</p>
<p>Contoh:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"username"</span><span class="hljs-tag">&gt;</span>Nama Pengguna:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"text"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"username"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"username"</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>4. <strong>Formulir Teks Area dan Pilihan</strong></h3>
<h4><strong>4.1. Elemen </strong><code><strong>&lt;textarea&gt;</strong></code></h4>
<p>Digunakan untuk input teks yang lebih panjang.</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"message"</span><span class="hljs-tag">&gt;</span>Pesan:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">textarea</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"message"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"message"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">rows</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"4"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">cols</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"50"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">textarea</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<h4><strong>4.2. Elemen </strong><code><strong>&lt;select&gt;</strong></code><strong> dan </strong><code><strong>&lt;option&gt;</strong></code></h4>
<p>Digunakan untuk dropdown menu.</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p><span>html</span></p>
        <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                    </svg>Salin kode</button></span></div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"country"</span><span class="hljs-tag">&gt;</span>Negara:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">select</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"country"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"country"</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"us"</span><span class="hljs-tag">&gt;</span>Amerika Serikat<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"uk"</span><span class="hljs-tag">&gt;</span>Inggris<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">value</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"fr"</span><span class="hljs-tag">&gt;</span>Prancis<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">option</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">select</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h3>5. <strong>Validasi Formulir</strong></h3>
<p>HTML5 menyediakan beberapa atribut untuk validasi input formulir secara otomatis.</p>
<h4><strong>5.1. Atribut Validasi</strong></h4>
<ul>
    <li>
        <p><code><strong>required</strong></code>: Menandai bahwa input ini harus diisi.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"name"</span><span class="hljs-tag">&gt;</span>Nama:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"text"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"name"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"name"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>pattern</strong></code>: Memastikan input sesuai dengan pola regex.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"phone"</span><span class="hljs-tag">&gt;</span>Nomor Telepon:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"text"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"phone"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"phone"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">pattern</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"\d{10}"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">title</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Masukkan nomor telepon 10 digit"</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>min</strong></code><strong> dan </strong><code><strong>max</strong></code>: Mengatur batasan untuk input angka dan tanggal.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag">&gt;</span>Umur:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"number"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"age"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">min</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"1"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">max</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"100"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
    <li>
        <p><code><strong>type="email"</strong></code>: Validasi format email.</p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
                <p><span>html</span></p>
                <div class="flex items-center"><span class="" data-state="closed"><button class="flex gap-1 items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5C7 3.34315 8.34315 2 10 2H19C20.6569 2 22 3.34315 22 5V14C22 15.6569 20.6569 17 19 17H17V19C17 20.6569 15.6569 22 14 22H5C3.34315 22 2 20.6569 2 19V10C2 8.34315 3.34315 7 5 7H7V5ZM9 7H14C15.6569 7 17 8.34315 17 10V15H19C19.5523 15 20 14.5523 20 14V5C20 4.44772 19.5523 4 19 4H10C9.44772 4 9 4.44772 9 5V7ZM5 9C4.44772 9 4 9.44772 4 10V19C4 19.5523 4.44772 20 5 20H14C14.5523 20 15 19.5523 15 19V10C15 9.44772 14.5523 9 14 9H5Z" fill="currentColor"></path>
                            </svg>Salin kode</button></span></div>
            </div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">for</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag">&gt;</span>Email:<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">label</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">input</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">type</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">name</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"email"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">required</span><span class="hljs-tag">&gt;</span>
                </code></div>
        </div>
    </li>
</ul>
<hr>
<h3><strong>Latihan</strong></h3>
<p>Cobalah membuat formulir lengkap menggunakan elemen yang telah dibahas. Sertakan berbagai jenis input, tambahkan label yang sesuai, dan terapkan validasi untuk memastikan data yang dikumpulkan sesuai dengan yang diharapkan.</p>
<hr>
<h3>Sumber Belajar Tambahan</h3>
<ul>
    <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=example"><a rel="noopener" target="_new"><strong>Tutorial Formulir HTML5</strong></a></a></li>
</ul>
<hr>
<p>Dengan memahami cara membuat dan memvalidasi formulir, Anda dapat membangun antarmuka pengguna yang efektif dan responsif. Selamat mencoba dan semoga sukses dalam pengembangan web Anda! 📝💻</p>'
        ]);


        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Gyanakaya sangat membantu dalam memahami coding dengan cara yang menyenangkan dan interaktif.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Materi di Gyanakaya disusun dengan baik, cocok untuk pemula yang ingin belajar coding.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Saya sangat terbantu dengan tutorial yang jelas dan mudah diikuti di Gyanakaya.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Gyanakaya menyediakan platform yang sangat bermanfaat bagi mereka yang ingin belajar coding online.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Belajar coding jadi lebih mudah dengan materi yang terstruktur di Gyanakaya.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Gyanakaya memberikan pengalaman belajar yang sangat baik dan efektif.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Platform yang sangat direkomendasikan untuk siapa saja yang ingin belajar coding dari dasar.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Saya sangat puas dengan Gyanakaya, konten yang disediakan sangat berkualitas dan membantu.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Materi yang disediakan Gyanakaya benar-benar mudah dipahami, bahkan untuk pemula.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => 'Gyanakaya adalah platform yang luar biasa untuk mempelajari coding dengan cepat dan efektif.',
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
    }
}
