<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Presentations', 'icon' => 'file-code-o', 'url' => ['/presentation']],
                    ['label' => 'Categories', 'icon' => 'users', 'url' => ['/category']], // if admin
                    ['label' => 'Users', 'icon' => 'users', 'url' => ['/user/admin/index']], // if admin
                ],
            ]
        ) ?>

    </section>

</aside>
