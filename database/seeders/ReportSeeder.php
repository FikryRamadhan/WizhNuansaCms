<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReportSeeder extends Seeder
{
    public function run()
    {
        $reports = [
            [
                'title' => 'Festival Seni dan Budaya Kuningan 2025 Resmi Dibuka',
                'report' => 'Pemerintah Kabupaten Kuningan resmi membuka Festival Seni dan Budaya 2025 yang berlangsung selama seminggu, menampilkan berbagai kesenian lokal seperti tari topeng, angklung, dan pameran UMKM.',
                'source' => 'Diskominfo Kuningan',
                'date' => Carbon::parse('2025-03-12 10:00:00'),
                'image' => 'festival_seni_2025.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kebun Raya Kuningan Tambah 50 Jenis Flora Langka',
                'report' => 'Dalam rangka konservasi, Kebun Raya Kuningan kini menambahkan 50 jenis flora langka asal Jawa Barat untuk meningkatkan edukasi dan pelestarian lingkungan.',
                'source' => 'Radar Kuningan',
                'date' => Carbon::parse('2025-03-18 09:30:00'),
                'image' => 'flora_langka_kebunraya.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Perbaikan Jalan Utama Jalaksana Dimulai Pekan Ini',
                'report' => 'Dinas PU Kuningan memulai proyek perbaikan jalan utama Jalaksana hingga Kramatmulya, ditargetkan selesai dalam waktu dua bulan.',
                'source' => 'KuninganMass',
                'date' => Carbon::parse('2025-04-02 08:00:00'),
                'image' => 'perbaikan_jalan_jalaksana.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gunung Ciremai Kembali Dibuka untuk Pendakian',
                'report' => 'Balai TNGC membuka kembali jalur pendakian Gunung Ciremai setelah ditutup selama musim hujan demi keamanan dan konservasi.',
                'source' => 'TNGC Official',
                'date' => Carbon::parse('2025-03-29 06:45:00'),
                'image' => 'ciremai_pendakian_dibuka.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pemkab Luncurkan Aplikasi Wisata Digital “KuninganGo”',
                'report' => 'Pemerintah Kuningan resmi meluncurkan aplikasi wisata digital bernama “KuninganGo” yang mempermudah wisatawan menemukan lokasi wisata, kuliner, dan penginapan.',
                'source' => 'Pemkab Kuningan',
                'date' => Carbon::parse('2025-04-01 11:20:00'),
                'image' => 'kuningan_go_app.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Curug Sidomba Tuai Apresiasi Sebagai Wisata Ramah Keluarga',
                'report' => 'Curug Sidomba mendapatkan penghargaan dari Dinas Pariwisata Jawa Barat sebagai salah satu destinasi ramah keluarga dengan fasilitas lengkap.',
                'source' => 'JabarNews',
                'date' => Carbon::parse('2025-03-22 15:45:00'),
                'image' => 'curug_sidomba_award.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kenaikan Harga Cabai di Pasar Baru Kuningan Capai 30%',
                'report' => 'Harga cabai rawit merah dan cabai merah besar di Pasar Baru Kuningan naik drastis akibat pasokan yang menurun dari daerah penghasil.',
                'source' => 'Kuningan Pos',
                'date' => Carbon::parse('2025-04-05 07:30:00'),
                'image' => 'harga_cabai_naik.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mahasiswa Kuningan Kembangkan Robot Pemadam Api Mini',
                'report' => 'Mahasiswa STIKKU berhasil membuat robot pemadam api mini untuk digunakan dalam simulasi keselamatan di sekolah-sekolah.',
                'source' => 'STIKKU News',
                'date' => Carbon::parse('2025-03-25 13:15:00'),
                'image' => 'robot_pemadam_mahasiswa.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Desa Cibuntu Terpilih Jadi Desa Wisata Terbaik Nasional',
                'report' => 'Desa Cibuntu kembali mencatat prestasi sebagai desa wisata terbaik nasional versi Kemenparekraf dengan program wisata budaya dan alam.',
                'source' => 'Kompas Travel',
                'date' => Carbon::parse('2025-04-03 12:00:00'),
                'image' => 'desa_cibuntu.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pelajar SMK di Kuningan Ciptakan Motor Listrik Sendiri',
                'report' => 'Siswa SMK Negeri 1 Kuningan menciptakan prototype motor listrik rakitan lokal sebagai proyek akhir tahun ajaran.',
                'source' => 'SMKN 1 Official',
                'date' => Carbon::parse('2025-03-20 10:00:00'),
                'image' => 'motor_listrik_smk.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('reports')->insert($reports);
    }
}
