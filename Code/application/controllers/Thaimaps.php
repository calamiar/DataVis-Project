<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Thaimaps extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Thaimaps_model');
        $this->load->helper(array('url', 'html', 'form'));
    }

    public function index() {
//put year data
        $data['year_list'] = $this->Thaimaps_model->getYear();
        $year = "2561";
        if ($this->input->get('submit_year')) {
            $year = $this->input->get('year');
        }
        $data['year'] = $year;
        $data['test'] = $this->Thaimaps_model->getAllRegion_n_data($year);
        $data['min_max_val'] = $this->MinMax_data($data['test']);

//here for sum function
        $data['people_per_year'] = $this->Thaimaps_model->getTotalPeople($year);

//here for sum proportion to show in year
        $data['ppl_waste_year'] = $this->Thaimaps_model->getTotalPeopleWaste($year);

//here for sending waste_per_head data to page
        $data['waste_head_year'] = $this->Thaimaps_model->getAvgWastePerHead($year);

//return to view page
        $this->load->view('thaimaps/main_map_page', $data);
    }

    function MinMax_data($d) {
        $min = min(array_column($d, 1));
        $max = max(array_column($d, 1));
        return array('min' => $min, 'max' => $max);
    }

    function zoomTourist() {
        $year = $this->uri->segment(5);
        $region = $this->uri->segment(3);
        $region_name = $this->uri->segment(4);
        $data['test'] = $this->Thaimaps_model->getAllProvince_n_data($year, $region);
        $data['geojson_name'] = $region_name;
        $data['min_max_val'] = $this->MinMax_data($data['test']);
// Set default for province
        $data['year'] = $year;
//****************barchart****************
        $data['default_year'] = $this->Thaimaps_model->getAllSemiRegion_n_data($year, $region);
        $data['region_name'] = $this->Thaimaps_model->getRegion_name($region)->region_name;
        //****************Piechart****************
        $data['default_waste_year'] = $this->Thaimaps_model->getAllSemiRegionWaste_Data($year, $region);
        //****************Call average waste per head data****************
        $data['waste_head_region'] = $this->Thaimaps_model->getAvgWastePerHeadRegion($year, $region);


//Set region average
//        $data['default_region'] = 
//return to view page
        $this->load->view('thaimaps/zoom_map_page', $data);
    }

    function province_data() {
        $year = $this->input->post('year');
        $province_id = $this->input->post('province');

// Population Vs. Tourist barchart
        $pt_chart = $this->Thaimaps_model->mergeProvinceData($year, $province_id);

        echo json_encode($pt_chart);
//echo json_encode('test');
    }

    function province_waste_data() {
        $year = $this->input->post('year');
        $province_id = $this->input->post('province');
        // Population Vs. Tourist waste piechart
        $ptw_chart = $this->Thaimaps_model->mergeWaste_data($year, $province_id);

        echo json_encode($ptw_chart);
    }

    function province_waste_per_head() {
        $year = $this->input->post('year');
        $province_id = $this->input->post('province');
        // Population Vs. Tourist waste piechart
        $waste_head = $this->Thaimaps_model->getWastePerHead($year, $province_id);

        echo json_encode($waste_head);
    }

}
