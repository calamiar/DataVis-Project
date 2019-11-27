<?php

class Thaimaps_model extends CI_Model {

    function getYear() {
        $result = $this->db->distinct('year')->order_by('year', 'DESC')->get('waste_tb')->result();
        $id = array();
        $name = array();
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->year);
            array_push($name, $result[$i]->year);
        }
        return array_combine($id, $name);
    }

    function getRegion_id() {
        $this->db->select('*');
        $query = $this->db->get('region');
        return $query->result();
    }

    function getRegion_name($r_id) {
        $this->db->select('region_name');
        $this->db->where('region_id', $r_id);
        $query = $this->db->get('region');
        return $query->row();
    }

    function getAllRegion_n_data($year) {
        $region_all_data = $this->getRegion_id();
        $region_id_arr = array();
        foreach ($region_all_data as $row) {
            $region_id = $row->region_id;
            $avg_data = $this->getAvgRegionData($year, $region_id);
            array_push($region_id_arr, array($region_id, $avg_data));
        }
        return $region_id_arr;
    }

    function getAvgRegionData($year, $region_id) {
        $this->db->select_avg('tourist');
        //join 2 table
        $this->db->from('waste_tb');
        $this->db->join('province', 'province.province_id = waste_tb.province_id');
        $this->db->where('year', $year);
        $this->db->where('province.region_id', $region_id);
        $query = $this->db->get();
        return $query->row()->tourist;
    }

    //This 3 function is for sum all of tourist and population data for display in year amount
    function getSumTour($year) {
        $this->db->select_sum('tourist');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $query = $this->db->get();
        return $query->row()->tourist;
    }

    function getSumPop($year) {
        $this->db->select_sum('population');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $query = $this->db->get();
        return $query->row()->population;
    }

    function getTotalPeople($year) {
        $a1 = array();
        $pop_data = $this->getSumPop($year);
        $tour_data = $this->getSumTour($year);
        array_push($a1, array('population', (int) $pop_data));
        array_push($a1, array('tourist', (int) $tour_data));
        return $a1;
    }

    function getProvince($r_id) {
        $this->db->select('*');
        $this->db->where('region_id', $r_id);
        $query = $this->db->get('province');
        return $query->result();
    }

    function getAllProvince_n_data($year, $r_id) {
        $pro_all_data = $this->getProvince($r_id);
        $pro_id_arr = array();
        foreach ($pro_all_data as $row) {
            $pro_id = $row->province_id;
            $tour_data = $this->getProvinceData($year, $pro_id);
            array_push($pro_id_arr, array($pro_id, $tour_data));
        }
        return $pro_id_arr;
    }

    function getProvinceData($year, $pro_id) {
        $this->db->select('tourist');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $this->db->where('province_id', $pro_id);
        $query = $this->db->get();
        return $query->row()->tourist;
    }

//    This is model for tourist_waste and pop_waste in database
    function getSumTourWaste($year) {
        $this->db->select_sum('tourist_waste');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $query = $this->db->get();
        return $query->row()->tourist_waste;
    }

    function getSumPopWaste($year) {
        $this->db->select_sum('pop_waste');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $query = $this->db->get();
        return $query->row()->pop_waste;
    }

    function getTotalPeopleWaste($year) {
        $ppl_waste_arr = array();
        $pop_data = $this->getSumPopWaste($year);
        $tour_data = $this->getSumTourWaste($year);
        array_push($ppl_waste_arr, array('population', (int) $pop_data));
        array_push($ppl_waste_arr, array('tourist', (int) $tour_data));
        return $ppl_waste_arr;
    }

    //This function is for sum column waste per head in database by year
    function getAvgWastePerHead($year) {
        $this->db->select_avg('waste_per_head');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $query = $this->db->get();
        return $query->row()->waste_per_head;
    }

    // Create each province data for using in zoom_map_page
    function getPopProvinceData($year, $province) {
        $this->db->select('population');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $this->db->where('province_id', $province);
        $query = $this->db->get();
        return $query->row()->population;
    }

    function getTourProvinceData($year, $province) {
        $this->db->select('tourist');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $this->db->where('province_id', $province);
        $query = $this->db->get();
        return $query->row()->tourist;
    }

    // create array that contain tourist and population data for using in barchart
    function mergeProvinceData($year, $province) {
        $pop_data = $this->getPopProvinceData($year, $province);
        $tour_data = $this->getTourProvinceData($year, $province);
        $barchart_arr = array();
        array_push($barchart_arr, array('population', (int) $pop_data));
        array_push($barchart_arr, array('tourist', (int) $tour_data));
        return $barchart_arr;
    }

    // create default view barchart for zoom_map_page
    function getAllSemiRegion_n_data($year, $region_id) {
        $pop_data = $this->getAvgPopProvinceData($year, $region_id);
        $tour_data = $this->getAvgRegionData($year, $region_id);
        $region_arr = array();

        array_push($region_arr, array('population', (int) $pop_data));
        array_push($region_arr, array('tourist', (int) $tour_data));

        return $region_arr;
    }

    // Create each province data for using in zoom_map_page (default view)
    function getAvgPopProvinceData($year, $region_id) {
        $this->db->select_avg('population');
        //join 2 table
        $this->db->from('waste_tb');
        $this->db->join('province', 'province.province_id = waste_tb.province_id');
        $this->db->where('year', $year);
        $this->db->where('province.region_id', $region_id);
        $query = $this->db->get();
        return $query->row()->population;
    }

    //Average pop_waste data in each region for shown in zoom_map_page
    function getAvgPop_waste_r($year, $region_id) {
        $this->db->select_avg('pop_waste');
        //join 2 table
        $this->db->from('waste_tb');
        $this->db->join('province', 'province.province_id = waste_tb.province_id');
        $this->db->where('year', $year);
        $this->db->where('province.region_id', $region_id);
        $query = $this->db->get();
        return $query->row()->pop_waste;
    }

    //Average tourist_waste data in each region for shown in zoom_map_page
    function getAvgTour_waste_r($year, $region_id) {
        $this->db->select_avg('tourist_waste');
        //join 2 table
        $this->db->from('waste_tb');
        $this->db->join('province', 'province.province_id = waste_tb.province_id');
        $this->db->where('year', $year);
        $this->db->where('province.region_id', $region_id);
        $query = $this->db->get();
        return $query->row()->tourist_waste;
    }

    // create default view,array for contain 'getAvgPop_waste_r' and 'getAvgTour_waste_r' and send it out to controller
    function getAllSemiRegionWaste_Data($year, $region_id) {
        $pop_data = $this->getAvgPop_waste_r($year, $region_id);
        $tour_data = $this->getAvgTour_waste_r($year, $region_id);
        $avg_waste_arr = array();
        array_push($avg_waste_arr, array('population', (int)$pop_data));
        array_push($avg_waste_arr, array('tourist', (int)$tour_data));
        return $avg_waste_arr;
    }

    //Call pop_waste from waste_tb
    function getPop_waste($year, $province) {
        $this->db->select('pop_waste');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $this->db->where('province_id', $province);
        $query = $this->db->get();
        return $query->row()->pop_waste;
    }

    //Call tourist_waste from waste_tb
    function getTourist_waste($year, $province) {
        $this->db->select('tourist_waste');
        $this->db->from('waste_tb');
        $this->db->where('year', $year);
        $this->db->where('province_id', $province);
        $query = $this->db->get();
        return $query->row()->tourist_waste;
    }
    
    function mergeWaste_data($year, $province) {
        $pop_data = $this->getPop_waste($year, $province);
        $tour_data = $this->getTourist_waste($year, $province);
        $barchart_arr = array();
        array_push($barchart_arr, array('population', (int)$pop_data));
        array_push($barchart_arr, array('tourist', (int)$tour_data));
        return $barchart_arr;
    
    }
    
    //call data in Waste_per_head column
    function getWastePerHead($year,$region_id) {
        $this->db->select('waste_per_head');
        $this->db->from('waste_tb');
        //join 2 table for region
        $this->db->join('province', 'province.province_id = waste_tb.province_id');
        $this->db->where('year', $year);
        $this->db->where('province.region_id', $region_id);
        $query = $this->db->get();
        return $query->row()->waste_per_head;
    }
    
    //Call data in Waste_per_head column to average
    function getAvgWastePerHeadRegion($year,$region_id) {
        $this->db->select_avg('waste_per_head');
        $this->db->from('waste_tb');
        //join 2 table for region
        $this->db->join('province', 'province.province_id = waste_tb.province_id');
        $this->db->where('year', $year);
        $this->db->where('province.region_id', $region_id);
        $query = $this->db->get();
        return $query->row()->waste_per_head;
    }
    
    

}
