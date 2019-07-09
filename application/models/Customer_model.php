<?php

class Customer_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * get a customer record by email
     *
     * @param $email
     * @return int
     */
    public function getcustomerbyemail($email)
    {
        $this->db->select('id, firstname, surname, email, gender, joined_date');

        $this->db->from('customers');

        $this->db->where('email', $email);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {

            return $query->result_array();

        } else {

            return 0;
        }
    }

    /**
     * Get customer by ID
     *
     * @param $id
     * @return int
     */
    public function getcustomerbyid($id)
    {
        $this->db->select('id, firstname, surname, email, gender, joined_date');

        $this->db->from('customers');

        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {

            return $query->result_array();

        } else {

            return 0;

        }
    }

    /**
     * get all customers record
     *
     * @return int
     */
    public function getallcustomers()
    {

        $this->db->select('id, firstname, surname, email, gender, joined_date');

        $this->db->from('customers');

        $this->db->order_by("id", "desc");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result_array();

        } else {

            return 0;

        }
    }

    /**
     * delete a customer record
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {

        $this->db->where('id', $id);

        if ($this->db->delete('customers')) {

            return true;

        } else {

            return false;

        }
    }

    /**
     * add new customer record
     *
     * @param $data
     * @return bool
     */
    public function add($data)
    {

        if ($this->db->insert('customers', $data)) {

            return true;

        } else {

            return false;

        }
    }

    /**
     * update a customer record
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {

        $this->db->where('id', $id);

        if ($this->db->update('customers', $data)) {

            return true;

        } else {

            return false;

        }
    }

}