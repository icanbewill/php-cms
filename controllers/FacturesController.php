<?php
        
          class FacturesController extends Controller{

                    public function process($params)  {
                        // HTML header
                        $this->head['title'] = 'Factures';
                        // Sets the template
                        $this->view = 'layout';
                    }
          }
?>