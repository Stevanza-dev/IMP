<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\WorkProgram;
use App\Models\SocialMedia;
use Carbon\Carbon;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // 1. SEED SOCIAL MEDIA
        // ==========================================
        $socials = [
            [
                'name' => 'Instagram',
                'url' => 'https://instagram.com/imp_pati',
                'icon_class' => 'fab fa-instagram', // Class FontAwesome
            ],
            [
                'name' => 'TikTok',
                'url' => 'https://tiktok.com/@imp_pati',
                'icon_class' => 'fab fa-tiktok',
            ],
            [
                'name' => 'YouTube',
                'url' => 'https://youtube.com/c/imppati',
                'icon_class' => 'fab fa-youtube',
            ],
            [
                'name' => 'Email',
                'url' => 'mailto:official@imp-pati.org',
                'icon_class' => 'fas fa-envelope',
            ],
        ];

        foreach ($socials as $soc) {
            SocialMedia::create($soc);
        }

        // ==========================================
        // 2. SEED DIVISIONS & PROKER
        // ==========================================
        
        // --- Divisi 1: Pendidikan & Penalaran (Menampung SI SEMAR) ---
        $pendidikan = Division::create([
            'name' => 'Departemen Pendidikan & Penalaran',
            'description' => 'Fokus pada pengembangan akademik anggota dan memfasilitasi pelajar Pati untuk melanjutkan pendidikan tinggi.',
            'logo' => 'education.png', // Placeholder
        ]);

        WorkProgram::create([
            'division_id' => $pendidikan->id,
            'name' => 'SI SEMAR 2026',
            'description' => 'Simulasi Seleksi Masuk Perguruan Tinggi Negeri dan sosialisasi kampus untuk pelajar SMA se-Kabupaten Pati.',
            'execution_date' => Carbon::create(2026, 1, 25), // 25 Jan 2026
            'is_active' => true,
        ]);
        
        WorkProgram::create([
            'division_id' => $pendidikan->id,
            'name' => 'Webinar Beasiswa',
            'description' => 'Sharing session mengenai tips dan trik mendapatkan beasiswa kuliah.',
            'execution_date' => Carbon::create(2025, 8, 10),
            'is_active' => true,
        ]);


        // --- Divisi 2: Pengabdian Masyarakat (Menampung AMPERA) ---
        $sosmas = Division::create([
            'name' => 'Departemen Pengabdian Masyarakat',
            'description' => 'Wadah kontribusi nyata mahasiswa IMP kepada masyarakat Pati melalui kegiatan sosial dan lingkungan.',
            'logo' => 'sosmas.png',
        ]);

        WorkProgram::create([
            'division_id' => $sosmas->id,
            'name' => 'AMPERA 2026',
            'description' => 'Aksi Mahasiswa Peduli Rakyat: Kegiatan bakti sosial, pengobatan gratis, dan penanaman 1000 pohon.',
            'execution_date' => Carbon::create(2026, 1, 18), // 18 Jan 2026
            'is_active' => true,
        ]);

        WorkProgram::create([
            'division_id' => $sosmas->id,
            'name' => 'IMP Mengajar',
            'description' => 'Kegiatan relawan mengajar di desa-desa terpencil di Kabupaten Pati.',
            'execution_date' => Carbon::create(2025, 11, 20),
            'is_active' => true,
        ]);


        // --- Divisi 3: PSDM (Pengembangan Sumber Daya Manusia) ---
        $psdm = Division::create([
            'name' => 'Departemen PSDM',
            'description' => 'Bertanggung jawab atas kaderisasi, upgrading skill, dan soliditas internal antar anggota IMP.',
            'logo' => 'psdm.png',
        ]);

        WorkProgram::create([
            'division_id' => $psdm->id,
            'name' => 'Latihan Dasar Kepemimpinan (LDK)',
            'description' => 'Pembekalan materi kepemimpinan untuk anggota baru IMP.',
            'execution_date' => Carbon::create(2025, 3, 15),
            'is_active' => true,
        ]);

        WorkProgram::create([
            'division_id' => $psdm->id,
            'name' => 'Makrab Anggota',
            'description' => 'Malam keakraban untuk mempererat tali persaudaraan.',
            'execution_date' => Carbon::create(2025, 6, 12),
            'is_active' => true,
        ]);


        // --- Divisi 4: Komunikasi & Informasi (Kominfo) ---
        $kominfo = Division::create([
            'name' => 'Departemen Kominfo',
            'description' => 'Ujung tombak publikasi, pengelolaan sosial media, dan dokumentasi kegiatan organisasi.',
            'logo' => 'kominfo.png',
        ]);

        WorkProgram::create([
            'division_id' => $kominfo->id,
            'name' => 'Workshop Desain Grafis',
            'description' => 'Pelatihan Canva dan Photoshop untuk anggota IMP.',
            'execution_date' => Carbon::create(2025, 5, 20),
            'is_active' => true,
        ]);


        // --- Divisi 5: Minat & Bakat (Mikat) ---
        $mikat = Division::create([
            'name' => 'Departemen Minat & Bakat',
            'description' => 'Mewadahi penyaluran hobi anggota di bidang olahraga dan seni.',
            'logo' => 'mikat.png',
        ]);

        WorkProgram::create([
            'division_id' => $mikat->id,
            'name' => 'IMP Cup (Futsal & Badminton)',
            'description' => 'Turnamen olahraga antar mahasiswa daerah.',
            'execution_date' => Carbon::create(2025, 9, 10),
            'is_active' => true,
        ]);


        // --- Divisi 6: Ekonomi Kreatif (Danus) ---
        $ekraf = Division::create([
            'name' => 'Departemen Ekonomi Kreatif',
            'description' => 'Membangun kemandirian finansial organisasi melalui usaha dana usaha dan merchandise.',
            'logo' => 'ekraf.png',
        ]);

        WorkProgram::create([
            'division_id' => $ekraf->id,
            'name' => 'Penjualan Merchandise Resmi',
            'description' => 'Pre-order kaos, PDH, dan gantungan kunci IMP.',
            'execution_date' => Carbon::create(2025, 2, 1),
            'is_active' => true,
        ]);


        // --- Divisi 7: Hubungan Masyarakat (Humas) ---
        $humas = Division::create([
            'name' => 'Departemen Humas',
            'description' => 'Menjalin relasi dengan organisasi daerah lain, pemerintah daerah, dan alumni.',
            'logo' => 'humas.png',
        ]);

        WorkProgram::create([
            'division_id' => $humas->id,
            'name' => 'Sowan Alumni',
            'description' => 'Kunjungan ke tokoh alumni IMP untuk memperkuat jejaring.',
            'execution_date' => Carbon::create(2025, 4, 5),
            'is_active' => true,
        ]);


        // --- Divisi 8: Pemberdayaan Perempuan ---
        $pp = Division::create([
            'name' => 'Departemen Pemberdayaan Perempuan',
            'description' => 'Wadah diskusi dan aksi mengenai isu-isu perempuan dan kesetaraan gender.',
            'logo' => 'pp.png',
        ]);

        WorkProgram::create([
            'division_id' => $pp->id,
            'name' => 'Kartini Day Celebration',
            'description' => 'Talkshow inspiratif wanita masa kini.',
            'execution_date' => Carbon::create(2025, 4, 21),
            'is_active' => true,
        ]);
    }
}