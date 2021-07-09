<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <!-- data tabel -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-book mr-2"></i>Buku Baru</h4>
                        <a href="<?= base_url('pages/buku'); ?>" class="btn btn-primary ml-auto">Lihat Selengkapnya</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Tanggal Dibuat</th>
                                    <th scope="col">Ditambahkan Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no =1;
                                foreach ($buku->result() as $key => $data) { ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $data->judul; ?></td>
                                    <td><?= $data->kategori; ?></td>
                                    <td><?= $data->date_created; ?></td>
                                    <td><?= $data->created_by; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-users mr-2"></i>Anggota Baru</h4>
                        <a href="#" class="btn btn-primary ml-auto">Lihat Selengkapnya</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">nama</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">No. Handphone</th>
                                    <th scope="col">Tanggal Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no =1;
                                foreach ($anggota->result() as $key => $data) { ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $data->nama; ?></td>
                                    <td><?= $data->alamat; ?></td>
                                    <td><?= $data->no_handphone; ?></td>
                                    <td><?= $data->date_created; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-upload mr-2"></i>Peminjaman Terbaru</h4>
                        <a href="#" class="btn btn-primary ml-auto">Lihat Selengkapnya</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Nama Peminjam</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no =1;
                                foreach ($peminjaman->result() as $key => $data) { ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $data->kode_transaksi; ?></td>
                                    <td><?= $data->nama; ?></td>
                                    <td><?= $data->tanggal_pinjam; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-download mr-2"></i>Buku Dikembalikan</h4>
                        <a href="#" class="btn btn-primary ml-auto">Lihat Selengkapnya</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Nama Peminjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no =1;
                                foreach ($pengembalian->result() as $key => $data) { ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $data->kode_transaksi; ?></td>
                                    <td><?= $data->nama; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data tabel -->
    </section>
</div>
<!-- main content -->