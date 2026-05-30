<?php if (!empty($users)): ?>
    <?php $no = $start + 1; ?>
    <?php foreach ($users as $u): ?>
        <?php
        $foto = basename(!empty($u->foto_profil) ? $u->foto_profil : 'default.png');
        $foto_path = FCPATH . 'uploads/' . $foto;
        $nama_avatar = !empty($u->full_name) ? $u->full_name : $u->username;
        $initial = strtoupper(substr($nama_avatar, 0, 1));
        ?>
        <tr>
            <td class="align-middle"><?= $no++; ?></td>
            <td class="align-middle text-center">
                <?php if (is_file($foto_path)): ?>
                    <img src="<?= base_url('uploads/' . $foto); ?>" alt="Foto <?= html_escape($u->username); ?>" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                <?php else: ?>
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white fw-semibold" style="width: 48px; height: 48px;">
                        <?= html_escape($initial); ?>
                    </span>
                <?php endif; ?>
            </td>
            <td class="align-middle"><?= html_escape($u->username); ?></td>
            <td class="align-middle"><?= html_escape($u->full_name); ?></td>
            <td class="align-middle"><?= tgl_indo($u->created_at); ?></td>
            <td class="align-middle text-nowrap">
                <button type="button"
                        class="btn btn-warning btn-sm btn-edit-user"
                        data-bs-toggle="modal"
                        data-bs-target="#editUserModal"
                        data-id="<?= (int) $u->id; ?>"
                        data-username="<?= html_escape($u->username); ?>"
                        data-full-name="<?= html_escape($u->full_name); ?>"
                        data-role="<?= html_escape($u->role); ?>">
                    Edit
                </button>
                <a href="<?= site_url('pagination/delete_user/' . $u->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">
                    Hapus
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center">Data tidak ditemukan</td>
    </tr>
<?php endif; ?>
