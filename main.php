<?php
require_once "./src/Tree.php";


$apple = new User\OborotRu\Tree('apple',10);
$pear = new User\OborotRu\Tree('apple',15);


echo $apple->treeHarvestCount();
echo $pear->treeHarvestCount();

