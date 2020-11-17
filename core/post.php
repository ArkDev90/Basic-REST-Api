    <?php
    class Post{
        //db stuff
        private $conn;
        private $table = 'tbl_posts';

        //post properties
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
                c.name_str as category_name,
                p.id_no,
                p.category_id,
                p.title_str,
                p.body_str,
                p.author_str,
                p.created_at
                FROM
                '.$this->table.' p
                LEFT JOIN 
                    tbl_categories c ON p.category_id = c.id_no
                    ORDER BY p.created_at DESC';

            //prepare statement
            $stmt = $this->conn->prepare($query);
            //execute query
            $stmt->execute();

            return $stmt;
        }

        public function readOne(){
             //create query
             $query = 'SELECT
             c.name_str as category_name,
             p.id_no,
             p.category_id,
             p.title_str,
             p.body_str,
             p.author_str,
             p.created_at
             FROM
             '.$this->table.' p
             LEFT JOIN 
                 tbl_categories c ON p.category_id = c.id_no
                 WHERE p.id_no = ? LIMIT 1';

         //prepare statement
         $stmt = $this->conn->prepare($query);
         //binding param
         $stmt->bindParam(1, $this->id);
         //execute
         $stmt->execute();

         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         $this->id_no = $row['id_no'];
         $this->title_str = $row['title_str'];
         $this->body_str = $row['body_str'];
         $this->author_str = $row['author_str'];
         $this->category_id = $row['category_id'];
         $this->category_name_str = $row['category_name'];
        }

        public function create(){
            //create query
            $query = 'INSERT INTO ' 
                . $this->table.
                ' SET
                title_str = :title, 
                body_str = :body, 
                author_str = :author, 
                category_id = :category_id';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);
            //clean data
            $this->title_str       = htmlspecialchars(strip_tags($this->title_str));
            $this->body_str        = htmlspecialchars(strip_tags($this->body_str));
            $this->author_str      = htmlspecialchars(strip_tags($this->author_str));
            $this->category_id     = htmlspecialchars(strip_tags($this->category_id));


            //parameter
            $stmt->bindParam(':title', $this->title_str);
            $stmt->bindParam(':body', $this->body_str);
            $stmt->bindParam(':author', $this->author_str);
            $stmt->bindParam(':category_id', $this->category_id);


            //execute
            if($stmt->execute())
            {
                return true;
            }
            
            printf("Error $s. \n", $stmt->error);
            return false;



        }

        public function update(){
            //create query
            $query = 'UPDATE ' 
                . $this->table.
                ' SET
                    title_str = :title, 
                    body_str = :body, 
                    author_str = :author, 
                    category_id = :category_id
                WHERE
                    id_no = :id_no
                ';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);
            //clean data
            $this->title_str       = htmlspecialchars(strip_tags($this->title_str));
            $this->body_str        = htmlspecialchars(strip_tags($this->body_str));
            $this->author_str      = htmlspecialchars(strip_tags($this->author_str));
            $this->category_id     = htmlspecialchars(strip_tags($this->category_id));
            $this->id_no           = htmlspecialchars(strip_tags($this->id_no));


            //parameter
            $stmt->bindParam(':title', $this->title_str);
            $stmt->bindParam(':body', $this->body_str);
            $stmt->bindParam(':author', $this->author_str);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id_no', $this->id_no);


            //execute
            if($stmt->execute())
            {
                return true;
            }
            
            printf("Error $s. \n", $stmt->error);
            return false;

        }

        //delete
        public function delete(){
            $query = "Delete from ". $this->table." where id_no = :id";
            // prepare
            $stmt = $this->conn->prepare($query);
            //clean
            $this->id_no  = htmlspecialchars(strip_tags($this->id_no));
            $stmt->bindParam(':id', $this->id_no);
            //execute
            if($stmt->execute())
            {
                return true;
            }
            
            printf("Error $s. \n", $stmt->error);
            return false;



        }

    }

?>