<?php $this->load->view('admin/header'); ?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Categories</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/admin/home/index'; ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/admin/category/index'; ?>">Categories</a></li>
                    <li class="breadcrumb-item active">Edit Categories</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">
                            Edit Category  "<?php echo $category['name']?>"
                        </div>
                    </div>
                    <form name="categoryForm" id="categoryForm" action="<?php echo base_url() . 'index.php/admin/category/edit/'.$category['id']?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="<?php echo set_value('name', $category['name']);?>" class="form-control <?php echo (form_error('name') != "") ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('name'); ?>
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label> <br>
                                <input type="file" name="image" id="image" value="" class=" <?php echo (!empty($errorImageUpload)) ? 'is-invalid' : '' ?>">
                                <?php echo (!empty($errorImageUpload)) ? $errorImageUpload : ''; ?>
                                <br>
                                <?php if($category['image'] != "" ) { ?>
                                    <img src="<?php echo base_url('public/uploads/category/'. $category['image']);?>" />
                                <?php } else {?>
                                    <img width="314" src="<?php echo base_url().'public/uploads/no-image.jpg';?>" />  
                                    <?php }?>

                            </div>
                            

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusActive" value="1" <?php echo ($category['status'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="statusActive"><strong>Active</strong></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusBlock" value="0" <?php echo ($category['status'] == 0) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="statusBlock"><strong>Block</strong></label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?php echo base_url() . 'index.php/admin/category/index'; ?>" class="btn btn-secondary">Back</a>
                        </div>
                    </form>



                </div>
            </div>


        </div><!-- /.card -->
    </div>
    <!-- /.col-md-6 -->

    <!-- /.col-md-6 -->
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $this->load->view('admin/footer'); ?>