<!-- page content -->

<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Profile</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?= validationErrors('alert alert-danger') ?>
                        <?= message() ?>
                        <form action="<?= url('/admin/profile/update') ?>" enctype="multipart/form-data" method="post"
                              class="form-horizontal form-label-left input_mask">
                            <input type="hidden" name="_id" value="<?= $loggedUser->id ?>">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="name" value="<?= $loggedUser->name ?>"
                                       class="form-control has-feedback-left" id="inputSuccess2"
                                       placeholder="Nick Name">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess4"
                                       placeholder="Email" name="email" value="<?= $loggedUser->email ?>">
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                            </div>


                            <div class="col-md-4 col-sm-4 col-xs-10 form-group has-feedback">
                                <input type="file" class="form-control has-feedback-left"
                                       name="image">
                                <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-2 form-group has-feedback">
                                <img src="<?= url('Uploads/admins/' . $loggedUser->image) ?>" height="50" alt="">
                            </div>


                            <?php
                            $loggedUserPrivileges = explode(',', $loggedUser->privileges_type);
                            ?>


                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                <select multiple class="form-control" name="privileges[]" id="privileges">
                                    <?php foreach ($privileges as $privilege): ?>
                                        <option <?= in_array($privilege->type, $loggedUserPrivileges) ? 'selected' : '' ?>
                                                value="<?= $privilege->id ?>"><?= $privilege->type ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <hr>

                    <form method="post" action="<?= url('/admin/update/password') ?>">
                        <input type="hidden" value="<?=$loggedUser->id?>" name="_id">
                        <div class="col-md-4 col-sm-3 col-xs-12 form-group has-feedback">
                            <input type="password" class="form-control has-feedback-left"
                                   placeholder="Old Password" name="old_password">
                            <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-4 col-sm-3 col-xs-12 form-group has-feedback">
                            <input type="password" class="form-control has-feedback-left"
                                   placeholder="Password" name="password">
                            <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-4 col-sm-3 col-xs-12 form-group has-feedback">
                            <input type="password" class="form-control has-feedback-left"
                                   placeholder="Confirm Password" name="password_confirmation">
                            <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <button type="submit" class="btn btn-success">Update Password</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <br>
                    <br>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
