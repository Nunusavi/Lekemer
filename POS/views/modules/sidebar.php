<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <?php
            if ($_SESSION["role"] == "admin") {
                echo '
                <li class="active">
                    <a href="home">
                        <i class="fa fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>';
            }
            if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "cashier") {
                echo '
                <li>
                    <a href="categories">
                        <i class="fa fa-th"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="products">
                        <i class="fa fa-product-hunt"></i>
                        <span>Products</span>
                    </a>
                </li>';
            }
            if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "cashier" || $_SESSION["role"] == "store manager") {
                echo '
                <li>
                    <a href="customers">
                        <i class="fa fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>';
            }
            if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "cashier") {
                echo '
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-usd"></i>
                        <span>Sales</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="create-sale">
                                <i class="fa fa-circle"></i>
                                <span>Create Sale</span>
                            </a>
                        </li>
                        <li>
                            <a href="sales">
                                <i class="fa fa-circle"></i>
                                <span>Manage Sales</span>
                            </a>
                        </li>';
                if ($_SESSION["role"] == "cashier") {
                    echo '
                        <li>
                            <a href="products">
                                <i class="fa fa-circle"></i>
                                <span>Manage Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="customers">
                                <i class="fa fa-circle"></i>
                                <span>Manage Customers</span>
                            </a>
                        </li>';
                }
                echo '
                    </ul>
                </li>';
            }
            if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "store manager") {
                echo '
                <li>
                    <a href="inventory">
                        <i class="fa fa-archive"></i>
                        <span>Inventory</span>
                    </a>
                </li>';
            }
            if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "accountant") {
                echo '
                <li>
                    <a href="financial-report">
                        <i class="fa fa-file-text"></i>
                        <span>Financial Report</span>
                    </a>
                </li>
                <li>
                    <a href="users">
                        <i class="fa fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                ';
            }
            ?>
        </ul>
    </section>
</aside>