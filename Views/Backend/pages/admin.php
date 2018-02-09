<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Admins</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?= message() ?>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nick Name</th>
                                <th>Email</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>


                            <?php if (count($admins) > 0) {
                                foreach ($admins as $key => $admin): ?>
                                    <tr>
                                        <th scope="row"><?= ++$key ?></th>
                                        <td><?= $admin->name ?></td>
                                        <td><?= $admin->email ?></td>
                                        <td>

                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?= $admin->id ?>">
                                                <?php if ($admin->status == 1): ?>
                                                    <button type="submit" name="disable" class="btn btn-danger btn-xs">
                                                        Disable
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-success btn-xs" type="submit" name="enable">
                                                        Enable
                                                    </button>
                                                <?php endif ?>
                                            </form>
                                        </td>
                                        <td>
                                            <?= $admin->created_at ?>
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Are you sure ?')" title="Delete"
                                               class="btn btn-danger btn-sm"
                                               href="<?= url('/admin/delete?id=' . $admin->id) ?>"><i
                                                        class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            } else { ?>
                                <tr>
                                    <td colspan="7">No Admin Found. You can add one <a href="<?= url('admin/add') ?>"><u>Here</u></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
