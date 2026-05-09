<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination & Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h4 class="mb-0 text-primary">Data Users</h4>
                <a href="<?= site_url('pagination/export_pdf'); ?>" class="btn btn-danger btn-sm" target="_blank">
                    Export PDF
                </a>
            </div>

            <div class="card-body">
                <form action="<?= site_url('pagination/index'); ?>" method="post" class="mb-3">
                    <div class="input-group w-50">
                        <input type="text" class="form-control" name="keyword" value="<?= $keyword; ?>" placeholder="Cari...">
                        <button class="btn btn-primary" type="submit" name="submit" value="Cari">
                            Cari
                        </button>
                        <button class="btn btn-secondary" type="submit" name="reset" value="Reset">
                            Reset
                        </button>
                    </div>
                </form>

                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Tgl Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = $start + 1; ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $u->username; ?></td>
                                    <td><?= $u->full_name; ?></td>
                                    <td><?= tgl_indo($u->created_at); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-3">
                    <?= $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>