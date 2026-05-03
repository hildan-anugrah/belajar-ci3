<!DOCTYPE html>
<html>
<head>
    <title>Data Users</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            background-color: #eee;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        .btn-add {
            background-color: #4CAF50;
            color: white;
            margin-bottom: 10px;
            display: inline-block;
            border: none;
        }

        .btn-edit {
            background-color: #2196F3;
            color: white;
            border: none;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <h2>Daftar Users</h2>

    <div style="margin-bottom: 15px;">
        Halo, <strong><?php echo $this->session->userdata('full_name'); ?></strong>
        <a href="<?php echo site_url('auth/logout'); ?>" class="btn" style="background-color: #f44336; color: white;">Logout</a>
    </div>

    <!-- Flashdata Success -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Flashdata Error -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert-error">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <a href="<?php echo site_url('user/add'); ?>" class="btn btn-add">Tambah User</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Created At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php $no = 1; foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $u->username; ?></td>
                        <td><?php echo $u->full_name; ?></td>
                        <td><?php echo $u->created_at; ?></td>
                        <td>
                            <a href="<?php echo site_url('user/edit/' . $u->id); ?>" class="btn btn-edit">Edit</a>
                            
                            <?php if ($this->session->userdata('role') === 'administrator'): ?>
                                <a href="<?php echo site_url('user/delete/' . $u->id); ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Yakin hapus data ini?');">
                                   Hapus
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>