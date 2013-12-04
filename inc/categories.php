<?php
    require_once(dirname(__FILE__).'/../config.php');

    function getCategories()
    {
        $query = "SELECT Categories.type FROM Categories GROUP BY Categories.type;";
        $result = mysqli_query($GLOBALS['db'], $query);

        if ($result) 
        {
            $categories = array();

            while($category = mysqli_fetch_array($result)) 
            {
                $subcategories = array();

                $query = "SELECT Categories.subtype FROM Categories WHERE Categories.type=$category['type'];";
                $result2 = mysqli_query($GLOBALS['db'], $query);

                while($subcategory = mysqli_fetch_array($result2)) 
                {
                    array_push($subcategories, $subcategory)
                }

                $dict = array(
                    'category' => $category['type'],
                    'subcategories' => $subcategories);
                array_push($categories, $dict);
            }

            return $categories;
        }
        else
        {
            echo 'false';
        }
    }

?>