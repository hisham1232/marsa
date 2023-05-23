<?php
    $foods = array(
        'Healthy'=>array(
            'Salad'=>array('Larb', 'Cobb'), 
            'Vegetables'=>array('Cabbage', 'Lady Finger'), 
            'Pasta'=>array('Filipino', 'Italian')),
        'Unhealthy'=>array(
            'Pizza'=>array('Pepperoni', 'Hawaian'), 
            'Ice Cream'=>array('Selecta', 'Magnolia'), 
            'Popcorn'=>array('Regular', 'Cheeze'))
    );
    foreach($foods as $category => $food_name){
        echo "<h2>".$category."</h2>";
        foreach($food_name as $food => $brands){
            echo "<h3>".$food."</h3>";
            foreach($brands as $name){
                echo "<h5>".$name."</h5>";
            }    
        }
    }         
?>