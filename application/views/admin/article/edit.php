<?php $this->load->view('admin/header'); ?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Articles</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/admin/home/index'; ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url() . 'index.php/admin/category/index'; ?>">Articles</a></li>
                    <li class="breadcrumb-item active">Edit Article</li>
                    <li class="breadcrumb-item active"><?php echo $article['title']?></li>
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
                            Edit Article "<?php echo $article['title']?>"
                        </div>
                    </div>
                    <form name="categoryForm" id="categoryForm" action="<?php echo base_url() . 'index.php/admin/article/edit/'.$article['id']?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">

                        <div class="form-group">
                                <label for="name">Category</label>
                                <select name="category_id" id="category_id" class="form-control <?php echo (form_error('category_id') != "") ? 'is-invalid' : ''; ?>">
                                    <option value="">Select a Category</option>
                                   <?php 
                                    if(!empty($categories)) {
                                        foreach ($categories as $category) {
                                            $selected = ($article['category'] == $category['id']) ? true : false;
                                   ?>  
                                            <option <?php echo set_select('category_id',$category['id'], $selected);?> value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
                                            <?php
                                        }
                                    }
                                   ?>
                                </select>
                                <?php echo form_error('category_id'); ?>
                            </div>    
                        <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" value="<?php echo set_value('title', $article['title'])?>" class="form-control <?php echo (form_error('title') != "") ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('title'); ?>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description"  class="textarea"><?php echo set_value('description', $article['description']);?></textarea>
                                
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label> <br>
                                <input type="file" name="image" id="image" value="" class=" <?php echo (!empty($errorImageUpload)) ? 'is-invalid' : '' ?>" >
                                <?php echo (!empty($errorImageUpload)) ? $errorImageUpload : ''; ?>
                                <br>
                                <?php if($article['image'] != "" ) { ?>
                                    <img class="mt-2" src="<?php echo base_url('public/uploads/articles/thumb_admin/'. $article['image']);?>" />
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" name="author" id="author" value="<?php echo set_value('author', $article['author'])?>" class="form-control <?php echo (form_error('author') != "") ? 'is-invalid' : ''; ?>">
                                <?php echo form_error('author'); ?>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusActive" value="1" <?php echo ($article['status'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="statusActive"><strong>Active</strong></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusBlock" value="0" <?php echo ($article['status'] == 0) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="statusBlock"><strong>Block</strong></label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?php echo base_url() . 'index.php/admin/article/index'; ?>" class="btn btn-secondary">Back</a>
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