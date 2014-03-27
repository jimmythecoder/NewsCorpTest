<?php

class HomeController extends BaseController {

	public function index()
	{
        return View::make('index');
	}

    public function showBestRecipe()
    {
        $obj_ingredients    = new Ingredients();
        $obj_recipes        = new Recipe();

        $arr_ingredients    = $obj_ingredients->parse_ingredients_from_csv_str(Input::get('ingredients'), $ignore_expired = true);

        $arr_recipes        = $obj_recipes->parse_recipes_from_json_str(Input::get('recipes'));

        $obj_best_recipe    = $obj_recipes->find_best_recipe_by_ingredients($arr_recipes, $arr_ingredients);

        return View::make('show_best_recipe', array('recipe' => $obj_best_recipe));
    }
}