<?php

/**
 * Author: Amirul Momenin
 * Desc:Report_attendance  Controller
 *
 */
class Report extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
        $this->load->model('Attendance_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of attendance table's index to get query
     *            
     */
    function index()
    {
        $data['_view'] = 'admin/report/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * report
     *
     * @param $start -
     *            Starting of product table's index to get query
     */
    function report($start = 0)
    {
           

            // attendance item_total
            $this->load->database();
            if ($this->input->post('date_from') && $this->input->post('date_to')) {
                $this->db->where("attendance.date_attendance BETWEEN '" . $this->input->post('date_from') . "' AND '" . $this->input->post('date_to') . "'");
            }
			if ($this->input->post('users_id')) {
                $this->db->where("users_id = '".$this->input->post('users_id')."'");
			}
			 $this->db->from('attendance');
            $attendance = $this->db->get()->result_array();
            $db_error = $this->db->error();
            if (! empty($db_error['code'])) {
                echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
                exit();
            }

            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/report/print_template.php');
            $html = ob_get_clean();
            include (APPPATH . "third_party/mpdf60/mpdf.php");
            $mpdf = new mPDF('', 'A4');
            // $mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
            // $mpdf->mirrorMargins = true;
            $mpdf->SetDisplayMode('fullpage');
            // ==============================================================
            $mpdf->autoScriptToLang = true;
            $mpdf->baseScript = 1; // Use values in classes/ucdn.php 1 = LATIN
            $mpdf->autoVietnamese = true;
            $mpdf->autoArabic = true;
            $mpdf->autoLangToFont = true;
            $mpdf->setAutoBottomMargin = 'stretch';
            $stylesheet = file_get_contents(APPPATH . "third_party/mpdf60/lang2fonts.css");
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($html);
            // $mpdf->AddPage();
            $mpdf->Output($filePath);
            $mpdf->Output();
            // $mpdf->Output( $filePath,'S');
            exit();
       
    }
}
//End of attendance controller