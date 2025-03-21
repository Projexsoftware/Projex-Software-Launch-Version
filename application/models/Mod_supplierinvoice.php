<?php

Class Mod_supplierinvoice extends CI_Model {
    
    public function updatereceipt($receipt_id, $increment){


        $query="UPDATE `project_suppliers_receipts` SET `payment` = `payment`+$increment  WHERE `id` = '".$receipt_id."'";

       return $this->db->query($query);    

    }

    
    public function updatereceiptitem($receiptitem_id, $increment){


        $query="UPDATE `project_suppliers_receipts_items` SET `payment` = `payment`+$increment  WHERE `id` = '".$receiptitem_id."'";

       return $this->db->query($query);    

    }
}

