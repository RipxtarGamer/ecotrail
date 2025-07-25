<?php
include '../header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../classes/functions.php');
$DB = new Database();
$posts = get_posts();

$logged = false;
if (isset($_SESSION['email'])) {
    $logged = true;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $content = addslashes(htmlspecialchars($_POST['comment']));
    $postId = $_POST['id'];
    $userid = get_userid($_SESSION['email']);
    if($DB->save("INSERT INTO comments (postId,userid,content) values ('$postId','$userid','$content')"))
    {
        header("Location: index.php");
        die;     
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Community</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .post {
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        .post img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            margin-top: 10px;
            border-radius: 8px;
        }
        .post .body {
            margin-top: 5px;
        }
        .post .user {
            font-weight: 700;
            font-size: 1.25rem;
            color: #0d6efd;
        }
        .comment {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
        }
        .comment .user {
            font-size: 0.9rem;
            font-weight: 600;
            color: #495057;
        }
        .comments textarea {
            border: 1px solid #ced4da;
            padding: 10px;
            display: none;
            resize: none;
            border-radius: 12px;
            width: 100%;
        }
        .comments textarea.active {
            display: block;
        }
        .comments .commentor {
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .comments .commentor .submit {
            background: #0d6efd;
            border: none;
            padding: 6px 12px;
            color: white;
            margin-top: 5px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

                .comments .replier {
            width: 100%;
            padding: 7px;
            margin: 9px 0;
        }

        .replies {
            margin-left: 30px;
            margin-top: 10px;
            padding: 7px;
            border-radius: 7px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
    </style>
</head>

<body class="bg-light">
    <section id="planner" class="py-5">
        <form method="post" id="commentor_form" style="display:none;">
            <textarea name="comment" id="text"></textarea>
            <input type="hidden" name="id" id="id" />
        </form>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold m-0">Community</h2>
                <a href="new.php" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i> Add Your Post
                </a>
            </div>

            <div class="mx-auto" style="max-width: 700px;">
                <?php
                if (is_array($posts)) {
                    foreach ($posts as $post) {
                        $username = get_post_username($post['userid']);
                        $content = nl2br(stripslashes($post['content']));
                        $comments = get_comments($post['id']);
                        echo "<div class='post shadow-sm'>
                            <p class='user'>$username</p>
                            <div class='body'>
                                <div class='content'>$content</div>";
                                if ($post['containsFile'] == 1) {
                                    echo "<img src='$post[image]' alt='Post image' class='image rounded'>";
                                }
                            echo "</div>
                            <div class='comments'>";
                        if ($logged) {
                            echo "<div class='commentor'>
                                <textarea class='non form-control' placeholder='Write your comment'></textarea>
                                <button data-id='$post[id]' class='submit' onclick='comment(this)'>Comment</button>
                            </div>";
                        }
                        if (is_array($comments)) {
                            foreach ($comments as $comment) {
                                    $commentorName = get_commentor_name($comment['id']);
                                    $replies = get_replies($comment['id']);

                                    echo "<div class='card mb-3'>
                                            <div class='card-body'>
                                                <h6 class='card-title text-primary fw-bold mb-1'>$commentorName</h6>
                                                <p class='card-text'>" . nl2br($comment['content']) . "</p>
                                                <a class='text-decoration-underline text-muted small' data-id='{$comment['id']}' style='cursor:pointer;' onclick='reply_to_this(this)'>Reply</a>";

                                    if (is_array($replies)) {
                                        echo "<div class='mt-3 ps-3 border-start'>";
                                        foreach ($replies as $reply) {
                                            $replyorName = get_commentor_name($reply["id"]);
                                            echo "<div class='card mb-2 bg-light'>
                                                    <div class='card-body py-2 px-3'>
                                                        <h6 class='card-subtitle mb-1 text-secondary fw-semibold'>$replyorName</h6>
                                                        <p class='card-text small mb-0'>{$reply['content']}</p>
                                                    </div>
                                                </div>";
                                        }
                                        echo "</div>";
                                    }

                                    echo "  </div>
                                        </div>";
                            }
                        } else {
                            echo "<p class='text-center text-muted'>No comments yet!</p>";
                        }
                        echo "</div></div>";
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let commentor_form = document.getElementById("commentor_form");
        function comment(ele) {
            let textarea = ele.previousElementSibling;
            if (textarea.classList.contains('non')) {
                textarea.className = 'active';
                textarea.focus();
            } else {
                let text = textarea.value;
                if (text.trim() == '') {
                    alert("Comment cannot be empty!");
                } else {
                    commentor_form.querySelector("#text").value = text.trim();
                    let id = ele.dataset.id;
                    commentor_form.querySelector("#id").value = id;
                    commentor_form.submit();
                }
            }
        }

        function reply_to_this(ele) {
            ele.style.display = 'none';
            let parent = ele.parentElement;
            let inp = document.createElement('input');
            inp.type = 'text';
            inp.className = 'replier';
            inp.placeholder = 'Write a reply and press Enter to submit';
            inp.onkeyup = function (eve) {
                if (eve.keyCode == 13) {
                    let reply = inp.value.trim();
                    let cId = ele.dataset.id;
                    if (reply == '')
                        alert('Reply cannot be empty!');
                    else {
                        let ajax = new XMLHttpRequest();
                        ajax.open("POST", '../ajax/reply.php', true);
                        ajax.setRequestHeader("Content-Type", "text/plain");
                        let data = {};
                        data.action = 'reply';
                        data.content = reply;
                        data.comment = cId;
                        data = JSON.stringify(data);
                        ajax.onreadystatechange = function () {
                            if (ajax.readyState === 4 && ajax.status === 200) {
                                if (ajax.responseText == 'success')
                                    location.reload();
                                else {
                                    alert("An error occured!");
                                    return;
                                }
                            }
                        };

                        ajax.send(data);
                    }
                }
            }
            inp.onblur = function () {
                inp.nextElementSibling.style.display = 'block';
                inp.remove();
            }
            parent.insertBefore(inp, ele);
            inp.focus();
        }
    </script>
</body>

</html>
<?php include '../footer.php'; ?>
