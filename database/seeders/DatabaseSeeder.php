<?php

namespace Database\Seeders;

use App\Models\Categoryorder;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Order;
use App\Models\Detailorder;
use App\Models\Tenant;
use App\Models\Refund;
use App\Models\detailRefund;
use App\Models\Reschedule;
use App\Models\DetailReschedule;
use App\Models\Payment;
use App\Models\KeluarMasukAlat;
use App\Models\detailKeluarMasukAlat;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'Dita Adetia Nadila',
            'username' => 'ditadetian',
            'email' => 'ditadetian@gmail.com',
            'password' => bcrypt('jinyoung'),
            'foto' => 'users/rxl3B3WlAKIaZc8xxXJMORU3IYLdbKK1o42cEKic.jpg',
            'kontak' => '089693838246',
            'jabatan' => 'admin',
            'nama_jabatan' => 'Staff UPT Alat Berat Dinas Pekerjaan Umum Dan Penataan Ruang Kota Pontianak',
            'pangkat' => 'Penata',
            'nip' => '12345678 9123 4 567',
            'alamat' => 'kotabaru',
            'status' => 'aktif'
        ]);

        User::create([
            'name' => 'Raja Rekha Vahlevie',
            'username' => 'raja_rekha',
            'email' => 'raja@gmail.com',
            'password' => bcrypt('dita'),
            'foto' => 'users/rxl3B3WlAKIaZc8xxXJMORU3IYLdbKK1o42cEKic.jpg',
            'kontak' => '089693838246',
            'jabatan' => 'admin',
            'nama_jabatan' => 'Staff UPT Alat Berat Dinas Pekerjaan Umum Dan Penataan Ruang Kota Pontianak',
            'pangkat' => 'Penata',
            'nip' => '12345678 9123 4 567',
            'alamat' => 'kotabaru',
            'status' => 'aktif'
        ]);

        User::create([
            'name' => 'URAY DENI ANDRIYADI, ST',
            'username' => 'yohenis',
            'email' => 'ditadetyan@gmail.com',
            'password' => bcrypt('yoheni64'),
            'foto' => 'users/rxl3B3WlAKIaZc8xxXJMORU3IYLdbKK1o42cEKic.jpg',
            'kontak' => '089693838246',
            'jabatan' => 'kepala uptd',
            'nama_jabatan' => 'Kepala UPT Alat Berat Dinas Pekerjaan Umum Dan Penataan Ruang Kota Pontianak',
            'pangkat' => 'Penata',
            'nip' => '19761208 2005 1 005',
            'alamat' => 'kotabaru',
            'status' => 'aktif'
        ]);

        User::create([
            'name' => 'Ir. FIRAYANTA, MT',
            'username' => 'pujiaswad',
            'email' => 'ditadetian@student.untan.ac.id',
            'password' => bcrypt('aswadi'),
            'foto' => 'users/rxl3B3WlAKIaZc8xxXJMORU3IYLdbKK1o42cEKic.jpg',
            'kontak' => '085245781234',
            'jabatan' => 'kepala dinas',
            'nama_jabatan' => 'Kepala Dinas Pekerjaan Umum Dan Penataan Ruang Kota Pontianak',
            'pangkat' => 'Pembina Utama Muda',
            'nip' => '19680617 199403 1 011',
            'alamat' => 'kotabaru',
            'status' => 'aktif'
        ]);

        User::create([
            'name' => 'Wilda Nadia Fitria',
            'username' => 'willwillnadia',
            'email' => 'ingforei14@gmail.com',
            'password' => bcrypt('nadine'),
            'foto' => 'users/rxl3B3WlAKIaZc8xxXJMORU3IYLdbKK1o42cEKic.jpg',
            'kontak' => '085245781234',
            'jabatan' => 'bendahara',
            'nama_jabatan' => 'Bendahara Pekerjaan Umum Dan Penataan Ruang Kota Pontianak',
            'pangkat' => 'Pembina Utama Muda',
            'nip' => '19680617 199403 1 011',
            'alamat' => 'kotabaru',
            'status' => 'aktif'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 2,
            'jumlah_tersedia' => 2,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 1,
            'jumlah_tersedia' => 1,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 5,
            'jumlah_tersedia' => 5,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 1,
            'jumlah_tersedia' => 1,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 2,
            'jumlah_tersedia' => 2,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 2,
            'jumlah_tersedia' => 2,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 1,
            'jumlah_tersedia' => 1,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 5,
            'jumlah_tersedia' => 5,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 1,
            'jumlah_tersedia' => 1,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 2,
            'jumlah_tersedia' => 2,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 1,
            'jumlah_tersedia' => 1,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 5,
            'jumlah_tersedia' => 5,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 1,
            'jumlah_tersedia' => 1,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Bachole Loader',
            'foto' => 'equipments/3npZZJUQB9AVN2pd7Gfvxp9xSgMFBnTCA4pdJHGj.png',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 200000,
            'harga_sewa_perhari' => 1240000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        Equipment::create([
            'nama' => 'Dumptruck',
            'foto' => 'equipments/I2yZxekqcQx7VngxIhpLgnyLeefj9l3yn89VC5Zv.jpg',
            'jenis' => 'pengangkut',
            'kegunaan' => 'mengangkut',
            'total' => 3,
            'jumlah_tersedia' => 3,
            'harga_sewa_perjam' => 45000,
            'harga_sewa_perhari' => 360000,
            'keterangan' => 'Bisa dipakai',
            'kondisi' => 'Baik'
        ]);

        // Order::create([
        //     'category_order_id' => 1,
        //     'tenant_id' => 1,
        //     'nama_instansi' => 'Universitas Tanjungpura',
        //     'jabatan' => 'Kepala',
        //     'alamat_instansi' => 'Jl.Dr.Prof. Hadari Nawawi',
        //     'nama_kegiatan' => 'Jembatan Tayan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 2,
        //     'category_order_id' => 1,
        //     'nama_instansi' => 'Muhammadiyah',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Taman Untan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta_notaris/akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 08:00:00',
        //     'tanggal_selesai' => '2021-11-25 15:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'category_order_id' => 1,
        //     'tenant_id' => 1,
        //     'nama_instansi' => 'Universitas Tanjungpura',
        //     'jabatan' => 'Kepala',
        //     'alamat_instansi' => 'Jl.Dr.Prof. Hadari Nawawi',
        //     'nama_kegiatan' => 'Jembatan Tayan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 2,
        //     'category_order_id' => 1,
        //     'nama_instansi' => 'Muhammadiyah',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Taman Untan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'category_order_id' => 1,
        //     'tenant_id' => 1,
        //     'nama_instansi' => 'Universitas Tanjungpura',
        //     'jabatan' => 'Kepala',
        //     'alamat_instansi' => 'Jl.Dr.Prof. Hadari Nawawi',
        //     'nama_kegiatan' => 'Jembatan Tayan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 2,
        //     'category_order_id' => 1,
        //     'nama_instansi' => 'Muhammadiyah',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Taman Untan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'category_order_id' => 1,
        //     'tenant_id' => 1,
        //     'nama_instansi' => 'Universitas Tanjungpura',
        //     'jabatan' => 'Kepala',
        //     'alamat_instansi' => 'Jl.Dr.Prof. Hadari Nawawi',
        //     'nama_kegiatan' => 'Jembatan Tayan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 2,
        //     'category_order_id' => 1,
        //     'nama_instansi' => 'Muhammadiyah',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Taman Untan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'category_order_id' => 1,
        //     'tenant_id' => 1,
        //     'nama_instansi' => 'Universitas Tanjungpura',
        //     'jabatan' => 'Kepala',
        //     'alamat_instansi' => 'Jl.Dr.Prof. Hadari Nawawi',
        //     'nama_kegiatan' => 'Jembatan Tayan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 2,
        //     'category_order_id' => 1,
        //     'nama_instansi' => 'Muhammadiyah',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Taman Untan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'category_order_id' => 1,
        //     'tenant_id' => 1,
        //     'nama_instansi' => 'Universitas Tanjungpura',
        //     'jabatan' => 'Kepala',
        //     'alamat_instansi' => 'Jl.Dr.Prof. Hadari Nawawi',
        //     'nama_kegiatan' => 'Jembatan Tayan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 2,
        //     'category_order_id' => 1,
        //     'nama_instansi' => 'Muhammadiyah',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Taman Untan',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 2,
        //     'category_order_id' => 2,
        //     'nama_instansi' => 'Untan',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Jembatan Kapuas',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Order::create([
        //     'tenant_id' => 1,
        //     'category_order_id' => 3,
        //     'nama_instansi' => 'pupr',
        //     'jabatan' => 'Staff',
        //     'alamat_instansi' => 'Jl.Ayani',
        //     'nama_kegiatan' => 'Jembatan Landak',
        //     'surat_permohonan' => 'permohonan.pdf',
        //     'ttd_pemohon' => '',
        //     'ktp' => 'ktp.jpg',
        //     'akta_notaris' => 'akta.jpg',
        //     'surat_ket' => 'suratket.jpg',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ttd_kepala_uptd' => '',
        //     'ttd_kepala_dinas' => '',
        //     'ket_konfirmasi' => '',
        //     'tanggal_mulai' => '2021-11-25 00:00:00',
        //     'tanggal_selesai' => '2021-12-25 00:00:00',
        //     'dokumen_sewa' => ''
        // ]);

        // Detailorder::create([
        //     'order_id' => 1,
        //     'equipment_id' => 1,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 1,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 2,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 3,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 4,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 5,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 6,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 7,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 8,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 9,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 10,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 11,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 12,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 13,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 14,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Detailorder::create([
        //     'order_id' => 15,
        //     'equipment_id' => 2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '1976-01-01 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Refund::create([
        //     'order_id' => 1,
        //     'tenant_id' => 1,
        //     'surat_permohonan_refund' => 'refund.docx',
        //     'metode_refund' => 'Transfer BNI'
        // ]);

        // Refund::create([
        //     'order_id' => 2,
        //     'tenant_id' => 2,
        //     'surat_permohonan_refund' => 'refund.docx',
        //     'metode_refund' => 'Transfer BCA',
        // ]);

        // Refund::create([
        //     'order_id' => 3,
        //     'tenant_id' => 1,
        //     'surat_permohonan_refund' => 'refund.docx',
        //     'metode_refund' => 'Transfer BNI'
        // ]);

        // Refund::create([
        //     'order_id' => 4,
        //     'tenant_id' => 2,
        //     'surat_permohonan_refund' => 'refund.docx',
        //     'metode_refund' => 'Transfer BCA',
        // ]);

        // Refund::create([
        //     'order_id' => 5,
        //     'tenant_id' => 1,
        //     'surat_permohonan_refund' => 'refund.docx',
        //     'metode_refund' => 'Transfer BNI'
        // ]);

        // Refund::create([
        //     'order_id' => 6,
        //     'tenant_id' => 2,
        //     'surat_permohonan_refund' => 'refund.docx',
        //     'metode_refund' => 'Transfer BCA',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 1,
        //     'equipment_id' => 2,
        //     'jumlah_hari_refund' => 2,
        //     'jumlah_jam_refund' => 2,
        //     'alasan' => 'Alat Rusak',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 1,
        //     'equipment_id' => 1,
        //     'jumlah_hari_refund' => 2,
        //     'jumlah_jam_refund' => 2,
        //     'alasan' => 'Alat Rusak',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 2,
        //     'equipment_id' => 1,
        //     'jumlah_hari_refund' => 2,
        //     'jumlah_jam_refund' => 2,
        //     'alasan' => 'Berubah Pikiran',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 2,
        //     'equipment_id' => 2,
        //     'jumlah_hari_refund' => 18,
        //     'jumlah_jam_refund' => 1,
        //     'alasan' => 'Berubah Pikiran',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 3,
        //     'equipment_id' => 2,
        //     'jumlah_hari_refund' => 18,
        //     'jumlah_jam_refund' => 1,
        //     'alasan' => 'Berubah Pikiran',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 4,
        //     'equipment_id' => 2,
        //     'jumlah_hari_refund' => 18,
        //     'jumlah_jam_refund' => 1,
        //     'alasan' => 'Berubah Pikiran',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 5,
        //     'equipment_id' => 2,
        //     'jumlah_hari_refund' => 18,
        //     'jumlah_jam_refund' => 1,
        //     'alasan' => 'Berubah Pikiran',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // detailRefund::create([
        //     'refund_id' => 6,
        //     'equipment_id' => 2,
        //     'jumlah_hari_refund' => 18,
        //     'jumlah_jam_refund' => 1,
        //     'alasan' => 'Berubah Pikiran',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'ket_persetujuan_kepala_dinas' => 'belum',
        //     'ket_konfirmasi' => '',
        // ]);

        // Reschedule::create([
        //     'order_id' => 1,
        //     'tenant_id' => 1
        // ]);

        // Reschedule::create([
        //     'order_id' => 2,
        //     'tenant_id' => 2
        // ]);

        // Reschedule::create([
        //     'order_id' => 3,
        //     'tenant_id' => 1
        // ]);

        // Reschedule::create([
        //     'order_id' => 4,
        //     'tenant_id' => 2
        // ]);

        // Reschedule::create([
        //     'order_id' => 5,
        //     'tenant_id' => 1
        // ]);

        // Reschedule::create([
        //     'order_id' => 6,
        //     'tenant_id' => 2
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 1,
        //     'order_id' => 1,
        //     'waktu_mulai' => '2021-11-03 00:00:00',
        //     'waktu_selesai' => '2021-12-03 00:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 2,
        //     'order_id' => 1,
        //     'waktu_mulai' => '2021-11-03 00:00:00',
        //     'waktu_selesai' => '2021-12-03 00:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 3,
        //     'order_id' => 2,
        //     'waktu_mulai' => '2021-11-25 07:00:00',
        //     'waktu_selesai' => '2021-11-25 14:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 4,
        //     'order_id' => 3,
        //     'waktu_mulai' => '2021-11-25 07:00:00',
        //     'waktu_selesai' => '2021-11-25 14:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 5,
        //     'order_id' => 4,
        //     'waktu_mulai' => '2021-11-24 00:00:00',
        //     'waktu_selesai' => '2021-12-24 00:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 6,
        //     'order_id' => 5,
        //     'waktu_mulai' => '2021-11-24 00:00:00',
        //     'waktu_selesai' => '2021-12-24 00:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 7,
        //     'order_id' => 6,
        //     'waktu_mulai' => '2021-11-24 00:00:00',
        //     'waktu_selesai' => '2021-12-24 00:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // DetailReschedule::create([
        //     'detail_order_id' => 8,
        //     'order_id' => 7,
        //     'waktu_mulai' => '2021-11-24 00:00:00',
        //     'waktu_selesai' => '2021-12-24 00:00:00',
        //     'ket_verif_admin' => 'belum',
        //     'ket_persetujuan_kepala_uptd' => 'belum',
        //     'keterangan' => 'a',
        // ]);

        // detailKeluarMasukAlat::create([
        //     'order_id' => 1,
        //     'equipment_id' =>1,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '2021-11-25 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // detailKeluarMasukAlat::create([
        //     'order_id' => 1,
        //     'equipment_id' =>2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '2021-12-25 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // detailKeluarMasukAlat::create([
        //     'order_id' => 2,
        //     'equipment_id' =>2,
        //     'tanggal_ambil' => '2021-11-25 00:00:00',
        //     'tanggal_kembali' => '2021-12-25 00:00:00',
        //     'status' => 'Belum Diambil'
        // ]);

        // Categoryorder::create([
        //     'kategori' => "Penyewa Umum"
        // ]);

        // Categoryorder::create([
        //     'kategori' => "Penyewa PUPR"
        // ]);

        // Categoryorder::create([
        //     'kategori' => "Kegiatan Masyarakat"
        // ]);

        Tenant::create([
            'nama' => 'Raja Rekha Vahlevie',
            'foto' => 'tenants/logo_kota_pontianak.png',
            'email' => 'brightness988@gmail.com',
            'username' => 'raja_rekha',
            'password' => bcrypt('ditacantik'),
            'no_hp' => '081250311586',
            'kontak_darurat' => '089693838246',
            'alamat' => 'purnama',
            'status' => 'aktif',
        ]);

        Tenant::create([
            'nama' => 'Dita Adetia Nadila',
            'foto' => 'tenants/logo_kota_pontianak.png',
            'email' => 'ahmadpawji67@gmail.com',
            'username' => 'ditadetian',
            'password' => bcrypt('ditacantik'),
            'no_hp' => '089693838246',
            'kontak_darurat' => '089693838246',
            'alamat' => 'kotabaru',
            'status' => 'aktif',
        ]);
    }
}
