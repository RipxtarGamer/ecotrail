
<?php include '../header.php'; ?><?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'db_config.php';
require_once "../classes/connect.php";
require_once "../classes/functions.php";
$DB = new Database();
$logged = false;
if (isset($_SESSION['email'])) {
  $logged = true;
  $my_followed_alerts = get_my_followed_alerts($_SESSION['email']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>EcoTrail+ Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f8f9fa;
    }


    .alert-card {
      border-left: 6px solid;
      margin-bottom: 1.8rem;
      padding: 1.5rem 1.5rem 1.5rem 2rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
      background: #fff;
      cursor: pointer;
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .alert-card:hover {
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .alert-card.zoomed-out {
      transform: scale(0.95);
    }

    .alert-high {
      border-color: #dc3545 !important;
    }

    .alert-medium {
      border-color: #ffc107 !important;
    }

    .alert-low {
      border-color: #198754 !important;
    }

    .alert-card h4 {
      font-weight: 600;
      margin-bottom: 0.3rem;
      color: #222;
    }

    .alert-meta {
      font-size: 0.9rem;
      color: #555;
      margin-bottom: 0.8rem;
    }

    .alert-severity,
    .alert-type,
    .alert-base {
      font-weight: 600;
      text-transform: uppercase;
      padding: 0.15em 0.5em;
      border-radius: 0.3rem;
      font-size: 0.75rem;
      display: inline-block;
      margin-right: 0.5rem;
    }

    .alert-severity.high {
      background: #dc3545;
      color: white;
    }

    .alert-severity.medium {
      background: #ffc107;
      color: #212529;
    }

    .alert-severity.low {
      background: #198754;
      color: white;
    }

    .alert-type {
      background: #0d6efd;
      color: white;
    }

    .alert-base {
      background: #33b512ff;
      color: white;
    }

    .alert-description {
      color: #333;
      line-height: 1.4;
      margin-bottom: 1rem;
    }

    .alt-route {
      font-style: italic;
      background: #e9ecef;
      padding: 0.7rem 1rem;
      border-left: 4px solid #0d6efd;
      border-radius: 0.4rem;
      margin-bottom: 1rem;
      color: #444;
    }

    .proof-image {
      max-width: 320px;
      max-height: 200px;
      object-fit: cover;
      border-radius: 0.5rem;
      border: 1px solid #ddd;
      box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
      cursor: zoom-in;
    }

    /* Hidden Gems Styles */
    .gem-card {
      border-left: 6px solid #0d6efd;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
      cursor: pointer;
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .gem-card:hover {
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .gem-card.zoomed-out {
      transform: scale(0.95);
    }

    .gem-photo {
      max-height: 150px;
      object-fit: cover;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
      width: 100%;
      cursor: zoom-in;
    }

    .card-body {
      padding: 1rem;
    }

    .card-title {
      font-weight: 600;
      color: #222;
    }

    .card-subtitle {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 0.5rem;
    }

    .card-text {
      color: #444;
      line-height: 1.4;
    }

    /* Responsive fixes */
    @media (max-width: 576px) {
      .proof-image {
        max-width: 100%;
        height: auto;
      }
    }

    /* Image Zoom Overlay */
    #img-zoom-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.7);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1050;
      cursor: zoom-out;
    }

    #img-zoom-overlay img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 0.5rem;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.8);
      cursor: zoom-out;
      transition: transform 0.3s ease;
    }
  </style>
</head>

<body>
  <div class="container mt-5">

    <h1 class="mb-4">EcoTrail+ - Alerts</h1>
    <h2>Alerts for You</h2>
    <?php
    if ($logged && is_array($my_followed_alerts)) {
      foreach ($my_followed_alerts as $my_id) {
        $alert = $DB->read("SELECT * from alerts where id='$my_id' limit 1");
        if (is_array($alert)):
          $alert = $alert[0];
          $severity_class = strtolower($alert['severity']);
          ?>
          <div class="alert-card alert-<?= $severity_class ?>">
            <h4><?= htmlspecialchars($alert['title']) ?></h4>
            <p class="alert-meta">
              <span class="alert-severity <?= $severity_class ?>"><?= htmlspecialchars($alert['severity']) ?> Impact</span>
              <span class="alert-type"><?= htmlspecialchars($alert['type']) ?></span>
              <span class="alert-base"><?= ucwords(htmlspecialchars($alert['place_name'] ?? 'N/A')) ?></span>
              <br>
              <br>
              <strong>Location:</strong> <?= htmlspecialchars($alert['location']) ?> | <strong>Date:</strong>
              <?= htmlspecialchars($alert['date']) ?>
            </p>
            <p class="alert-description"><?= nl2br(htmlspecialchars($alert['description'])) ?></p>
            <?php if ($alert['alt_route']): ?>
              <p class="alt-route"><strong>Alternative Route:</strong> <?= nl2br(htmlspecialchars($alert['alt_route'])) ?></p>
            <?php endif; ?>
            <?php if ($alert['proof'] && file_exists($alert['proof'])): ?>
              <img src="<?= htmlspecialchars($alert['proof']) ?>" alt="Proof Image" class="proof-image" />
            <?php endif; ?>
          </div>
          <?php
        else:
          echo "No results found!";
        endif;
      }
    }else{
      echo "<p >You are not following any alerts.</p>";
    }
    ?>
    <br>
    <br>
    <h2>Current Alerts</h2>
    <?php
$alerts = $conn->query("SELECT alerts.*, places.name AS place_name FROM alerts LEFT JOIN places ON alerts.place_id = places.id WHERE alerts.approved = 'approved' ORDER BY alerts.id DESC");
    if ($alerts->num_rows > 0):
      while ($alert = $alerts->fetch_assoc()):
        $severity_class = strtolower($alert['severity']);
        ?>
        <div class="alert-card alert-<?= $severity_class ?>">
          <h4><?= htmlspecialchars($alert['title']) ?></h4>
          <p class="alert-meta">
            <span class="alert-severity <?= $severity_class ?>"><?= htmlspecialchars($alert['severity']) ?> Impact</span>
            <span class="alert-type"><?= htmlspecialchars($alert['type']) ?></span>
            <span class="alert-base"><?= ucwords(htmlspecialchars($alert['place_name'] ?? 'N/A')) ?></span>
            <br>
            <br>
            <strong>Location:</strong> <?= htmlspecialchars($alert['location']) ?> | <strong>Date:</strong>
            <?= htmlspecialchars($alert['date']) ?>
          </p>
          <p class="alert-description"><?= nl2br(htmlspecialchars($alert['description'])) ?></p>
          <?php if ($alert['alt_route']): ?>
            <p class="alt-route"><strong>Alternative Route:</strong> <?= nl2br(htmlspecialchars($alert['alt_route'])) ?></p>
          <?php endif; ?>
          <?php if ($alert['proof'] && file_exists($alert['proof'])): ?>
            <img src="<?= htmlspecialchars($alert['proof']) ?>" alt="Proof Image" class="proof-image" />
          <?php endif; ?>
        </div>
        <?php
      endwhile;
    else:
      echo "<p>No alerts at the moment.</p>";
    endif;
    ?>

  </div>

  <!-- Image Zoom Overlay -->
  <div id="img-zoom-overlay" aria-hidden="true">
    <img src="" alt="Zoomed Image" />
  </div>

  <script>
    // Zoom out effect on card click (optional)
    document.querySelectorAll('.alert-card, .gem-card').forEach(card => {
      card.addEventListener('click', () => {
        card.classList.add('zoomed-out');
        setTimeout(() => {
          card.classList.remove('zoomed-out');
        }, 300);
      });
    });

    // Image zoom overlay logic
    const overlay = document.getElementById('img-zoom-overlay');
    const overlayImg = overlay.querySelector('img');

    // Attach zoom-in cursor and click event to images
    document.querySelectorAll('.proof-image, .gem-photo').forEach(img => {
      img.style.cursor = 'zoom-in';
      img.addEventListener('click', e => {
        e.stopPropagation(); // Prevent card click zoom effect
        overlayImg.src = e.target.src;
        overlay.style.display = 'flex';
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden'; // Prevent scroll when zoomed
      });
    });

    // Close overlay when clicking outside or on image
    overlay.addEventListener('click', e => {
      if (e.target === overlay || e.target === overlayImg) {
        overlay.style.display = 'none';
        overlay.setAttribute('aria-hidden', 'true');
        overlayImg.src = '';
        document.body.style.overflow = ''; // Restore scroll
      }
    });
  </script>
</body>

</html>
<?php include '../footer.php'; ?>