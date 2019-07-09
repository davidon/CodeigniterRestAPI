<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Customers extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('customer_model');
    }

    /**
     * Get customer information by email
     */
    function infobyemail_get()
    {
        //the Email cannot be put as URI segment; instead as query parameter
        $email = $this->get('email');

        if(!$email) {
            $this->response('No EMAIL specified', 400);
            exit;
        }

        $result = $this->customer_model->getcustomerbyemail($email);

        if($result) {
            $this->response($result, 200);
        } else {
            $this->response('Invalid EMAIL ' . $email, 404);
        }
    }

    /**
     * Get customer information
     */
    function info_get()
    {
        $id = $this->get('id');

        if(!$id) {
            $this->response('No ID specified', 400);
            exit;
        }

        $result = $this->customer_model->getcustomerbyid($id);

        if($result) {
            $this->response($result, 200);
        } else {
            $this->response('Customer cannot be found by ID ' . $id, 404);
        }
    }

    /**
     * Get all customers
     */
    function all_get()
    {
        $result = $this->customer_model->getallcustomers();

        if($result) {
            $this->response($result, 200);
        } else {
            $this->response('No record found', 404);
        }
    }

    /**
     * create a new customer item in database.
     */
    function new_post()
    {
        $firstname = $this->post('firstname');
        $surname = $this->post('surname');
        $email = $this->post('email');
        $gender = $this->post('gender');

        if(!$firstname || !$surname || !$email || !$gender) {
            $this->response('Enter complete customer information to save', 400);
        } else {
            //TODO joined_date to be inserted automatically
            $result = $this->customer_model->add(
                array(
                    'firstname'=>$firstname,
                    'surname'=>$surname,
                    'email'=>$email,
                    'gender'=>$gender
                ));

            if($result === 0) {
                $this->response('Customer could not be created.', 404);
            } else {
                $this->response('Customer is added successfully', 200);
            }
        }
    }
    
    /**
     * update a customer
     */
    function edit_put()
    {
        //$this->put() only works for form data x-www-form-urlencoded
        $firstname = $this->put('firstname');
        $surname = $this->put('surname');
        $email = $this->put('email');
        $gender = $this->put('gender');

        //get() only works for URI segment
        $id = $this->get('id');
        if(!$id) {
            $this->response('No ID specified', 400);
            exit;
        }

        $result = $this->customer_model->getcustomerbyid($id);
        if(!$result) {
            $this->response('Customer cannot be found by ID' . $id, 404);
        }

        if(!$firstname && !$surname && !$email && !$gender) {
            $this->response('Enter complete customer information to save.', 400);
        } else {
            $result = $this->customer_model->update(
                $id,
                array(
                    'firstname'=>$firstname,
                    'surname'=>$surname,
                    'email'=>$email,
                    'gender'=>$gender
                ));

            if($result === 0) {
                $this->response('Customer could not be updated.', 404);
            } else {
                $this->response('Customer is updated successfully.', 200);
            }
        }
    }

    //API - delete a customer 
    function remove_delete()
    {
        //$this->delete() doesn't work
        $id = $this->get('id');

        if(!$id) {
            $this->response('No ID specified', 404);
        };

        $result = $this->customer_model->getcustomerbyid($id);
        if(!$result) {
            $this->response('Customer cannot be found by ID.' . $id, 404);
        }

        if($this->customer_model->delete($id)) {
            $this->response('Customer is deleted successfully.', 200);
        } else {
            $this->response('Failed to delete customer.', 400);
        }
    }
}