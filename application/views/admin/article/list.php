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
                                    <input class="form-control" type="text" value="<?php echo $q;?>" placeholder="Search" name="q">
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
                                <th width="50">#</th>
                                <th width="100">Image</th>
                                <th>Title</th>
                                <th width="180">Author</th>
                                <th width="110">Created</th>
                                <th width="100">Status</th>
                                <th width="100" class="text-center">Action</th>
                            </tr>
                            <?php if (!empty($articles)) { ?>
                                <?php foreach ($articles as $article) { ?>
                                    <tr>

                                        <td><?php echo $article['id'] ?></td>
                                        <td>
                                            <?php if ($article['image'] != "") { ?>
                                                <img class="w-100" src="<?php echo base_url('public/uploads/articles/' . $article['image']); ?>"/>
                                            <?php } else { ?>
                                                <img class="w-100" width="314" src="<?php echo base_url() . 'public/uploads/no.image.svg.webp'; ?>" />
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $article['title'] ?></td>
                                        <td><?php echo $article['author'] ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($article['created_at'])) ?></td>


                                        <td>
                                            <?php if ($article['status'] == 1) { ?>
                                                <span class="badge badge-success text-center">Active</span>

                                            <?php } else { ?>

                                                <span class="badge badge-danger text-center"> Block</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url() . 'index.php/admin/article/edit/' . $article['id']; ?>" class="btn btn-primary btn-sm"> <i class="far fa-edit"></i></a>
                                            <a href="javascript:void(0);" onclick="deleteArticle(<?php echo $article['id']; ?>)" class="btn btn-danger btn-sm ml-2"> <i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6">Record Not Found</td>
                                </tr>
                            <?php } ?>

                        </table>
                        <div>
                            <?php echo $pagination_links ?>
                        </div>
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
    function deleteArticle(id) {
        if (confirm("Are you sure you want to delete this category ?")) {
            window.location.href = '<?php echo base_url() . 'index.php/admin/article/delete/'; ?>' + id;
        }
        //    alert('<?php echo base_url() . 'index.php/admin/category/delete/'; ?>'+id);
    }
</script>