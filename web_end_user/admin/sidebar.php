<div class="admin-sidebar">

    <style>
        .admin-sidebar {
            width: 175px;
            min-height: 100vh;
            padding: 16px 12px;
            background: #EEF3F1;
            border-right: 1px solid #D6E0DC;
            flex-shrink: 0;
        }

        .admin-sidebar-title {
            margin: 0 0 14px;
            padding-bottom: 9px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-family: "Times New Roman", Times, serif;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .admin-btn {
            display: block;
            width: 100%;
            margin-bottom: 7px;
            padding: 7px 6px;
            background: #FFFFFF;
            border: 1px solid #BFCFCA;
            color: #404040;
            text-align: center;
            text-decoration: none;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            transition: 0.15s;
        }

        .admin-btn:hover {
            background: #EAF1EF;
            color: #345D6B;
        }

        .admin-btn.active {
            background: #5B8798;
            border-color: #5B8798;
            color: #FFFFFF;
            font-weight: bold;
        }
    </style>

    <div class="admin-sidebar-title">ADMIN</div>

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <a href="../index.php" class="admin-btn">
        Return Home
    </a>

    <a href="index.php"
       class="admin-btn <?= $currentPage === 'index.php' ? 'active' : '' ?>">
        Admin Home
    </a>

    <a href="userList.php"
       class="admin-btn <?= in_array($currentPage, ['userList.php', 'userAdd.php', 'userEdit.php', 'userDetail.php'], true) ? 'active' : '' ?>">
        Users Manage
    </a>

    <a href="categoryList.php"
       class="admin-btn <?= $currentPage === 'categoryList.php' ? 'active' : '' ?>">
        Categories
    </a>

    <a href="productList.php"
       class="admin-btn <?= $currentPage === 'productList.php' ? 'active' : '' ?>">
        Products
    </a>

    <a href="../logout.php" class="admin-btn">
        Logout
    </a>

</div>