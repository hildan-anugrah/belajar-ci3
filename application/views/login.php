<!DOCTYPE html>
<html>
<head>
    <title>Login System</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .login-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box; /* Tambahan agar padding tidak merusak lebar */
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Login</h2>

        <!-- Notifikasi Error Login -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert-error">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo site_url('auth'); ?>" method="post">
            <div class="form-group">
                <label>Username:</label>
                <input autocomplete="off" type="text" name="username" value="<?php echo set_value('username'); ?>">
                <div class="error"><?php echo form_error('username'); ?></div>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input autocomplete="off" type="password" name="password">
                <div class="error"><?php echo form_error('password'); ?></div>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>