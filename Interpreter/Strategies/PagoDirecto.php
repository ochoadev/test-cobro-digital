<?php

namespace Interpreter\Strategies;
 
use Interpreter\Strategy;

class PagoDirecto implements Strategy
{
    // implemendo el de cob-cob
    public function process_file($file_in_array)
    {
        $footer = $this->get_footer($file_in_array, count($file_in_array));
        $footer_index = $this->get_footer_index($file_in_array, count($file_in_array));
        $header = $this->get_header($file_in_array);
        $calcs = $this->get_data($file_in_array, $footer_index);
        return $calcs;
    }

    public function get_header($data) 
    {
        return $data[0];
    }
    
    public function get_footer($data, $itemsQuantity) 
    {
        $footer = $data[$itemsQuantity - 1];
    
        if(strlen($footer) != 352) {
            return $this->get_footer($data, $itemsQuantity - 1);
        }
    
        return $footer;
    }
    
    public function get_footer_index($data, $itemsQuantity) 
    {
        $index = $itemsQuantity - 1;
        $footer = $data[$index];
    
        if(strlen($footer) != 352) {
            return $this->get_footer_index($data, $index);
        }
    
        return $index;
    }
    

    public function process_line($str, $index) 
    {
        $format = substr($str, 0, 4);
        
        if ($format == "0371") {
            return $this->process_line_rev_rev($str, $index);
        }

        return $this->process_line_cob_cob($str, $index);        
    }
    
    public function process_line_cob_cob($str, $index)
    {
        $data = [];

        $data['referencia'] = substr($str, 52, 15);
        $data['fecha'] = substr($str, 294, 8);
        $data['temp'] = floatval(substr($str, 302, 14));
        $data['monto'] = $data['temp']/100;
        $data['moneda'] = substr($str, 133, 1);

        $this->print_line_data($data, $index);

        return $data;
    }

    public function process_line_rev_rev($str, $index)
    {
        $data = [];

        $data['referencia'] = substr($str, 52, 15);
        $data['fecha'] = substr($str, 67, 8);
        $data['temp'] = floatval(substr($str, 75, 14));
        $data['monto'] = $data['temp']/100;
        $data['moneda'] = substr($str, 133, 1);

        $this->print_line_data($data, $index);

        return $data;
    }

    public function get_data($data, $footer_index) 
    {
        $results = [];
        $total_cobrado = 0;
        $total_registros_cobrados = 0;

        echo "Nro. Transaccion \t Monto \t Id. \t Fecha \t Medio Pago";

        for ($i=1; $i < $footer_index; $i++) { 
            $temp = $this->process_line($data[$i], $i);
            $results[] = $temp;
            $total_cobrado+= $temp['monto'];
            if ($total_cobrado > 0) {
                $total_registros_cobrados++;
            }
        }
    
        $promedio = ($total_cobrado / $total_registros_cobrados);

        //$this->print_line_resume($total_cobrado, $total_registros_cobrados, $promedio);

        $return_data['total_cobrado'] = $total_cobrado;
        $return_data['total_registros_cobrados'] = $total_registros_cobrados;
        $return_data['promedio'] = $promedio;

        return $return_data;
    }
    
    public function print_line_data($data, $index) 
    {
        echo "\n {$index} \t {$data['monto']} \t {$data['referencia']} \t {$data['fecha']} \t Null \n";
        return;
    }
    
    public function print_line_resume($total_cobrado, $total_registros_cobrados, $promedio) 
    {
        echo "Total Registros \t Total Cobrado \t Promedio Cobro\n";
        echo "{$total_registros_cobrados}\t {$total_cobrado}  \t {$promedio} ";
        return;
    }


}