<!-- id int(11) NOT NULL
p_name varchar(100) NOT NULL
p_category varchar(50) NOT NULL
p_category_spec json NULL
p_custom_field json NULL
p_colour json NULL
p_badge json NULL
p_variation int(11) NULL
p_userstamp int(11) NOT NULL
p_timestamp int(11) NOT NULL -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 offset-md-1">
                        <!-- Image upload -->
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="file" name="images[]" accept="image/*" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <!-- Text information -->
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="category" class="form-control" placeholder="Category" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>