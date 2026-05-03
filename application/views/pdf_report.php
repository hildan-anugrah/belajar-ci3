<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data User</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
            color: #2c3e50;
        }

        .header p {
            margin: 5px 0 0;
            font-style: italic;
            color: #7f8c8d;
        }

        .info {
            margin-bottom: 15px;
        }

        .info table {
            width: 100%;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .content-table th {
            background-color: #34495e;
            color: #ffffff;
            text-align: left;
            padding: 12px 15px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
        }

        .content-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #ecf0f1;
        }

        .content-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .content-table tr:last-of-type {
            border-bottom: 2px solid #34495e;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 10px;
            color: #bdc3c7;
            border-top: 1px solid #ecf0f1;
            padding-top: 10px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            background-color: #3498db;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Laporan Data Pengguna</h2>
            <p>Sistem Informasi Manajemen - Pemrograman Web 2</p>
        </div>

        <div class="info">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width: 50%;">
                        <strong>Dicetak pada:</strong> <?php echo date('d F Y, H:i'); ?>
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Status:</strong> <span class="badge">Official Report</span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="content-table">
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="35%">Username</th>
                    <th width="40%">Full Name</th>
                    <th width="20%" class="text-center">Role</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php $no = 1;
                    foreach ($users as $user): ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->full_name; ?></td>
                            <td class="text-center">
                                <span style="color: #27ae60; font-weight: bold;">
                                    <?php echo isset($user->role) ? ucfirst($user->role) : 'User'; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="footer">
            Copyright &copy; <?php echo date('Y'); ?> - Pemrograman Web 2. All rights reserved.
        </div>
    </div>
</body>

</html>