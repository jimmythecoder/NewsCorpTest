<?php

class Recipe
{
    /**
     * @param $json_str
     * @return Array of recipe objects
     * @throws Exception
     */
    public function parse_recipes_from_json_str($json_str)
    {
        if(empty($json_str))
            throw new Exception('No data given for recipes');

        $arr_recipes = json_decode($json_str);

        if(empty($arr_recipes))
            throw new Exception('Could not parse recipe json data');

        return $arr_recipes;
    }

    /**
     * Examines the ingredients for the best match to the recipes
     * @param $arr_ingredients assoc array of ingredients (item,amount,units,use_by)
     */
    public function find_best_recipe_by_ingredients($arr_recipes, $arr_ingredients)
    {
        $arr_valid_recipes = array();

        //First we find all the matching valid recipes we could make
        foreach($arr_recipes as $obj_recipe)
        {
            try{
                $first_expiry_date = $this->recipe_can_be_made_with($obj_recipe, $arr_ingredients);

                Log::info('Found valid recipe: ' . $obj_recipe->name);

                $arr_valid_recipes[$first_expiry_date] = $obj_recipe;

            }catch(Exception $e){
                //Can capture invalid recipes and reason here if needed
                Log::info('Can not make ' . $obj_recipe->name . ' because ' . $e->getMessage());
            }
        }

        if(empty($arr_valid_recipes))
            return false;

        ksort($arr_recipes); //Sort by expiry date

        return array_shift($arr_recipes); //Return the first recipe (one expiring soonest)
    }

    /**
     * @param $obj_recipe recipe ingredient requirements
     * @param $arr_ingredients array of supplied ingredients
     * @return int/bool if all ingredients are present, returns the expiry date as a unix timestamp of the first expiring ingredient, else returns false
     */
    private function recipe_can_be_made_with($obj_recipe, $arr_ingredients)
    {
        $first_expiring_ingredient_ts = null;

        foreach($obj_recipe->ingredients as $obj_required_ingredient)
        {
            Log::info('Checking ingredients for item ' . $obj_required_ingredient->item);

            //Do we have the item?
            if(empty($arr_ingredients[$obj_required_ingredient->item]))
                throw new Exception('Missing ingredient '.$obj_required_ingredient->item);

            //Do we have enough of the item?
            if($obj_required_ingredient->amount > $arr_ingredients[$obj_required_ingredient->item]['amount'])
                throw new Exception('Not enough ingredients for '.$obj_required_ingredient->item);

            //Save the expiry date of the item if its the item nearest to expiring
            if(!$first_expiring_ingredient_ts || $arr_ingredients[$obj_required_ingredient->item]['use_by_as_timestamp'] < $first_expiring_ingredient_ts)
                $first_expiring_ingredient_ts = $arr_ingredients[$obj_required_ingredient->item]['use_by_as_timestamp'];
        }

        return $first_expiring_ingredient_ts;
    }
}