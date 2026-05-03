<!-- Membungkus konten di dalam container agar ada jarak rapi di kiri-kanan -->
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Users</h2>

        <div class="alert alert-secondary py-2 mb-4">
            Halo, <strong><?php echo $this->session->userdata('full_name'); ?></strong>
        </div>

        <!-- Flashdata Success -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Flashdata Error -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <a href="<?php echo site_url('user/add'); ?>" class="btn btn-success mb-3">Tambah User</a>

        <!-- Membuat tabel menjadi responsif -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Created At</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $u): ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td><?php echo $u->username; ?></td>
                                <td><?php echo $u->full_name; ?></td>
                                <td><?php echo $u->created_at; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('user/edit/' . $u->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                                    
                                    <?php if ($this->session->userdata('role') === 'administrator'): ?>
                                        <a href="<?php echo site_url('user/delete/' . $u->id); ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin hapus data ini?');">
                                           Hapus
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>