<?php
class ComputerManager {
    private $computers = [];
    private $dataFile = 'computers.json';

    public function __construct() {
        if (file_exists($this->dataFile)) {
            $this->computers = json_decode(file_get_contents($this->dataFile), true);
        } else {
            $this->computers = [
                ['id' => 1, 'name' => 'Komputer 1', 'status' => 'available'],
                ['id' => 2, 'name' => 'Komputer 2', 'status' => 'available'],
                ['id' => 3, 'name' => 'Komputer 3', 'status' => 'available'],
                ['id' => 4, 'name' => 'Komputer 4', 'status' => 'available'],
                ['id' => 5, 'name' => 'Komputer 5', 'status' => 'available'],
                ['id' => 6, 'name' => 'Komputer 6', 'status' => 'available'],
            ];
            $this->saveData();
        }
    }

    private function saveData() {
        file_put_contents($this->dataFile, 
        json_encode($this->computers));
    }

    public function getComputers() {
        return $this->computers;
    }

    public function updateStatus($id, $status) {
        foreach ($this->computers as &$computer) {
            if ($computer['id'] == $id) {
                $computer['status'] = $status;
                $this->saveData();
                return true;
            }
        }
        return false;
    }
}
