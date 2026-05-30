<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination & Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php
    $old_input = $this->session->flashdata('old_input');
    $old_input = is_array($old_input) ? $old_input : [];
    $selected_role = isset($old_input['role']) ? $old_input['role'] : 'operator';
    $show_add_modal = (bool) $this->session->flashdata('show_add_modal');
    ?>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h4 class="mb-0 text-primary">Data Users</h4>
                <a href="<?= site_url('pagination/export_pdf'); ?>" class="btn btn-danger btn-sm" target="_blank">
                    Export PDF
                </a>
            </div>

            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <form id="search-form" action="<?= site_url('pagination/ajax_list'); ?>" method="post" class="m-0 flex-grow-1" style="max-width: 540px;">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" value="<?= html_escape($keyword); ?>" placeholder="Cari...">
                            <button class="btn btn-primary" type="submit" name="submit" value="Cari">
                                Cari
                            </button>
                            <button class="btn btn-secondary" type="submit" name="reset" value="Reset">
                                Reset
                            </button>
                        </div>
                    </form>

                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        Tambah User
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Foto Profil</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Tgl Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            <?php $this->load->view('partials/user_rows', [
                                'users' => $users,
                                'start' => $start
                            ]); ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination-links" class="mt-3">
                    <?= $pagination; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= site_url('pagination/add_user'); ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= isset($old_input['username']) ? html_escape($old_input['username']) : ''; ?>" maxlength="50" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                        </div>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= isset($old_input['full_name']) ? html_escape($old_input['full_name']) : ''; ?>" maxlength="100" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="operator" <?= $selected_role === 'operator' ? 'selected' : ''; ?>>Operator</option>
                                <option value="administrator" <?= $selected_role === 'administrator' ? 'selected' : ''; ?>>Administrator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil (Opsional)</label>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-user-form" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username" maxlength="50" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="edit_password" name="password" minlength="6" placeholder="Kosongkan jika tidak diganti">
                        </div>
                        <div class="mb-3">
                            <label for="edit_full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_full_name" name="full_name" maxlength="100" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="operator">Operator</option>
                                <option value="administrator">Administrator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_foto_profil" class="form-label">Ganti Foto Profil (Opsional)</label>
                            <input type="file" class="form-control" id="edit_foto_profil" name="foto_profil" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.getElementById("user-table-body");
    const paginationContainer = document.getElementById("pagination-links");
    const searchForm = document.getElementById("search-form");
    const editUserBaseUrl = "<?= site_url('pagination/update_user'); ?>";
    const editUserForm = document.getElementById("edit-user-form");
    const editUsernameInput = document.getElementById("edit_username");
    const editPasswordInput = document.getElementById("edit_password");
    const editFullNameInput = document.getElementById("edit_full_name");
    const editRoleInput = document.getElementById("edit_role");
    const editFotoInput = document.getElementById("edit_foto_profil");

    paginationContainer.addEventListener("click", function (e) {
        const targetLink = e.target.closest("a.page-link");

        if (targetLink) {
            e.preventDefault(); 
            const url = targetLink.getAttribute("href");
            if (url && url !== "#") {
                fetchData(url, "GET");
            }
        }
    });

    tableBody.addEventListener("click", function (e) {
        const editButton = e.target.closest(".btn-edit-user");

        if (!editButton) {
            return;
        }

        editUserForm.action = editUserBaseUrl + "/" + editButton.dataset.id;
        editUsernameInput.value = editButton.dataset.username || "";
        editFullNameInput.value = editButton.dataset.fullName || "";
        editRoleInput.value = editButton.dataset.role || "operator";
        editPasswordInput.value = "";
        editFotoInput.value = "";
    });

    searchForm.addEventListener("submit", function (e) {
        e.preventDefault(); 

        const url = searchForm.getAttribute("action");
        const formData = new FormData(searchForm);

        if (e.submitter) {
            formData.append(e.submitter.name, e.submitter.value);

            if (e.submitter.name === "reset") {
                searchForm.querySelector("input[name='keyword']").value = "";
            }
        } else {
            formData.append("submit", "Cari");
        }

        fetchData(url, "POST", formData);
    });

    const keywordInput = searchForm.querySelector("input[name='keyword']");
    let debounceTimer;

    keywordInput.addEventListener("input", function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            const event = new Event("submit", { cancelable: true });
            searchForm.dispatchEvent(event);
        }, 300); 
    });

    function fetchData(url, method = "GET", bodyData = null) {
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Memuat data...</td></tr>`;

        const options = {
            method: method,
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        };

        if (method === "POST" && bodyData) {
            options.body = bodyData;
        }

        fetch(url, options)
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = data.tabel_html;
            paginationContainer.innerHTML = data.pagination;
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Gagal memuat data.</td></tr>`;
        });
    }

    <?php if ($show_add_modal): ?>
    const addUserModal = new bootstrap.Modal(document.getElementById("addUserModal"));
    addUserModal.show();
    <?php endif; ?>
});
</script>
</body>
</html>
