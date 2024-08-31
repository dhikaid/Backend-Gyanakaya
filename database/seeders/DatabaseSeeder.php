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
            'detail' => '<h3>Memahami HTML dengan Gaya Kekinian</h3>
<h4>Heading: Buat Judul yang Berkelas!</h4>
<p>Tag <code>&lt;h1&gt;</code> hingga <code>&lt;h6&gt;</code> dipakai buat bikin judul (heading) dengan ukuran dan kepentingan yang berbeda. Penasaran bedanya? Nih, lihat!</p>
<ul>
    <li><code><strong>&lt;h1&gt;</strong></code><strong>:</strong> Judul utama dengan ukuran paling besar dan paling penting, font-nya 200% dari ukuran dasar.</li>
    <li><code><strong>&lt;h2&gt;</strong></code><strong>:</strong> Judul level dua, masih tebal dan besar, tapi cuma 150% dari ukuran dasar.</li>
    <li><code><strong>&lt;h3&gt;</strong></code><strong>:</strong> Sedikit lebih kecil, dengan ukuran 117%, cocok buat subjudul.</li>
    <li><code><strong>&lt;h4&gt;</strong></code><strong>:</strong> Lebih kecil lagi, dengan ukuran sama kayak font biasa (100%).</li>
    <li><code><strong>&lt;h5&gt;</strong></code><strong>:</strong> Mulai mengecil, cuma 83% dari ukuran font dasar.</li>
    <li><code><strong>&lt;h6&gt;</strong></code><strong>:</strong> Paling kecil, dengan ukuran 67% dari font dasar, tapi tetap penting!</li>
</ul>
<p>Kenapa heading penting? Karena selain bikin konten lebih rapi, mesin pencari juga suka! Ini membantu SEO buat ningkatin visibilitas di Google.</p>
<hr>
<h4>Paragraf: Pisahin Ide dengan Gaya</h4>
<p>Tag <code>&lt;p&gt;</code> dipakai buat bikin paragraf. Mau nulis artikel panjang tapi gak mau bikin pembaca pusing? Paragraf adalah solusinya!</p>
<p>&nbsp;</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah contoh penggunaan tag paragraf.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<p>Paragraf bikin teks lebih mudah dibaca dan dipahami. Siapa sih yang mau baca tulisan panjang tanpa jeda?</p>
<hr>
<h4>Teks Tebal: Tonjolkan Poin Penting!</h4>
<p>Mau ada yang diperhatiin lebih? Bikin teksnya tebal!</p>
<ul>
    <li><code><strong>&lt;b&gt;</strong></code><strong>:</strong> Tag ini bikin teks jadi tebal tanpa embel-embel.</li>
    <li><code><strong>&lt;strong&gt;</strong></code><strong>:</strong> Mirip <code>&lt;b&gt;</code>, tapi juga menambahkan penekanan (emphasis).</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p>&nbsp;</p>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Contoh: <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">b</span><span class="hljs-tag">&gt;</span>Ini teks tebal pertama<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">b</span><span class="hljs-tag">&gt;</span> dan <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">strong</span><span class="hljs-tag">&gt;</span>ini teks tebal kedua<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">strong</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h4>Teks Miring: Sentuhan Gaya dengan Italic</h4>
<p>Mau kasih efek dramatis atau penekanan? Miringin teksnya!</p>
<ul>
    <li><code><strong>&lt;i&gt;</strong></code><strong>:</strong> Bikin teks jadi miring (italic) buat gaya.</li>
    <li><code><strong>&lt;em&gt;</strong></code><strong>:</strong> Bikin teks miring sambil nunjukin penekanan (emphasis).</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p>&nbsp;</p>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Teks <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">i</span><span class="hljs-tag">&gt;</span>italic<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">i</span><span class="hljs-tag">&gt;</span> bisa kita gunakan untuk <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">em</span><span class="hljs-tag">&gt;</span>menekankan<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">em</span><span class="hljs-tag">&gt;</span> suatu kalimat.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h4>Garis Bawah: Highlight Pentingnya!</h4>
<p>Ingin menekankan sesuatu yang penting? Garis bawah aja!</p>
<ul>
    <li><code><strong>&lt;u&gt;</strong></code><strong>:</strong> Bikin underline (garis bawah) di teks.</li>
    <li><code><strong>&lt;ins&gt;</strong></code><strong>:</strong> Mirip <code>&lt;u&gt;</code>, tapi menunjukkan kalau teks ini di-insert.</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <div class="flex items-center">&nbsp;</div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Berikutnya adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">u</span><span class="hljs-tag">&gt;</span>menambahkan garis bawah<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">u</span><span class="hljs-tag">&gt;</span> pada kalimat.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h4>Coret-Coret: Buat yang Udah Gak Berlaku</h4>
<p>Kadang ada hal yang udah gak relevan, tinggal coret aja!</p>
<ul>
    <li><code><strong>&lt;s&gt;</strong></code><strong>:</strong> Strikethrough (teks dicoret).</li>
    <li><code><strong>&lt;del&gt;</strong></code><strong>:</strong> Delete (menunjukkan teks yang dihapus).</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <div class="flex items-center">&nbsp;</div>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Coret <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">s</span><span class="hljs-tag">&gt;</span>sesuatu<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">s</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Aku suka mencoret <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">del</span><span class="hljs-tag">&gt;</span>tembok rumah<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">del</span><span class="hljs-tag">&gt;</span> di atas kertas.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h4>Stabilo: Tandai yang Penting Banget!</h4>
<p>Biar gak kelewatan yang penting, stabiloin teksnya!</p>
<ul>
    <li><code><strong>&lt;mark&gt;</strong></code><strong>:</strong> Buat teks kayak distabilo, jadi jelas banget mana yang penting.</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p>&nbsp;</p>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Gunakan <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">mark</span><span class="hljs-tag">&gt;</span>stabilo<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">mark</span><span class="hljs-tag">&gt;</span> untuk hal penting<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h4>Teks Kecil: Detail yang Gak Mau Kelewat</h4>
<p>Buat info kecil atau catatan? Gunakan teks kecil!</p>
<ul>
    <li><code><strong>&lt;small&gt;</strong></code><strong>:</strong> Kecilkan teks dari ukuran normal.</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p>&nbsp;</p>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ini adalah <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;</span>contoh teks kecil<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">small</span><span class="hljs-tag">&gt;</span> yang mudah terbaca.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h4>Daftar: Urutkan atau Acak, Semua Bisa!</h4>
<p>Mau bikin list barang atau langkah-langkah? Pilih antara:</p>
<ul>
    <li><code><strong>&lt;ul&gt;</strong></code><strong>:</strong> Buat daftar tak berurutan (bullets).</li>
    <li><code><strong>&lt;ol&gt;</strong></code><strong>:</strong> Buat daftar berurutan (angka).</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="flex items-center relative text-token-text-secondary bg-token-main-surface-secondary px-4 py-2 text-xs font-sans justify-between rounded-t-md">
        <p>&nbsp;</p>
    </div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Item pertama<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Item kedua<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span>

            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">ol</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Langkah pertama<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>Langkah kedua<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">ol</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<hr>
<h4>Link: Hubungkan Duniamu</h4>
<p>Mau nambahin link ke halaman lain? Pakai tag <code>&lt;a&gt;</code>.</p>
<p>&nbsp;</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"https://www.contoh.com"</span><span class="hljs-tag">&gt;</span>Kunjungi Situs Web<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span></code></div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
        </code></div>
</div>
<p>Jadi, gak cuma tulisan, tapi juga bisa nyambung ke mana aja!</p>
<hr>
<p>Dengan memahami HTML dasar ini, kamu bisa bikin halaman web yang keren, rapi, dan fungsional. Yuk, coba langsung!</p>'
        ]);



        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'HTML dengan Gambar dan Video',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 1,
            'detail' => '<h3>Menampilkan Gambar dan Video di Halaman Web dengan Gaya!</h3>
<h4>Gambar: Biar Halamanmu Lebih Hidup</h4>
<p>Kalau mau nge-embed gambar di halaman web, gampang banget! Gunakan tag <code>&lt;img&gt;</code>. Ini tag sederhana yang nggak butuh tag penutup, tapi harus pakai dua atribut penting: <code>src</code> dan <code>alt</code>.</p>
<ul>
    <li>
        <p><code><strong>src</strong></code><strong>:</strong> Ini kayak alamat rumahnya gambar. Kamu kasih tahu di mana gambar itu disimpan, bisa pakai URL relatif (kalau gambar di folder yang sama) atau URL absolut (link penuh ke gambar).</p>
        <p>&nbsp;</p>
    </li>
</ul>
<p>Contoh simpel kayak gini:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Budi"</span><span class="hljs-tag"> /&gt;</span></code></div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
        </code></div>
</div>
<p>Kalau gambarnya ada di folder lain, misalnya:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar/Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Budi"</span><span class="hljs-tag"> /&gt;</span></code></div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
        </code></div>
</div>
<p>Bahkan, kamu juga bisa panggil gambar dari internet:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"https://www.contoh.com/gambar/Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Budi"</span><span class="hljs-tag"> /&gt;</span></code></div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
        </code></div>
</div>
<ul>
    <li><code><strong>alt</strong></code><strong>:</strong> Ini deskripsi teks dari gambar, yang bakal muncul kalau gambar nggak bisa ditampilkan. Berguna banget kalau internet lemot atau gambarnya rusak. Misalnya:</li>
</ul>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"gambar/Budi.jpg"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">alt</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"Gambar tidak tersedia"</span><span class="hljs-tag"> /&gt;</span>
        </code></div>
</div>
<p>Jadi, kalau gambar gak muncul, pengunjung tetap tahu apa yang harusnya ada di situ.</p>
<hr>
<h4>Video: Nge-Embed Video, Semudah Itu!</h4>
<p>Mau nampilin video di halaman web? Pakai tag <code>&lt;video&gt;</code>. Ini contoh cara simpel buat nyematkan video:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">src</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"rabbit320.webm"</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">controls</span><span class="hljs-tag">&gt;</span>
            &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;Browser kamu nggak mendukung video HTML. Tenang, kamu bisa nonton lewat
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"rabbit320.webm"</span><span class="hljs-tag">&gt;</span>link ini<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span>.
            &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">video</span><span class="hljs-tag">&gt;</span>
        </code></div>
</div>
<p>Ada beberapa hal penting yang harus kamu tahu:</p>
<ul>
    <li><code><strong>src</strong></code><strong>:</strong> Sama kayak gambar, ini buat ngasih tahu di mana video disimpan.</li>
    <li><code><strong>controls</strong></code><strong>:</strong> Ini penting banget! Ini adalah kontrol buat play, pause, volume, dll. Kamu bisa pakai kontrol bawaan browser atau bikin sendiri dengan JavaScript. Tapi yang pasti, kontrol ini harus ada, terutama buat alasan kesehatan seperti epilepsi.</li>
    <li><strong>Fallback Content:</strong> Ini bagian teks di dalam tag <code>&lt;video&gt;</code>, yang muncul kalau browser nggak bisa nampilin videonya. Ini semacam cadangan, jadi pengunjung tetap bisa akses konten videonya, misalnya lewat link.</li>
</ul>
<hr>
<p>Sekarang kamu bisa bikin halaman web yang lebih keren dan interaktif dengan gambar dan video! Yuk, coba-coba langsung di project-mu!</p>'
        ]);
        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => 'HTML semantik',
            'cover' => $this->randomPhoto('cover'),
            'id_materi' => 1,
            'detail' => '<h3>Struktur Semantik di HTML5: Biar Website-mu Lebih Bermakna!</h3>
<p>Ketika kamu bikin website dengan HTML5, ada beberapa tag yang penting banget buat kamu tahu:</p>
<ul>
    <li><strong>Header</strong></li>
    <li><strong>Nav</strong></li>
    <li><strong>Section</strong></li>
    <li><strong>Article</strong></li>
    <li><strong>Aside</strong></li>
    <li><strong>Footer</strong></li>
</ul>
<h4>Kenapa Harus Pakai Struktur Semantik?</h4>
<p>Struktur semantik itu kayak ngasih arti atau makna ke elemen-elemen di web kamu. Ini nggak cuma soal tampilannya aja, tapi lebih ke gimana mesin pencari atau alat bantu (kayak screen reader) bisa lebih paham tentang konten di halamanmu. Intinya, bikin website kamu lebih <i>friendly</i> buat mesin pencari dan lebih mudah dipahami, baik oleh programmer lain maupun pengguna.</p>
<h3>Contoh:</h3>
<p>Tanpa semantik, mungkin kamu sering lihat kode HTML yang kayak gini:</p>
<p>&nbsp;</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"header"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"section"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"article"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"figure"</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">class</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"figcaption"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"footer"</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">div</span><span class="hljs-tag">&gt;</span></code></div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
        </code></div>
</div>
<p>Nah, itu bisa diganti dengan struktur semantik yang lebih jelas dan rapi:</p>
<div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">img</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">figcaption</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">figure</span><span class="hljs-tag">&gt;</span>
            &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">article</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span>
            <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;</span></code></div>
    <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
        </code></div>
</div>
<p>Pakai elemen semantik bikin kodenya lebih gampang dibaca dan dipahami, baik oleh kita yang ngoding maupun mesin pencari. Plus, lebih mudah juga buat teknologi bantu kayak screen reader, jadi web kamu lebih aksesibel.</p>
<hr>
<h3>Penjelasan Tag Semantik yang Wajib Kamu Tahu</h3>
<ol>
    <li>
        <p><strong>Header</strong></p>
        <p>Tag <code>&lt;header&gt;</code> ini biasanya dipakai buat mendefinisikan bagian atas dari halaman atau bagian tertentu. Biasanya, di dalamnya ada judul, navigasi, atau pengantar.</p>
        <p><strong>Contoh:</strong></p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>Selamat Datang di Website Saya<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h1</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Tempat terbaik buat belajar pengembangan web<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">header</span><span class="hljs-tag">&gt;</span></code></div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Nav</strong></p>
        <p>Tag <code>&lt;nav&gt;</code> ini khusus buat bagian navigasi. Di dalamnya ada link-link buat berpindah ke bagian lain dari halaman atau ke halaman lain.</p>
        <p><strong>Contoh:</strong></p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">nav</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#home"</span><span class="hljs-tag">&gt;</span>Beranda<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#about"</span><span class="hljs-tag">&gt;</span>Tentang<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#services"</span><span class="hljs-tag">&gt;</span>Layanan<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp; &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#contact"</span><span class="hljs-tag">&gt;</span>Kontak<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;&lt;/</span><span class="hljs-tag hljs-name">li</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">ul</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">nav</span><span class="hljs-tag">&gt;</span></code></div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Section</strong></p>
        <p>Tag <code>&lt;section&gt;</code> dipakai buat mengelompokkan konten yang berhubungan. Jadi, konten yang ada di dalam satu section itu punya topik atau tema yang sama.</p>
        <p><strong>Contoh:</strong></p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">id</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"home"</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>Beranda<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">h2</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Selamat datang di beranda kami. Di sini kamu bisa lihat pembaruan terbaru dan konten unggulan.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span></code></div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Article</strong></p>
        <p>Tag <code>&lt;article&gt;</code> ini buat konten yang bisa berdiri sendiri dan bisa didistribusikan secara independen. Misalnya, postingan blog atau artikel berita.</p>
        <p><strong>Contoh:</strong></p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
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
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">section</span><span class="hljs-tag">&gt;</span></code></div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
                </code></div>
        </div>
    </li>
    <li>
        <p><strong>Footer</strong></p>
        <p>Tag <code>&lt;footer&gt;</code> ini buat bagian bawah dari dokumen atau bagian tertentu. Biasanya, ada informasi tentang penulis, hak cipta, atau link ke dokumen terkait.</p>
        <p><strong>Contoh:</strong></p>
        <div class="dark bg-gray-950 contain-inline-size rounded-md border-[0.5px] border-token-border-medium">
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html"><span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span><span class="hljs-symbol">&amp;copy;</span> 2024 Situs Web Saya. Semua hak dilindungi.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
                    &nbsp; &nbsp;<span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>Ikuti kami di <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#"</span><span class="hljs-tag">&gt;</span>Twitter<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span> dan <span class="hljs-tag">&lt;</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag"> </span><span class="hljs-tag hljs-attr">href</span><span class="hljs-tag">=</span><span class="hljs-tag hljs-string">"#"</span><span class="hljs-tag">&gt;</span>Facebook<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">a</span><span class="hljs-tag">&gt;</span>.<span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">p</span><span class="hljs-tag">&gt;</span>
                    <span class="hljs-tag">&lt;/</span><span class="hljs-tag hljs-name">footer</span><span class="hljs-tag">&gt;</span></code></div>
            <div class="overflow-y-auto p-4" dir="ltr"><code class="!whitespace-pre hljs language-html">
                </code></div>
        </div>
    </li>
</ol>
<hr>
<p>Mau tahu lebih banyak? Cek video ini buat belajar lebih lanjut: <a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=o3m15BWi2HM"><a rel="noopener" target="_new">Link Video Pembelajaran</a></a>.</p>
<hr>
<p>Dengan pakai struktur semantik, kamu bikin web yang lebih terstruktur, mudah dipahami, dan tentunya lebih <i>cool</i>! Yuk, mulai terapkan di project kamu!</p>'
        ]);



        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
        Reviews::factory()->create([
            'nama' => fake()->name(),
            'review' => fake()->paragraph(1),
            'image' => $this->randomPhoto('reviews'),
            'stars' => rand(1, 5),
        ]);
    }
}
