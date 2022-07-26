<?php
    class Category extends CI_Controller {

        public function index()
        {   
            $this->load->model('Category_model');
            $queryString = $this->input->get('q');
            $params['queryString'] = $queryString;

            $categories = $this->Category_model->getCategories($params);
            $data['categories'] = $categories;
            $data['queryString'] = $queryString;
            $this->load->view('admin/category/list', $data);
        }

        public function create()
        {   
            $this->load->helper('common_helper');
            $config['upload_path'] = './public/uploads/category/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            $this->load->model('Category_model');
            $this->load->library('form_validation');

            $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');

            if($this->form_validation->run() == TRUE)
            {   
               // print_r($_FILES); die(); exit;
                if($_FILES['image']['name']) {

                    // Now user has selected a file so will proceed
                    if($this->upload->do_upload('image')) 
                    {
                        
                        $data = $this->upload->data();

                        // Resizing
                        resizeImage($config['upload_path'].$data['file_name'],  $config['upload_path'].'thumb/'.$data['file_name'], 300, 270);
                        
                        
                        // File upload successfully
                        $formArray['image'] = $data['file_name'];
                        $formArray['name'] = $this->input->post('name');
                        $formArray['status'] = $this->input->post('status');
                        $formArray['created_at'] = date('Y-m-d H:i:s');
                        $this->Category_model->create($formArray);
                        $this->session->set_flashdata('success','Category Added Successfully');
                        redirect(base_url().'index.php/admin/category/index');
                    } else {
                        // Error
                        $error = $this->upload->display_errors('<p class="invalid-feedback">', '</p>');
                        $data['errorImageUpload'] = $error;
                        $this->load->view('admin/category/create', $data);
                    }

                } else {
                    // create category without image
                    $formArray['name'] = $this->input->post('name');
                    $formArray['status'] = $this->input->post('status');
                    $formArray['created_at'] = date('Y-m-d H:i:s');
                    $this->Category_model->create($formArray);
                    $this->session->set_flashdata('success','Category Added Successfully');
                    redirect(base_url().'index.php/admin/category/index');
                    
                }

               
            } else 
            {
                $this->load->view('admin/category/create');
            }
           
        }

        public function edit($id)
        {
          $this->load->model('Category_model');
          $category = $this->Category_model->getCategory($id);
         
          if (empty($category)) {
            $this->session->set_flashdata('error', 'Category not found');
            redirect(base_url().'index.php/admin/category/index');
          }
          $this->load->helper('common_helper');
          
          $config['upload_path'] = './public/uploads/category/';
          $config['allowed_types'] = 'gif|jpg|png';
          $config['encrypt_name'] = true;
          $this->load->library('upload', $config);

         
          $this->load->library('form_validation');

          $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
          $this->form_validation->set_rules('name', 'Name', 'trim|required');

          if($this->form_validation->run() == TRUE)
          {

            // print_r($_FILES); die(); exit;
            if($_FILES['image']['name']) {

                // Now user has selected a file so will proceed
                if($this->upload->do_upload('image')) 
                {
                    
                    $data = $this->upload->data();

                    // Resizing
                    resizeImage($config['upload_path'].$data['file_name'],  $config['upload_path'].'thumb/'.$data['file_name'], 300, 270);
                    
                    
                    // File upload successfully
                    $formArray['image'] = $data['file_name'];
                    $formArray['name'] = $this->input->post('name');
                    $formArray['status'] = $this->input->post('status');
                    $formArray['updated_at'] = date('Y-m-d H:i:s');

                    $this->Category_model->update($id, $formArray);

                    if(file_exists('./public/uploads/category/'.$category['image'])){
                        unlink('./public/uploads/category/'.$category['image']);
                    }

                    if(file_exists('./public/uploads/category/thumb/'.$category['image'])){
                        unlink('./public/uploads/category/thumb/'.$category['image']);
                    }

                    $this->session->set_flashdata('success','Category Updated Successfully');
                    redirect(base_url().'index.php/admin/category/index');
                } else {
                    // Error
                    $error = $this->upload->display_errors('<p class="invalid-feedback">', '</p>');
                    $data['errorImageUpload'] = $error;
                    $data['category'] = $category;
                    $this->load->view('admin/category/edit', $data);
                }

            } else {
                // create category without image
                $formArray['name'] = $this->input->post('name');
                $formArray['status'] = $this->input->post('status');
                $formArray['updated_at'] = date('Y-m-d H:i:s');
                $this->Category_model->update($id, $formArray);
                $this->session->set_flashdata('success','Category Updated Successfully');
                redirect(base_url().'index.php/admin/category/index');
                
            }            


          } else {
                $data['category'] = $category;
                $this->load->view('admin/category/edit', $data);
          }
        }

        public function delete($id)
        {
            $this->load->model('Category_model');
            $category = $this->Category_model->getCategory($id);
           
            if (empty($category)) {
              $this->session->set_flashdata('error', 'Category not found');
              redirect(base_url().'index.php/admin/category/index');
            }

            if(file_exists('./public/uploads/category/'.$category['image'])){
                unlink('./public/uploads/category/'.$category['image']);
            }

            if(file_exists('./public/uploads/category/thumb/'.$category['image'])){
                unlink('./public/uploads/category/thumb/'.$category['image']);
            }

            $category = $this->Category_model->deleteCategory($id); 
            $this->session->set_flashdata('success','Category deleted Successfully');
            redirect(base_url().'index.php/admin/category/index');
        }
    }
