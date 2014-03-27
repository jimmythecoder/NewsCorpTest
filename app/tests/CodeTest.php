<?php
//Use php vendor/bin/phpunit to run
class CodeTest extends TestCase {

	/**
	 * Tests that we can parse recipe CSV data and remove expired items
	 *
	 * @return void
	 */
	public function testCanParseIngredients()
	{
        $ingredients_csv_data   = file_get_contents(app_path().'/tests/ingredients.csv');

        $obj_ingredients        = new Ingredients();
        $arr_valid_ingredients  = $obj_ingredients->parse_ingredients_from_csv_str($ingredients_csv_data);

		$this->assertTrue(count($arr_valid_ingredients) == 4);
	}
}