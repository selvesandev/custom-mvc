<!-- page content -->

<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add New Admin</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">


                        <?= validationErrors('alert alert-danger') ?>


                        <form method="post" class="form-horizontal form-label-left input_mask">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="name" class="form-control has-feedback-left" id="inputSuccess2"
                                       placeholder="Nick Name">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess4"
                                       placeholder="Email" name="email">
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="password" class="form-control has-feedback-left"
                                       placeholder="Password" name="password">
                                <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="password" class="form-control has-feedback-left"
                                       placeholder="Confirm Password" name="password_confirmation">
                                <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="file" class="form-control has-feedback-left"
                                       name="image">
                                <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
