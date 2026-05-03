<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        button {
            padding: 10px 15px;
            background-color: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #1976D2;
        }

        .btn-back {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none; /* Perbaikan typo: textdecoration -> text-decoration */
            color: #333;
            font-size: 14px;
        }

        .btn-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h2>Edit User</h2>

    <form action="<?php echo site_url('user/edit/' . $user->id); ?>" method="post">
        <div class="form-group">
            <label>Username:</label>
            <input autocomplete="off" type="text" name="username" value="<?php echo set_value('username', $user->username); ?>">
            <div class="error"><?php echo form_error('username'); ?></div>
        </div>

        <div class="form-group">
            <label>Password (kosongkan jika tidak ingin mengubah):</label>
            <input autocomplete="off" type="password" name="password">
            <div class="error"><?php echo form_error('password'); ?></div>
        </div>

        <div class="form-group">
            <label>Full Name:</label>
            <input autocomplete="off" type="text" name="full_name" value="<?php echo set_value('full_name', $user->full_name); ?>">
            <div class="error"><?php echo form_error('full_name'); ?></div>
        </div>

        <button type="submit">Update</button>
    </form>

    <a href="<?php echo site_url('user'); ?>" class="btn-back">&larr; Kembali ke Daftar Users</a>

</body>
</html>