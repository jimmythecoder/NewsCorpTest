<?php

class Ingredients
{
    public function parse_ingredients_from_csv_str($data, $ignore_expired = true)
    {
        $arr_headers        = array('item','amount','units','use_by');
        $arr_ingredients    = array();

        $arr_csv_lines = preg_split ('/$\R?^/m', $data);

        Log::info('Found ' . count($arr_csv_lines) . ' ingredient items');

        try{
            if(empty($arr_csv_lines))
                throw new Exception('No ingredients given, go shopping!');

            foreach($arr_csv_lines as $line_item)
            {
                $arr_ingredient = str_getcsv($line_item);

                if(count($arr_ingredient) != count($arr_headers))
                    throw new Exception('Invalid ingredient found: ' . $line_item);

                $arr_record = array_combine($arr_headers,$arr_ingredient);

                //Convert use by date to timestamp for easier calculations
                $arr_record['use_by_as_timestamp'] = strtotime(str_replace('/','-',$arr_record['use_by']));

                if(!$ignore_expired || $arr_record['use_by_as_timestamp'] > time()){
                    $arr_ingredients[$arr_record['item']] = $arr_record;
                }
            }

            if(empty($arr_ingredients))
                throw new Exception('No eatable ingredients found');

        }catch(Exception $e){
            Log::info('Error reading ingredients: ' . $e->getMessage());
        }

        return $arr_ingredients;
    }
}