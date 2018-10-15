<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Models extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
      
        $this->load->model('Models_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }

    // ****************************** View Page -- START ****************************** //

    // View Manufacturer;
    public function view()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        $config = array();
        $config['base_url'] = base_url().'models/view/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Models_model->record_models_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Models_model->fetch_models_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Models_model->record_models_count();

            $start_pg_point = 0;
            if ($have_count == 0) {
                $start_pg_point = 0;
            } else {
                $start_pg_point = 1;
            }

            $sh_text = "Showing $start_pg_point to ".count($data['results']).' of '.$this->Models_model->record_models_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Models_model->record_models_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data['setting_dateformat'] = $setting_dateformat;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['manufacturer'] = $this->lang->line('manufacturer');
        $data['models'] = $this->lang->line('models');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['models_manufacturer'] = $this->lang->line('models_manufacturer');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');

        $data['lang_export'] = $this->lang->line('export');
        $data['lang_search'] = $this->lang->line('search');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_email'] = $this->lang->line('email');
        $data['lang_mobile'] = $this->lang->line('mobile');
        
        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_sales_history'] = $this->lang->line('sales_history');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $this->load->view('models', $data);
    }

    // Edit Customer;
   
   
    public function addModels()
    {
        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['manufacturer'] = $this->lang->line('manufacturer');
         $data['models'] = $this->lang->line('models');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
             $data['models_manufacturer'] = $this->lang->line('models_manufacturer');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_add_customer'] = $this->lang->line('add_customer');
        $data['lang_export'] = $this->lang->line('export');
        $data['lang_search'] = $this->lang->line('search');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_email'] = $this->lang->line('email');
        $data['lang_mobile'] = $this->lang->line('mobile');
        $data['lang_customer_name'] = $this->lang->line('customer_name');
        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_sales_history'] = $this->lang->line('sales_history');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_full_name'] = $this->lang->line('full_name');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $this->load->view('add_models', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Customer;
    public function deleteModels()
    {
        $id = $this->input->post('id');
        $mod_fn = $this->input->post('mod_fn');
            $mod_man = $this->input->post('mod_man');

        if ($this->Constant_model->deleteData('models', $id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Models', "Product Sold : $id."));
            redirect(base_url().'models/list_models');
        }
    }

    // Insert New Customer;
    public function insertModels()
    {
        $fullname = $this->input->post('fullname');
           $manuf = $this->input->post('manuf');

        /*$us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());*/

        if (empty($fullname)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Models', 'Please enter Models Full Name!'));
            redirect(base_url().'models/addModels');
        } else {
            if (empty($manuf)) {
                 $this->session->set_flashdata('alert_msg', array('failure', 'Add New Manufacturer', 'Please choose Manufacturer!'));
            redirect(base_url().'models/addModels');
                }
            }

            $ins_mod_data = array(
                      'fullname' => $fullname,
                      'manufacturer' => $manuf,

                     
            );
            if ($this->Constant_model->insertData('models', $ins_mod_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add Models', "Successfully Added Models : $fullname"));
                redirect(base_url().'models/addModels');
            }
        }
  

    public function updateModels()
    {
        $mod_id = $this->input->post('mod_id');
        $fn = $this->input->post('fullname');
    


        $upd_data = array(
                'fullname' => $fn,
              
        );
        $this->Constant_model->updateData('models', $upd_data, $cust_id);

        $this->session->set_flashdata('alert_msg', array('success', 'Update Models', 'Successfully Updated Models Detail!'));
        redirect(base_url().'models/edit_models?mod_id='.$mod_id);
    }

    public function list_Models()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'inventory';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Models_model->record_models_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Models_model->fetch_models_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Models_model->record_models_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Models_model->record_models_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Models_model->record_models_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['list_Models'] = $this->lang->line('list_models');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_code'] = $this->lang->line('code');
        $data['lang_image'] = $this->lang->line('image');
        $data['lang_category'] = $this->lang->line('category');
        $data['lang_cost'] = $this->lang->line('cost');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_add_product'] = $this->lang->line('add_product');

        $this->load->view('inventory', $data);
    }


    // ****************************** Action To Database -- END ****************************** //

    // ****************************** Export Excel -- START ********************************** //

   
    // ****************************** Export Excel -- START ********************************** //
}
