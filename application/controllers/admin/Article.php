<?php
class Article extends CI_Controller
{
  public function __construct()
  {
      parent::__construct();
      $admin = $this->session->userdata('admin');

      if(empty($admin)) {
          $this->session->set_flashdata('msg', 'Your session has been expired');
              redirect(base_url().'index.php/admin/login/index');
      }
  }

  public function index($page = 1)
  {
    // print_r($_GET);
    $perpage = 5;
    $param['offset'] = $perpage;
    $param['limit']  = ($page * $perpage) - $perpage;
    $param['q'] = $this->input->get('q');

    $this->load->model('Article_model');
    $this->load->library('pagination');
    $config['base_url'] = base_url('index.php/admin/article/index');
    $config['total_rows'] = $this->Article_model->getArticlesCount($param);
    $config['per_page'] = $perpage;
    $config['use_page_numbers'] = true;

    $config['first_link'] = 'First';
    $config['next_link'] = 'Next';
    $config['last_link'] = 'Last';
    $config['prev_link'] = 'Prev';
    $config['full_tag_open'] = "<ul class ='pagination'>";
    $config['full_tag_close'] = "</ul>";
    $config['num_tag_open'] = '<li class = "page-item " >';
    $config['num_tag_close'] = " </li>";
    $config['cur_tag_open'] = "<li class =\"disabled page-item\"><li class = 'active'><a href='#' class=\"page-link\">";
    $config['cur_tag_close'] = "<span class = 'sr-only'></span></a></li>";
    $config['next_tag_open'] = "<li class = \"page-item\">";
    $config['next_tagl_close'] = "</li>";
    $config['prev_tag_open'] = "<li class = \"page-item\">";
    $config['prev_tagl_close'] = "</li>";
    $config['first_tag_open'] = "<li class = \"page-item\">";
    $config['first_tagl_close'] = "</li>";
    $config['last_tag_open'] = "<li class = \" page-item\">";
    $config['last_tagl_close'] = "</li>";
    $config['attributes'] = array('class' => 'page-link');


    $this->pagination->initialize($config);
    $pagination_links = $this->pagination->create_links();
    $articles = $this->Article_model->getArticles($param);
    $data['q'] = $this->input->get('q');
    $data['articles'] = $articles;
    $data['pagination_links'] =  $pagination_links;
    $data['mainModule'] = $this->input->get('article');
    $data['subModule'] = $this->input->get('viewArticle'); 
    
    $this->load->view('admin/article/list', $data);
  }

  public function create()
  {

    $this->load->model('Article_model');
    $this->load->model('Category_model');
    $this->load->helper('common_helper');

    $categories = $this->Category_model->getCategories();
    $data['categories'] = $categories;

    $config['upload_path'] = './public/uploads/articles/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config);

    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
    $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
    $this->form_validation->set_rules('author', 'Author', 'trim|required');

    if ($this->form_validation->run() == true) {

      if ($_FILES['image']['name']) {

        // Now user has selected a file so will proceed
        if ($this->upload->do_upload('image')) {

          $data = $this->upload->data();

          // Resizing
          resizeImage($config['upload_path'] . $data['file_name'],  $config['upload_path'] . 'thumb_front/' . $data['file_name'], 1120, 800);
          resizeImage($config['upload_path'] . $data['file_name'],  $config['upload_path'] . 'thumb_admin/' . $data['file_name'], 300, 250);


          //  // File upload successfully
          $formArray['image'] = $data['file_name'];
          $formArray['title'] = $this->input->post('title');
          $formArray['description'] = $this->input->post('description');
          $formArray['category'] = $this->input->post('category_id');
          $formArray['author'] = $this->input->post('author');
          $formArray['status'] = $this->input->post('status');
          $formArray['created_at'] = date('Y-m-d H:i:s');
          $this->Article_model->addArticle($formArray);
          $this->session->set_flashdata('success', 'Article Added Successfully');
          redirect(base_url() . 'index.php/admin/article/index');
        } else {
          // Error
          $error = $this->upload->display_errors('<p class="invalid-feedback">', '</p>');
          $data['errorImageUpload'] = $error;
          $this->load->view('admin/article/create', $data);
        }
      } else {
        // Here we will save data without image
        $formArray['title'] = $this->input->post('title');
        $formArray['description'] = $this->input->post('description');
        $formArray['category'] = $this->input->post('category_id');
        $formArray['author'] = $this->input->post('author');
        $formArray['status'] = $this->input->post('status');
        $formArray['created_at'] = date('Y-m-d H:i:s');
        $this->Article_model->addArticle($formArray);
        $this->session->set_flashdata('success', 'Article Added Successfully');
        redirect(base_url() . 'index.php/admin/article/index');
      }
    } else {
      // error not validated
      $this->load->view('admin/article/create', $data);
    }
  }

  public function edit($id)
  {
    $this->load->library('form_validation');
    $this->load->model('Article_model');
    $this->load->model('Category_model');
    $this->load->helper('common_helper');

    $article = $this->Article_model->getArticle($id);
    // echo "<pre>";
    // print_r($article);
    if (empty($article)) {
      $this->session->set_flashdata('error', 'Article Not found !');
      redirect(base_url() . 'index.php/admin/article/index');
    }

    $categories = $this->Category_model->getCategories();
    $data['categories'] = $categories;
    $data['article'] = $article;

    $config['upload_path'] = './public/uploads/articles/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config);

    $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
    $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
    $this->form_validation->set_rules('author', 'Author', 'trim|required');

    if ($this->form_validation->run() == true) {

      if ($_FILES['image']['name']) {

        // Now user has selected a file so will proceed
        if ($this->upload->do_upload('image')) {

          $data = $this->upload->data();

          // Resizing
          resizeImage($config['upload_path'] . $data['file_name'],  $config['upload_path'] . 'thumb_front/' . $data['file_name'], 1120, 800);
          resizeImage($config['upload_path'] . $data['file_name'],  $config['upload_path'] . 'thumb_admin/' . $data['file_name'], 300, 250);


          //  // File upload successfully
          $formArray['image'] = $data['file_name'];
          $formArray['title'] = $this->input->post('title');
          $formArray['description'] = $this->input->post('description');
          $formArray['category'] = $this->input->post('category_id');
          $formArray['author'] = $this->input->post('author');
          $formArray['status'] = $this->input->post('status');
          $formArray['updated_at'] = date('Y-m-d H:i:s');
          $this->Article_model->updateArticle($id, $formArray);

          if (file_exists('./public/uploads/articles/' . $article['image'])) {
            unlink('./public/uploads/articles/' . $article['image']);
          }

          if (file_exists('./public/uploads/articles/thumb_front/' . $article['image'])) {
            unlink('./public/uploads/articles/thumb_front/' . $article['image']);
          }

          if (file_exists('./public/uploads/articles/thumb_admin/' . $article['image'])) {
            unlink('./public/uploads/articles/thumb_admin/' . $article['image']);
          }

          $this->session->set_flashdata('success', 'Article Updated Successfully');
          redirect(base_url() . 'index.php/admin/article/index');
        } else {
          // Error
          $error = $this->upload->display_errors('<p class="invalid-feedback">', '</p>');
          $data['errorImageUpload'] = $error;
          $this->load->view('admin/article/edit', $data);
        }
      } else {
        // Here we will save data without image
        $formArray['title'] = $this->input->post('title');
        $formArray['description'] = $this->input->post('description');
        $formArray['category'] = $this->input->post('category_id');
        $formArray['author'] = $this->input->post('author');
        $formArray['status'] = $this->input->post('status');
        $formArray['updated_at'] = date('Y-m-d H:i:s');
        $this->Article_model->updateArticle($id, $formArray);
        $this->session->set_flashdata('success', 'Article Updated Successfully');
        redirect(base_url() . 'index.php/admin/article/index');
      }
    } else {
      // error not validated
      $this->load->view('admin/article/edit', $data);
    }



    $this->load->view('admin/article/edit', $data);
  }

  public function delete($id)
  {
    $this->load->model('Article_model');
    $article = $this->Article_model->getArticle($id);
    // echo "<pre>";
    // print_r($article);
    if (empty($article)) {
      $this->session->set_flashdata('error', 'Article Not found !');
      redirect(base_url() . 'index.php/admin/article/index');
    }

    if (file_exists('./public/uploads/articles/' . $article['image'])) {
      unlink('./public/uploads/articles/' . $article['image']);
    }

    if (file_exists('./public/uploads/articles/thumb_front/' . $article['image'])) {
      unlink('./public/uploads/articles/thumb_front/' . $article['image']);
    }

    if (file_exists('./public/uploads/articles/thumb_admin/' . $article['image'])) {
      unlink('./public/uploads/articles/thumb_admin/' . $article['image']);
    }

    $this->Article_model->deleteArticles($id);
    $this->session->set_flashdata('success', 'Article has been deleted Successfully');
    redirect(base_url() . 'index.php/admin/article/index');
  }
}
