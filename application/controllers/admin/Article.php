<?php
class Article extends CI_Controller{

    public function index() {
        
        $this->load->view('admin/article/list');
    }

    public function create() {

          $this->load->model('Article_model');
          $this->load->model('Category_model');
          $this->load->helper('common_helper');

          $categories = $this->Category_model->getCategories();
          $data['categories'] = $categories;

          $config['upload_path'] = './public/uploads/articles/';
          $config['allowed_types'] = 'gif|jpg|png';
          $config['encrypt_name'] = true;
          $this->load->library('upload', $config);

          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
          $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
          $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
          $this->form_validation->set_rules('author', 'Author', 'trim|required');

          if($this->form_validation->run() == true) {

            if($_FILES['image']['name']){

                 // Now user has selected a file so will proceed
                 if($this->upload->do_upload('image')) 
                 {
                     
                    $data = $this->upload->data();

                    // Resizing
                    resizeImage($config['upload_path'].$data['file_name'],  $config['upload_path'].'thumb_front/'.$data['file_name'], 1120, 800);
                    resizeImage($config['upload_path'].$data['file_name'],  $config['upload_path'].'thumb_admin/'.$data['file_name'], 300, 250);
                     
                     
                    //  // File upload successfully
                    $formArray['image'] = $data['file_name'];
                    $formArray['title'] = $this->input->post('title');
                    $formArray['description'] = $this->input->post('description');
                    $formArray['category'] = $this->input->post('category_id');
                    $formArray['author'] = $this->input->post('author');
                    $formArray['status'] = $this->input->post('status');
                    $formArray['created_at'] = date('Y-m-d H:i:s');
                    $this->Article_model->addArticle($formArray);
                    $this->session->set_flashdata('success','Article Added Successfully');
                    redirect(base_url().'index.php/admin/article/index');
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
                    $this->session->set_flashdata('success','Article Added Successfully');
                    redirect(base_url().'index.php/admin/article/index');
            }

          } else {
            // error not validated
            $this->load->view('admin/article/create', $data);
          }

       
    }

    public function edit() {
        
    }

    public function delete() {
        
    }



}

?>