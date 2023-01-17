<?php
namespace User\OborotRu;

class Tree{
    protected int $count;
    protected string $name;
    private array $harvest_min_max;
    private array $harvest_mass_min_max;
    const FILENAME = 'trees.json';

    public function __construct($name, $count){
        $this->name = $name;
        $this->count = $count;
        $this->setHarvestMinMax();
        $this->storeToJson();
    }

    public function setHarvestMinMax()
    {
        if($this->name === 'apple'){
            $this->harvest_mass_min_max = [150, 180];
            $this->harvest_min_max = [40, 50];
        }elseif($this->name === 'pear') {
            $this->harvest_mass_min_max = [130, 170];
            $this->harvest_min_max = [0, 20];
        }else {
            $this->harvest_mass_min_max = [];
            $this->harvest_min_max = [];
        }
    }

    public function storeToJson(){
        $new_tree = [];
        for ($i = 0; $i<$this->count; $i++){
            $arr = [
                "id" => uniqid(),
                "harvest_count" => rand($this->harvest_min_max[0],$this->harvest_min_max[1])
            ];
            array_push($new_tree, $arr);
        }
        $trees = $this->readFile();
        $all_tree = isset($trees[$this->name]) ? array_merge($trees[$this->name], $new_tree) : $new_tree;
        $trees[$this->name] = $all_tree;
        file_put_contents(self::FILENAME, json_encode($trees, JSON_PRETTY_PRINT));
    }


    public function readFile()
    {
        if(file_exists(self::FILENAME)){
            $jsonString = file_get_contents(self::FILENAME);
            return json_decode($jsonString, true);
        }
        file_put_contents(self::FILENAME, json_encode (new \stdClass));
        return [];
    }

    public function calculateMass($count) {
        $mass = 0;
        for ($i = 0; $i < $count; $i++){
            $mass += rand($this->harvest_mass_min_max[0],$this->harvest_mass_min_max[1] );
        }
        return round($mass /1000,1);
    }

    public function treeHarvestCount(): bool|string
    {
        $jsonData = $this->readFile();
        if($jsonData){
            $trees = $jsonData[$this->name];
            $count = array_sum(array_column($trees, 'harvest_count'));
            $mass = $this->calculateMass($count);
            return PHP_EOL . count($trees) . ' trees of ' . $this->name . ', Harvest count is ' . $count . '. The mass is '. $mass . 'kg';
        }
        return false;
    }
}