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
                    <li class="breadcrumb-item active">Articles</li>
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
                <?php if ($this->session->flashdata('success') != "") { ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php } ?>
                <?php if ($this->session->flashdata('error') != "") { ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php } ?>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <form name="searchFrm" id="searchFrm" action="" method="get">
                                <div class="input-group mb-0">
                                    <input class="form-control" type="text" value="" placeholder="Search" name="q">
                                    <div class="input-group-append">
                                        <button class="input-group-text" id="basic-addon1" type="">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="card-tools">
                            <a href="<?php echo base_url() . 'index.php/admin/article/create' ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table border">
                            <tr>
                                <!-- <th width="50">#</th> -->
                                <th>Name</th>

                                <th width="100">Status</th>

                                <th width="160" class="text-center">Action</th>
                            </tr>
                            <?php if (!empty($categories)) { ?>
                                <?php foreach ($categories as $categoryRow) { ?>
                                    <tr>

                                        <td><?php echo $categoryRow['name'] ?></td>


                                        <?php if ($categoryRow['status'] == 1) { ?>
                                            <td><span class="badge badge-success text-center">Active</span></td>
                                            <td>
                                        <?php }  ?>
                                        <?php if ($categoryRow['status'] == 0) { ?>
                                            <td><span class="badge badge-danger text-center"> Block</span></td>
                                        <?php } ?>
                                        <div class="row">
                                            <a href="<?php echo base_url() . 'index.php/admin/category/edit/' . $categoryRow['id']; ?>" class="btn btn-primary btn-sm"> <i class="far fa-edit"></i> Edit</a>
                                            <a href="javascript:void(0);" onclick="deleteCategory(<?php echo $categoryRow['id']; ?>)" class="btn btn-danger btn-sm ml-2"> <i class="far fa-trash-alt"></i> Delete</a>
                                        </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4">Record Not Found</td>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>


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

<script>
    function deleteCategory(id) {
       if(confirm("Are you sure you want to delete this category ?")){
        window.location.href='<?php echo base_url().'index.php/admin/category/delete/';?>'+id;
       }
    //    alert('<?php echo base_url().'index.php/admin/category/delete/';?>'+id);
    }
</script>