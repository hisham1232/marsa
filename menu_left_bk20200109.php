 <aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
            <?php
                $subMenu = new DbaseManipulation;
                $sql = "SELECT m.id, m.user_type_id, m.menu_left_main_id, m.active, a.menu_name, a.appearance FROM access_menu_matrix as m 
                LEFT OUTER JOIN access_menu_left_main AS a ON a.id = m.menu_left_main_id
                WHERE m.user_type_id = $user_type
                AND m.active = 1 AND a.active = 1
                ORDER BY a.appearance ASC";
                $rowsOut = $helper->readData($sql);
                foreach($rowsOut as $rowOut){
                    $menu_left_id = $rowOut['menu_left_main_id'];
                    ?>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><?php echo $rowOut['menu_name']; ?></a>
                            <ul aria-expanded="false" class="collapse">
                                <?php
                                    $query = "SELECT sub.*, p.page_name, p.menu_name_sub, p.menu_left_id FROM access_menu_matrix_sub as sub 
                                    LEFT OUTER JOIN access_menu_left_sub as p ON p.id = sub.access_menu_left_sub_id
                                    WHERE sub.user_type_id = $user_type AND p.menu_left_id = $menu_left_id AND sub.active = 1
                                    ORDER BY sub.id ASC";
                                    $rows = $subMenu->readData($query);
                                    foreach($rows as $row) {
                                        ?>
                                        <li><a href="<?php echo $row['page_name']; ?>?linkid=<?php echo $row['id']; ?>"><i class="ti-link"></i><?php echo $row['menu_name_sub']; ?></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </li>
                    <?php
                }
            ?>   
                        <li>
                            <a href="?logout=true"><i class="fa fa-power-off"></i> Logout</a>
                        </li> 
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>