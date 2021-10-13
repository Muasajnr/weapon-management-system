<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?=$page_header_title?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php foreach($pages_path as $key => $val): ?>
                        <li class="breadcrumb-item <?=$val['active'] ? 'active' : ''?>">
                            <?php if(!$val['active']): ?>
                                <a href="<?=$val['url']?>"><?=ucwords($key)?></a>
                            <?php else: ?>
                                <?=ucwords($key)?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->