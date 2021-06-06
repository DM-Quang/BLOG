<?php 
    
    class Comment {
        // properties.

        public $comment_text;
        public $comment_userID;
        public $comment_postID;        
        public $comments = [];
        public $insert_id;
        public $conn;


        // constructor function.
        public function __construct($post_ID, $conn) {
            $this->comment_postID = $post_ID;
            $this->conn = $conn;
        }

        // Comment methods.
        public function getComments() {
            $sql = "SELECT c.ID AS comment_id, u.user_name, c.comment_text, c.date_created FROM comments c JOIN users u ON u.ID = c.comment_user WHERE comment_post = ? ORDER BY c.date_created DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $this->comment_postID);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->comments = $result->fetch_all(MYSQLI_ASSOC);
        }

        public function outputComments() {
            $output = "";
            foreach ($this->comments as $comment) {
                $output .= "
                    <div class='col-md-6 offset-md-3 mt-2 mb-2'>
                        <div class='card'>
                            <div class='card-header'>
                                {$comment['user_name']} | {$comment['date_created']}
                                <a href='#' data-comment-number='{$comment['comment_id']}'><button class='delete-comment float-right btn btn-outline-danger btn-sm'>X</button></a>                             
                            </div>                        
                            <div class='body-body'>
                                <p class='card-text'>{$comment['comment_text']}</p>
                            </div>
                        </div>                                        
                    </div>
                ";
            }
            echo $output;
        }

        public function createComment($comment_text, $user_id) {
            $sql = "INSERT INTO comments (comment_text, comment_user, comment_post) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii", $comment_text, $user_id, $this->comment_postID);
            $stmt->execute();
            if ($stmt->affected_rows == 1) {
                $this->insert_id = $stmt->insert_id;
                $this->getComment();
                }
        }

        public function getComment() {
            $sql = "SELECT u.user_name, c.comment_text, c.date_created FROM comments c JOIN users u ON u.ID = c.comment_user WHERE c.ID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $this->insert_id);
            $stmt->execute();
            $result = $stmt->get_result();
            echo json_encode($result->fetch_assoc());
        }
    }

?>