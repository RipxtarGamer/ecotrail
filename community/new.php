<?php
include '../header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../classes/functions.php');
$DB = new Database();
$message = '';

if(isset($_GET['s']) && $_GET['s'])
    $message = 'Post created!';

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    die;
}

function generate_file_name(){
    $file = bin2hex(random_bytes(12));
    return "uploads/$file";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = addslashes(htmlspecialchars($_POST['content']));
    $containsFile = false;
    $userid = get_userid($_SESSION['email']);
    if($_FILES['image']['name'] != "")
    {
        $file = $_FILES['image'];
        $type = $file['type'];
        if($type == 'image/png')
        {
            $ext = '.png';
        }else{
            $ext = '.jpg';
        }
        $filename = generate_file_name() . $ext;
        move_uploaded_file($file['tmp_name'],$filename);
        $containsFile = true;
    }
    if($containsFile)
    {
        if($DB->save("INSERT INTO posts (userid,content,containsFile,image) values ('$userid','$content','1','$filename')"))
        {
            $message = "Posted successfully!";
            header("Location: new.php?s=1");
            die;
        }
    }else{
        if($DB->save("INSERT INTO posts (userid,content) values ('$userid','$content')"))
        {
            $message = "Posted successfully!";
            header("Location: new.php?s=1");
            die;
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create a Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        #statusMessage {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #198754;
            color: #198754;
            border-radius: 0.375rem;
            background-color: #d1e7dd;
        }
        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <section class="py-5 bg-light min-vh-100 d-flex align-items-center">
        <div class="container d-flex justify-content-center">
            <div class="card shadow-sm p-4" style="max-width: 600px; width: 100%;">
                <h2 class="mb-4 text-center text-primary fw-bold">Create a Post</h2>

                <?php if ($message): ?>
                    <div id="statusMessage"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form id="tripPlannerForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">Content</label>
                        <textarea id="content" name="content" rows="8" class="form-control" required></textarea>
                        <div class="invalid-feedback">
                            Please enter the content.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">Image (JPEG or PNG)</label>
                        <input type="file" accept="image/jpeg,image/png" name="image" id="image" class="form-control" onchange="input_image(this)">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function input_image(inp) {
            let file = inp.files[0];
            if (file) {
                if (file.type !== "image/jpeg" && file.type !== "image/png") {
                    alert("Only JPEG and PNG allowed!");
                    inp.value = '';
                }
            }
        }

        // Bootstrap form validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();
    </script>
</body>

</html>

<?php include '../footer.php'; ?>
