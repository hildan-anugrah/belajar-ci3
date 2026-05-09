<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload & Resize</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Upload Gambar</h5>
            </div>
            <div class="card-body">
                <!-- Pesan Error -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <!-- Pesan Sukses & Preview -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                    <div class="text-center mb-3">
                        <img src="<?= base_url('uploads/' . $this->session->flashdata('file_name')); ?>" class="img-fluid rounded border">
                    </div>
                <?php endif; ?>

                <!-- Form Upload -->
                <form action="<?= site_url('upload_file/do_upload'); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Pilih Gambar (JPG/PNG)</label>
                        <input type="file" name="image_file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        Upload & Resize
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>