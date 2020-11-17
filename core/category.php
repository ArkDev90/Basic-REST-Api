<?php
    class Category{
        //db stuff
        private $conn;
        private $table = 'tbl_categories';

        //category properties
        public $id_no;
        public $category_id;
        public $category_name_str;
        public $title_str;
        public $body_str;
        public $author_str;
        public $create_at;

        //constructor with db connection
        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function read()
        {
            //create query
            $query = 'SELECT
                *
                FROM
                '.$this->table;

            //prepare statement
            $stmt = $this->conn->prepare($query);
            //execute query
            $stmt->execute();

            return $stmt;
        }


    }

?>